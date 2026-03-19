<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Hutang;
use App\Models\Simpanan;
use App\Models\TransaksiBulanan;
use Illuminate\Support\Facades\Hash;

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
     * Dashboard Dinamis per Tahun
     */
    public function dashboard(Request $request)
    {
        $tahunAktif = $request->get('tahun', date('Y'));
        $daftarTahun = range(2025, date('Y') + 5);

        $totalAnggota  = User::where('role', 'user')->count();
        $anggotaAktif  = User::where('role', 'user')->where('status', 'aktif')->count();
        $anggotaKeluar = User::where('role', 'user')->where('status', 'keluar')->count();

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
     * LAPORAN BULANAN: Input Massal per Bulan
     * Diurutkan berdasarkan ID agar sesuai CSV
     */
    public function laporanBulanan(Request $request)
    {
        $tahunAktif = $request->get('tahun', date('Y'));
        $bulanAktif = $request->get('bulan', date('n'));

        // PERBAIKAN: Tambah orderBy('id', 'asc')
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

    /**
     * SIMPAN LAPORAN: Simpan data bulanan & Sync ke Saldo Utama
     */
    public function simpanBulanan(Request $request)
{
    $tahun = $request->tahun;
    $bulan = $request->bulan;
    $dataInput = $request->input('data'); 

    if (!$dataInput) {
        return redirect()->back()->withErrors(['error' => 'Tidak ada data yang dikirim.']);
    }

    foreach ($dataInput as $anggotaId => $nilai) {
        // 1. Update History Bulanan
        TransaksiBulanan::updateOrCreate(
            ['anggota_id' => $anggotaId, 'bulan' => $bulan, 'tahun' => $tahun],
            [
                'pokok'        => $nilai['pokok'] ?? 0,
                'wajib'        => $nilai['wajib'] ?? 0,
                'sukarela'     => $nilai['sukarela'] ?? 0,
                'saldo_hutang' => $nilai['saldo_hutang'] ?? 0, // PASTIKAN NAMA KOLOM INI BENAR
            ]
        );

        $user = User::find($anggotaId);
        if ($user) {
            // 2. Akumulasi Simpanan (Tetap seperti kodinganmu sebelumnya)
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

            Hutang::updateOrCreate(
                ['anggota_id' => $anggotaId, 'tahun' => $tahun],
                [
                    'nipp'         => $user->nipp,
                    'saldo_hutang' => $nilai['saldo_hutang'] ?? 0, 
                ]
            );
        }
    }

    return redirect()->back()->with('success', "Laporan bulan $bulan tahun $tahun berhasil disinkronkan!");
}
    /**
     * KELOLA SALDO: Menampilkan daftar anggota & total saldo pertahun
     * Diurutkan berdasarkan ID agar konsisten
     */
    public function listAnggota(Request $request)
    {
        $tahunAktif = $request->get('tahun', date('Y'));

        // PERBAIKAN: Ubah pengurutan dari 'status' ke 'id'
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

    public function tambahAnggota(Request $request)
    {
        $request->validate([
            'nipp'     => 'required|unique:anggota,nipp',
            'users'    => 'required', 
            'password' => 'required|min:6',
        ]);

        User::create([
            'nipp'     => $request->nipp,
            'users'    => $request->users,
            'password' => Hash::make($request->password),
            'role'     => 'user',
            'status'   => 'aktif',
        ]);

        return redirect()->back()->with('success', "Anggota baru berhasil didaftarkan!");
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = ($user->status == 'aktif') ? 'keluar' : 'aktif';
        $user->save();

        return redirect()->back()->with('success', "Status anggota berhasil diperbarui!");
    }

    public function inputSimpanan(Request $request)
    {
        $user = User::where('nipp', $request->nipp)->first();
        if (!$user) return redirect()->back()->withErrors(['error' => 'Anggota tidak ditemukan.']);

        Simpanan::updateOrCreate(
            ['anggota_id' => $user->id, 'tahun' => $request->tahun],
            [
                'nipp'           => $request->nipp,
                'pokok'          => $request->pokok,
                'wajib'          => $request->wajib,
                'sukarela'       => $request->sukarela,
                'total_simpanan' => (int)$request->pokok + (int)$request->wajib + (int)$request->sukarela
            ]
        );
        return redirect()->back()->with('success', "Saldo manual berhasil diupdate!");
    }

    public function inputHutang(Request $request)
    {
        $user = User::where('nipp', $request->nipp)->first();
        if (!$user) return redirect()->back()->withErrors(['error' => 'Anggota tidak ditemukan.']);

        Hutang::updateOrCreate(
            ['anggota_id' => $user->id, 'tahun' => $request->tahun],
            [
                'nipp'         => $request->nipp,
                'saldo_hutang' => $request->saldo_hutang
            ]
        );
        return redirect()->back()->with('success', "Data hutang berhasil disimpan!");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    public function hapusAnggota($id)
{
    $user = User::findOrFail($id);
    
    // Opsional: Hapus data terkait agar database bersih (Cascade Manual)
    \App\Models\Simpanan::where('anggota_id', $id)->delete();
    \App\Models\Hutang::where('anggota_id', $id)->delete();
    \App\Models\TransaksiBulanan::where('anggota_id', $id)->delete();
    
    $user->delete();

    return redirect()->back()->with('success', "Anggota {$user->users} dan seluruh data keuangannya telah dihapus!");
}
}