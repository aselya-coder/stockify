<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 🔹 Statistik singkat khusus admin (bisa dikembangkan)
        $productsCount = Product::count();
        $categoriesCount = Category::count();
        $suppliersCount = DB::table('suppliers')->count();
        $lowStock = Product::where('stok_masuk', '<', 10)->count();

        // 🔹 Produk per kategori
        $categoryData = Category::withCount('products')->get();
        $categoryLabels = $categoryData->pluck('name');
        $categoryCounts = $categoryData->pluck('products_count');

        // 🔹 Data stok masuk vs keluar dari tabel products
        $produkLabels = Product::pluck('nama_barang');
        $stokMasuk = Product::pluck('stok_masuk');
        $stokKeluar = Product::pluck('stok_keluar');

        // 🔹 Kirim ke view admin dashboard (buat view terpisah jika diperlukan)
        return view('dashboard.admin', [
            'productsCount' => $productsCount,
            'categoriesCount' => $categoriesCount,
            'suppliersCount' => $suppliersCount,
            'lowStock' => $lowStock,

            'categoryLabelsJson' => $categoryLabels->toJson(),
            'categoryCountsJson' => $categoryCounts->toJson(),

            'produkLabelsJson' => $produkLabels->toJson(),
            'stokMasukJson' => $stokMasuk->toJson(),
            'stokKeluarJson' => $stokKeluar->toJson(),
        ]);
    }
}
