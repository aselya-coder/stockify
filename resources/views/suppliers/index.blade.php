@extends('layouts.app')

@section('title', 'Daftar Supplier')

{{-- Header Halaman --}}
@section('page-header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">🚚 Daftar Supplier</h1>
            <p class="text-muted mb-0">Kelola informasi supplier atau pemasok barang.</p>
        </div>
        {{-- TOMBOL TAMBAH SUPPLIER SUDAH DIHAPUS DARI SINI --}}
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
                        <th>Nama Supplier</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th style="width: 150px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                    <tr>
                        <td class="text-center text-muted">{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $supplier->nama_supplier }}</td>
                        <td>{{ $supplier->telepon }}</td>
                        <td class="text-muted">{{ $supplier->alamat }}</td>
                        <td class="text-center">
                            @role('admin|manager')
                                <div class="btn-group" role="group">
                                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
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
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="bi bi-truck fs-1 d-block mb-2"></i>
                            Belum ada data supplier.
                            @role('admin|manager')
                                <br>
                                <a href="{{ route('suppliers.create') }}" class="btn btn-sm btn-primary mt-2">
                                    <i class="bi bi-plus-circle me-1"></i> Tambah Supplier Pertama
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