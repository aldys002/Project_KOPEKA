<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Auth;

// --- Halaman Depan ---
Route::get('/', function () {
    return view('welcome'); 
})->name('home');

// --- Auth Umum ---
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// --- Login Khusus Admin ---
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

// --- Group Middleware Auth ---
Route::middleware(['auth'])->group(function () {

    // --- Rute Khusus Admin ---
    Route::prefix('admin')->group(function () {
        
        // Dashboard & Logout
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        
        // Laporan Bulanan (Dihapus kata /admin/ di depannya karena sudah ada prefix)
        Route::get('/laporan-bulanan', [AdminController::class, 'laporanBulanan'])->name('admin.laporan.bulanan');
        Route::post('/laporan-bulanan/simpan', [AdminController::class, 'simpanBulanan'])->name('admin.laporan.simpan');
        
        // Manajemen Anggota
        Route::get('/anggota', [AdminController::class, 'listAnggota'])->name('admin.anggota.index');
        Route::post('/anggota/tambah', [AdminController::class, 'tambahAnggota'])->name('admin.anggota.tambah');
        
        // Toggle Status (Sesuaikan name dengan yang ada di controller/blade)
        Route::post('/anggota/status/{id}', [AdminController::class, 'toggleStatus'])->name('admin.toggle.status');
        
        // Hapus Anggota (Dihapus kata /admin/ di depan)
        Route::delete('/anggota/{id}', [AdminController::class, 'hapusAnggota'])->name('admin.anggota.hapus');

        // Update Saldo (Manual via Modal)
        Route::post('/input-simpanan', [AdminController::class, 'inputSimpanan'])->name('admin.simpanan.update');
        Route::post('/input-hutang', [AdminController::class, 'inputHutang'])->name('admin.hutang.update');
    });

    // --- Rute Untuk User Biasa ---
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/my-simpanan', [UserController::class, 'showSimpanan'])->name('user.simpanan');

    // --- Logout Umum ---
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});