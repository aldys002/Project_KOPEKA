<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil data murni dari database
        $simpanan = DB::table('simpanan')->where('anggota_id', $user->id)->first();
        $hutang = DB::table('hutang')->where('anggota_id', $user->id)->first();

        $keuangan = (object)[
            'simp_pokok'     => $simpanan->pokok ?? 0,
            'simp_wajib'     => $simpanan->wajib ?? 0,
            'simp_sukarela'  => $simpanan->sukarela ?? 0,
            'total_simpanan' => $simpanan->total_simpanan ?? 0,
            'saldo_hutang'   => $hutang->saldo_hutang ?? 0, // Murni dari CSV
        ];

        return view('user.dashboard', compact('user', 'keuangan'));
    }

    public function showSimpanan()
    {
        $user = Auth::user();
        $simpanan = DB::table('simpanan')->where('anggota_id', $user->id)->first();

        return view('user.simpanan', compact('user', 'simpanan'));
    }
    
    // Fungsi showHutang SUDAH DIHAPUS
}