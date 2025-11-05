{{-- resources/views/suppliers/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Supplier</h1>

    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- penting untuk update data --}}

        @include('suppliers.form') {{-- form.blade.php digunakan ulang --}}

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
