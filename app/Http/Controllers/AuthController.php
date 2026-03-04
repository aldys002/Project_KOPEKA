<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{   
    // Menampilkan halaman registrasi (Aktivasi)
    public function showRegister() {
        return view('register');
    }

    /**
     * LOGIKA AKTIVASI AKUN
     */
    public function register(Request $request) {
        $request->validate([
            'nama_anggota' => 'required|string|max:150',
            'identity'     => 'required', 
            'password'     => 'required|min:8|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password.min'       => 'Password minimal harus 8 karakter.'
        ]);

        $identity = trim($request->identity);
        $namaInput = strtolower(trim($request->nama_anggota));

        // Cari data anggota dari CSV yang belum punya password
        $user = User::where(function($q) use ($identity) {
                    $q->where('nipp', $identity)->orWhere('nik', $identity);
                })
                ->whereNull('password') 
                ->first();

        if (!$user) {
            return back()->withErrors([
                'error' => 'Data tidak ditemukan atau akun sudah pernah diaktivasi.'
            ])->withInput();
        }

        if (strtolower(trim($user->users)) !== $namaInput) {
            return back()->withErrors([
                'error' => 'Nama Anggota tidak cocok dengan data kami.'
            ])->withInput();
        }

        $user->update([
            'password' => Hash::make($request->password),
            'updated_at' => now(),
        ]);

        return redirect()->route('login')->with('success', 'Aktivasi Berhasil! Silakan login.');
    }

    /**
     * TAMPILKAN LOGIN
     */
    public function showLogin() {
        if (Auth::check()) {
            // SINKRONISASI: Redirect ke 'user.dashboard' sesuai web.php
            return redirect()->route('user.dashboard');
        }
        return view('login');
    }

    /**
     * PROSES LOGIN
     */
    public function login(Request $request) {
        $request->validate([
            'nama_anggota' => 'required',
            'identity'     => 'required', 
            'password'     => 'required',
        ]);

        $user = User::where('nipp', $request->identity)
                    ->orWhere('nik', $request->identity)
                    ->first();

        if ($user) {
            if (is_null($user->password)) {
                return back()->withErrors(['error' => 'Akun belum diaktivasi. Silakan registrasi dulu.']);
            }

            $inputNama = strtolower(trim($request->nama_anggota));
            $dbNama    = strtolower(trim($user->users));

            if ($dbNama === $inputNama && Hash::check($request->password, $user->password)) {
                Auth::login($user);
                $request->session()->regenerate();
                
                // SINKRONISASI: Gunakan nama route yang benar
                return ($user->role === 'admin') 
                    ? redirect()->intended(route('admin.dashboard')) 
                    : redirect()->intended(route('user.dashboard'));
            }
        }

        return back()->withErrors([
            'error' => 'Nama, Identitas, atau Password salah!'
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}