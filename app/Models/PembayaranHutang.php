<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranHutang extends Model
{
    protected $fillable = [
        'hutang_id',
        'user_id',
        'jumlah_bayar',
        'tanggal_bayar',
        'metode_bayar',
        'catatan',
    ];

    public function hutang()
    {
        return $this->belongsTo(Hutang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}