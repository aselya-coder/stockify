<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kategori'];

    public function products()
    {
        // ✅ foreign key sesuai dengan kolom di tabel products
        return $this->hasMany(Product::class, 'kategori_id');
    }
}
