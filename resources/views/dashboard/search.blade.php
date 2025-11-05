@extends('layouts.app')

@section('title', 'Hasil Pencarian')

@section('content')
<div class="container mt-4">
    <h4>🔍 Hasil pencarian untuk: "{{ $query }}"</h4>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-2 mb-4">⬅ Kembali ke Dashboard</a>

    {{-- Produk --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Produk</div>
        <div class="card-body">
            @if($products->isEmpty())
                <p class="text-muted">Tidak ada produk yang cocok.</p>
            @else
                <ul>
                    @foreach($products as $product)
                        <li>{{ $product->nama_barang }} — stok: {{ $product->stok }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    {{-- Kategori --}}
    <div class="card mb-4">
        <div class="card-header bg-success text-white">Kategori</div>
        <div class="card-body">
            @if($categories->isEmpty())
                <p class="text-muted">Tidak ada kategori yang cocok.</p>
            @else
                <ul>
                    @foreach($categories as $category)
                        <li>{{ $category->nama_kategori }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    {{-- Supplier --}}
    <div class="card mb-4">
        <div class="card-header bg-warning text-white">Supplier</div>
        <div class="card-body">
            @if($suppliers->isEmpty())
                <p class="text-muted">Tidak ada supplier yang cocok.</p>
            @else
                <ul>
                    @foreach($suppliers as $supplier)
                        <li>{{ $supplier->nama_supplier }} — {{ $supplier->perusahaan }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
