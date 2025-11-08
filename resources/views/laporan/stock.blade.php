@extends('layouts.app')

@section('title', 'Laporan Stok')

{{-- Header Halaman --}}
@section('page-header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">📊 Laporan Stok</h1>
            <p class="text-muted mb-0">Laporan detail stok barang per kategori, periode, dll.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle me-2"></i> Kembali ke Dashboard
        </a>
    </div>
@endsection

{{-- Konten Utama --}}
@section('content')
<div class="row">
    <!-- Filter Section -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">🔍 Filter Laporan</h5>
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select name="kategori" id="kategori" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach(\App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}" {{ request('kategori') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="supplier" class="form-label">Supplier</label>
                        <select name="supplier" id="supplier" class="form-select">
                            <option value="">Semua Supplier</option>
                            @foreach(\App\Models\Supplier::all() as $supplier)
                                <option value="{{ $supplier->id }}" {{ request('supplier') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->nama_supplier }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status_stok" class="form-label">Status Stok</label>
                        <select name="status_stok" id="status_stok" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="tersedia" {{ request('status_stok') == 'tersedia' ? 'selected' : '' }}>Tersedia (>0)</option>
                            <option value="habis" {{ request('status_stok') == 'habis' ? 'selected' : '' }}>Habis (=0)</option>
                            <option value="rendah" {{ request('status_stok') == 'rendah' ? 'selected' : '' }}>Stok Rendah (<10)</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-search me-1"></i> Filter
                        </button>
                        <a href="{{ route('laporan.stock') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="col-12 mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card border-primary">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam text-primary fs-2"></i>
                        <h4 class="mt-2 mb-1">{{ $products->count() }}</h4>
                        <p class="text-muted mb-0">Total Produk</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-success">
                    <div class="card-body text-center">
                        <i class="bi bi-check-circle text-success fs-2"></i>
                        <h4 class="mt-2 mb-1">{{ $products->where('stok', '>', 0)->count() }}</h4>
                        <p class="text-muted mb-0">Produk Tersedia</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-warning">
                    <div class="card-body text-center">
                        <i class="bi bi-exclamation-triangle text-warning fs-2"></i>
                        <h4 class="mt-2 mb-1">{{ $products->where('stok', '<', 10)->where('stok', '>', 0)->count() }}</h4>
                        <p class="text-muted mb-0">Stok Rendah</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-danger">
                    <div class="card-body text-center">
                        <i class="bi bi-x-circle text-danger fs-2"></i>
                        <h4 class="mt-2 mb-1">{{ $products->where('stok', '=', 0)->count() }}</h4>
                        <p class="text-muted mb-0">Stok Habis</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Detail Stok Produk</h5>
                    <button onclick="window.print()" class="btn btn-outline-primary">
                        <i class="bi bi-printer me-1"></i> Cetak Laporan
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Supplier</th>
                                <th class="text-end">Harga Beli</th>
                                <th class="text-center">Stok</th>
                                <th class="text-end">Nilai Stok</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $product->nama_barang }}</td>
                                <td>{{ $product->category->nama_kategori ?? '-' }}</td>
                                <td>{{ $product->supplier->nama_supplier ?? '-' }}</td>
                                <td class="text-end">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $product->stok == 0 ? 'bg-danger' : ($product->stok < 10 ? 'bg-warning' : 'bg-success') }}">
                                        {{ $product->stok }}
                                    </span>
                                </td>
                                <td class="text-end fw-semibold">
                                    Rp {{ number_format($product->harga * $product->stok, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    @if($product->stok == 0)
                                        <span class="badge bg-danger">Habis</span>
                                    @elseif($product->stok < 10)
                                        <span class="badge bg-warning">Rendah</span>
                                    @else
                                        <span class="badge bg-success">Tersedia</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                                    Tidak ada produk yang sesuai dengan filter.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if($products->count() > 0)
                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td colspan="5" class="text-end">TOTAL:</td>
                                <td class="text-center">{{ $products->sum('stok') }}</td>
                                <td class="text-end">Rp {{ number_format($products->sum(function($product) { return $product->harga * $product->stok; }), 0, ',', '.') }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media print {
        .btn, .card-header, .page-header {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .table-responsive {
            overflow: visible !important;
        }
        .table {
            font-size: 12px;
        }
    }
</style>
@endpush
