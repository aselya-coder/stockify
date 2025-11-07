<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct()
    {
        // Hanya user dengan permission 'view-products' yang bisa melihat daftar dan detail
        $this->middleware('permission:view-products')->only('index', 'show');

        // Hanya user dengan permission 'create-products' yang bisa menambah
        $this->middleware('permission:create-products')->only('create', 'store');

        // Hanya user dengan permission 'edit-products' yang bisa mengedit
        $this->middleware('permission:edit-products')->only('edit', 'update');

        // Hanya user dengan permission 'delete-products' yang bisa menghapus
        $this->middleware('permission:delete-products')->only('destroy');
    }


    /**
     * Menampilkan daftar semua produk.
     */
    public function index()
    {
        $products = Product::with(['category', 'supplier'])->get();
        return view('products.index', compact('products'));
    }

    /**
     * Menampilkan form untuk menambah produk.
     */
    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();

        // 🔧 Perbaikan: Arahkan ke view 'products.create'
        return view('products.create', compact('categories', 'suppliers'));
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        Product::create([
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'supplier_id' => $request->supplier_id,
            'stok' => $request->stok,
            'stok_masuk' => $request->stok, // awal sama dengan stok
            'stok_keluar' => 0,
            'harga' => $request->harga,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit produk.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $suppliers = Supplier::all();

        // 🔧 Perbaikan: Arahkan ke view 'products.edit'
        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    /**
     * Memperbarui data produk di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($id);

        $product->update([
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'supplier_id' => $request->supplier_id,
            'stok' => $request->stok,
            'stok_masuk' => $request->stok_masuk ?? $product->stok_masuk,
            'stok_keluar' => $request->stok_keluar ?? $product->stok_keluar,
            'harga' => $request->harga,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}