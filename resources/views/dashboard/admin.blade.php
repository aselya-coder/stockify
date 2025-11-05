@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">📊 Dashboard Admin</h2>
    <p>Halo, {{ Auth::user()->name }} 👋</p>

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Jumlah Produk</h5>
                    <h3>{{ $productsCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Kategori</h5>
                    <h3>{{ $categoriesCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Supplier</h5>
                    <h3>{{ $suppliersCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Stok Rendah</h5>
                    <h3>{{ $lowStock }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 text-center">
        <a href="{{ route('products.index') }}" class="btn btn-primary">Kelola Produk</a>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kelola Kategori</a>
        <a href="{{ route('suppliers.index') }}" class="btn btn-success">Kelola Supplier</a>
    </div>
</div>
@endsection
