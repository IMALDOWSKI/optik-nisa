<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'kategori',
        'deskripsi',
        'harga',
        'stok',
        'merk',
    ];

    // Relasi: satu produk ada di banyak transaksi
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}