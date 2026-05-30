<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MekanikFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->mekanik(),
            'spesialis' => fake()->randomElement(['Mesin', 'Kelistrikan', 'Body', 'Suspensi', 'Rem']),
            'no_hp' => fake()->phoneNumber(),
            'pengalaman_tahun' => fake()->numberBetween(1, 15),
        ];
    }
}
