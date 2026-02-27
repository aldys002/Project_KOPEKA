<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// Halaman Login
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Group Middleware Auth
Route::middleware(['auth'])->group(function () {
<<<<<<< HEAD
    
    // Dashboard (Manggil UserController@index)
=======

    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/anggota', [AdminController::class, 'listAnggota'])->name('admin.anggota.index');

    // Dashboard User
>>>>>>> 8ff7fe3890995f9f613cc5e2872f308bd4fe6c47
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    
    // Fitur Tambahan
    Route::get('/my-hutang', [UserController::class, 'showHutang'])->name('user.hutang');
    Route::get('/my-simpanan', [UserController::class, 'showSimpanan'])->name('user.simpanan');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});