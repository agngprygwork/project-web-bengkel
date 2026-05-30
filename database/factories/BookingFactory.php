<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Mekanik;
use App\Models\JenisService;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    public function definition(): array
    {
        $statuses = ['pending', 'dijadwalkan', 'diproses', 'menunggu_pembayaran', 'selesai', 'ditolak'];
        $paymentStatuses = ['pending', 'lunas', 'gagal'];
        $paymentMethods = ['cash', 'transfer', 'qris', 'e_wallet'];

        return [
            'booking_code' => 'BKG-' . fake()->unique()->bothify('???-#####'),
            'customer_id' => Customer::factory(),
            'mekanik_id' => Mekanik::factory(),
            'jenis_service_id' => JenisService::factory(),
            'tanggal_booking' => fake()->dateTimeBetween('-1 month', '+1 month'),
            'waktu_booking' => fake()->time(),
            'keluhan' => fake()->paragraph(),
            'status' => fake()->randomElement($statuses),
            'metode_pembayaran' => fake()->randomElement($paymentMethods),
            'status_pembayaran' => fake()->randomElement($paymentStatuses),
            'total_bayar' => fake()->numberBetween(50000, 500000),
            'tanggal_pembayaran' => fake()->optional()->dateTimeBetween('-1 month', 'now'),
            'catatan' => fake()->optional()->sentence(),
        ];
    }
}
