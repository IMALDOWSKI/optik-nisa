<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Garansi extends Model
{
    protected $fillable = [
        'transaksi_id',
        'pelanggan_id',
        'produk_id',
        'no_garansi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'ketentuan',
        'catatan_klaim',
        'tanggal_klaim',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    // Sisa hari garansi
    public function sisaHari()
    {
        if ($this->status === 'expired') return 0;
        $sisa = Carbon::now()->diffInDays($this->tanggal_selesai, false);
        return max(0, $sisa);
    }

    // Generate nomor garansi
    public static function generateNoGaransi()
    {
        $prefix = 'GRN' . date('Ymd');
        $last   = self::where('no_garansi', 'like', $prefix . '%')
                      ->orderBy('no_garansi', 'desc')
                      ->first();
        $number = $last ? (int) substr($last->no_garansi, -4) + 1 : 1;
        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    // Auto update status expired
    public static function updateStatusExpired()
    {
        self::where('status', 'aktif')
            ->where('tanggal_selesai', '<', Carbon::today())
            ->update(['status' => 'expired']);
    }
}