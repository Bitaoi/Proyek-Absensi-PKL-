<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController; 

Route::get('/', function () {
    return view('welcome');
});

// Tampilkan form buku tamu (halaman utama)
Route::get('/', [GuestController::class, 'create'])->name('guest.form');

// Simpan data buku tamu
Route::post('/store', [GuestController::class, 'store'])->name('guest.store');

// Ambil data kelurahan berdasarkan kecamatan (untuk Ajax)
Route::get('/kelurahan/{kecamatan_id}', [GuestController::class, 'getKelurahan']);

//route log in dan log out
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login']);
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    // Route untuk laporan mingguan, bulanan, export, lihat aktivitas akan ditambahkan di sini
});
