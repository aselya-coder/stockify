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
        'stok',
        'stok_masuk',
        'stok_keluar',
        'harga',
    ];

    // ✅ Relasi ke Kategori (pakai kolom 'kategori_id')
    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    // ✅ Relasi ke Supplier (tetap)
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    public function stockIns()
    {
        return $this->hasMany(StockIn::class);
    }

    public function stockOuts()
    {
        return $this->hasMany(StockOut::class);
    }

}
