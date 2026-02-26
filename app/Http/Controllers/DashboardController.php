<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil user login
        $user = Auth::user()->load(['simpanan', 'hutang']);
        
        // Menghitung total simpanan & sisa hutang (opsional buat tampilan kartu)
        $totalSimpanan = $user->simpanan->sum('jumlah');
        $sisaHutang = $user->hutang->sum('sisa_tagihan');

        return view('dashboard', compact('user', 'totalSimpanan', 'sisaHutang'));
    }
}