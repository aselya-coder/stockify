@extends('layouts.app')

@section('page-title')
    <h1 class="text-2xl font-semibold">Menu Stok</h1>
@endsection

@section('content')
<div class="max-w-3xl mx-auto mt-4">
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">

        <h2 class="text-lg font-semibold mb-4">Pilih Menu Stok</h2>

        <div class="space-y-3">
            <a href="{{ route('stok.masuk') }}"
               class="block px-4 py-2 rounded-lg border hover:bg-gray-100 transition">
                📥 Stok Masuk
            </a>
            <a href="{{ route('stok.keluar') }}"
               class="block px-4 py-2 rounded-lg border hover:bg-gray-100 transition">
                📤 Stok Keluar
            </a>
            <a href="{{ route('stok.total') }}"
               class="block px-4 py-2 rounded-lg border hover:bg-gray-100 transition">
                📊 Total Stok
            </a>
        </div>
    </div>
</div>

<!-- ====== Tabel Rekap Stok Full Width ====== -->
<div class="w-full mt-6">
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        <h2 class="text-lg font-semibold mb-3">📊 Rekap Stok Produk</h2>

        <div class="overflow-x-auto">
            <table class="w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2">Produk</th>
                        <th class="border px-4 py-2 text-center">Stok Masuk</th>
                        <th class="border px-4 py-2 text-center">Stok Keluar</th>
                        <th class="border px-4 py-2 text-center">Total Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td class="border px-4 py-2">{{ $product['name'] }}</td>
                            <td class="border px-4 py-2 text-center">{{ $product['stok_masuk'] }}</td>
                            <td class="border px-4 py-2 text-center">{{ $product['stok_keluar'] }}</td>
                            <td class="border px-4 py-2 text-center font-semibold">
                                {{ $product['total_stok'] }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-3 text-gray-500">Belum ada data stok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
