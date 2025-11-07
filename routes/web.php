<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;

// --- Guest Routes ---
Route::middleware('guest')->group(function () {
    Route::get('/', function () { return view('welcome'); })->name('welcome');
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// --- Authenticated Routes ---
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Dashboard (satu route untuk semua, controller yang mengatur)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- ROUTE GROUP UNTUK MANAJER & ADMIN ---
    Route::middleware('permission:view-products|view-categories|view-suppliers')->group(function () {
        // ==========================================================
        // ROUTE UNTUK FITUR MANAJEMEN STOK (AJAX)
        // ==========================================================
        // Route untuk mengambil data produk dalam format JSON
        Route::get('/products.json', [ProductController::class, 'jsonIndex'])->name('products.json');

        // Route untuk menambah stok via AJAX
        Route::post('/products/{product}/add-stock', [ProductController::class, 'addStock'])->name('products.add-stock');

        // --- ROUTE YANG DITAMBAHKAN ---
        // Route untuk mengurangi stok via AJAX
        Route::post('/products/{product}/reduce-stock', [ProductController::class, 'reduceStock'])->name('products.reduce-stock');

        // Route resource untuk produk (diletakkan setelah route kustom)
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('suppliers', SupplierController::class);
    });

    // --- ROUTE GROUP UNTUK MODUL STOK ---
    Route::prefix('stok')->name('stok.')->group(function () {
        Route::get('/', [StokController::class, 'index'])->name('index')->middleware('permission:view-stock-history');
        Route::get('/history', [StokController::class, 'history'])->name('history')->middleware('permission:view-stock-history');
        
        // Manajer: Mencatat transaksi
        Route::get('/masuk', [StokController::class, 'createMasuk'])->name('masuk')->middleware('permission:record-stock-in');
        Route::get('/masuk/create', [StokController::class, 'createMasuk'])->name('masuk.create')->middleware('permission:record-stock-in');
        Route::post('/masuk', [StokController::class, 'storeMasuk'])->name('masuk.store')->middleware('permission:record-stock-in');
        Route::get('/keluar', [StokController::class, 'createKeluar'])->name('keluar')->middleware('permission:record-stock-out');
        Route::get('/keluar/create', [StokController::class, 'createKeluar'])->name('keluar.create')->middleware('permission:record-stock-out');
        Route::post('/keluar', [StokController::class, 'storeKeluar'])->name('keluar.store')->middleware('permission:record-stock-out');

        // Staff: Konfirmasi transaksi
        Route::get('/masuk/{id}/confirm', [StokController::class, 'confirmMasukForm'])->name('masuk.confirm')->middleware('permission:confirm-stock-in');
        Route::patch('/masuk/{id}/confirm', [StokController::class, 'confirmMasuk'])->name('masuk.confirm.update')->middleware('permission:confirm-stock-in');
        Route::get('/keluar/{id}/confirm', [StokController::class, 'confirmKeluarForm'])->name('keluar.confirm')->middleware('permission:confirm-stock-out');
        Route::patch('/keluar/{id}/confirm', [StokController::class, 'confirmKeluar'])->name('keluar.confirm.update')->middleware('permission:confirm-stock-out');

        Route::get('/opname', [StokController::class, 'opname'])->name('opname')->middleware('permission:perform-stock-opname');
        Route::get('/total', [StokController::class, 'total'])->name('total')->middleware('permission:view-stock-history');
    });

    // --- ROUTE GROUP KHUSUS ADMIN ---
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::patch('/settings', [SettingController::class, 'update'])->name('settings.update');
    });

    // --- ROUTE GROUP UNTUK LAPORAN ---
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/stok', [ReportController::class, 'stock'])->name('stock')->middleware('permission:view-stock-report');
        Route::get('/transaksi', [ReportController::class, 'transaction'])->name('transaction')->middleware('permission:view-transaction-report');
        Route::get('/aktivitas', [ReportController::class, 'activity'])->name('activity')->middleware('permission:view-user-activity-report');
    });
});