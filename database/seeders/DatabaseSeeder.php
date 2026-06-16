<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===== 1. PELANGGAN =====
        $namaPelanggan = [
            'Budi Santoso', 'Siti Aminah', 'Ahmad Fauzi', 'Dewi Lestari', 'Rudi Hartono',
            'Maya Sari', 'Eko Prasetyo', 'Rina Wijaya', 'Hendra Gunawan', 'Putri Ayu',
            'Joko Susilo', 'Lina Marlina', 'Agus Setiawan', 'Wati Suryani', 'Bambang Sutrisno',
            'Yuli Astuti', 'Dedi Kurniawan', 'Sri Wahyuni', 'Fajar Nugroho', 'Indah Permata',
        ];

        $pelanggans = [];
        foreach ($namaPelanggan as $i => $nama) {
            $pelanggans[] = Pelanggan::create([
                'nama'       => $nama,
                'no_telepon' => '0812' . rand(10000000, 99999999),
                'email'      => strtolower(str_replace(' ', '.', $nama)) . '@gmail.com',
                'alamat'     => 'Jl. Contoh No. ' . ($i + 1) . ', Banda Aceh',
                'created_at' => Carbon::now()->subDays(rand(1, 180)),
            ]);
        }

        // ===== 2. PRODUK =====
        $produkData = [
            // Kacamata
            ['nama' => 'Ovale Classic',       'kategori' => 'kacamata', 'merk' => 'NVG',     'harga' => 500000],
            ['nama' => 'Kacamata Silinder',   'kategori' => 'kacamata', 'merk' => 'Transitions', 'harga' => 150000],
            ['nama' => 'Kacamata Minus Pro',  'kategori' => 'kacamata', 'merk' => 'Transitions', 'harga' => 500000],
            ['nama' => 'Frame Titanium',      'kategori' => 'kacamata', 'merk' => 'Oakley',  'harga' => 750000],
            ['nama' => 'Frame Kotak Retro',   'kategori' => 'kacamata', 'merk' => 'Ray-Ban', 'harga' => 650000],
            ['nama' => 'Frame Bulat Vintage', 'kategori' => 'kacamata', 'merk' => 'NVG',     'harga' => 480000],
            ['nama' => 'Frame Anak-anak',     'kategori' => 'kacamata', 'merk' => 'Essilor', 'harga' => 350000],
            ['nama' => 'Frame Premium Gold',  'kategori' => 'kacamata', 'merk' => 'Oakley',  'harga' => 950000],

            // Lensa
            ['nama' => 'Lensa Softlens Bening',   'kategori' => 'lensa', 'merk' => 'Transitions', 'harga' => 75000],
            ['nama' => 'Lensa Softlens Warna',    'kategori' => 'lensa', 'merk' => 'Oakley',      'harga' => 200000],
            ['nama' => 'Lensa Anti Radiasi',      'kategori' => 'lensa', 'merk' => 'Essilor',     'harga' => 350000],
            ['nama' => 'Lensa Progresif',         'kategori' => 'lensa', 'merk' => 'Essilor',     'harga' => 850000],
            ['nama' => 'Lensa Minus Standar',     'kategori' => 'lensa', 'merk' => 'Transitions', 'harga' => 180000],
            ['nama' => 'Lensa Plus Standar',      'kategori' => 'lensa', 'merk' => 'Transitions', 'harga' => 180000],
            ['nama' => 'Lensa Photochromic',      'kategori' => 'lensa', 'merk' => 'Transitions', 'harga' => 600000],

            // Aksesoris
            ['nama' => 'Cairan Pembersih Lensa', 'kategori' => 'aksesoris', 'merk' => 'Essilor', 'harga' => 100000],
            ['nama' => 'Tali Kacamata',          'kategori' => 'aksesoris', 'merk' => 'Oakley',  'harga' => 50000],
            ['nama' => 'Case Kacamata Keras',    'kategori' => 'aksesoris', 'merk' => 'NVG',     'harga' => 80000],
            ['nama' => 'Kain Microfiber',        'kategori' => 'aksesoris', 'merk' => 'Essilor', 'harga' => 25000],
            ['nama' => 'Sarung Kacamata Kain',   'kategori' => 'aksesoris', 'merk' => 'NVG',     'harga' => 35000],
        ];

        $produks = [];
        foreach ($produkData as $p) {
            $produks[] = Produk::create([
                'kode_produk' => Produk::generateKode($p['kategori']),
                'nama_produk' => $p['nama'],
                'kategori'    => $p['kategori'],
                'deskripsi'   => $p['nama'] . ' kualitas terbaik dari ' . $p['merk'],
                'harga'       => $p['harga'],
                'stok'        => rand(10, 100),
                'status'      => 'aktif',
                'merk'        => $p['merk'],
            ]);
        }

        // ===== 3. USER UNTUK TRANSAKSI =====
        $users = User::all();
        if ($users->isEmpty()) {
            // Fallback kalau belum ada user (seharusnya sudah ada dari sebelumnya)
            $users = collect([User::create([
                'name'     => 'Admin Optik Nisa',
                'email'    => 'admin2@optiknisa.com',
                'password' => bcrypt('admin123'),
                'role'     => 'admin',
            ])]);
        }

        // ===== 4. TRANSAKSI + DETAIL =====
        $metodeBayar = ['tunai', 'transfer', 'qris'];

        for ($i = 1; $i <= 30; $i++) {
            $pelanggan   = $pelanggans[array_rand($pelanggans)];
            $user        = $users->random();
            $tanggal     = Carbon::now()->subDays(rand(0, 90));
            $jumlahItem  = rand(1, 3);

            $totalHarga = 0;
            $itemTransaksi = [];

            for ($j = 0; $j < $jumlahItem; $j++) {
                $produk   = $produks[array_rand($produks)];
                $jumlah   = rand(1, 2);
                $subtotal = $produk->harga * $jumlah;
                $totalHarga += $subtotal;

                $itemTransaksi[] = [
                    'produk_id'    => $produk->id,
                    'jumlah'       => $jumlah,
                    'harga_satuan' => $produk->harga,
                    'subtotal'     => $subtotal,
                ];
            }

            // Diskon random (30% transaksi dapat diskon)
            $diskon = rand(1, 10) <= 3 ? round($totalHarga * (rand(5, 15) / 100)) : 0;
            $grandTotal = $totalHarga - $diskon;
            $bayar = $grandTotal;
            $kembalian = 0;

            $transaksi = Transaksi::create([
                'kode_transaksi'    => Transaksi::generateKode() . '-' . $i,
                'pelanggan_id'      => $pelanggan->id,
                'user_id'           => $user->id,
                'total_harga'       => $totalHarga,
                'diskon'            => $diskon,
                'grand_total'       => $grandTotal,
                'metode_bayar'      => $metodeBayar[array_rand($metodeBayar)],
                'bayar'             => $bayar,
                'kembalian'         => $kembalian,
                'tanggal_transaksi' => $tanggal,
                'status'            => 'selesai',
                'catatan'           => null,
                'created_at'        => $tanggal,
            ]);

            foreach ($itemTransaksi as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id'    => $item['produk_id'],
                    'jumlah'       => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal'     => $item['subtotal'],
                ]);
            }
        }

        $this->command->info('Seeding selesai! ' . count($pelanggans) . ' pelanggan, ' . count($produks) . ' produk, 30 transaksi berhasil dibuat.');
    }
}