{{-- resources/views/suppliers/form.blade.php --}}
<div class="mb-3">
    <label for="nama_supplier" class="form-label">Nama Supplier</label>
    <input
        type="text"
        name="nama_supplier"
        id="nama_supplier"
        class="form-control"
        value="{{ old('nama_supplier', $supplier->nama_supplier ?? '') }}"
        required
    >
</div>

<div class="mb-3">
    <label for="alamat" class="form-label">Alamat</label>
    <input
        type="text"
        name="alamat"
        id="alamat"
        class="form-control"
        value="{{ old('alamat', $supplier->alamat ?? '') }}"
    >
</div>

<div class="mb-3">
    <label for="telepon" class="form-label">Telepon</label>
    <input
        type="text"
        name="telepon"
        id="telepon"
        class="form-control"
        value="{{ old('telepon', $supplier->telepon ?? '') }}"
    >
</div>
