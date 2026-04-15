<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    public function tambahAnggota(Request $request)
    {
        $request->validate([
            'nipp'  => 'required|unique:anggota,nipp',
            'users' => 'required', 
            'tahun' => 'required|numeric',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'nipp'     => $request->nipp,
                    'nik'      => $request->nik,
                    'users'    => $request->users,
                    'password' => null, 
                    'role'     => 'user',
                    'status'   => 'aktif',
                ]);

                $pokok    = $this->cleanNumber($request->pokok);
                $wajib    = $this->cleanNumber($request->wajib);
                $sukarela = $this->cleanNumber($request->sukarela);
                $hutang   = $this->cleanNumber($request->saldo_hutang);

                TransaksiBulanan::create([
                    'anggota_id'   => $user->id,
                    'bulan'        => date('n'),
                    'tahun'        => $request->tahun,
                    'pokok'        => $pokok,
                    'wajib'        => $wajib,
                    'sukarela'     => $sukarela,
                    'saldo_hutang' => $hutang,
                ]);

                Simpanan::create([
                    'anggota_id'     => $user->id,
                    'nipp'           => $user->nipp,
                    'tahun'          => $request->tahun,
                    'pokok'          => $pokok,
                    'wajib'          => $wajib,
                    'sukarela'       => $sukarela,
                    'total_simpanan' => $pokok + $wajib + $sukarela
                ]);

                Hutang::create([
                    'anggota_id'   => $user->id,
                    'nipp'         => $user->nipp,
                    'tahun'        => $request->tahun,
                    'saldo_hutang' => $hutang
                ]);
            });

            return redirect()->back()->with('success', "Anggota {$request->users} berhasil didaftarkan!");

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal simpan data: ' . $e->getMessage()]);
        }
    }

    public function listAnggota(Request $request)
    {
        $tahunAktif = $request->get('tahun', date('Y'));
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

    /**
     * SIMPAN BULANAN - VERSI FIX 2026 & DATA BESAR
     */
    public function simpanBulanan(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $dataInput = $request->input('data'); 

        if (!$dataInput) {
            return redirect()->back()->withErrors(['error' => 'Tidak ada data yang dikirim. Cek limit max_input_vars PHP.']);
        }

        try {
            DB::transaction(function () use ($dataInput, $bulan, $tahun) {
                foreach ($dataInput as $anggotaId => $nilai) {
                    // Bersihkan input angka
                    $p = $this->cleanNumber($nilai['pokok'] ?? 0);
                    $w = $this->cleanNumber($nilai['wajib'] ?? 0);
                    $s = $this->cleanNumber($nilai['sukarela'] ?? 0);
                    $h = $this->cleanNumber($nilai['saldo_hutang'] ?? 0);

                    // 1. Update/Create Transaksi Bulanan (Primary Key: anggota, bulan, tahun)
                    TransaksiBulanan::updateOrCreate(
                        ['anggota_id' => $anggotaId, 'bulan' => $bulan, 'tahun' => $tahun],
                        [
                            'pokok'        => $p,
                            'wajib'        => $w,
                            'sukarela'     => $s,
                            'saldo_hutang' => $h,
                        ]
                    );

                    // 2. Sinkronkan ke tabel akumulasi (Simpanan & Hutang)
                    $user = User::find($anggotaId);
                    if ($user) {
                        // Ambil total simpanan satu tahun tersebut
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
                                'saldo_hutang' => $h, 
                            ]
                        );
                    }
                }
            });

            return redirect()->back()->with('success', "Laporan bulan $bulan tahun $tahun berhasil disimpan!");
        } catch (\Exception $e) {
            \Log::error("Error Simpan Bulanan: " . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal: ' . $e->getMessage()]);
        }
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

        return redirect()->back()->with('success', "Data Anggota dihapus permanen!");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    private function cleanNumber($value) {
        if (!$value) return 0;
        if (is_numeric($value)) return (float) $value;
        $clean = preg_replace('/[^0-9]/', '', $value);
        return (float) $clean;
    }

    public function updateIdentitas(Request $request)
    {
        $request->validate([
            'id'    => 'required',
            'users' => 'required|string|max:255',
            'nik'   => 'nullable|string|max:20',
        ]);

        try {
            DB::table('anggota')->where('id', $request->id)->update([
                'users' => $request->users,
                'nik'   => $request->nik,
                'updated_at' => now(),
            ]);
            return redirect()->back()->with('success', "Identitas anggota berhasil diperbarui!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Gagal: " . $e->getMessage());
        }
    }

public function exportExcel(Request $request)
{
    $tahun = $request->get('tahun', date('Y'));
    $nama_file = 'Laporan_Simpanan_Hutang_KOPEKA_' . $tahun . '.csv';

    // Ambil data simpanan berdasarkan tahun
    $data = \App\Models\Simpanan::where('tahun', $tahun)->get();

    $headers = [
        "Content-type"        => "text/csv",
        "Content-Disposition" => "attachment; filename=$nama_file",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    // Kita tambahkan $tahun ke dalam 'use' agar bisa dipakai di dalam callback
    $callback = function() use($data, $tahun) {
        $file = fopen('php://output', 'w');
        
        // 1. Tambahkan 'Hutang' di Header Kolom
        fputcsv($file, ['NIPP', 'Tahun', 'Pokok', 'Wajib', 'Sukarela', 'Hutang', 'Total Simpanan']);

        foreach ($data as $row) {
            // 2. Cari data hutang untuk anggota ini di tahun yang sama
            $hutang = \App\Models\Hutang::where('anggota_id', $row->anggota_id)
                        ->where('tahun', $tahun)
                        ->first();

            // 3. Masukkan ke baris Excel
            fputcsv($file, [
                $row->nipp,
                $row->tahun,
                $row->pokok,
                $row->wajib,
                $row->sukarela,
                $hutang ? $hutang->saldo_hutang : 0, // Ambil saldo_hutang jika ada, kalau tidak ada kasih 0
                $row->total_simpanan,
            ]);
        }
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}