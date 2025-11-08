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

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- ROUTE GROUP UNTUK MANAJEMEN PRODUK, KATEGORI, SUPPLIER ---
    // Grup ini mengelola data master produk, kategori, dan supplier.
    Route::middleware('permission:view-products|view-categories|view-suppliers')->group(function () {
        // AJAX routes untuk manajemen stok di halaman produk
        Route::get('/products.json', [ProductController::class, 'jsonIndex'])->name('products.json');
        Route::post('/products/{product}/add-stock', [ProductController::class, 'addStock'])->name('products.add-stock');
        Route::post('/products/{product}/reduce-stock', [ProductController::class, 'reduceStock'])->name('products.reduce-stock');

        // Resource routes untuk CRUD standar
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('suppliers', SupplierController::class);
    });

    // --- ROUTE GROUP UNTUK MODUL STOK ---
    // Grup ini menangani transaksi dan histori stok secara detail.
    Route::prefix('stok')->name('stok.')->group(function () {
        Route::get('/', [StokController::class, 'index'])->name('index')->middleware('permission:view-stock-history');
        Route::get('/history', [StokController::class, 'history'])->name('history')->middleware('permission:view-stock-history');

        // Manajer: Mencatat transaksi stok masuk dan keluar
        Route::get('/masuk', [StokController::class, 'createMasuk'])->name('masuk')->middleware('permission:record-stock-in');
        Route::post('/masuk', [StokController::class, 'storeMasuk'])->name('masuk.store')->middleware('permission:record-stock-in');
        Route::get('/keluar', [StokController::class, 'createKeluar'])->name('keluar')->middleware('permission:record-stock-out');
        Route::post('/keluar', [StokController::class, 'storeKeluar'])->name('keluar.store')->middleware('permission:record-stock-out');

        // Staff: Konfirmasi transaksi stok
        Route::get('/masuk/{id}/confirm', [StokController::class, 'confirmMasukForm'])->name('masuk.confirm')->middleware('permission:confirm-stock-in');
        Route::patch('/masuk/{id}/confirm', [StokController::class, 'confirmMasuk'])->name('masuk.confirm.update')->middleware('permission:confirm-stock-in');
        Route::get('/keluar/{id}/confirm', [StokController::class, 'confirmKeluarForm'])->name('keluar.confirm')->middleware('permission:confirm-stock-out');
        Route::patch('/keluar/{id}/confirm', [StokController::class, 'confirmKeluar'])->name('keluar.confirm.update')->middleware('permission:confirm-stock-out');

        // Admin: Edit dan hapus mutasi stok
        Route::get('/{id}/edit', [StokController::class, 'edit'])->name('edit')->middleware('role:admin');
        Route::patch('/{id}', [StokController::class, 'update'])->name('update')->middleware('role:admin');
        Route::delete('/{id}', [StokController::class, 'destroy'])->name('destroy')->middleware('role:admin');

        Route::get('/opname', [StokController::class, 'opname'])->name('opname')->middleware('permission:perform-stock-opname');
        Route::get('/total', [StokController::class, 'total'])->name('total')->middleware('permission:view-stock-history');
    });

    // --- ROUTE GROUP KHUSUS ADMIN ---
    // Grup ini hanya dapat diakses oleh user dengan role 'admin'.
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Route resource untuk UserController
        Route::resource('users', UserController::class);
        
        // Route untuk settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::patch('/settings', [SettingController::class, 'update'])->name('settings.update');
    });

    // --- ROUTE GROUP UNTUK LAPORAN ---
    // Grup ini menangani pembuatan laporan.
    Route::prefix('laporan')->name('laporan.')->group(function () {
        // PERBAIKAN: Mengubah permission menjadi bahasa Inggris untuk konsistensi.
        Route::get('/stok', [ReportController::class, 'stock'])->name('laporan.stock')->middleware('permission:view-stock-report');
        Route::get('/transaksi', [ReportController::class, 'transaction'])->name('laporan.transaction')->middleware('permission:view-transaction-report');
        Route::get('/aktivitas', [ReportController::class, 'activity'])->name('laporan.activity')->middleware('permission:view-user-activity-report');
    });
});