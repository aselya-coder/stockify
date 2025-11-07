@extends('layouts.app')

@section('title', 'Dashboard Manajer Gudang')

@section('page-header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">📋 Dashboard Manajer Gudang</h1>
            <p class="text-muted mb-0">Pantau operasional dan kondisi stok harian.</p>
        </div>
    </div>
@endsection

@section('content')
<div class="row g-4">
    <!-- Card Stok Menipis -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title mb-3">⚠️ Stok Menipis</h5>
                @php
                    $lowStockProducts = \App\Models\Product::with('category')->where('stok', '<', 10)->orderBy('stok', 'asc')->get();
                @endphp
                @if($lowStockProducts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th class="text-center">Stok Tersisa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lowStockProducts as $product)
                                <tr>
                                    <td class="fw-semibold">{{ $product->nama_barang }}</td>
                                    <td>{{ $product->category->nama_kategori ?? '-' }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-danger">{{ $product->stok }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">Semua stok aman. ✅</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Card Mutasi Terkini -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title mb-3">🕐 Mutasi Terkini</h5>
                @php
                    $recentMutations = \App\Models\StockMutation::with('product')->latest()->take(5)->get();
                @endphp
                <ul class="list-group list-group-flush">
                    @forelse($recentMutations as $mutation)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <strong>{{ $mutation->product->nama_barang }}</strong>
                            <br>
                            <small class="text-muted">
                                @if($mutation->type == 'masuk')
                                    <span class="text-success">Barang Masuk</span>
                                @else
                                    <span class="text-danger">Barang Keluar</span>
                                @endif
                            </small>
                        </div>
                        <span class="badge bg-secondary rounded-pill">{{ $mutation->quantity }} unit</span>
                    </li>
                    @empty
                    <li class="list-group-item px-0 text-muted">Belum ada mutasi.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection