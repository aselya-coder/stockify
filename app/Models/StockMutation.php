<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMutation extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'type', // 'masuk' atau 'keluar'
        'quantity',
        'status', // 'pending', 'confirmed'
        'notes',
        'user_id', // user yang mencatat transaksi (manajer)
    ];

    /**
     * Relasi ke produk.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relasi ke user yang membuat transaksi.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}