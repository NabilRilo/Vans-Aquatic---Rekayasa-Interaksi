<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimGaransi extends Model
{
    use HasFactory;

    protected $table = 'claim_garansi';

    protected $fillable = [
        'transaksi_id',
        'nama_pembeli',
        'alasan',
        'bukti',
        'status',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }
}
