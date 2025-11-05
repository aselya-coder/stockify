@extends('layouts.app')

@section('content')
<div class="container">
    <h1>📦 Dashboard Manajer Gudang</h1>
    <p>Hai, <strong>Manajer</strong>! Berikut data penting dari gudang:</p>

    <div style="margin-top: 20px;">
        <p>Total Produk: {{ $productsCount }}</p>
        <p>Total Kategori: {{ $categoriesCount }}</p>
        <p>Total Supplier: {{ $suppliersCount }}</p>
        <p>Produk Stok Rendah: {{ $lowStock }}</p>
    </div>

    <p><a href="{{ route('reports.index') }}">📑 Lihat Laporan Stok</a></p>
</div>
@endsection
