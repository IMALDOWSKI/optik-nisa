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

    // Reminder kontrol mata (sudah lebih dari 1 tahun)
public static function cekReminderKontrolMata()
{
    $satu_tahun_lalu = now()->subYear();

    // Cari pelanggan yang resep matanya sudah lebih dari 1 tahun
    $pelangganPerluKontrol = \App\Models\Pelanggan::whereHas('resepMatas', function($q) use ($satu_tahun_lalu) {
        $q->where('tanggal_periksa', '<', $satu_tahun_lalu);
    })->whereDoesntHave('resepMatas', function($q) use ($satu_tahun_lalu) {
        $q->where('tanggal_periksa', '>=', $satu_tahun_lalu);
    })->get();

    foreach ($pelangganPerluKontrol as $pelanggan) {
        $sudahAda = self::where('tipe', 'pelanggan')
                        ->where('judul', 'like', '%Kontrol Mata%' . $pelanggan->nama . '%')
                        ->whereDate('created_at', today())
                        ->exists();

        if (!$sudahAda) {
            $resepTerakhir = $pelanggan->resepMatas()->latest('tanggal_periksa')->first();
            $selisih       = \Carbon\Carbon::parse($resepTerakhir->tanggal_periksa)->diffForHumans();

            self::create([
                'judul' => 'Reminder Kontrol Mata: ' . $pelanggan->nama,
                'pesan' => $pelanggan->nama . ' terakhir kontrol mata ' . $selisih . '. Sudah waktunya kontrol mata kembali!',
                'tipe'  => 'pelanggan',
                'url'   => '/pelanggan/' . $pelanggan->id . '/riwayat',
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