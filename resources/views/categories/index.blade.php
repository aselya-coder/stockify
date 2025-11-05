@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
<style>
    /* === Gaya Umum === */
    table.table {
        border-collapse: separate !important;
        border-spacing: 0;
        font-size: 0.95rem; /* ukuran teks pas */
    }

    table.table th {
        background-color: #e8f1ff !important;
        color: #000;
        text-align: center;
        vertical-align: middle !important;
        height: 48px !important; /* lebih proporsional */
        font-weight: 600;
    }

    table.table td {
        vertical-align: middle !important;
        height: 48px !important;
        font-size: 0.95rem;
    }

    td.text-start {
        padding-left: 14px !important;
    }

    /* Tombol aksi konsisten */
    .btn-action {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        border-radius: 6px;
    }

    /* Hover lembut */
    .table-hover tbody tr:hover {
        background-color: #f6f9ff !important;
    }

    /* Kartu tabel */
    .card {
        border-radius: 10px !important;
    }

    /* Tombol Tambah */
    .btn-primary {
        background-color: #0d6efd !important;
        border: none !important;
        font-size: 0.9rem;
        padding: 8px 14px;
        border-radius: 8px;
    }

    .btn-primary i {
        font-size: 1rem;
    }

    h3.fw-bold {
        font-size: 1.3rem;
    }
</style>

<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 d-flex align-items-center gap-2">
            📁 Daftar Kategori
        </h3>
        <a href="{{ route('categories.create') }}" class="btn btn-primary shadow-sm d-flex align-items-center gap-1">
            <i class="bi bi-plus-circle"></i> Tambah Kategori
        </a>
    </div>

    <!-- Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm small" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Table -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 6%;">No</th>
                        <th class="text-start" style="width: 34%;">Nama Kategori</th>
                        <th class="text-start" style="width: 45%;">Keterangan</th>
                        <th class="text-center" style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $kategori)
                    <tr>
                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                        <td class="text-start align-middle fw-semibold">{{ $kategori->nama_kategori }}</td>
                        <td class="text-start align-middle">{{ $kategori->deskripsi ?? '-' }}</td>
                        <td class="text-center align-middle">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('categories.edit', $kategori->id) }}" 
                                   class="btn btn-warning btn-action">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('categories.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-action">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">
                            Belum ada kategori yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
