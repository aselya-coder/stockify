@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('page-header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">🗂️ Daftar Kategori</h1>
            <p class="text-muted mb-0">Kelola semua kategori produk yang ada.</p>
        </div>
        @can('create-categories')
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i> Tambah Kategori
        </a>
        @endcan
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>
                                <strong>{{ $category->nama_kategori }}</strong>
                            </td>
                            <td>
                                <span class="text-muted">
                                    {{ Str::limit($category->deskripsi ?? '-', 100) }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if(auth()->user()->can('edit-categories') || auth()->user()->can('delete-categories'))
                                <div class="btn-group" role="group">
                                    @can('edit-categories')
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @endcan
                                    @can('delete-categories')
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                Belum ada kategori.
                                @can('create-categories')
                                <a href="{{ route('categories.create') }}">Tambah kategori baru?</a>
                                @endcan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection