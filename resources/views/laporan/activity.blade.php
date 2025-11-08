@extends('layouts.app')

@section('title', 'Laporan Aktivitas')

{{-- Header Halaman --}}
@section('page-header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">📋 Laporan Aktivitas</h1>
            <p class="text-muted mb-0">Laporan aktivitas pengguna dalam sistem.</p>
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
                    <div class="col-md-4">
                        <label for="user" class="form-label">Pengguna</label>
                        <select name="user" id="user" class="form-select">
                            <option value="">Semua Pengguna</option>
                            @foreach(\App\Models\User::all() as $user)
                                <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="tanggal_dari" class="form-label">Dari Tanggal</label>
                        <input type="date" name="tanggal_dari" id="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="tanggal_sampai" class="form-label">Sampai Tanggal</label>
                        <input type="date" name="tanggal_sampai" id="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-search me-1"></i> Filter
                        </button>
                        <a href="{{ route('laporan.activity') }}" class="btn btn-outline-secondary">
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
            <div class="col-md-4">
                <div class="card border-primary">
                    <div class="card-body text-center">
                        <i class="bi bi-people text-primary fs-2"></i>
                        <h4 class="mt-2 mb-1">{{ \App\Models\User::count() }}</h4>
                        <p class="text-muted mb-0">Total Pengguna</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-success">
                    <div class="card-body text-center">
                        <i class="bi bi-activity text-success fs-2"></i>
                        <h4 class="mt-2 mb-1">{{ \App\Models\StockMutation::count() }}</h4>
                        <p class="text-muted mb-0">Total Aktivitas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-info">
                    <div class="card-body text-center">
                        <i class="bi bi-clock text-info fs-2"></i>
                        <h4 class="mt-2 mb-1">{{ \App\Models\StockMutation::where('created_at', '>=', now()->startOfDay())->count() }}</h4>
                        <p class="text-muted mb-0">Aktivitas Hari Ini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Log Section -->
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Log Aktivitas Pengguna</h5>
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
                                <th>Pengguna</th>
                                <th>Aktivitas</th>
                                <th>Detail</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mutations as $mutation)
                            <tr>
                                <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                <td>{{ $mutation->created_at->format('d M Y, H:i:s') }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2">
                                            <span class="avatar-initial rounded-circle bg-primary">{{ substr($mutation->user->name ?? 'U', 0, 1) }}</span>
                                        </div>
                                        {{ $mutation->user->name ?? 'User Dihapus' }}
                                    </div>
                                </td>
                                <td>
                                    @if($mutation->type == 'masuk')
                                        <span class="badge bg-success">
                                            <i class="bi bi-plus-circle me-1"></i> Catat Barang Masuk
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="bi bi-dash-circle me-1"></i> Catat Barang Keluar
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $mutation->product->nama_barang ?? 'Produk Dihapus' }}</strong>
                                    <br>
                                    <small class="text-muted">Jumlah: {{ $mutation->quantity }} unit</small>
                                    @if($mutation->notes)
                                        <br>
                                        <small class="text-muted">Catatan: {{ $mutation->notes }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($mutation->status == 'confirmed')
                                        <span class="badge bg-success">Dikonfirmasi</span>
                                    @else
                                        <span class="badge bg-warning">Menunggu Konfirmasi</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-activity fs-1 d-block mb-2"></i>
                                    Tidak ada aktivitas yang sesuai dengan filter.
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
    .avatar {
        width: 32px;
        height: 32px;
    }
    .avatar-initial {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        font-weight: bold;
        color: white;
        font-size: 14px;
    }
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
