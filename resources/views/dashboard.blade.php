@extends('layouts.app')

@section('title', 'Dashboard')

{{-- Header Halaman --}}
@section('page-header')
    <h1>👋 Selamat Datang, {{ auth()->user()->name }}!</h1>
    <p class="text-muted mb-0 mt-1">Ini adalah dashboard Sistem Informasi Stok Anda.</p>
@endsection

{{-- Konten Utama --}}
@section('content')
<!-- Kartu Statistik -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="number">{{ $totalProducts }}</p>
                    <p class="label">Total Produk</p>
                </div>
                <div class="icon">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="number">{{ $lowStockProducts }}</p>
                    <p class="label">Stok Menipis</p>
                </div>
                <div class="icon">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="number">{{ $totalCategories }}</p>
                    <p class="label">Kategori</p>
                </div>
                <div class="icon">
                    <i class="bi bi-tags"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card info">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="number">{{ $totalSuppliers }}</p>
                    <p class="label">Supplier</p>
                </div>
                <div class="icon">
                    <i class="bi bi-truck"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Aksi Cepat -->
    <div class="col-lg-4 mb-4">
        <div class="quick-action-card">
            <h5 class="mb-3">🚀 Aksi Cepat</h5>
            @can('create-products')
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Produk
                </a>
            @endcan
            @can('create-categories')
                <a href="{{ route('categories.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Kategori
                </a>
            @endcan
            @can('create-suppliers')
                <a href="{{ route('suppliers.create') }}" class="btn btn-info">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Supplier
                </a>
            @endcan
            {{-- TOMBOL STOK --}}
            @can('record-stock-in')
                <a href="{{ route('stok.masuk') }}" class="btn btn-warning">
                    <i class="bi bi-plus-circle me-2"></i> Stok Masuk
                </a>
            @endcan
            @can('record-stock-out')
                <a href="{{ route('stok.keluar') }}" class="btn btn-danger">
                    <i class="bi bi-dash-circle me-2"></i> Stok Keluar
                </a>
            @endcan
            <a href="{{ route('stok.total') }}" class="btn btn-secondary">
                <i class="bi bi-clipboard-data me-2"></i> Laporan Stok
            </a>
        </div>
    </div>

    <!-- Aktivitas Terkini -->
    <div class="col-lg-8 mb-4">
        <div class="activity-card">
            <h5>📜 Aktivitas Stok Terkini</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Produk</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentStocks as $stock)
                            <tr>
                                <td>{{ $stock->created_at->format('d M Y, H:i') }}</td>
                                <td>{{ $stock->product->nama_barang ?? '-' }}</td>
                                <td>
                                    @if($stock->jenis == 'masuk')
                                        <span class="badge bg-success">Stok Masuk</span>
                                    @else
                                        <span class="badge bg-danger">Stok Keluar</span>
                                    @endif
                                </td>
                                <td>{{ $stock->jumlah }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada aktivitas stok.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="text-end mt-3">
                <a href="{{ route('stok.index') }}" class="btn btn-sm btn-outline-secondary">Lihat Semua →</a>
            </div>
        </div>
    </div>
</div>

{{-- CSS untuk kartu tetap diperlukan di sini --}}
<style>
    .stat-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
    .stat-card.primary { border-left-color: var(--primary); }
    .stat-card.success { border-left-color: #10b981; }
    .stat-card.warning { border-left-color: #f59e0b; }
    .stat-card.info { border-left-color: #3b82f6; }
    .stat-card .icon { width: 48px; height: 48px; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; }
    .stat-card.primary .icon { background-color: var(--primary); }
    .stat-card.success .icon { background-color: #10b981; }
    .stat-card.warning .icon { background-color: #f59e0b; }
    .stat-card.info .icon { background-color: #3b82f6; }
    .stat-card .number { font-size: 2rem; font-weight: 700; margin: 0; }
    .stat-card .label { color: #6b7280; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; }
    .quick-action-card, .activity-card { background: white; border-radius: 0.75rem; padding: 1.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); }
    .quick-action-card .btn { width: 100%; margin-bottom: 0.75rem; border-radius: 0.5rem; font-weight: 500; }
    .quick-action-card .btn:last-child { margin-bottom: 0; }
    .activity-card h5 { margin-bottom: 1rem; font-weight: 600; color: #1f2937; }
    .activity-card .table th { border-top: none; font-weight: 600; color: #6b7280; text-transform: uppercase; font-size: 0.75rem; }
</style>
@endsection