<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users'
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'admin' => [ // <-- TAMBAHKAN BAGIAN INI
            'driver' => 'session',
            'provider' => 'admins', // <-- Ini menunjuk ke provider 'admins' di bawah
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],

        'admins' => [ // <-- TAMBAHKAN BAGIAN INI
            'driver' => 'eloquent',
            'model' => App\Models\User::class, // <-- Jika admin Anda menggunakan model App\Models\User
            // ATAU:
            // 'model' => App\Models\Admin::class, // <-- Jika Anda memiliki model terpisah untuk Admin (misal: php artisan make:model Admin)
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     // 'table' => 'users', // Baris ini dikomentari, biarkan saja
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
        // Anda juga bisa menambahkan entri 'admins' di sini jika admin butuh fitur reset password terpisah
        // 'admins' => [
        //     'provider' => 'admins',
        //     'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'), // Bisa pakai tabel yang sama atau tabel terpisah
        //     'expire' => 60,
        //     'throttle' => 60,
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];