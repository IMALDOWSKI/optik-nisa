<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin Optik Nisa',
            'email'    => 'admin@optiknisa.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Kasir 1',
            'email'    => 'kasir@optiknisa.com',
            'password' => Hash::make('password123'),
            'role'     => 'kasir',
        ]);
    }
}