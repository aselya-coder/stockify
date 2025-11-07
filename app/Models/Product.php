<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'kategori_id',
        'supplier_id',
        'harga',
        'stok',
    ];

    /**
     * Relasi ke kategori.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    /**
     * Relasi ke supplier.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * Relasi ke riwayat mutasi stok.
     */
    public function stockMutations()
    {
        return $this->hasMany(StockMutation::class);
    }
}