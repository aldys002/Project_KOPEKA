<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin() {
        // Jika sudah login, lempar langsung ke dashboard
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }
        return view('login');
    }

    public function login(Request $request) {
        // 1. Validasi input
        $request->validate([
            'nama_anggota' => 'required',
            'identity'     => 'required', // Ini field NIPP/NIK
            'password'     => 'required',
        ]);

        // 2. Cari user berdasarkan NIPP ATAU NIK
        // Kita cek di dua kolom sekaligus agar anggota tanpa NIPP bisa login
        $user = User::where('nipp', $request->identity)
                    ->orWhere('nik', $request->identity)
                    ->first();

        if ($user) {
            // 3. Cek apakah Nama cocok (Case Insensitive)
            // Menggunakan strtolower agar 'Budi' dan 'budi' tetap dianggap sama
            $inputNama = strtolower(trim($request->nama_anggota));
            $dbNama    = strtolower(trim($user->users));

            if ($dbNama === $inputNama) {
                
                // 4. Cek Password
                if (Hash::check($request->password, $user->password)) {
                    
                    // 5. Login-kan ke session
                    Auth::login($user);
                    
                    $request->session()->regenerate();
                    
                    // Cek role: jika admin ke dashboard admin, jika user ke dashboard user
                    if ($user->role === 'admin') {
                        return redirect()->intended('/admin/dashboard');
                    }
                    
                    return redirect()->intended('/dashboard');
                }
            }
        }

        // Jika gagal, kembalikan dengan pesan error yang aman
        return back()->withErrors([
            'error' => 'Kombinasi Nama, Identitas (NIPP/NIK), atau Password salah!'
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}