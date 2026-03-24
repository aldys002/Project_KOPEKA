<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk transaksi
use App\Models\User;
use App\Models\Hutang;
use App\Models\Simpanan;
use App\Models\TransaksiBulanan;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nipp'     => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('nipp', 'password'))) {
            if (strtolower(Auth::user()->role) == 'admin') {
                $request->session()->regenerate();
                return redirect()->intended('/admin/dashboard');
            }
            Auth::logout();
            return back()->withErrors(['error' => 'Akses ditolak!']);
        }
        return back()->withInput()->withErrors(['error' => 'NIPP atau Password salah!']);
    }

    /**
     * Dashboard Ringkasan
     */
    public function dashboard(Request $request)
    {
        $tahunAktif = $request->get('tahun', date('Y'));
        $daftarTahun = range(2025, date('Y') + 5);

        $totalAnggota  = User::where('role', 'user')->count();
        $anggotaAktif  = User::where('role', 'user')->where('status', 'aktif')->count();
        $anggotaKeluar = User::where('role', 'user')->where('status', 'keluar')->count();

        // Ambil totalan berdasarkan tahun aktif
        $totalPokok    = Simpanan::where('tahun', $tahunAktif)->sum('pokok');
        $totalWajib    = Simpanan::where('tahun', $tahunAktif)->sum('wajib');
        $totalSukarela = Simpanan::where('tahun', $tahunAktif)->sum('sukarela');
        $totalSimpananKeseluruhan = Simpanan::where('tahun', $tahunAktif)->sum('total_simpanan');
        $totalHutang   = Hutang::where('tahun', $tahunAktif)->sum('saldo_hutang');

        return view('admin.dashboard', compact(
            'totalAnggota', 'anggotaAktif', 'anggotaKeluar', 
            'totalPokok', 'totalWajib', 'totalSukarela',
            'totalSimpananKeseluruhan', 'totalHutang', 'tahunAktif', 'daftarTahun'
        ));
    }

    /**
     * TAMBAH ANGGOTA LENGKAP: Simpan ke 3 Tabel Sekaligus
     */
    public function tambahAnggota(Request $request)
    {
        $request->validate([
            'nipp'     => 'required|unique:anggota,nipp',
            'users'    => 'required', 
            'tahun'    => 'required|numeric',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // 1. Buat Akun User (Password NULL agar bisa Aktivasi)
                $user = User::create([
                    'nipp'     => $request->nipp,
                    'nik'      => $request->nik,
                    'users'    => $request->users,
                    'password' => null, 
                    'role'     => 'user',
                    'status'   => 'aktif',
                ]);

                // Bersihkan input angka dari format ribuan/Rp
                $pokok    = $this->cleanNumber($request->pokok);
                $wajib    = $this->cleanNumber($request->wajib);
                $sukarela = $this->cleanNumber($request->sukarela);
                $hutang   = $this->cleanNumber($request->saldo_hutang);

                // 2. Buat Data Simpanan Awal
                Simpanan::create([
                    'anggota_id'     => $user->id,
                    'nipp'           => $user->nipp,
                    'tahun'          => $request->tahun,
                    'pokok'          => $pokok,
                    'wajib'          => $wajib,
                    'sukarela'       => $sukarela,
                    'total_simpanan' => $pokok + $wajib + $sukarela
                ]);

                // 3. Buat Data Hutang Awal
                Hutang::create([
                    'anggota_id'   => $user->id,
                    'nipp'         => $user->nipp,
                    'tahun'        => $request->tahun,
                    'saldo_hutang' => $hutang
                ]);
            });

            return redirect()->back()->with('success', "Anggota {$request->users} berhasil didaftarkan dan saldo awal telah masuk!");

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal simpan data: ' . $e->getMessage()]);
        }
    }

    /**
     * KELOLA SALDO: Daftar Anggota per Tahun
     */
    public function listAnggota(Request $request)
    {
        $tahunAktif = $request->get('tahun', date('Y'));

        // Gunakan with untuk memanggil data simpanan/hutang di tahun terpilih
        $anggota = User::where('role', 'user')
                    ->with(['simpanans' => function($q) use ($tahunAktif) {
                        $q->where('tahun', $tahunAktif);
                    }, 'hutangs' => function($q) use ($tahunAktif) {
                        $q->where('tahun', $tahunAktif);
                    }])
                    ->orderBy('id', 'asc') 
                    ->get();

        return view('admin.anggota_index', compact('anggota', 'tahunAktif'));
    }

    /**
     * Input Massal Laporan Bulanan (Input di Tabel Besar)
     */
    public function laporanBulanan(Request $request)
    {
        $tahunAktif = $request->get('tahun', date('Y'));
        $bulanAktif = $request->get('bulan', date('n'));

        $anggota = User::where('role', 'user')
                    ->where('status', 'aktif')
                    ->orderBy('id', 'asc') 
                    ->get();

        $transaksi = TransaksiBulanan::where('tahun', $tahunAktif)
                                     ->where('bulan', $bulanAktif)
                                     ->get()
                                     ->keyBy('anggota_id');

        return view('admin.laporan_bulanan', compact('anggota', 'tahunAktif', 'bulanAktif', 'transaksi'));
    }

    public function simpanBulanan(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $dataInput = $request->input('data'); 

        if (!$dataInput) return redirect()->back()->withErrors(['error' => 'Tidak ada data.']);

        try {
            DB::transaction(function () use ($dataInput, $bulan, $tahun) {
                foreach ($dataInput as $anggotaId => $nilai) {
                    $p = $this->cleanNumber($nilai['pokok'] ?? 0);
                    $w = $this->cleanNumber($nilai['wajib'] ?? 0);
                    $s = $this->cleanNumber($nilai['sukarela'] ?? 0);
                    $h = $this->cleanNumber($nilai['saldo_hutang'] ?? 0);

                    // 1. Update/Create Log Bulanan
                    TransaksiBulanan::updateOrCreate(
                        ['anggota_id' => $anggotaId, 'bulan' => $bulan, 'tahun' => $tahun],
                        [
                            'pokok'        => $p,
                            'wajib'        => $w,
                            'sukarela'     => $s,
                            'saldo_hutang' => $h,
                        ]
                    );

                    $user = User::find($anggotaId);
                    if ($user) {
                        // 2. Hitung total akumulasi tahun ini untuk update tabel Simpanan
                        $akumulasi = TransaksiBulanan::where('anggota_id', $anggotaId)
                            ->where('tahun', $tahun)
                            ->selectRaw('SUM(pokok) as p, SUM(wajib) as w, SUM(sukarela) as s')
                            ->first();

                        Simpanan::updateOrCreate(
                            ['anggota_id' => $anggotaId, 'tahun' => $tahun],
                            [
                                'nipp'           => $user->nipp,
                                'pokok'          => $akumulasi->p ?? 0,
                                'wajib'          => $akumulasi->w ?? 0,
                                'sukarela'       => $akumulasi->s ?? 0,
                                'total_simpanan' => ($akumulasi->p ?? 0) + ($akumulasi->w ?? 0) + ($akumulasi->s ?? 0)
                            ]
                        );

                        // 3. Update Saldo Hutang Terakhir
                        Hutang::updateOrCreate(
                            ['anggota_id' => $anggotaId, 'tahun' => $tahun],
                            [
                                'nipp'         => $user->nipp,
                                'saldo_hutang' => $h, 
                            ]
                        );
                    }
                }
            });

            return redirect()->back()->with('success', "Laporan bulan $bulan tahun $tahun berhasil disinkronkan!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Update Manual per Baris (Jika ada revisi satu orang)
     */
    public function updateSimpananManual(Request $request)
    {
        $user = User::where('nipp', $request->nipp)->first();
        if (!$user) return redirect()->back()->withErrors(['error' => 'User tidak ditemukan.']);

        $p = $this->cleanNumber($request->pokok);
        $w = $this->cleanNumber($request->wajib);
        $s = $this->cleanNumber($request->sukarela);

        Simpanan::updateOrCreate(
            ['anggota_id' => $user->id, 'tahun' => $request->tahun],
            [
                'nipp'           => $request->nipp,
                'pokok'          => $p,
                'wajib'          => $w,
                'sukarela'       => $s,
                'total_simpanan' => $p + $w + $s
            ]
        );
        return redirect()->back()->with('success', "Simpanan anggota $request->nipp diperbarui!");
    }

    public function updateHutangManual(Request $request)
    {
        $user = User::where('nipp', $request->nipp)->first();
        if (!$user) return redirect()->back()->withErrors(['error' => 'User tidak ditemukan.']);

        Hutang::updateOrCreate(
            ['anggota_id' => $user->id, 'tahun' => $request->tahun],
            [
                'nipp'         => $request->nipp,
                'saldo_hutang' => $this->cleanNumber($request->saldo_hutang)
            ]
        );
        return redirect()->back()->with('success', "Hutang anggota $request->nipp diperbarui!");
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = ($user->status == 'aktif') ? 'keluar' : 'aktif';
        $user->save();
        return redirect()->back()->with('success', "Status anggota {$user->users} diperbarui!");
    }

    public function hapusAnggota($id)
    {
        $user = User::findOrFail($id);
        Simpanan::where('anggota_id', $id)->delete();
        Hutang::where('anggota_id', $id)->delete();
        TransaksiBulanan::where('anggota_id', $id)->delete();
        $user->delete();

        return redirect()->back()->with('success', "Data Anggota dihapus permanen dari sistem!");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    /**
     * Helper: Membersihkan format angka (titik, Rp, spasi)
     */
    private function cleanNumber($value) {
        if (!$value) return 0;
        if (is_numeric($value)) return (float) $value;
        $clean = str_replace(['.', ',', 'Rp', ' ', 'rp'], '', $value);
        return (float) $clean;
    }
}