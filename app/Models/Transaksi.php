<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = [
        'nama_pembeli',
        'alamat',
        'no_hp',
        'metode_pembayaran',
        'bukti_pembayaran',
        'total_harga',
        'status', // ✅ tambahkan status
    ];

    /**
     * Relasi: 1 transaksi punya banyak item
     */
    public function items()
    {
        return $this->hasMany(TransaksiItem::class, 'transaksi_id');
    }
}
