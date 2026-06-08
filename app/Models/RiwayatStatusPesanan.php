<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatStatusPesanan extends Model
{
    protected $fillable = [
        'pesanan_id',
        'user_id',
        'status',
        'keterangan',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}