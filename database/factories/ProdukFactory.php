<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    public function definition(): array
    {
        $kategori = $this->faker->randomElement(['kacamata', 'lensa', 'aksesoris']);

        $namaProduk = match($kategori) {
            'kacamata'   => 'Kacamata ' . $this->faker->randomElement(['Minus', 'Plus', 'Silinder', 'Baca', 'Hitam']),
            'lensa'      => 'Lensa ' . $this->faker->randomElement(['Softlens', 'Photochromic', 'Antiradiasi', 'Blue Ray']),
            'aksesoris'  => $this->faker->randomElement(['Tali Kacamata', 'Kotak Kacamata', 'Cairan Pembersih', 'Kain Lap']),
        };

        return [
            'nama_produk' => $namaProduk,
            'kategori'    => $kategori,
            'deskripsi'   => $this->faker->sentence(10),
            'harga'       => $this->faker->randomElement([50000, 75000, 100000, 150000, 200000, 350000, 500000]),
            'stok'        => $this->faker->numberBetween(5, 100),
            'merk'        => $this->faker->randomElement(['Essilor', 'Transitions', 'Ray-Ban', 'Oakley', 'Lokal']),
        ];
    }
}