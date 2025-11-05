<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;

class DashboardController extends Controller
{
// 📊 Halaman utama dashboard
public function index()
{
$productsCount = Product::count();
$categoriesCount = Category::count();
$suppliersCount = DB::table('suppliers')->count();

// Pakai kolom stok (total) untuk low stock threshold
$lowStock = Product::where('stok', '<', 10)->count();

// Ambil data kategori untuk grafik (fallback name jika nama_kategori tidak ada)
$categories = Category::withCount('products')->get();
$categoryLabels = $categories->pluck(
$categories->first() && array_key_exists('nama_kategori', $categories->first()->getAttributes())
? 'nama_kategori'
: 'name'
)->toArray();
$categoryCounts = $categories->pluck('products_count')->toArray();

// Ambil data stok masuk & keluar
$products = Product::select('nama_barang', 'stok_masuk', 'stok_keluar')->get();
$produkLabels = $products->pluck('nama_barang')->toArray();
$stokMasuk = $products->pluck('stok_masuk')->toArray();
$stokKeluar = $products->pluck('stok_keluar')->toArray();

return view('dashboard.index', [
'productsCount' => $productsCount,
'categoriesCount' => $categoriesCount,
'suppliersCount' => $suppliersCount,
'lowStock' => $lowStock,
'categoryLabels' => $categoryLabels,
'categoryCounts' => $categoryCounts,
'produkLabels' => $produkLabels,
'stokMasuk' => $stokMasuk,
'stokKeluar' => $stokKeluar,
]);
}

// 🔍 Fungsi Search untuk Produk, Kategori, dan Supplier
public function search(Request $request)
{
$query = $request->input('query');

// Cari di produk (nama/kode/stok)
$products = Product::query()
->when($query, function ($q) use ($query) {
$q->where('nama_barang', 'like', "%{$query}%")
->orWhere('kode_barang', 'like', "%{$query}%")
->orWhere('stok', 'like', "%{$query}%");
})
->get();

// Cari di kategori (fallback name/nama_kategori)
$categories = Category::query()
->when($query, function ($q) use ($query) {
$q->where('nama_kategori', 'like', "%{$query}%")
->orWhere('name', 'like', "%{$query}%");
})
->get();

// Cari di supplier (nama/perusahaan/email)
$suppliers = Supplier::query()
->when($query, function ($q) use ($query) {
$q->where('nama_supplier', 'like', "%{$query}%")
->orWhere('perusahaan', 'like', "%{$query}%")
->orWhere('email', 'like', "%{$query}%");
})
->get();

return view('dashboard.search', [
'query' => $query,
'products' => $products,
'categories' => $categories,
'suppliers' => $suppliers,
]);
}
}
