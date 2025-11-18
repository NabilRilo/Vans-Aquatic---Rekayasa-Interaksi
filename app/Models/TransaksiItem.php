<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiItem extends Model
{
    use HasFactory;

    protected $table = 'transaksi_items'; // Nama tabel di database

    protected $fillable = [
        'transaksi_id', // ID transaksi induk
        'produk_id',    // ID produk
        'jumlah',       // Jumlah produk dibeli
        'harga',        // Harga per item saat checkout
    ];

    /**
     * Relasi: Item ini milik satu transaksi
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    /**
     * Relasi: Item ini mengacu pada produk
     */
    public function produk()
    {
        return $this->belongsTo(Tambahproduk::class, 'produk_id');
    }
}
