<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB; // WAJIB ADA BIAR GAK ERROR CLASS DB

class AuthController extends Controller
{   
    public function showRegister() {
        return view('register');
    }

    public function register(Request $request) {
        // 1. Validasi Input: NIPP atau NIK boleh kosong salah satu
        $request->validate([
            'nama_anggota' => 'required|string|max:150',
            'nipp'         => 'nullable|unique:anggota,nipp', 
            'nik'          => 'nullable|unique:anggota,nik',  
            'password'     => 'required|min:8|confirmed',
        ], [
            'nipp.unique' => 'NIPP ini sudah terdaftar sebagai akun.',
            'nik.unique'  => 'NIK ini sudah terdaftar sebagai akun.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.'
        ]);

        // Proteksi: Minimal satu identitas wajib diisi
        if (!$request->nipp && !$request->nik) {
            return back()->withErrors(['error' => 'Wajib mengisi NIPP atau NIK untuk mendaftar.'])->withInput();
        }

        // 2. Simpan Anggota Baru
        $anggotaId = DB::table('anggota')->insertGetId([
            'users'      => $request->nama_anggota,
            'nipp'       => $request->nipp,
            'nik'        => $request->nik, 
            'password'   => Hash::make($request->password),
            'role'       => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. LOGIKA PENYAMBUNG SALDO (Kunci agar tidak Rp 0)
        // Ambil nomor identitas yang tersedia (Contoh: 171277)
        $identity = $request->nipp ?? $request->nik;

        // Cari di tabel simpanan, apakah ada data "gantung" dengan nomor tersebut?
        $dataExist = DB::table('simpanan')
                    ->where('nipp_asal', $identity)
                    ->orWhere('nik_asal', $identity)
                    ->exists();

        if ($dataExist) {
            // Jika ada, langsung hubungkan ke ID anggota yang baru lahir
            DB::table('simpanan')
                ->where('nipp_asal', $identity)
                ->orWhere('nik_asal', $identity)
                ->update(['anggota_id' => $anggotaId]);

            DB::table('hutang')
                ->where('nipp_asal', $identity)
                ->orWhere('nik_asal', $identity)
                ->update(['anggota_id' => $anggotaId]);
        } else {
            // Jika benar-benar orang baru tanpa data di CSV
            DB::table('simpanan')->insert([
                'anggota_id'     => $anggotaId,
                'nipp_asal'      => $request->nipp,
                'nik_asal'       => $request->nik,
                'tahun'          => date('Y'),
                'pokok' => 0, 'wajib' => 0, 'sukarela' => 0, 'total_simpanan' => 0,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
            
            DB::table('hutang')->insert([
                'anggota_id'     => $anggotaId,
                'nipp_asal'      => $request->nipp,
                'nik_asal'       => $request->nik,
                'tahun'          => date('Y'),
                'saldo_hutang'   => 0,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login untuk cek saldo.');
    }

    public function showLogin() {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }
        return view('login');
    }

    public function login(Request $request) {
        $request->validate([
            'nama_anggota' => 'required',
            'identity'     => 'required', 
            'password'     => 'required',
        ]);

        // Cari user: Cek kolom NIPP ATAU NIK (Fleksibel buat yang gak punya NIPP)
        $user = User::where('nipp', $request->identity)
                    ->orWhere('nik', $request->identity)
                    ->first();

        if ($user) {
            // Validasi Nama (Trim dan Lowercase biar gak sensitif spasi/huruf besar)
            $inputNama = strtolower(trim($request->nama_anggota));
            $dbNama    = strtolower(trim($user->users));

            if ($dbNama === $inputNama) {
                if (Hash::check($request->password, $user->password)) {
                    Auth::login($user);
                    $request->session()->regenerate();
                    
                    return ($user->role === 'admin') 
                        ? redirect()->intended('/admin/dashboard') 
                        : redirect()->intended('/dashboard');
                }
            }
        }

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