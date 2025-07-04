<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::get('/form', [GuestController::class, 'create'])->name('guest.form');
Route::post('/store', [GuestController::class, 'store'])->name('guest.store');
Route::get('/kelurahan/{kecamatan_id}', [GuestController::class, 'getKelurahan'])->name('kelurahan.byKecamatan');

// --------------------
// Rute Login Admin
// --------------------
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

// --------------------
// Rute Dashboard & Admin Panel
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/laporan-mingguan', [AdminController::class, 'laporanMingguan'])->name('admin.laporanMingguan');
Route::get('/admin/laporan-bulanan', [AdminController::class, 'laporanBulanan'])->name('admin.laporanBulanan');
Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.export');
Route::get('/admin/aktivitas', [AdminController::class, 'aktivitas'])->name('admin.aktivitas');
