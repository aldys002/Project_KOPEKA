<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome'); 
})->name('home');
// --- Halaman Login ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// --- Group Middleware Auth (Hanya yang sudah login) ---
Route::middleware(['auth'])->group(function () {

    // --- Rute Untuk Admin ---
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/anggota', [AdminController::class, 'listAnggota'])->name('admin.anggota.index');
    Route::post('/admin/input-simpanan', [AdminController::class, 'inputSimpanan'])->name('admin.simpanan.update');
Route::post('/admin/input-hutang', [AdminController::class, 'inputHutang'])->name('admin.hutang.update');

    // --- Rute Untuk User Biasa ---
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/my-hutang', [UserController::class, 'showHutang'])->name('user.hutang');
    Route::get('/my-simpanan', [UserController::class, 'showSimpanan'])->name('user.simpanan');

    // --- Logout Umum ---
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});