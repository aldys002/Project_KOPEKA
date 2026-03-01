<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\AuthController;

// 1. Ganti '/login' jadi '/' supaya alamat utama 127.0.0.1:8000 GAK 404
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// 2. Login khusus Admin
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

/* --- Rute yang butuh Login --- */
Route::middleware(['auth'])->group(function () {

    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/anggota', [AdminController::class, 'listAnggota'])->name('admin.anggota.index');
    Route::post('/admin/input-simpanan', [AdminController::class, 'inputSimpanan'])->name('admin.simpanan.update');
Route::post('/admin/input-hutang', [AdminController::class, 'inputHutang'])->name('admin.hutang.update');

    // Dashboard User
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/my-hutang', [UserController::class, 'showHutang'])->name('user.hutang');
    Route::get('/my-simpanan', [UserController::class, 'showSimpanan'])->name('user.simpanan');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
