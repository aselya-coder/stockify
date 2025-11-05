@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Supplier</h1>

    <form action="{{ route('suppliers.store') }}" method="POST">
        @csrf
        @include('suppliers.form')

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
