<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restok extends Model
{
protected $fillable = [
    'produk_id',
    'supplier_id',
    'jumlah_tambah',
    'stok_sebelum',
    'stok_sesudah',
    'harga_beli',
    'supplier',
    'no_faktur',
    'tanggal_restok',
    'catatan',
    'user_id',
];

public function supplier()
{
    return $this->belongsTo(Supplier::class);
}

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}