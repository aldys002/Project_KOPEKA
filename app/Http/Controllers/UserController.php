<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Halaman Dashboard Utama User
     */
    public function index()
    {
        $user = Auth::user(); // Mengambil data dari tabel 'anggota'
        
        // Ambil data dari tabel simpanan & hutang berdasarkan anggota_id (id user yang login)
        $simpanan = DB::table('simpanan')->where('anggota_id', $user->id)->first();
        $hutang = DB::table('hutang')->where('anggota_id', $user->id)->first();

        // Logika perhitungan bunga hutang otomatis
        $saldoAwal = $hutang->saldo_hutang ?? 0; 
        $tanggalAwal = Carbon::create(2025, 1, 1);
        $selisihBulan = $tanggalAwal->diffInMonths(Carbon::now());
        
        // Bunga 1% per bulan
        $totalHutangSekarang = $saldoAwal + ($saldoAwal * 0.01 * $selisihBulan);

        // Bungkus dalam object untuk mempermudah pemanggilan di dashboard.blade.php
        $keuangan = (object)[
            'simp_pokok'     => $simpanan->pokok ?? 0,
            'simp_wajib'     => $simpanan->wajib ?? 0,
            'simp_sukarela'  => $simpanan->sukarela ?? 0,
            'saldo_hutang'   => $totalHutangSekarang,
            'total_simpanan' => $simpanan->total_simpanan ?? 0,
        ];

        return view('user.dashboard', compact('user', 'keuangan'));
    }

    /**
     * Halaman Detail Pinjaman/Hutang
     */
    public function showHutang()
    {
        $user = Auth::user();
        
        // Cari berdasarkan anggota_id sesuai struktur migration
        $hutang = DB::table('hutang')->where('anggota_id', $user->id)->first();

        $saldoAwal = $hutang->saldo_hutang ?? 0;

        // Perhitungan Bunga 1% dari Januari 2025
        $tanggalAwal = Carbon::create(2025, 1, 1);
        $tanggalSekarang = Carbon::now();
        $selisihBulan = $tanggalAwal->diffInMonths($tanggalSekarang);

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

    /**
     * Halaman Detail Simpanan
     */
    public function showSimpanan()
    {
        $user = Auth::user();
        
        // Cari berdasarkan anggota_id (Id primer di tabel anggota)
        $simpanan = DB::table('simpanan')->where('anggota_id', $user->id)->first();

        return view('user.simpanan', compact('user', 'simpanan'));
    }
}