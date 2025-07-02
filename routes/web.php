<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;

// ======= Form Buku Tamu =======
Route::get('/form', [GuestController::class, 'create'])->name('guest.form');
Route::post('/store', [GuestController::class, 'store'])->name('guest.store');
Route::get('/kelurahan/{kecamatan_id}', [GuestController::class, 'getKelurahan']);

// ======= Login Admin (optional - jika pakai login) =======
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login']);
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

