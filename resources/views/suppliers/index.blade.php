@extends('layouts.app')

@section('title', 'Daftar Supplier')

@section('content')
<style>
    /* 🌈 Gaya interaktif & modern */
    h3 {
        font-weight: 700;
        color: #1e40af;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: linear-gradient(90deg, #2563eb, #4f46e5);
        border: none;
        border-radius: 10px;
        transition: 0.3s;
    }
    .btn-primary:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    }

    .table {
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 0 10px rgba(0,0,0,0.08);
    }
    thead {
        background: linear-gradient(90deg, #2563eb, #4f46e5);
        color: white;
    }
    th {
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    tbody tr:hover {
        background-color: #eef2ff !important;
        transition: 0.2s;
    }

    .btn-warning, .btn-danger {
        border-radius: 8px;
        transition: all 0.2s ease-in-out;
    }
    .btn-warning:hover {
        transform: scale(1.1);
        box-shadow: 0 3px 10px rgba(234, 179, 8, 0.3);
    }
    .btn-danger:hover {
        transform: scale(1.1);
        box-shadow: 0 3px 10px rgba(239, 68, 68, 0.3);
    }

    /* Alert animasi muncul */
    .alert-success {
        animation: fadeInDown 0.5s ease;
        border-radius: 10px;
        background: #d1fae5;
        color: #065f46;
        border: none;
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>🏭 Daftar Supplier</h3>
    <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Supplier
    </a>
</div>

@if(session('success'))
<div class="alert alert-success shadow-sm">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped align-middle mt-3">
    <thead>
        <tr>
            <th style="width: 60px;">No</th>
            <th>Nama Supplier</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th style="width: 120px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($suppliers as $s)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="text-capitalize fw-semibold">{{ $s->nama_supplier }}</td>
            <td>{{ $s->telepon }}</td>
            <td>{{ $s->alamat }}</td>
            <td>
                <a href="{{ route('suppliers.edit', $s->id) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <form action="{{ route('suppliers.destroy', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center text-muted py-4">Belum ada data supplier.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
