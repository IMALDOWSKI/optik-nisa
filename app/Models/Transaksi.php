<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelanggan_id',
        'produk_id',
        'jumlah',
        'total_harga',
        'tanggal_transaksi',
        'status',
        'catatan',
    ];

    // Relasi: transaksi milik satu pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    // Relasi: transaksi milik satu produk
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}