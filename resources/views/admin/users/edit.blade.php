@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('page-header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">✏️ Edit Pengguna</h1>
            <p class="text-muted mb-0">Perbarui informasi dan role pengguna.</p>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle me-2"></i> Kembali
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Formulir Edit Pengguna</h5>
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password (Kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="roles" class="form-label">Role</label>
                        <select name="roles[]" id="roles" class="form-select" multiple required>
                            @foreach($roles as $id => $name)
                                <option value="{{ $id }}" {{ in_array($name, $userRoles) ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Tahan Ctrl/Cmd untuk memilih lebih dari satu role.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i> Perbarui Pengguna
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection