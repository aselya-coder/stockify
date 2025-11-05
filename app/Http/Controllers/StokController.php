<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;   
use App\Models\StockIn;
use App\Models\StockOut;   

class StokController extends Controller
{
    public function masuk()
    {
        $stockIns = StockIn::with('product')->get(); // ✅ tidak error lagi
        $products = Product::all(); // ✅ data untuk dropdown pilih produk

        return view('stok.masuk', compact('stockIns', 'products'));
    }

    public function index()
    {
        // Ambil data stok masuk, keluar dan total per produk
        $products = Product::with(['stockIns', 'stockOuts'])->get()->map(function ($product) {
            $stokMasuk = $product->stockIns->sum('quantity');
            $stokKeluar = $product->stockOuts->sum('quantity');
            $totalStok = $stokMasuk - $stokKeluar;

            return [
                'name' => $product->name,
                'stok_masuk' => $stokMasuk,
                'stok_keluar' => $stokKeluar,
                'total_stok' => $totalStok,
            ];
        });

        // Kirim data ke view
        return view('stok.index', compact('products'));
    }

    public function keluar()
    {
        $stockOuts = StockOut::with('product')->get(); // ✅ tidak error lagi
        $products = Product::all(); // ✅ data untuk dropdown pilih produk

        return view('stok.keluar', compact('stockOuts', 'products'));
    }

    
    public function total()
    {
        $stok = \App\Models\StockIn::with('product')->get(); 
        return view('stok.total', compact('stok'));
    }

    public function menuStok()
    {
        $products = Product::with(['stockIns', 'stockOuts'])->get()->map(function ($product) {
            $stokMasuk = $product->stockIns->sum('quantity');
            $stokKeluar = $product->stockOuts->sum('quantity');
            $totalStok = $stokMasuk - $stokKeluar;

            return [
                'name' => $product->name,
                'stok_masuk' => $stokMasuk,
                'stok_keluar' => $stokKeluar,
                'total_stok' => $totalStok,
            ];
        });

        return view('stok.menu', compact('products'));
    }


}
