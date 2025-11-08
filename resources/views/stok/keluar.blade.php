@extends('layouts.app')

@section('title', 'Stok Keluar')

{{-- Header Halaman --}}
@section('page-header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">📉 Stok Keluar</h1>
            <p class="text-muted mb-0">Catat barang yang keluar dari gudang.</p>
        </div>
        <a href="{{ route('stok.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle me-2"></i> Kembali ke Mutasi
        </a>
    </div>
@endsection

{{-- Konten Utama --}}
@section('content')
<div class="row">
    <!-- Form Stok Keluar -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Formulir Stok Keluar</h5>
                <form action="{{ route('stok.keluar.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="product_id" class="form-label">Pilih Produk</label>
                        <select name="product_id" id="product_id" class="form-select" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->nama_barang }}</option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Jumlah Keluar</label>
                        <input type="number" name="quantity" class="form-control" min="1" required>
                        @error('quantity')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Keterangan (Opsional)</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-dash-circle me-2"></i> Simpan Stok Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Informasi Stok Saat Ini -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Informasi Stok Saat Ini</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Stok Tersedia</th>
                                <th>Jumlah Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product->nama_barang }}</td>
                                <td>
                                    <span class="badge bg-danger">{{ $product->stok }}</span>
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" value="{{ old('jumlah', $product->stok) }}" readonly>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection