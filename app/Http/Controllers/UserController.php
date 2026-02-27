<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $simpanan = DB::table('simpanan')->where('nipp', $user->nipp)->first();
        $hutang = DB::table('hutang')->where('nipp', $user->nipp)->first();

        $keuangan = (object)[
            'simp_pokok'    => $simpanan->pokok ?? 0,
            'simp_wajib'    => $simpanan->wajib ?? 0,
            'simp_sukarela' => $simpanan->sukarela ?? 0,
            'saldo_hutang'  => $hutang->saldo_hutang_2025 ?? 0,
            'total_simpanan' => $simpanan->total_simpanan ?? 0,
        ];

        return view('dashboard', compact('user', 'keuangan'));
    }

    public function showHutang() {
        $user = Auth::user();
        $hutang = DB::table('hutang')->where('nipp', $user->nipp)->first();
        return view('user.hutang', compact('user', 'hutang'));
    }

    public function showSimpanan() {
        $user = Auth::user();
        $simpanan = DB::table('simpanan')->where('nipp', $user->nipp)->first();
        return view('user.simpanan', compact('user', 'simpanan'));
    }
}