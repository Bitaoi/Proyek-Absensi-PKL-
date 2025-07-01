<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

<<<<<<< HEAD
Route::get('/', function () {
    return view('gatau');
});
=======
Route::get('/home', function () {
    return view('home');
});


Route::get('/index', function () {
    return view('index');
});
>>>>>>> c89faf3cdac5c4952a58f37ccbe96072d781e29c
