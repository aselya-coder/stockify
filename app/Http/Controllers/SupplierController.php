<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct()
    {
        // Hanya user dengan permission 'view-suppliers' yang bisa melihat daftar dan detail
        $this->middleware('permission:view-suppliers')->only('index', 'show');

        // Hanya user dengan permission 'create-suppliers' yang bisa menambah
        $this->middleware('permission:create-suppliers')->only('create', 'store');

        // Hanya user dengan permission 'edit-suppliers' yang bisa mengedit
        $this->middleware('permission:edit-suppliers')->only('edit', 'update');

        // Hanya user dengan permission 'delete-suppliers' yang bisa menghapus
        $this->middleware('permission:delete-suppliers')->only('destroy');
    }

    /**
     * Menampilkan daftar semua supplier
     */
    public function index()
    {
        // Ambil semua data supplier dari database
        $suppliers = Supplier::all();

        // Arahkan ke view resources/views/suppliers/index.blade.php
        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Menampilkan form tambah supplier baru
     */
    public function create()
    {
        // Arahkan ke view resources/views/suppliers/create.blade.php
        return view('suppliers.create');
    }

    /**
     * Menyimpan data supplier baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input agar data yang disimpan aman
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:50',
        ]);

        // Simpan data ke tabel suppliers
        Supplier::create($request->all());

        // Kembali ke halaman index suppliers
        return redirect()->route('suppliers.index')
                         ->with('success', 'Supplier berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit supplier berdasarkan ID
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);

        // Arahkan ke view resources/views/suppliers/edit.blade.php
        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Mengupdate data supplier
     */
    public function update(Request $request, $id)
    {
        // Validasi data input sebelum disimpan
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:50',
        ]);

        // Cari supplier berdasarkan ID
        $supplier = Supplier::findOrFail($id);

        // Update data supplier
        $supplier->update($request->all());

        // Kembali ke halaman index suppliers
        return redirect()->route('suppliers.index')
                         ->with('success', 'Data supplier berhasil diperbarui.');
    }

    /**
     * Menghapus supplier berdasarkan ID
     */
    public function destroy($id)
    {
        Supplier::destroy($id);

        // Redirect ke index dengan pesan sukses
        return redirect()->route('suppliers.index')
             ->with('success', 'Supplier berhasil dihapus.');
    }
}
