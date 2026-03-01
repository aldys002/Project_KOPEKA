<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil data dari database
        $simpanan = DB::table('simpanan')->where('nipp', $user->nipp)->first();
        $hutang = DB::table('hutang')->where('nipp', $user->nipp)->first();

        $saldoAwal = $hutang->saldo_hutang_2025 ?? 0;
        $tanggalAwal = Carbon::create(2025, 1, 1);
        $selisihBulan = $tanggalAwal->diffInMonths(Carbon::now());
        $totalHutangSekarang = $saldoAwal + ($saldoAwal * 0.01 * $selisihBulan);

        // Bungkus dalam object biar manggil di view-nya gampang
        $keuangan = (object)[
            'simp_pokok'     => $simpanan->pokok ?? 0,
            'simp_wajib'     => $simpanan->wajib ?? 0,
            'simp_sukarela'  => $simpanan->sukarela ?? 0,
            'saldo_hutang'   => $hutang->saldo_hutang_2025 ?? 0,
            'total_simpanan' => $simpanan->total_simpanan ?? 0,
        ];

        // Pastikan view-nya diarahkan ke folder user
        return view('user.dashboard', compact('user', 'keuangan'));
    }

   public function showHutang()
{
    $user = Auth::user();
    $hutang = DB::table('hutang')->where('nipp', $user->nipp)->first();

    $saldoAwal = $hutang->saldo_hutang_2025 ?? 0;

    // 1. Tentukan tanggal awal (Januari 2025)
    $tanggalAwal = Carbon::create(2025, 1, 1);
    
    // 2. Tentukan tanggal sekarang
    $tanggalSekarang = Carbon::now();

    // 3. Hitung selisih bulan
    $selisihBulan = $tanggalAwal->diffInMonths($tanggalSekarang);

    // 4. Hitung total hutang + bunga 1% per bulan
    // Rumus: Saldo + (Saldo * 0.01 * jumlah bulan)
    $bunga = $saldoAwal * 0.01 * $selisihBulan;
    $totalHutangSekarang = $saldoAwal + $bunga;

    return view('user.hutang', compact(
        'user', 
        'hutang', 
        'saldoAwal', 
        'totalHutangSekarang', 
        'selisihBulan', 
        'bunga'
    ));
}

    public function showSimpanan()
    {
        $user = Auth::user();
        $simpanan = DB::table('simpanan')->where('nipp', $user->nipp)->first();

        return view('user.simpanan', compact('user', 'simpanan'));
    }
}