<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Jalankan ini terlebih dahulu untuk membuat role dan permission
            RolePermissionSeeder::class,
            
            // Kemudian jalankan ini untuk membuat user dan memberikan role
            UserSeeder::class,

            // Jalankan seeder lainnya jika ada
            // CategorySeeder::class,
            // SupplierSeeder::class,
        ]);
    }
}