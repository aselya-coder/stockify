@extends('layouts.app')

@section('title', 'Tambah Supplier')

{{-- Header Halaman --}}
@section('page-header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">🚚 Tambah Supplier</h1>
            <p class="text-muted mb-0">Tambahkan pemasok baru ke dalam sistem.</p>
        </div>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle me-2"></i> Kembali
        </a>
    </div>
@endsection

{{-- Konten Utama --}}
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Formulir Supplier</h5>
                <form action="{{ route('suppliers.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_supplier" class="form-label">Nama Supplier</label>
                        <input type="text" name="nama_supplier" id="nama_supplier" class="form-control" placeholder="Masukkan nama supplier" required>
                        @error('nama_supplier')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="tel" name="telepon" id="telepon" class="form-control" placeholder="Masukkan nomor telepon" required>
                        @error('telepon')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="4" placeholder="Masukkan alamat lengkap" required></textarea>
                        @error('alamat')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i> Simpan Supplier
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection