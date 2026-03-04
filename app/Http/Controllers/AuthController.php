<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{   public function showRegister() {
    return view('register');
}

public function register(Request $request) {
    // 1. Validasi Input
    $request->validate([
        'nama_anggota' => 'required|string|max:150',
        'nipp'         => 'required|unique:anggota,nipp', // NIPP harus unik di tabel anggota
        'nik'          => 'nullable', // NIK boleh setengah atau kosong
        'password'     => 'required|min:8|confirmed',
    ], [
        'nipp.unique' => 'NIPP ini sudah terdaftar sebagai akun.',
        'password.confirmed' => 'Konfirmasi password tidak sesuai.'
    ]);

    // 2. Simpan Anggota Baru ke tabel 'anggota'
    // id ini yang akan jadi 'anggota_id' di tabel simpanan & hutang
    $anggotaId = DB::table('anggota')->insertGetId([
        'users'      => $request->nama_anggota,
        'nipp'       => $request->nipp,
        'nik'        => $request->nik, 
        'password'   => Hash::make($request->password),
        'role'       => 'user',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // 3. LOGIKA PENYAMBUNG (The Magic Part)
    // Cek apakah NIPP ini sudah ada di tabel simpanan (hasil import CSV sebelumnya)
    $dataExist = DB::table('simpanan')->where('nipp_asal', $request->nipp)->exists();

    if ($dataExist) {
        // Jika data gantung ada, hubungkan dengan anggota_id yang baru lahir
        DB::table('simpanan')->where('nipp_asal', $request->nipp)->update(['anggota_id' => $anggotaId]);
        DB::table('hutang')->where('nipp_asal', $request->nipp)->update(['anggota_id' => $anggotaId]);
    } else {
        // Jika data belum ada di CSV, buatkan baris saldo 0 biar dashboard gak error
        DB::table('simpanan')->insert([
            'anggota_id' => $anggotaId,
            'nipp_asal'  => $request->nipp,
            'tahun'      => date('Y'),
            'pokok'      => 0, 'wajib' => 0, 'sukarela' => 0, 'total_simpanan' => 0,
            'created_at' => now(),
        ]);
        DB::table('hutang')->insert([
            'anggota_id'   => $anggotaId,
            'nipp_asal'    => $request->nipp,
            'tahun'        => date('Y'),
            'saldo_hutang' => 0,
            'created_at'   => now(),
        ]);
    }

    return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login untuk melihat saldo Anda.');
}
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