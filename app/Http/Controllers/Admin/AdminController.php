<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
public function showLogin() {
return view('admin.login');
}

public function login(Request $request) {
    $request->validate([
        'nipp' => 'required',
        'password' => 'required',
    ]);

    $credentials = $request->only('nipp', 'password');

    if (Auth::attempt($credentials)) {
        if (strtolower(Auth::user()->role) == 'admin') {
            $request->session()->regenerate();
            return redirect('/admin/dashboard'); 
        }
        
        Auth::logout();
        return back()->withErrors(['error' => 'Akses ditolak!']);
    }

    // Jika gagal, pastikan pesan error ini muncul di layar
    return back()->withInput()->withErrors(['error' => 'NIPP atau Password salah!']);
}

public function dashboard() {
   
    $totalAnggota = \App\Models\User::where('role', 'user')->count();
    return view('admin.dashboard', compact('totalAnggota'));
}

public function listAnggota() {
    $anggota = \App\Models\User::where('role', 'user')->get();
    return view('admin.anggota_index', compact('anggota'));
}

public function inputSimpanan(Request $request)
{
    $request->validate([
        'nipp' => 'required|exists:anggota,nipp',
        'pokok' => 'required|numeric',
        'wajib' => 'required|numeric',
        'sukarela' => 'required|numeric',
    ]);

    \App\Models\Simpanan::updateOrCreate(
        ['nipp' => $request->nipp],
        [
            'pokok' => $request->pokok,
            'wajib' => $request->wajib,
            'sukarela' => $request->sukarela,
        ]
    );

    return redirect()->back()->with('success', 'Data simpanan berhasil diperbarui!');
}

public function inputHutang(Request $request)
{
    $request->validate([
        'nipp' => 'required|exists:anggota,nipp',
        'saldo_hutang_2025' => 'required|numeric',
    ]);

    \App\Models\Hutang::updateOrCreate(
        ['nipp' => $request->nipp],
        ['saldo_hutang_2025' => $request->saldo_hutang_2025]
    );

    return redirect()->back()->with('success', 'Data hutang berhasil diperbarui!');
}

public function logout(Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/admin/login');
}
}
