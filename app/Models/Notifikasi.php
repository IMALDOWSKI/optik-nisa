<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $fillable = [
        'judul',
        'pesan',
        'tipe',
        'url',
        'sudah_dibaca',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Generate notifikasi stok menipis
    public static function cekStokMenipis()
    {
        $produkMenipis = Produk::where('stok', '<=', 5)
                            ->where('status', 'aktif')
                            ->get();

        foreach ($produkMenipis as $produk) {
            // Cek apakah notifikasi untuk produk ini sudah ada hari ini
            $sudahAda = self::where('tipe', 'stok')
                            ->where('judul', 'like', '%' . $produk->nama_produk . '%')
                            ->whereDate('created_at', today())
                            ->exists();

            if (!$sudahAda) {
                self::create([
                    'judul'   => 'Stok Menipis: ' . $produk->nama_produk,
                    'pesan'   => 'Stok ' . $produk->nama_produk . ' tinggal ' . $produk->stok . ' unit. Segera lakukan restok!',
                    'tipe'    => 'stok',
                    'url'     => '/produk/' . $produk->id . '/edit',
                ]);
            }
        }
    }

    // Generate notifikasi pelanggan tidak aktif
    public static function cekPelangganTidakAktif()
    {
        $tiga_bulan_lalu = now()->subMonths(3);

        $pelangganTidakAktif = Pelanggan::whereDoesntHave('transaksis', function ($q) use ($tiga_bulan_lalu) {
            $q->where('tanggal_transaksi', '>=', $tiga_bulan_lalu);
        })->get();

        foreach ($pelangganTidakAktif as $pelanggan) {
            $sudahAda = self::where('tipe', 'pelanggan')
                            ->where('judul', 'like', '%' . $pelanggan->nama . '%')
                            ->whereDate('created_at', today())
                            ->exists();

            if (!$sudahAda) {
                self::create([
                    'judul' => 'Pelanggan Tidak Aktif: ' . $pelanggan->nama,
                    'pesan' => $pelanggan->nama . ' belum melakukan transaksi lebih dari 3 bulan. Mungkin perlu dihubungi!',
                    'tipe'  => 'pelanggan',
                    'url'   => '/pelanggan/' . $pelanggan->id . '/riwayat',
                ]);
            }
        }
    }
}