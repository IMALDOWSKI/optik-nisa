<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 10 pelanggan
        Pelanggan::factory(10)->create();

        // Buat 15 produk
        Produk::factory(15)->create();

        // Buat 20 transaksi (setelah pelanggan & produk ada)
        Transaksi::factory(20)->create();
    }
}