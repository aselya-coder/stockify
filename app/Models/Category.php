<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id']; // Atau $fillable jika Anda lebih suka

    /**
     * Relasi ke model Product.
     * Satu kategori bisa dimiliki oleh banyak produk.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'kategori_id'); // Sesuaikan 'kategori_id' dengan foreign key di tabel products Anda
    }
}