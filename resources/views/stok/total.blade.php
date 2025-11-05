@extends('layouts.app')

@section('page-title')
    <h1 class="text-2xl font-semibold">Total Stok Produk</h1>
@endsection

@section('content')
<div class="bg-white p-4 rounded shadow">

    {{-- Tombol Kembali --}}
    <div class="flex justify-between mb-4">
        <a href="{{ url('/stok') }}" class="bg-gray-500 text-white px-4 py-2 rounded">
            ← Kembali ke Menu Stok
        </a>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABEL DATA TOTAL STOK --}}
    <table class="min-w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">No</th>
                <th class="border px-4 py-2">Produk</th>
                <th class="border px-4 py-2">Stok Tersedia</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stok as $index => $item)
                <tr>
                    <td class="border px-4 py-2">{{ $index + 1 }}</td>
                    <td class="border px-4 py-2">{{ $item->product->name }}</td>
                    <td class="border px-4 py-2">{{ $item->product->stock }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center py-3">Belum ada data stok.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection
