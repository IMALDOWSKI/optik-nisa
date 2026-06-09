<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoinRiwayat extends Model
{
    protected $fillable = [
        'member_id',
        'transaksi_id',
        'tipe',
        'poin',
        'keterangan',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}