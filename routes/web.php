<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\AuthController;


Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

Route::middleware(['auth'])->group(function () {
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
Route::get('/my-hutang', [UserController::class, 'showHutang'])->name('user.hutang');
Route::get('/my-simpanan', [UserController::class, 'showSimpanan'])->name('user.simpanan');

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Rute Logout Umum
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


});
