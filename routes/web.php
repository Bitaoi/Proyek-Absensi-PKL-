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

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // --- PERBAIKAN DI SINI ---
    Route::middleware('auth:admin')->group(function () { // <-- Ubah 'auth' menjadi 'auth:admin'
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::get('/laporan-mingguan', [AdminController::class, 'laporanMingguan'])->name('laporanMingguan');
        Route::get('/export-mingguan/{type}', [AdminController::class, 'exportMingguan'])->name('exportMingguan');

        Route::get('/laporan-bulanan', [AdminController::class, 'laporanBulanan'])->name('laporanBulanan');
        Route::get('/export-bulanan/{type}', [AdminController::class, 'export'])->name('exportBulanan');

        Route::get('/aktivitas', [AdminController::class, 'aktivitas'])->name('aktivitas');
    });
});
