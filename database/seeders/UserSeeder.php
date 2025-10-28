<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@cupstore.test'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'kasir@cupstore.test'],
            [
                'name' => 'Kasir Satu',
                'password' => Hash::make('password'),
                'role' => 'kasir',
            ]
        );

        User::updateOrCreate(
            ['email' => 'pelanggan@cupstore.test'],
            [
                'name' => 'Pelanggan Test',
                'password' => Hash::make('password'),
                'role' => 'pelanggan',
            ]
        );
    }
}
