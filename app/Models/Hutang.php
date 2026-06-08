<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hutang extends Model
{
    protected $fillable = [
        'pelanggan_id',
        'transaksi_id',
        'user_id',
        'total_tagihan',
        'total_bayar',
        'sisa_hutang',
        'status',
        'jatuh_tempo',
        'catatan',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembayarans()
    {
        return $this->hasMany(PembayaranHutang::class);
    }
}