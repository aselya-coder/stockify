@extends('layouts.app')

@section('title', 'Pengaturan Aplikasi')

@section('page-header')
    <h1>⚙️ Pengaturan Aplikasi</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="app_name" class="form-label">Nama Aplikasi</label>
                <input type="text" class="form-control" id="app_name" name="app_name" value="{{ $settings['app_name'] }}">
            </div>
            <div class="mb-3">
                <label for="app_logo" class="form-label">Logo Aplikasi</label>
                <input type="file" class="form-control" id="app_logo" name="app_logo">
                <small class="form-text text-muted">Fitur upload akan datang.</small>
            </div>
            <button type="submit" class="btn btn-success">Simpan Pengaturan</button>
        </form>
    </div>
</div>
@endsection