<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController; 
use App\Http\Controllers\Admin\LaporanController; 

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/form', [GuestController::class, 'create'])->name('guest.form');
Route::post('/store', [GuestController::class, 'store'])->name('guest.store');
Route::get('/kelurahan/{kecamatan_id}', [GuestController::class, 'getKelurahan'])->name('kelurahan.byKecamatan');


Route::get('login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('login', [LoginController::class, 'login'])->name('admin.login.submit');
Route::post('logout', [LoginController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () { // Contoh middleware: pastikan user adalah admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Rute Laporan Mingguan
    Route::get('/laporan-mingguan', [AdminController::class, 'laporanMingguan'])->name('laporanMingguan');
    // Rute Export Mingguan (mengarah ke LaporanController)
    Route::get('/laporan-mingguan/export/{type}', [LaporanController::class, 'exportMingguan'])->name('exportMingguan');

    // Rute Laporan Bulanan
    Route::get('/laporan-bulanan', [AdminController::class, 'laporanBulanan'])->name('laporanBulanan');
    // Rute Export Bulanan (mengarah ke LaporanController jika ada export bulanan di sana, atau AdminController jika di sana)
    // Asumsi AdminController yang menanganinya, dan nama rute lebih spesifik
    Route::get('/laporan-bulanan/export/{type}', [AdminController::class, 'exportBulanan'])->name('exportBulanan');
    // ^^^ Perhatikan: metode di AdminController harus bernama `exportBulanan` dan menerima `type`
    // Jika Anda punya LaporanController yang menangani kedua export, ubah juga ini.

    // Rute Aktivitas
    Route::get('/aktivitas', [AdminController::class, 'aktivitas'])->name('aktivitas');
});