<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;   
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
        @return void
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Bukut@mu123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
