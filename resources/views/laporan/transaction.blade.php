@extends('layouts.app')

@section('title', 'Laporan Transaksi')

{{-- Header Halaman --}}
@section('page-header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">📈 Laporan Transaksi</h1>
            <p class="text-muted mb-0">Laporan barang masuk dan keluar dalam periode tertentu.</p>
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
                        <label for="jenis" class="form-label">Jenis Transaksi</label>
                        <select name="jenis" id="jenis" class="form-select">
                            <option value="">Semua Jenis</option>
                            <option value="masuk" {{ request('jenis') == 'masuk' ? 'selected' : '' }}>Barang Masuk</option>
                            <option value="keluar" {{ request('jenis') == 'keluar' ? 'selected' : '' }}>Barang Keluar</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="tanggal_dari" class="form-label">Dari Tanggal</label>
                        <input type="date" name="tanggal_dari" id="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="tanggal_sampai" class="form-label">Sampai Tanggal</label>
                        <input type="date" name="tanggal_sampai" id="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-search me-1"></i> Filter
                        </button>
                        <a href="{{ route('laporan.transaction') }}" class="btn btn-outline-secondary">
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
                <div class="card border-info">
                    <div class="card-body text-center">
                        <i class="bi bi-arrow-left-right text-info fs-2"></i>
                        <h4 class="mt-2 mb-1">{{ $mutations->count() }}</h4>
                        <p class="text-muted mb-0">Total Transaksi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-success">
                    <div class="card-body text-center">
                        <i class="bi bi-arrow-down-circle text-success fs-2"></i>
                        <h4 class="mt-2 mb-1">{{ $mutations->where('type', 'masuk')->count() }}</h4>
                        <p class="text-muted mb-0">Barang Masuk</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-danger">
                    <div class="card-body text-center">
                        <i class="bi bi-arrow-up-circle text-danger fs-2"></i>
                        <h4 class="mt-2 mb-1">{{ $mutations->where('type', 'keluar')->count() }}</h4>
                        <p class="text-muted mb-0">Barang Keluar</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-warning">
                    <div class="card-body text-center">
                        <i class="bi bi-clock text-warning fs-2"></i>
                        <h4 class="mt-2 mb-1">{{ $mutations->where('status', 'pending')->count() }}</h4>
                        <p class="text-muted mb-0">Menunggu Konfirmasi</p>
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
                    <h5 class="card-title mb-0">Detail Transaksi</h5>
                    <button onclick="window.print()" class="btn btn-outline-primary">
                        <i class="bi bi-printer me-1"></i> Cetak Laporan
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Waktu</th>
                                <th>Produk</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Pengguna</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mutations as $mutation)
                            <tr>
                                <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                <td>{{ $mutation->created_at->format('d M Y, H:i') }}</td>
                                <td class="fw-semibold">{{ $mutation->product->nama_barang ?? 'Produk Dihapus' }}</td>
                                <td>
                                    @if($mutation->type == 'masuk')
                                        <span class="badge bg-success">
                                            <i class="bi bi-arrow-down-circle me-1"></i> Masuk
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="bi bi-arrow-up-circle me-1"></i> Keluar
                                        </span>
                                    @endif
                                </td>
                                <td class="fw-semibold">{{ $mutation->quantity }}</td>
                                <td>
                                    @if($mutation->status == 'confirmed')
                                        <span class="badge bg-success">Dikonfirmasi</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $mutation->user->name ?? 'User Dihapus' }}</td>
                                <td class="text-muted">{{ $mutation->notes ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="bi bi-arrow-left-right fs-1 d-block mb-2"></i>
                                    Tidak ada transaksi yang sesuai dengan filter.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
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
