<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/produk', function () {
    $produk = [
        ['nama' => 'Laptop', 'harga' => 15000000],
        ['nama' => 'Keyboard', 'harga' => 300000],
        ['nama' => 'Mouse', 'harga' => 150000],
    ];
    
    return view('produk.index', ['produk' => $produk]);
});