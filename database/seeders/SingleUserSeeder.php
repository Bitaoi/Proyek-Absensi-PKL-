<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;   // <-- TAMBAHKAN BARIS INI
use Illuminate\Support\Facades\Hash; // Ini sudah ada, pastikan juga ada

class SingleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Contoh: Membuat satu akun admin
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com', // Ganti dengan email admin yang Anda inginkan
            'password' => Hash::make('password123'), // Ganti 'password123' dengan password yang kuat
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@example.com', // Ganti dengan email admin yang Anda inginkan
            'password' => Hash::make('admin'), // Ganti 'password123' dengan password yang kuat
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'admin123',
            'email' => 'admin123@example.com', // Ganti dengan email admin yang Anda inginkan
            'password' => Hash::make('admin123'), // Ganti 'password123' dengan password yang kuat
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'name' => 'adminn',
            'email' => 'admin123@example.com', 
            'password' => Hash::make('adminn'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}