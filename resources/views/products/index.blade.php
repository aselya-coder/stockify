@extends('layouts.app')

@section('title', 'Daftar Produk')

{{-- Header Halaman --}}
@section('page-header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">📦 Daftar Produk</h1>
            <p class="text-muted mb-0">Kelola semua data produk yang ada di gudang.</p>
        </div>
    </div>
@endsection

{{-- Konten Utama --}}
@section('content')
<div class="card">
    <div class="card-body">
        {{-- Tabel Produk --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Supplier</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th style="width: 150px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="text-center text-muted">{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $product->nama_barang }}</td>
                        <td>{{ $product->category->nama_kategori ?? '-' }}</td>
                        <td>{{ $product->supplier->nama_supplier ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $product->stok < 10 ? 'bg-danger' : 'bg-success' }}">
                                {{ $product->stok }}
                            </span>
                        </td>
                        <td class="text-end fw-semibold">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @role('admin|manager')
                                <div class="btn-group" role="group">
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endrole
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Belum ada data produk.
                            @role('admin|manager')
                                <br>
                                <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary mt-2">
                                    <i class="bi bi-plus-circle me-1"></i> Tambah Produk Pertama
                                </a>
                            @endrole
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection