<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Antrian extends Model
{
    protected $fillable = [
        'nomor_antrian',
        'tanggal',
        'nama_pelanggan',
        'keperluan',
        'status',
        'dipanggil_at',
    ];

    // Generate nomor antrian baru untuk hari ini
    public static function nomorBerikutnya()
    {
        $today = Carbon::today();
        $last  = self::whereDate('tanggal', $today)
                     ->orderBy('nomor_antrian', 'desc')
                     ->first();

        return $last ? $last->nomor_antrian + 1 : 1;
    }

    // Label keperluan
    public function labelKeperluan()
    {
        return match($this->keperluan) {
            'kontrol_mata'  => '👁️ Kontrol Mata',
            'beli_produk'   => '🛒 Beli Produk',
            'ambil_pesanan' => '👓 Ambil Pesanan',
            'konsultasi'    => '💬 Konsultasi',
            default         => '📌 Lainnya',
        };
    }

    // Label status
    public function labelStatus()
    {
        return match($this->status) {
            'menunggu'  => ['label' => 'Menunggu',  'color' => 'secondary'],
            'dipanggil' => ['label' => 'Dipanggil', 'color' => 'warning'],
            'selesai'   => ['label' => 'Selesai',   'color' => 'success'],
            'batal'     => ['label' => 'Batal',     'color' => 'danger'],
            default     => ['label' => 'Unknown',   'color' => 'light'],
        };
    }
}