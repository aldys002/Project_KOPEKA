<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// Halaman Login
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Group Middleware Auth
Route::middleware(['auth'])->group(function () {
    
    // Dashboard (Manggil UserController@index)
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    
    // Fitur Tambahan
    Route::get('/my-hutang', [UserController::class, 'showHutang'])->name('user.hutang');
    Route::get('/my-simpanan', [UserController::class, 'showSimpanan'])->name('user.simpanan');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});