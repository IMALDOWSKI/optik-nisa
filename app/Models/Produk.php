<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

protected $fillable = [
    'kode_produk',
    'barcode',
    'nama_produk',
    'kategori',
    'deskripsi',
    'harga',
    'stok',
    'status',
    'merk',
    'material',
    'ukuran',
    'warna',
    'gender',
    'jenis_lensa',
    'indeks_lensa',
    'coating',
];
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    // Generate kode produk otomatis
    public static function generateKode($kategori)
    {
        $prefix = match($kategori) {
            'kacamata'  => 'FRM',
            'lensa'     => 'LNS',
            'aksesoris' => 'AKS',
            default     => 'PRD',
        };

        $last = self::where('kode_produk', 'like', $prefix . '%')
                    ->orderBy('kode_produk', 'desc')
                    ->first();

        $number = $last ? (int) substr($last->kode_produk, 3) + 1 : 1;

        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}