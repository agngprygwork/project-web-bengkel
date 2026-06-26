<?php
// app/Http/Controllers/LandingController.php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use App\Models\JenisService;
use App\Models\Booking;
use App\Models\Mekanik;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index()
    {
        // Get featured services
        $services = JenisService::where('is_active', true)
            ->take(6)
            ->get();

        // Get some statistics
        $stats = [
            'customers' => \App\Models\Customer::count(),
            'services_completed' => Booking::where('status', 'selesai')->count(),
            'mekaniks' => Mekanik::count(),
            'years_experience' => 5, // Static or calculate from mekaniks
        ];

        // Get mekaniks for display
        $mekaniks = Mekanik::with('user')
            ->take(4)
            ->get();

        // Get recent testimonials (if you have testimonials table)
        // $testimonials = Testimonial::with('customer.user')->latest()->take(3)->get();
        $testimonials = collect([
            (object) [
                'customer' => (object) ['user' => (object) ['name' => 'Andi Pratama']],
                'content' => 'Service sangat memuaskan, motor saya jadi lebih bertenaga!',
                'rating' => 5,
                'created_at' => now()->subDays(5),
            ],
            (object) [
                'customer' => (object) ['user' => (object) ['name' => 'Siti Rahayu']],
                'content' => 'Mekaniknya profesional dan ramah. Harga juga terjangkau.',
                'rating' => 4,
                'created_at' => now()->subDays(10),
            ],
            (object) [
                'customer' => (object) ['user' => (object) ['name' => 'Budi Santoso']],
                'content' => 'Booking mudah, pelayanan cepat. Recommended banget!',
                'rating' => 5,
                'created_at' => now()->subDays(15),
            ],
        ]);

        return view('pages.guest.index', compact('services', 'stats', 'mekaniks', 'testimonials'));
    }
}
