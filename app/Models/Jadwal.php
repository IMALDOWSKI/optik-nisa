<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'kode_jadwal',
        'pelanggan_id',
        'user_id',
        'jenis',
        'tanggal',
        'jam',
        'status',
        'catatan',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Generate kode jadwal
    public static function generateKode()
    {
        $prefix = 'BKG' . date('Ymd');
        $last   = self::where('kode_jadwal', 'like', $prefix . '%')
                      ->orderBy('kode_jadwal', 'desc')
                      ->first();
        $number = $last ? (int) substr($last->kode_jadwal, -3) + 1 : 1;
        return $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    // Label jenis
    public function labelJenis()
    {
        return match($this->jenis) {
            'kontrol_mata'   => ['label' => '👁️ Kontrol Mata',    'color' => 'info'],
            'ambil_kacamata' => ['label' => '👓 Ambil Kacamata',  'color' => 'primary'],
            'konsultasi'     => ['label' => '💬 Konsultasi',      'color' => 'success'],
            default          => ['label' => '📌 Lainnya',         'color' => 'secondary'],
        };
    }

    // Label status
    public function labelStatus()
    {
        return match($this->status) {
            'menunggu'     => ['label' => 'Menunggu',     'color' => 'secondary'],
            'dikonfirmasi' => ['label' => 'Dikonfirmasi', 'color' => 'info'],
            'selesai'      => ['label' => 'Selesai',      'color' => 'success'],
            'batal'        => ['label' => 'Batal',        'color' => 'danger'],
            default        => ['label' => 'Unknown',      'color' => 'light'],
        };
    }
}