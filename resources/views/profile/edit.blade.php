@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Profil Pengguna</h4>
                </div>

                <div class="card-body text-center">
                    {{-- ✅ Foto Profil --}}
                    <img src="{{ auth()->user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" 
                        alt="Foto Profil" 
                        class="rounded-circle mb-3" 
                        width="120" height="120">

                    {{-- ✅ Data Profil --}}
                    <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                    <p class="text-muted mb-3">{{ auth()->user()->email }}</p>

                    {{-- ✅ Role Pengguna --}}
                    <span class="badge 
                        @if(auth()->user()->role == 'admin') bg-danger 
                        @elseif(auth()->user()->role == 'manager') bg-warning 
                        @else bg-success 
                        @endif">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                </div>

                <div class="card-body border-top">
                    {{-- ✅ Form Ubah Profil --}}
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3 text-start">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}">
                        </div>

                        <div class="mb-3 text-start">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}">
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">💾 Simpan Perubahan</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">⬅️ Kembali</a>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center text-muted">
                    Diperbarui pada: {{ auth()->user()->updated_at->format('d M Y, H:i') }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
