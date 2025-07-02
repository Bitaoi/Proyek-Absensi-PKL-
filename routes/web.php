<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;

// Ini adalah rute pertama yang akan diakses saat URL utama "/" dibuka
Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [LoginController::class, 'login'])->name('login'); 

Route::get('/form', [GuestController::class, 'create'])->name('guest.form');
Route::post('/store', [GuestController::class, 'store'])->name('guest.store');
Route::get('/kelurahan/{kecamatan_id}', [GuestController::class, 'getKelurahan']);

// --- Rute untuk Admin Login ---
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login']); // <--- POTENSI MASALAH 2: Ini juga memanggil method 'login'
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

Route::get('/admin/dashboardadmin', [AdminController::class, 'index'])->name('dashboard');
    // Route untuk laporan mingguan, bulanan, export, lihat aktivitas akan ditambahkan di sini
