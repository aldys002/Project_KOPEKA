<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // <-- ini juga perlu ditambahkan
use App\Models\User;

class UserController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nama_anggota' => 'required',
            'nipp'         => 'required',
            'password'     => 'required',
        ]);

        $user = User::where('nipp', $request->nipp)
                    ->where('nama_anggota', $request->nama_anggota)
                    ->first();

        if ($user) {
            if (Auth::attempt(['nipp' => $request->nipp, 'password' => $request->password])) {
                $request->session()->regenerate();

                if (Auth::user()->role == 'admin') {
                    return redirect()->intended('/admin/dashboard');
                }

                return redirect()->intended('/dashboard');
            }
        }

        return back()->withErrors([
            'error' => 'Data Nama, NIPP, atau Password tidak sesuai!'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function index()
    {
        $user = Auth::user();

        $totalSimpanan = 0;
        $sisaHutang = 0;

        return view('user.dashboard', compact('user', 'totalSimpanan', 'sisaHutang'));
    }
}