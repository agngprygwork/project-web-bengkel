<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SparepartFactory extends Factory
{
    public function definition(): array
    {
        $spareparts = [
            'Oli Mesin' => 50000,
            'Busi' => 25000,
            'Ban Dalam' => 45000,
            'Kampas Rem' => 35000,
            'Lampu LED' => 55000,
            'Aki Kering' => 150000,
            'Filter Udara' => 40000,
            'V-Belt' => 75000,
        ];

        $name = fake()->randomElement(array_keys($spareparts));

        return [
            'kode_sparepart' => 'SP-' . fake()->unique()->bothify('??###'),
            'nama_sparepart' => $name,
            'merk' => fake()->randomElement(['Yamaha', 'Honda', 'Suzuki', 'Kawasaki', 'Generic']),
            'stok' => fake()->numberBetween(0, 100),
            'stok_minimum' => fake()->numberBetween(5, 20),
            'harga_beli' => $spareparts[$name] * 0.7,
            'harga_jual' => $spareparts[$name],
            'satuan' => 'pcs',
            'deskripsi' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
