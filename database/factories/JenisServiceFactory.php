<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JenisServiceFactory extends Factory
{
    public function definition(): array
    {
        $services = [
            'Service Ringan' => ['harga' => 50000, 'waktu' => 60],
            'Service Besar' => ['harga' => 150000, 'waktu' => 120],
            'Ganti Oli' => ['harga' => 35000, 'waktu' => 30],
            'Tune Up' => ['harga' => 100000, 'waktu' => 90],
            'Perbaikan Mesin' => ['harga' => 200000, 'waktu' => 180],
            'Service Rem' => ['harga' => 75000, 'waktu' => 60],
            'Service Kelistrikan' => ['harga' => 80000, 'waktu' => 90],
        ];

        $name = fake()->randomElement(array_keys($services));

        return [
            'nama_service' => $name,
            'harga' => $services[$name]['harga'],
            'deskripsi' => fake()->sentence(),
            'estimasi_waktu' => $services[$name]['waktu'],
            'is_active' => true,
        ];
    }
}
