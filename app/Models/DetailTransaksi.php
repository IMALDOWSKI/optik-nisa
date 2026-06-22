<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
        'is_frame_sendiri',
        'keterangan_frame_sendiri',
    ];

    protected $casts = [
        'is_frame_sendiri' => 'boolean',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    // Nama produk untuk ditampilkan — aman walau produk_id null (frame sendiri)
    public function namaTampil(): string
    {
        if ($this->is_frame_sendiri) {
            return 'Frame Milik Pelanggan' . ($this->keterangan_frame_sendiri ? ' (' . $this->keterangan_frame_sendiri . ')' : '');
        }

        return $this->produk->nama_produk ?? 'Produk tidak ditemukan';
    }
}