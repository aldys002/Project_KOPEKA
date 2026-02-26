<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::user()->role == 'admin') {
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        }
        Auth::logout();
        return back()->withErrors(['error' => 'Khusus Admin!']);
    }
    return back()->withErrors(['error' => 'NIPP/Password Salah!']);
}

public function dashboard() {
    return view('admin.dashboard');
}

public function logout(Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/admin/login');
}
}
