<?php
// app/Http/Controllers/Mekanik/DashboardController.php

namespace App\Http\Controllers\Mekanik;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard mekanik dengan statistik
     */
    public function index()
    {
        $mekanik = Auth::user()->mekanik;

        // Pastikan mekanik memiliki record
        if (!$mekanik) {
            return redirect()->route('dashboard')
                ->with('error', 'Data mekanik tidak ditemukan.');
        }

        $stats = [
            'total_tasks' => Booking::where('mekanik_id', $mekanik->id)->count(),
            'today_services' => Booking::where('mekanik_id', $mekanik->id)
                ->whereDate('tanggal_booking', today())
                ->count(),
            'in_progress' => Booking::where('mekanik_id', $mekanik->id)
                ->where('status', 'diproses')
                ->count(),
            'completed' => Booking::where('mekanik_id', $mekanik->id)
                ->where('status', 'selesai')
                ->count(),
            'waiting_payment' => Booking::where('mekanik_id', $mekanik->id)
                ->where('status', 'menunggu_pembayaran')
                ->count(),
            'scheduled' => Booking::where('mekanik_id', $mekanik->id)
                ->where('status', 'dijadwalkan')
                ->count(),
            'rejected' => Booking::where('mekanik_id', $mekanik->id)
                ->where('status', 'ditolak')
                ->count(),
        ];

        $recentServices = Booking::where('mekanik_id', $mekanik->id)
            ->with(['customer.user', 'jenisService'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('pages.mekanik.dashboard.index', compact('stats', 'recentServices'));
    }
}
