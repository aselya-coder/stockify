<?php

namespace Database\Seeders;

use App\Models\StockMutation;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class StockMutationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $user = User::where('email', 'manager@stockify.com')->first();

        if ($products->isNotEmpty() && $user) {
            // Add some sample stock-in mutations
            StockMutation::create([
                'product_id' => $products->first()->id,
                'type' => 'masuk',
                'quantity' => 10,
                'status' => 'confirmed',
                'notes' => 'Stok awal',
                'user_id' => $user->id,
            ]);

            StockMutation::create([
                'product_id' => $products->skip(1)->first()->id ?? $products->first()->id,
                'type' => 'masuk',
                'quantity' => 5,
                'status' => 'pending',
                'notes' => 'Barang baru',
                'user_id' => $user->id,
            ]);

            StockMutation::create([
                'product_id' => $products->skip(2)->first()->id ?? $products->first()->id,
                'type' => 'keluar',
                'quantity' => 2,
                'status' => 'confirmed',
                'notes' => 'Penjualan',
                'user_id' => $user->id,
            ]);
        }
    }
}
