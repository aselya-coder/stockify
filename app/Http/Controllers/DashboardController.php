<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\StockMutation; // Asumsikan Anda punya model untuk mutasi
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard berdasarkan role user.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('admin')) {
            return $this->adminDashboard();
        } elseif ($user->hasRole('manajer_gudang')) {
            return $this->managerDashboard();
        } elseif ($user->hasRole('staff_gudang')) {
            return $this->staffDashboard();
        }

        // Jika role tidak dikenal, tampilkan error atau dashboard default
        abort(403, 'Anda tidak memiliki role yang valid untuk mengakses dashboard.');
    }

    /**
     * Dashboard untuk Admin
     */
    private function adminDashboard()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();
        $totalUsers = User::count();

        // Hitung nilai total stok (harga * stok)
        $totalStockValue = Product::sum(DB::raw('harga * stok'));

        return view('dashboard.admin', compact(
            'totalProducts',
            'totalCategories',
            'totalSuppliers',
            'totalUsers',
            'totalStockValue'
        ));
    }

    /**
     * Dashboard untuk Manajer Gudang
     */
    private function managerDashboard()
    {
        // Produk dengan stok menipis (kurang dari 10)
        $lowStockProducts = Product::with('category')
            ->where('stok', '<', 10)
            ->orderBy('stok', 'asc')
            ->get();

        // 5 Mutasi stok terakhir
        $recentMutations = StockMutation::with('product')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.manajer', compact(
            'lowStockProducts',
            'recentMutations'
        ));
    }

    /**
     * Dashboard untuk Staff Gudang
     */
    private function staffDashboard()
    {
        // Produk dengan stok menipis yang perlu diperhatikan staff
        $lowStockProducts = Product::with('category')
            ->where('stok', '<', 10)
            ->orderBy('stok', 'asc')
            ->take(10) // Batasi 10 agar tidak terlalu panjang
            ->get();

        return view('dashboard.staff', compact('lowStockProducts'));
    }
}