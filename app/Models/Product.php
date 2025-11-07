<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_barang',
        'kategori_id',
        'supplier_id',
        'harga',
        'stok',
        'stok_masuk', // DITAMBAHKAN
        'stok_keluar', // DITAMBAHKAN
    ];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    /**
     * Get the supplier that owns the product.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * Get the stock mutations for the product.
     * Catatan: Memastikan Anda sudah membuat model StockMutation agar relasi ini berfungsi.
     */
    public function stockMutations()
    {
        return $this->hasMany(StockMutation::class);
    }
}