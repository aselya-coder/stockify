@extends('layouts.app')

@section('title', 'Daftar Kategori')

{{-- Header Halaman --}}
@section('page-header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">🗂️ Daftar Kategori</h1>
            <p class="text-muted mb-0">Kelola grup atau kategori untuk setiap produk.</p>
        </div>
    </div>
@endsection

{{-- Konten Utama --}}
@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Kategori</th>
                        <th>Keterangan</th>
                        <th style="width: 150px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td class="text-center text-muted">{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $category->nama_kategori }}</td>
                        <td class="text-muted">{{ $category->deskripsi ?? '-' }}</td>
                        <td class="text-center">
                            @role('admin|manager')
                                <div class="btn-group" role="group">
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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
                        <td colspan="4" class="text-center text-muted py-5">
                            <i class="bi bi-tags fs-1 d-block mb-2"></i>
                            Belum ada data kategori.
                            @role('admin|manager')
                                <br>
                                <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary mt-2">
                                    <i class="bi bi-plus-circle me-1"></i> Tambah Kategori Pertama
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