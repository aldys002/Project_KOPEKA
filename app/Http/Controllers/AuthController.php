<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login untuk User/Anggota
    public function showLogin()
    {
        return view('login'); // Pastikan kamu punya file resources/views/login.blade.php
    }

    // Proses login untuk User/Anggota
    public function login(Request $request)
    {
        // Validasi input NIPP dan Password
        $credentials = $request->validate([
            'nipp'     => 'required',
            'password' => 'required',
        ]);

        // Coba proses login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // CEK ROLE: Jika admin masuk ke dashboard admin, jika user masuk ke dashboard user
            if (Auth::user()->role == 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            // Jika role-nya 'user' atau anggota
            return redirect()->intended('/dashboard');
        }

        // Jika gagal login
        return back()->withErrors([
            'loginError' => 'NIPP atau Password salah!',
        ])->onlyInput('nipp');
    }

    // Proses Logout (Bisa dipakai Admin maupun User)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/'); // Balik ke halaman login awal
    }
}