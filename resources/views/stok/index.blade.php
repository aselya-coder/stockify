@extends('layouts.app')

@section('title', 'Mutasi Stok')

{{-- Header Halaman --}}
@section('page-header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">📊 Mutasi Stok</h1>
            <p class="text-muted mb-0">Lihat semua riwayat pergerakan stok barang.</p>
        </div>
        <div>
            <a href="{{ route('stok.masuk') }}" class="btn btn-success me-2">
                <i class="bi bi-plus-circle me-1"></i> Catat Stok Masuk
            </a>
            <a href="{{ route('stok.keluar') }}" class="btn btn-danger">
                <i class="bi bi-dash-circle me-1"></i> Catat Stok Keluar
            </a>
        </div>
    </div>
@endsection

{{-- Konten Utama --}}
@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Waktu</th>
                        <th>Produk</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th style="width: 100px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mutations as $mutation)
                    <tr>
                        <td class="text-center text-muted">{{ $loop->iteration }}</td>
                        <td>{{ $mutation->created_at->format('d M Y, H:i') }}</td>
                        <td class="fw-semibold">{{ $mutation->product->nama_barang ?? 'Produk Dihapus' }}</td>
                        <td>
                            @if($mutation->type == 'masuk')
                                <span class="badge bg-success">
                                    <i class="bi bi-arrow-down-circle me-1"></i> Stok Masuk
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="bi bi-arrow-up-circle me-1"></i> Stok Keluar
                                </span>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $mutation->quantity }}</td>
                        <td class="text-muted">{{ $mutation->notes ?? '-' }}</td>
                        <td class="text-center">
                            @if(auth()->user()->hasRole('admin'))
                                <div class="btn-group" role="group">
                                    <a href="{{ route('stok.edit', $mutation->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('stok.destroy', $mutation->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mutasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-arrow-left-right fs-1 d-block mb-2"></i>
                            Belum ada riwayat mutasi stok.
                            <br>
                            <a href="{{ route('stok.masuk') }}" class="btn btn-sm btn-success mt-2 me-2">
                                <i class="bi bi-plus-circle me-1"></i> Catat Stok Masuk
                            </a>
                            <a href="{{ route('stok.keluar') }}" class="btn btn-sm btn-danger mt-2">
                                <i class="bi bi-dash-circle me-1"></i> Catat Stok Keluar
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection