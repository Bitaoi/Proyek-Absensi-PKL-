<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute Halaman Utama
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// --------------------
// Rute Form Buku Tamu (Publik)
// --------------------
Route::get('/form', [GuestController::class, 'create'])->name('guest.form');
Route::post('/store', [GuestController::class, 'store'])->name('guest.store');
Route::get('/kelurahan/{kecamatan_id}', [GuestController::class, 'getKelurahan'])->name('kelurahan.byKecamatan');

// --------------------
// Rute Login & Logout Admin
// --------------------
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

// -------------------------------------------------------------------
// Rute Panel Admin (Dashboard, Laporan, Ekspor, Aktivitas)
// Sebaiknya dikelompokkan agar lebih rapi
// -------------------------------------------------------------------
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Laporan Mingguan
    Route::get('/laporan-mingguan', [AdminController::class, 'laporanMingguan'])->name('laporanMingguan');
    Route::get('/export-mingguan/{type}', [AdminController::class, 'exportMingguan'])->name('exportMingguan');

    // Laporan Bulanan
    Route::get('/laporan-bulanan', [AdminController::class, 'laporanBulanan'])->name('laporanBulanan');
    // PERBAIKAN: Menambahkan parameter {type} dan path yang benar
    Route::get('/export-bulanan/{type}', [AdminController::class, 'export'])->name('export'); 
    
    // Aktivitas Admin
    Route::get('/aktivitas', [AdminController::class, 'aktivitas'])->name('aktivitas');
});
