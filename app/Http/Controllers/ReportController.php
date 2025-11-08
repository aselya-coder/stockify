<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockMutation;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:lihat-laporan-stok')->only('stock');
        $this->middleware('permission:lihat-laporan-transaksi')->only('transaction');
        $this->middleware('permission:lihat-laporan-aktivitas')->only('activity');
    }

    public function stock(Request $request)
    {
        // Logika untuk laporan stok (filter periode, kategori, dll)
        $products = Product::with(['category', 'supplier'])->paginate(20);
        return view('laporan.stock', compact('products'));
    }

    public function transaction(Request $request)
    {
        // Logika untuk laporan transaksi (filter periode, jenis)
        $mutations = StockMutation::with(['product', 'user'])->latest()->paginate(20);
        return view('laporan.transaction', compact('mutations'));
    }

    public function activity(Request $request)
    {
        // Logika untuk laporan aktivitas user (misal menggunakan activitylog package)
        return view('laporan.activity');
    }
}