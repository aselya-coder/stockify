@extends('layouts.app')

@section('title', 'Stok Masuk')

{{-- Header Halaman --}}
@section('page-header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">📈 Stok Masuk</h1>
            <p class="text-muted mb-0">Catat barang yang baru saja tiba di gudang.</p>
        </div>
        {{-- TOMBOL KEMBALI ADA DI SINI --}}
        <a href="{{ route('stok.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle me-2"></i> Kembali ke Mutasi
        </a>
    </div>
@endsection

{{-- Konten Utama --}}
@section('content')
<div class="row">
    <!-- Form Stok Masuk -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Formulir Stok Masuk</h5>
                <form action="{{ route('stok.masuk.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Produk</label>
                        <select name="product_id" id="product_id" class="form-select" required>
                            <option value="" selected disabled>-- Pilih Produk --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->nama_barang }}</option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" required>
                        @error('jumlah')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="3"></textarea>
                        @error('keterangan')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-plus-circle me-2"></i> Simpan Stok Masuk
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Riwayat Stok Masuk Terkini -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">5 Stok Masuk Terkini</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stockIns as $stockIn)
                                <tr>
                                    <td>{{ $stockIn->created_at->format('d M, H:i') }}</td>
                                    <td>{{ $stockIn->product->nama_barang }}</td>
                                    <td><span class="badge bg-success">{{ $stockIn->jumlah }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada data stok masuk.</td>
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