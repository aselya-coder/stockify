@extends('layouts.app')

@section('title', isset($product) ? 'Edit Produk' : 'Tambah Produk')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white fw-bold">
            {{ isset($product) ? '✏️ Edit Produk' : '➕ Tambah Produk' }}
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi Kesalahan:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form 
                action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" 
                method="POST">
                @csrf
                @if(isset($product)) @method('PUT') @endif

                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Produk</label>
                    <input type="text" name="nama_barang" class="form-control"
                        value="{{ old('nama_barang', $product->nama_barang ?? '') }}"
                        placeholder="Masukkan nama produk" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="kategori_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ old('kategori_id', $product->kategori_id ?? '') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Supplier</label>
                        <select name="supplier_id" class="form-select" required>
                            <option value="">-- Pilih Supplier --</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ old('supplier_id', $product->supplier_id ?? '') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->nama_supplier }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Stok Sekarang</label>
                        <input type="number" name="stok" class="form-control"
                            value="{{ old('stok', $product->stok ?? 0) }}" min="0">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Stok Masuk</label>
                        <input type="number" name="stok_masuk" class="form-control"
                            value="{{ old('stok_masuk', 0) }}" min="0">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Stok Keluar</label>
                        <input type="number" name="stok_keluar" class="form-control"
                            value="{{ old('stok_keluar', 0) }}" min="0">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Harga (Rp)</label>
                    <input type="number" name="harga" class="form-control"
                        value="{{ old('harga', $product->harga ?? 0) }}" min="0">
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
