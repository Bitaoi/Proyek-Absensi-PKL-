<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // PERBAIKI BARIS INI DARI:
        // $middleware->redirectGuestsTo(route('admin.login'));
        // MENJADI SALAH SATU DARI BERIKUT:

        // Opsi 1 (Disarankan untuk kesederhanaan jika hanya ada satu jenis redirect):
        // Cukup berikan string URL langsung
        $middleware->redirectGuestsTo('/admin/login'); 

        // Opsi 2 (Disarankan jika Anda mungkin memiliki guard berbeda di masa depan):
        // Gunakan fungsi anonim (closure) agar `route()` dipanggil saat dibutuhkan
        // $middleware->redirectGuestsTo(fn (string $guard) => route('admin.login'));
        
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();