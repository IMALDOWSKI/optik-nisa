<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

protected $fillable = [
    'kode_transaksi',
    'pelanggan_id',
    'user_id',
    'total_harga',
    'diskon',
    'grand_total',
    'metode_bayar',
    'bayar',
    'kembalian',
    'tanggal_transaksi',
    'status',
    'catatan',
];

// Tambahkan relasi user
public function user()
{
    return $this->belongsTo(User::class);
}

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    // Generate kode transaksi otomatis
    public static function generateKode()
    {
        $prefix = 'TRX' . date('Ymd');
        $last   = self::where('kode_transaksi', 'like', $prefix . '%')
                      ->orderBy('kode_transaksi', 'desc')
                      ->first();
        $number = $last ? (int) substr($last->kode_transaksi, -4) + 1 : 1;
        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}