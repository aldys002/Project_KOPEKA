<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Halaman Depan ---
Route::get('/', function () {
    return view('welcome'); 
})->name('home');

// --- Auth Umum (User) ---
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// --- Login Khusus Admin ---
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

// --- Group Middleware Auth (Harus Login) ---
Route::middleware(['auth'])->group(function () {

    // --- Grup Rute Khusus Admin ---
    Route::prefix('admin')->group(function () {
        
        // Dashboard & Logout
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        
        // Laporan Bulanan (GET untuk tampil, POST untuk simpan)
        // Name ini harus sinkron dengan action di form Blade kamu
        Route::get('/laporan-bulanan', [AdminController::class, 'laporanBulanan'])->name('admin.laporan.bulanan');
        Route::post('/laporan-bulanan/simpan', [AdminController::class, 'simpanBulanan'])->name('admin.laporan.simpan');
        
        // Manajemen Anggota
        Route::get('/anggota', [AdminController::class, 'listAnggota'])->name('admin.anggota.index');
        Route::post('/anggota/tambah', [AdminController::class, 'tambahAnggota'])->name('admin.anggota.tambah');
        Route::post('/anggota/update-identitas', [AdminController::class, 'updateIdentitas'])->name('admin.anggota.update.identitas');
        
        // Aksi Anggota (Toggle Status & Hapus)
        Route::post('/anggota/status/{id}', [AdminController::class, 'toggleStatus'])->name('admin.toggle.status');
        Route::delete('/anggota/{id}', [AdminController::class, 'hapusAnggota'])->name('admin.anggota.hapus');

        Route::get('/export-simpanan', [AdminController::class, 'exportExcel'])->name('admin.export.simpanan');
    });

    // --- Rute Untuk User Biasa ---
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/my-simpanan', [UserController::class, 'showSimpanan'])->name('user.simpanan');

    // Logout Umum
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});