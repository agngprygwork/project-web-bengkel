<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;

        $stats = [
            'total_bookings' => Booking::where('customer_id', $customer->id)->count(),
            'pending_bookings' => Booking::where('customer_id', $customer->id)
                ->where('status', 'pending')->count(),
            'completed_bookings' => Booking::where('customer_id', $customer->id)
                ->where('status', 'selesai')->count(),
            'pending_payments' => Booking::where('customer_id', $customer->id)
                ->where('status_pembayaran', 'pending')
                ->where('status', '!=', 'selesai')
                ->count(),
        ];

        $recentBookings = Booking::where('customer_id', $customer->id)
            ->with(['jenisService', 'mekanik.user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $activeBookings = Booking::where('customer_id', $customer->id)
            ->whereNotIn('status', ['selesai', 'ditolak'])
            ->with(['jenisService'])
            ->get();

        return view('pages.customer.dashboard.index', compact('stats', 'recentBookings', 'activeBookings'));
    }
}
