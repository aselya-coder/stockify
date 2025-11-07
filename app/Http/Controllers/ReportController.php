<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockMutation;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-stock-report')->only('stock');
        $this->middleware('permission:view-transaction-report')->only('transaction');
        $this->middleware('permission:view-user-activity-report')->only('activity');
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