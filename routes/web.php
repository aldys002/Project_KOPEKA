<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminController;



// --- Halaman Depan ---
Route::get('/', function () {
    return view('welcome'); 
})->name('home');

// Halaman Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
// Proses Simpan Register
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// --- Login User Biasa ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// --- Login Khusus Admin ---
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

// --- Group Middleware Auth (Hanya yang sudah login bisa akses) ---
Route::middleware(['auth'])->group(function () {

    // --- Rute Khusus Admin ---
    Route::prefix('admin')->group(function () {
        Route::get('/home', function() {
        return Auth::user()->role === 'admin' 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('user.dashboard');
    })->name('dashboard');
        // Dashboard & Logout
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        Route::get('/admin/laporan-bulanan', [AdminController::class, 'laporanBulanan'])->name('admin.laporan.bulanan');
        Route::post('/admin/laporan-bulanan/simpan', [AdminController::class, 'simpanBulanan'])->name('admin.laporan.simpan');
        // Manajemen Anggota (Input Data, Tambah Anggota, & Status Pensiun)
        Route::get('/anggota', [AdminController::class, 'listAnggota'])->name('admin.anggota.index');
        Route::post('/anggota/tambah', [AdminController::class, 'tambahAnggota'])->name('admin.anggota.tambah');
        Route::post('/anggota/status/{id}', [AdminController::class, 'toggleStatus'])->name('admin.anggota.status');

        // Update Simpanan & Hutang
        Route::post('/input-simpanan', [AdminController::class, 'inputSimpanan'])->name('admin.simpanan.update');
        Route::post('/input-hutang', [AdminController::class, 'inputHutang'])->name('admin.hutang.update');
    });

    // --- Rute Untuk User Biasa ---
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/my-simpanan', [UserController::class, 'showSimpanan'])->name('user.simpanan');

    // --- Logout Umum ---
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});