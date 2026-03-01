<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin() {
        return view('login');
    }

    public function login(Request $request) {
        // 1. Validasi input - Nama field harus 'nama_anggota' sesuai file Blade lo
        $request->validate([
            'nama_anggota' => 'required',
            'nipp'         => 'required',
            'password'     => 'required',
        ]);

        // 2. Cari user berdasarkan NIPP (Primary Key)
        $user = User::where('nipp', $request->nipp)->first();

        if ($user) {
            // 3. Cek apakah Nama cocok (Case Insensitive)
            // Di database kolomnya namanya 'users', di input namanya 'nama_anggota'
            $inputNama = strtoupper($request->nama_anggota);
            $dbNama    = strtoupper($user->users);

            if ($dbNama === $inputNama) {
                
                // 4. Cek Password menggunakan Hash::check
                // Ini akan mengevaluasi 'kai123' terhadap hash Bcrypt di database
                if (Hash::check($request->password, $user->password)) {
                    
                    // 5. Login-kan secara manual ke dalam session Laravel
                    Auth::login($user);
                    
                    $request->session()->regenerate();
                    
                    // Lempar ke dashboard
                    return redirect()->intended('/dashboard');
                }
            }
        }

        // Jika salah satu (NIPP, Nama, atau Password) salah, balikkan error
        return back()->withErrors(['error' => 'Kombinasi Nama, NIPP, atau Password salah!'])->withInput();
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}