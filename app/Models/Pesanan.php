<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = [
        'kode_pesanan',
        'transaksi_id',
        'pelanggan_id',
        'user_id',
        'status',
        'tanggal_estimasi',
        'tanggal_selesai',
        'catatan',
        'catatan_internal',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function riwayats()
    {
        return $this->hasMany(RiwayatStatusPesanan::class);
    }

    // Label status
    public function labelStatus()
    {
        return match($this->status) {
            'menunggu'      => ['label' => 'Menunggu',      'color' => 'secondary'],
            'diproses'      => ['label' => 'Diproses',      'color' => 'info'],
            'selesai_dibuat'=> ['label' => 'Selesai Dibuat','color' => 'primary'],
            'siap_diambil'  => ['label' => 'Siap Diambil',  'color' => 'success'],
            'sudah_diambil' => ['label' => 'Sudah Diambil', 'color' => 'dark'],
            default         => ['label' => 'Unknown',       'color' => 'light'],
        };
    }

    // Generate kode pesanan
    public static function generateKode()
    {
        $prefix = 'PSN' . date('Ymd');
        $last   = self::where('kode_pesanan', 'like', $prefix . '%')
                      ->orderBy('kode_pesanan', 'desc')
                      ->first();
        $number = $last ? (int) substr($last->kode_pesanan, -4) + 1 : 1;
        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}