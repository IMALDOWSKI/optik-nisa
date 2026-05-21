<?php

namespace Database\Factories;

use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransaksiFactory extends Factory
{
    public function definition(): array
    {
        $produk  = Produk::inRandomOrder()->first();
        $jumlah  = $this->faker->numberBetween(1, 5);
        $total   = $produk ? $produk->harga * $jumlah : 100000;

        return [
            'pelanggan_id'      => Pelanggan::inRandomOrder()->first()->id,
            'produk_id'         => $produk->id,
            'jumlah'            => $jumlah,
            'total_harga'       => $total,
            'tanggal_transaksi' => $this->faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            'status'            => $this->faker->randomElement(['pending', 'selesai', 'dibatalkan']),
            'catatan'           => $this->faker->optional()->sentence(),
        ];
    }
}