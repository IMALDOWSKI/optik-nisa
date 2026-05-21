<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PelangganFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama'          => $this->faker->name(),
            'no_telepon'    => '08' . $this->faker->numerify('#########'),
            'email'         => $this->faker->unique()->safeEmail(),
            'alamat'        => $this->faker->address(),
            'tanggal_lahir' => $this->faker->date('Y-m-d', '-17 years'),
        ];
    }
}