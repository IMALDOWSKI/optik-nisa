<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'kode_supplier',
        'nama',
        'no_telepon',
        'email',
        'alamat',
        'kontak_person',
        'status',
        'catatan',
    ];

    public function restoks()
    {
        return $this->hasMany(Restok::class);
    }

    // Generate kode supplier otomatis
    public static function generateKode()
    {
        $prefix = 'SUP';
        $last   = self::where('kode_supplier', 'like', $prefix . '%')
                      ->orderBy('kode_supplier', 'desc')
                      ->first();
        $number = $last ? (int) substr($last->kode_supplier, 3) + 1 : 1;
        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}