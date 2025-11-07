@extends('layouts.app')

@section('title', 'Konfirmasi Barang Masuk')

@section('page-header')
    <h1>✅ Konfirmasi Barang Masuk</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Detail Produk</h5>
        <table class="table table-borderless">
            <tr>
                <td width="150">Nama Barang</td>
                <td><strong>{{ $mutation->product->nama_barang }}</strong></td>
            </tr>
            <tr>
                <td>Jumlah</td>
                <td><strong>{{ $mutation->quantity }} unit</strong></td>
            </tr>
            <tr>
                <td>Catatan</td>
                <td>{{ $mutation->notes ?? '-' }}</td>
            </tr>
        </table>

        <hr>

        <form action="{{ route('stok.masuk.confirm.update', $mutation->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <p>Apakah Anda yakin ingin mengkonfirmasi penerimaan barang ini?</p>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle me-2"></i>Ya, Konfirmasi
            </button>
            <a href="{{ route('stok.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection