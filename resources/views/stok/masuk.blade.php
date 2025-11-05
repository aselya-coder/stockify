@extends('layouts.app')

@section('page-title')
  <h1 class="text-2xl font-semibold">Stok Masuk</h1>
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

    {{-- FORM TAMBAH (LANGSUNG TAMPIL) --}}
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md mb-6">
        <h2 class="text-lg font-semibold mb-4">Tambah Stok Masuk</h2>
        <form action="{{ route('stok.masuk.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="block">Pilih Produk</label>
                <select name="product_id" class="w-full border px-3 py-2 rounded" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="block">Jumlah</label>
                <input type="number" name="quantity" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="mb-3">
                <label class="block">Tanggal</label>
                <input type="date" name="tanggal" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- TABEL DATA --}}
    <table class="min-w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">No</th>
                <th class="border px-4 py-2">Produk</th>
                <th class="border px-4 py-2">Jumlah</th>
                <th class="border px-4 py-2">Tanggal</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stockIns as $index => $item)
                <tr>
                    <td class="border px-4 py-2">{{ $index + 1 }}</td>
                    <td class="border px-4 py-2">{{ $item->product->name }}</td>
                    <td class="border px-4 py-2">{{ $item->quantity }}</td>
                    <td class="border px-4 py-2">{{ $item->tanggal }}</td>
                    <td class="border px-4 py-2">
                        <form action="{{ route('stok.masuk.destroy', $item->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 text-white px-3 py-1 rounded">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-3">Belum ada data stok masuk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
