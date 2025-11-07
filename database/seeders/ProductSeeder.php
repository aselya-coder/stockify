<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'nama_barang' => 'Laptop Gaming',
                'kategori_id' => 1, // Elektronik
                'supplier_id' => 1, // PT Maju Jaya
                'stok' => 5,
                'harga' => 15000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Mouse Wireless',
                'kategori_id' => 1, // Elektronik
                'supplier_id' => 1,
                'stok' => 20,
                'harga' => 150000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Keyboard Mechanical',
                'kategori_id' => 1, // Elektronik
                'supplier_id' => 2, // CV Sumber Rezeki
                'stok' => 15,
                'harga' => 500000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Kaos Polos',
                'kategori_id' => 2, // Pakaian
                'supplier_id' => 2,
                'stok' => 50,
                'harga' => 75000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Celana Jeans',
                'kategori_id' => 2, // Pakaian
                'supplier_id' => 1,
                'stok' => 30,
                'harga' => 200000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Nasi Goreng Instant',
                'kategori_id' => 3, // Makanan & Minuman
                'supplier_id' => 2,
                'stok' => 100,
                'harga' => 25000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Teh Botol',
                'kategori_id' => 3, // Makanan & Minuman
                'supplier_id' => 1,
                'stok' => 200,
                'harga' => 5000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Smartphone',
                'kategori_id' => 1, // Elektronik
                'supplier_id' => 1,
                'stok' => 8,
                'harga' => 3000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Jaket Hoodie',
                'kategori_id' => 2, // Pakaian
                'supplier_id' => 2,
                'stok' => 25,
                'harga' => 150000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Kopi Sachet',
                'kategori_id' => 3, // Makanan & Minuman
                'supplier_id' => 1,
                'stok' => 150,
                'harga' => 10000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Monitor LED',
                'kategori_id' => 1, // Elektronik
                'supplier_id' => 2,
                'stok' => 3, // Low stock
                'harga' => 2000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Headphone Bluetooth',
                'kategori_id' => 1, // Elektronik
                'supplier_id' => 1,
                'stok' => 12,
                'harga' => 400000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
