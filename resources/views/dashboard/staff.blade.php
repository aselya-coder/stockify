@extends('layouts.app')

@section('title', 'Dashboard Staff Gudang')

@section('page-header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">📦 Dashboard Staff Gudang</h1>
            <p class="text-muted mb-0">Pusat aktivitas dan tugas harian Anda.</p>
        </div>
    </div>
@endsection

@section('content')
<div class="row g-4">
    <!-- Card Tugas Konfirmasi -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">🔄 Menunggu Konfirmasi Anda</h5>
                @php
                    $pendingMutations = \App\Models\StockMutation::with('product')->where('status', 'pending')->latest()->get();
                @endphp
                @if($pendingMutations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Tipe</th>
                                    <th>Produk</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingMutations as $mutation)
                                <tr>
                                    <td>
                                        @if($mutation->type == 'masuk')
                                            <span class="badge bg-success">Masuk</span>
                                        @else
                                            <span class="badge bg-danger">Keluar</span>
                                        @endif
                                    </td>
                                    <td class="fw-semibold">{{ $mutation->product->nama_barang }}</td>
                                    <td class="text-center">{{ $mutation->quantity }}</td>
                                    <td class="text-center">
                                        @if($mutation->type == 'masuk')
                                            <a href="{{ route('stok.masuk.confirm', $mutation->id) }}" class="btn btn-sm btn-primary">Konfirmasi</a>
                                        @else
                                            <a href="{{ route('stok.keluar.confirm', $mutation->id) }}" class="btn btn-sm btn-primary">Konfirmasi</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">Tidak ada transaksi yang menunggu konfirmasi saat ini.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Card Aksi Cepat -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title mb-3">🚀 Aksi Cepat</h5>
                <p class="text-muted small">Lihat riwayat semua transaksi stok.</p>
                <a href="{{ route('stok.index') }}" class="btn btn-secondary btn-lg w-100 py-3">
                    <i class="bi bi-clock-history me-2"></i> Lihat Riwayat Stok
                </a>
            </div>
        </div>
    </div>
</div>
@endsection