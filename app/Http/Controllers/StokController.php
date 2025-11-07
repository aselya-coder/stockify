<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMutation;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-stock-history')->only('index', 'history');
        $this->middleware('permission:record-stock-in')->only('createMasuk', 'storeMasuk');
        $this->middleware('permission:record-stock-out')->only('createKeluar', 'storeKeluar');
        $this->middleware('permission:confirm-stock-in')->only('confirmMasukForm', 'confirmMasuk');
        $this->middleware('permission:confirm-stock-out')->only('confirmKeluarForm', 'confirmKeluar');
        $this->middleware('permission:perform-stock-opname')->only('opname');
    }

    public function index()
    {
        // Tampilkan semua mutasi, bisa difilter
        $mutations = StockMutation::with(['product', 'user'])->latest()->paginate(20);
        return view('stok.index', compact('mutations'));
    }

    public function createMasuk()
    {
        $products = Product::all();
        $stockIns = StockMutation::where('type', 'masuk')->with('product')->latest()->take(5)->get();
        return view('stok.masuk', compact('products', 'stockIns'));
    }

    public function storeMasuk(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        StockMutation::create([
            'product_id' => $request->product_id,
            'type' => 'masuk',
            'quantity' => $request->quantity,
            'status' => 'pending', // Status awal adalah pending
            'notes' => $request->notes,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('stok.index')->with('success', 'Transaksi barang masuk berhasil dicatat, menunggu konfirmasi staff.');
    }

    public function createKeluar()
    {
        $products = Product::all();
        return view('stok.keluar', compact('products'));
    }

    public function storeKeluar(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        StockMutation::create([
            'product_id' => $request->product_id,
            'type' => 'keluar',
            'quantity' => $request->quantity,
            'status' => 'pending', // Status awal adalah pending
            'notes' => $request->notes,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('stok.index')->with('success', 'Transaksi barang keluar berhasil dicatat, menunggu konfirmasi staff.');
    }

    public function confirmMasukForm($id)
    {
        $mutation = StockMutation::with('product')->findOrFail($id);
        return view('stok.confirm-masuk', compact('mutation'));
    }

    public function confirmMasuk(Request $request, $id)
    {
        $mutation = StockMutation::findOrFail($id);
        if ($mutation->status !== 'pending') {
            return redirect()->back()->with('error', 'Transaksi ini sudah dikonfirmasi.');
        }

        $mutation->status = 'confirmed';
        $mutation->save();

        // Tambah stok produk
        $product = $mutation->product;
        $product->stok += $mutation->quantity;
        $product->save();

        return redirect()->route('stok.index')->with('success', 'Barang masuk berhasil dikonfirmasi!');
    }

    public function confirmKeluarForm($id)
    {
        $mutation = StockMutation::with('product')->findOrFail($id);
        return view('stok.confirm-keluar', compact('mutation'));
    }

    public function confirmKeluar(Request $request, $id)
    {
        $mutation = StockMutation::findOrFail($id);
        if ($mutation->status !== 'pending') {
            return redirect()->back()->with('error', 'Transaksi ini sudah dikonfirmasi.');
        }

        $mutation->status = 'confirmed';
        $mutation->save();

        // Kurangi stok produk
        $product = $mutation->product;
        $product->stok -= $mutation->quantity;
        $product->save();

        return redirect()->route('stok.index')->with('success', 'Barang keluar berhasil dikonfirmasi!');
    }

    public function opname()
    {
        $products = Product::all();
        return view('stok.opname', compact('products'));
    }

    public function total()
    {
        $products = Product::with('category', 'supplier')->get();
        return view('stok.total', compact('products'));
    }
}