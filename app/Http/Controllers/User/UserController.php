<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Tambahkan ini buat nyari user berdasarkan nama

class AuthController extends Controller
{
    public function showLogin() {
        return view('login');
    }

    public function login(Request $request) {
        // 1. Validasi input dari form
        $request->validate([
            'nama_anggota' => 'required',
            'nipp'         => 'required',
            'password'     => 'required',
        ]);

        // 2. Cek apakah ada User yang NIPP DAN Namanya cocok
        $user = User::where('nipp', $request->nipp)
                    ->where('nama_anggota', $request->nama_anggota)
                    ->first();

        if ($user) {
            // 3. Kalau user ketemu, baru cek passwordnya
            if (Auth::attempt(['nipp' => $request->nipp, 'password' => $request->password])) {
                $request->session()->regenerate();
                
                if (Auth::user()->role == 'admin') {
                    return redirect()->intended('/admin/dashboard');
                }
                return redirect()->intended('/dashboard');
            }
        }

        // 4. Kalau Nama, NIPP, atau Password salah
        return back()->withErrors(['error' => 'Data Nama, NIPP, atau Password tidak sesuai!']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}