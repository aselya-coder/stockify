@extends('layouts.app')

@section('content')
<div class="container">
    <h1>🧰 Dashboard Staff Gudang</h1>
    <p>Hai, <strong>Staff</strong>! Berikut data stok terbaru:</p>

    <div style="margin-top: 20px;">
        <p>Total Produk: {{ $productsCount }}</p>
        <p>Total Kategori: {{ $categoriesCount }}</p>
        <p>Total Supplier: {{ $suppliersCount }}</p>
        <p>Produk Stok Rendah: {{ $lowStock }}</p>
    </div>

    <p><a href="{{ route('stock.in.form') }}">📥 Tambah Barang Masuk</a></p>
    <p><a href="{{ route('stock.out.form') }}">📤 Catat Barang Keluar</a></p>
</div>
@endsection
