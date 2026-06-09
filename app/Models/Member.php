<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'pelanggan_id',
        'no_member',
        'level',
        'total_poin',
        'total_poin_digunakan',
        'tanggal_bergabung',
        'status',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function poinRiwayats()
    {
        return $this->hasMany(PoinRiwayat::class);
    }

    // Generate nomor member
    public static function generateNoMember()
    {
        $prefix = 'MBR';
        $last   = self::where('no_member', 'like', $prefix . '%')
                      ->orderBy('no_member', 'desc')
                      ->first();
        $number = $last ? (int) substr($last->no_member, 3) + 1 : 1;
        return $prefix . str_pad($number, 5, '0', STR_PAD_LEFT);
    }

    // Hitung poin dari nominal transaksi
    // Setiap Rp 10.000 = 1 poin
    public static function hitungPoin($grandTotal)
    {
        return (int) floor($grandTotal / 10000);
    }

    // Level member berdasarkan total poin
    public function updateLevel()
    {
        $level = 'silver';
        if ($this->total_poin >= 1000) {
            $level = 'platinum';
        } elseif ($this->total_poin >= 500) {
            $level = 'gold';
        }
        $this->update(['level' => $level]);
    }

    // Nilai rupiah per poin
    // 1 poin = Rp 1.000
    public static function nilaiPoin($poin)
    {
        return $poin * 1000;
    }

    public function poinAktif()
    {
        return $this->total_poin - $this->total_poin_digunakan;
    }

    public function labelLevel()
    {
        return match($this->level) {
            'silver'   => ['label' => '🥈 Silver',   'color' => 'secondary'],
            'gold'     => ['label' => '🥇 Gold',     'color' => 'warning'],
            'platinum' => ['label' => '💎 Platinum', 'color' => 'info'],
            default    => ['label' => 'Silver',       'color' => 'secondary'],
        };
    }
}