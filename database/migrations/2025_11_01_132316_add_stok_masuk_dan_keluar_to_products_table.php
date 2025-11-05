<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Tambahkan dua kolom baru jika belum ada
            if (!Schema::hasColumn('products', 'stok_masuk')) {
                $table->integer('stok_masuk')->default(0);
            }

            if (!Schema::hasColumn('products', 'stok_keluar')) {
                $table->integer('stok_keluar')->default(0);
            }
        });
    }

    /**
     * Batalkan migrasi (rollback).
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Hapus kolom saat rollback
            $table->dropColumn(['stok_masuk', 'stok_keluar']);
        });
    }
};
