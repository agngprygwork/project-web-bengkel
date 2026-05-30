<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Mekanik;
use App\Models\JenisService;
use App\Models\Booking;
use App\Models\Sparepart;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@bengkel.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create Mekaniks
        $mekaniks = [];
        $mekanikUsers = User::factory(3)->mekanik()->create();
        foreach ($mekanikUsers as $user) {
            $mekaniks[] = Mekanik::create([
                'user_id' => $user->id,
                'spesialis' => fake()->randomElement(['Mesin', 'Kelistrikan', 'Body']),
                'no_hp' => fake()->phoneNumber(),
                'pengalaman_tahun' => fake()->numberBetween(1, 10),
            ]);
        }

        // Create Customers
        $customers = [];
        $customerUsers = User::factory(10)->customer()->create();
        foreach ($customerUsers as $user) {
            $customers[] = Customer::create([
                'user_id' => $user->id,
                'alamat' => fake()->address(),
                'no_hp' => fake()->phoneNumber(),
            ]);
        }

        // Create Jenis Services
        $jenisServices = JenisService::factory(7)->create();

        // Create Bookings
        foreach (range(1, 30) as $i) {
            Booking::create([
                'booking_code' => 'BKG-' . strtoupper(uniqid()),
                'customer_id' => $customers[array_rand($customers)]->id,
                'mekanik_id' => $mekaniks[array_rand($mekaniks)]->id,
                'jenis_service_id' => $jenisServices->random()->id,
                'tanggal_booking' => fake()->dateTimeBetween('-1 month', '+1 week'),
                'waktu_booking' => fake()->time(),
                'keluhan' => fake()->paragraph(),
                'status' => fake()->randomElement(['pending', 'dijadwalkan', 'diproses', 'selesai']),
                'metode_pembayaran' => fake()->randomElement(['cash', 'transfer', 'qris']),
                'status_pembayaran' => fake()->randomElement(['pending', 'lunas']),
                'total_bayar' => fake()->numberBetween(50000, 500000),
                'catatan' => fake()->optional()->sentence(),
            ]);
        }

        // Create Spareparts
        Sparepart::factory(20)->create();

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin login: admin@bengkel.com / password');
    }
}
