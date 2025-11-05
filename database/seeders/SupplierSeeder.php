<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('suppliers')->insert([
            ['nama_supplier' => 'PT Maju Jaya', 'alamat' => 'Jakarta', 'telepon' => '081234567890'],
            ['nama_supplier' => 'CV Sumber Rezeki', 'alamat' => 'Bandung', 'telepon' => '082345678901'],
        ]);
    }
}
