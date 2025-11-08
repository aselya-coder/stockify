<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product; // Tambahkan ini untuk pengecekan saat hapus
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        // Hanya user dengan permission 'view-categories' yang bisa melihat daftar dan detail
        $this->middleware('permission:view-categories')->only('index', 'show');

        // Hanya user dengan permission 'create-categories' yang bisa menambah
        $this->middleware('permission:create-categories')->only('create', 'store');

        // Hanya user dengan permission 'edit-categories' yang bisa mengedit
        $this->middleware('permission:edit-categories')->only('edit', 'update');

        // Hanya user dengan permission 'delete-categories' yang bisa menghapus
        $this->middleware('permission:delete-categories')->only('destroy');
    }

    /**
     * Menampilkan daftar kategori dengan pagination.
     */
    public function index()
    {
        // Menggunakan pagination untuk performa yang lebih baik jika data banyak
        $categories = Category::orderBy('nama_kategori')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    /**
     * Menampilkan form untuk menambah kategori baru.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Menyimpan data kategori baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:categories,nama_kategori',
            'deskripsi'     => 'nullable|string|max:1000', // Tambahkan validasi untuk deskripsi
        ]);

        // Membuat kategori baru
        Category::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi'     => $request->deskripsi, // Simpan deskripsi
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit kategori yang ada.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Memperbarui data kategori di database.
     */
    public function update(Request $request, Category $category)
    {
        // Validasi data input
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:categories,nama_kategori,' . $category->id,
            'deskripsi'     => 'nullable|string|max:1000', // Tambahkan validasi untuk deskripsi
        ]);

        // Memperbarui data kategori
        $category->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi'     => $request->deskripsi, // Perbarui deskripsi
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Menghapus data kategori dari database.
     */
    public function destroy(Category $category)
    {
        // Cek apakah kategori memiliki produk terkait
        if ($category->products()->exists()) {
            // Jika ada, batalkan penghapusan dan berikan pesan error
            return redirect()->route('categories.index')
                ->with('error', 'Kategori "' . $category->nama_kategori . '" tidak dapat dihapus karena masih ada produk terkait.');
        }

        // Jika tidak ada produk terkait, hapus kategori
        $category->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}