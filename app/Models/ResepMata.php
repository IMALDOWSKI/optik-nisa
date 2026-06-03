<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResepMata extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelanggan_id',
        'od_sph', 'od_cyl', 'od_axis', 'od_add',
        'os_sph', 'os_cyl', 'os_axis', 'os_add',
        'pd_kanan', 'pd_kiri',
        'tanggal_periksa',
        'dokter',
        'catatan',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    // Format nilai SPH/CYL dengan tanda + atau -
    public function formatNilai($nilai)
    {
        if (is_null($nilai)) return '-';
        return $nilai > 0 ? '+' . number_format($nilai, 2) : number_format($nilai, 2);
    }
}