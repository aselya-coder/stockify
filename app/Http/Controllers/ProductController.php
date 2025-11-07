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
     * Menampilkan daftar semua produk dengan pagination.
     */
    public function index()
    {
        $products = Product::with(['category', 'supplier'])->orderBy('nama_barang')->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Menampilkan form untuk menambah produk.
     */
    public function create()
    {
        $categories = Category::orderBy('nama_kategori')->get();
        $suppliers = Supplier::orderBy('nama_supplier')->get();

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

        // Bersihkan input harga dari format Rupiah sebelum disimpan
        $hargaBersih = str_replace('.', '', $request->harga);

        $product = Product::create([
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'supplier_id' => $request->supplier_id,
            'stok' => $request->stok,
            'stok_masuk' => $request->stok, // awal sama dengan stok
            'stok_keluar' => 0,
            'harga' => $hargaBersih,
        ]);

        return redirect()
            ->route('products.create')
            ->with('success', 'Produk "' . $product->nama_barang . '" berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit produk.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('nama_kategori')->get();
        $suppliers = Supplier::orderBy('nama_supplier')->get();

        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    /**
     * Memperbarui data produk di database.
     * PERBAIKAN: Stok tidak boleh diubah langsung dari sini untuk menjaga konsistensi data.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'harga' => 'required|numeric|min:0',
        ]);

        // Bersihkan input harga dari format Rupiah sebelum disimpan
        $hargaBersih = str_replace('.', '', $request->harga);

        $product->update([
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'supplier_id' => $request->supplier_id,
            'harga' => $hargaBersih,
            // PERHATIAN: Field 'stok' sengaja DIHAPUS dari update untuk mencegah inkonsistensi.
            // Perubahan stok harus melalui fitur khusus (tambah/kurang stok).
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }

    // ==========================================================
    // FITUR MANAJEMEN STOK
    // ==========================================================

    /**
     * Mengambil semua produk dalam format JSON untuk dropdown modal.
     */
    public function jsonIndex()
    {
        $products = Product::select('id', 'nama_barang', 'stok')->orderBy('nama_barang')->get();
        return response()->json($products);
    }

    /**
     * Menambah stok ke produk tertentu via AJAX.
     */
    public function addStock(Request $request, Product $product)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        // Tambah stok dan update stok_masuk
        $product->increment('stok', $request->jumlah);
        $product->increment('stok_masuk', $request->jumlah);

        return response()->json(['success' => true, 'message' => 'Stok berhasil ditambahkan.']);
    }

    /**
     * FITUR BARU: Mengurangi stok produk tertentu via AJAX.
     */
    public function reduceStock(Request $request, Product $product)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        // Cek apakah stok mencukupi
        if ($product->stok < $request->jumlah) {
            return response()->json(['success' => false, 'message' => 'Stok tidak mencukupi!'], 400);
        }

        // Kurangi stok dan update stok_keluar
        $product->decrement('stok', $request->jumlah);
        $product->increment('stok_keluar', $request->jumlah);

        return response()->json(['success' => true, 'message' => 'Stok berhasil dikurangi.']);
    }
}