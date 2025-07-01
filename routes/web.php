<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;

Route::get('/', function () {
    return view('welcome');
});

// Tampilkan form buku tamu (halaman utama)
Route::get('/', [GuestController::class, 'create'])->name('guest.form');

// Simpan data buku tamu
Route::post('/store', [GuestController::class, 'store'])->name('guest.store');

// Ambil data kelurahan berdasarkan kecamatan (untuk Ajax)
Route::get('/kelurahan/{kecamatan_id}', [GuestController::class, 'getKelurahan']);
