<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\Admin\AdminDashboardController;

// Landing page atau redirect ke dashboard jika sudah login
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('welcome');

// Login & Register
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');
Route::get('/register', [RegisteredUserController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

// Dashboard (akses oleh semua role yang login)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:staff|manager|admin'])
    ->name('dashboard');

// Admin only: admin dashboard
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// Manager + Admin: CRUD kategori, pemasok, produk
Route::middleware(['auth', 'role:manager|admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('products', ProductController::class);
});

// Staff + Manager + Admin: modul stok
Route::prefix('stok')->middleware(['auth', 'role:staff|manager|admin'])->group(function () {
    Route::get('/', [StokController::class, 'index'])->name('stok.index');
    Route::get('/masuk', [StokController::class, 'masuk'])->name('stok.masuk');
    Route::post('/masuk', [StokController::class, 'storeMasuk'])->name('stok.masuk.store');
    Route::get('/keluar', [StokController::class, 'keluar'])->name('stok.keluar');
    Route::post('/keluar', [StokController::class, 'storeKeluar'])->name('stok.keluar.store');
    Route::delete('/keluar/{id}', [StokController::class, 'keluarDestroy'])->name('stok.keluar.destroy');
    Route::get('/total', [StokController::class, 'total'])->name('stok.total');
});

// Profile (akses semua role yang login)
Route::middleware(['auth', 'role:staff|manager|admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});