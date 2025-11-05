<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Seeder idempotent: update atau buat jika belum ada
        User::updateOrCreate(
            ['email' => 'admin@stockify.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'manager@stockify.com'],
            [
                'name' => 'Manager Gudang',
                'password' => Hash::make('manager123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@stockify.com'],
            [
                'name' => 'Staff Gudang',
                'password' => Hash::make('staff123'),
            ]
        );
    }
}