@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="container mt-4 animate__animated animate__fadeIn">

    {{-- 🔹 Header dan Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-gradient mb-0">
            <i class="bi bi-box-seam"></i> Daftar Produk
        </h3>
        <a href="{{ route('products.create') }}" class="btn btn-primary shadow-sm px-3 py-2 btn-animate">
            <i class="bi bi-plus-circle me-1"></i> Tambah Produk
        </a>
    </div>

    {{-- 🔹 Notifikasi Berhasil --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- 🔹 Tabel Produk --}}
    <div class="card shadow border-0 rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-hover">
                    <thead class="bg-gradient text-white text-center">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Supplier</th>
                            <th>Harga</th>
                            <th style="width: 130px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $p)
                        <tr class="row-hover">
                            <td class="text-center text-muted">{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $p->nama_barang }}</td>
                            <td>{{ $p->category->nama_kategori ?? '-' }}</td>
                            <td>{{ $p->supplier->nama_supplier ?? '-' }}</td>
                            <td class="text-end fw-semibold text-dark">
                                Rp {{ number_format($p->harga, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('products.edit', $p->id) }}" 
                                   class="btn btn-warning btn-sm me-1 shadow-sm btn-animate">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('products.destroy', $p->id) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm shadow-sm btn-animate">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-4"></i><br>
                                Belum ada produk yang ditambahkan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

{{-- 🔹 Style Tambahan --}}
<style>
    /* 🌈 Gradient heading */
    .text-gradient {
        background: linear-gradient(90deg, #6366f1, #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* 🌈 Header tabel gradient */
    .bg-gradient {
        background: linear-gradient(90deg, #6366f1, #8b5cf6);
    }

    /* 🪄 Hover efek baris */
    .row-hover {
        transition: all 0.2s ease;
    }
    .row-hover:hover {
        background-color: #f3f4ff !important;
        transform: scale(1.01);
    }

    /* 🔘 Tombol interaktif */
    .btn-animate {
        transition: all 0.2s ease-in-out;
    }
    .btn-animate:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
    }
</style>

{{-- 🔹 Animasi Masuk (Animate.css CDN) --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection
