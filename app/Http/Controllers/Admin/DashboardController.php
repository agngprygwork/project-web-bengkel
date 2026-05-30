<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use App\Models\Mekanik;
use App\Models\Booking;
use App\Models\JenisService;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik dasar
        $totalCustomers = Customer::count();
        $totalMekaniks = Mekanik::count();
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();

        // Pendapatan bulan ini
        $totalRevenue = Booking::where('status_pembayaran', 'lunas')
            ->whereMonth('tanggal_pembayaran', now()->month)
            ->sum('total_bayar');

        // Customer baru bulan ini
        $newCustomersThisMonth = Customer::whereMonth('created_at', now()->month)->count();

        // Mekanik tersedia (tidak sedang bertugas)
        $availableMekaniks = Mekanik::whereDoesntHave('bookings', function ($query) {
            $query->whereIn('status', ['diproses', 'dijadwalkan']);
        })->count();

        // Low stock spareparts
        $lowStockSpareparts = Sparepart::whereRaw('stok <= stok_minimum')->count();

        // Data untuk chart booking
        $chartLabels = [];
        $bookingChartData = [];

        // Booking 7 hari terakhir
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $bookingChartData[] = Booking::whereDate('created_at', $date)->count();
        }

        // Statistik pembayaran
        $paymentStats = [
            'lunas' => Booking::where('status_pembayaran', 'lunas')->count(),
            'pending' => Booking::where('status_pembayaran', 'pending')->count(),
            'gagal' => Booking::where('status_pembayaran', 'gagal')->count(),
        ];

        // Recent bookings
        $recentBookings = Booking::with(['customer.user', 'jenisService'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Recent customers
        $recentCustomers = Customer::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Recent mekaniks
        $recentMekaniks = Mekanik::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('pages.admin.dashboard.index', compact(
            'totalCustomers',
            'totalMekaniks',
            'totalBookings',
            'pendingBookings',
            'totalRevenue',
            'newCustomersThisMonth',
            'availableMekaniks',
            'lowStockSpareparts',
            'chartLabels',
            'bookingChartData',
            'paymentStats',
            'recentBookings',
            'recentCustomers',
            'recentMekaniks'
        ));
    }

    // AJAX endpoint untuk update chart
    public function chartData(Request $request)
    {
        $period = $request->get('period', 'weekly');

        switch ($period) {
            case 'yearly':
                $labels = [];
                $data = [];
                for ($i = 1; $i <= 12; $i++) {
                    $labels[] = date('F', mktime(0, 0, 0, $i, 1));
                    $data[] = Booking::whereMonth('created_at', $i)
                        ->whereYear('created_at', now()->year)
                        ->count();
                }
                break;
            case 'monthly':
                $daysInMonth = now()->daysInMonth;
                $labels = [];
                $data = [];
                for ($i = 1; $i <= $daysInMonth; $i++) {
                    $labels[] = $i;
                    $data[] = Booking::whereDate('created_at', now()->format('Y-m-') . str_pad($i, 2, '0', STR_PAD_LEFT))
                        ->count();
                }
                break;
            default: // weekly
                $labels = [];
                $data = [];
                for ($i = 6; $i >= 0; $i--) {
                    $date = now()->subDays($i);
                    $labels[] = $date->format('D');
                    $data[] = Booking::whereDate('created_at', $date)->count();
                }
                break;
        }

        return response()->json([
            'labels' => $labels,
            'bookings' => $data
        ]);
    }
}
