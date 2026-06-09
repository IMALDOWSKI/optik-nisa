<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $fillable = [
        'user_id',
        'judul',
        'kategori',
        'jumlah',
        'tanggal',
        'catatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Daftar kategori
    public static function daftarKategori()
    {
        return [
            'gaji'          => '👨‍💼 Gaji Karyawan',
            'sewa'          => '🏠 Sewa Tempat',
            'listrik'       => '💡 Listrik',
            'air'           => '💧 Air',
            'internet'      => '🌐 Internet',
            'peralatan'     => '🔧 Peralatan',
            'transportasi'  => '🚗 Transportasi',
            'lainnya'       => '📦 Lainnya',
        ];
    }
}