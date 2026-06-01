<?php
// app/Http/Controllers/Mekanik/ScheduleController.php

namespace App\Http\Controllers\Mekanik;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    /**
     * Menampilkan jadwal service mekanik dalam format daftar
     */
    public function index()
    {
        $mekanik = Auth::user()->mekanik;

        $schedules = Booking::where('mekanik_id', $mekanik->id)
            ->whereIn('status', ['dijadwalkan', 'diproses'])
            ->whereDate('tanggal_booking', '>=', now())
            ->with(['customer.user', 'jenisService'])
            ->orderBy('tanggal_booking', 'asc')
            ->orderBy('waktu_booking', 'asc')
            ->get()
            ->groupBy(function ($item) {
                return $item->tanggal_booking->format('Y-m-d');
            });

        return view('pages.mekanik.schedule.index', compact('schedules'));
    }

    /**
     * Menampilkan kalender jadwal mekanik
     */
    public function calendar(Request $request)
    {
        $mekanik = Auth::user()->mekanik;

        // Get month and year from request or use current
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        // Validate month and year
        $month = max(1, min(12, (int)$month));
        $year = max(2000, min(2100, (int)$year));

        // Get schedules for the month
        $schedules = Booking::where('mekanik_id', $mekanik->id)
            ->whereYear('tanggal_booking', $year)
            ->whereMonth('tanggal_booking', $month)
            ->whereIn('status', ['dijadwalkan', 'diproses'])
            ->with(['customer.user', 'jenisService'])
            ->get()
            ->groupBy(function ($item) {
                return $item->tanggal_booking->day;
            });

        // Calculate calendar data
        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;
        $firstDayOfMonth = Carbon::create($year, $month, 1)->dayOfWeek;

        // Convert Sunday (0) to 7 for easier calculation
        $firstDayOfMonth = $firstDayOfMonth == 0 ? 7 : $firstDayOfMonth;

        // Previous and next month navigation
        $currentDate = Carbon::create($year, $month, 1);
        $previousMonthDate = $currentDate->copy()->subMonth();
        $nextMonthDate = $currentDate->copy()->addMonth();

        $previousMonth = $previousMonthDate->month;
        $previousYear = $previousMonthDate->year;
        $nextMonth = $nextMonthDate->month;
        $nextYear = $nextMonthDate->year;

        return view('pages.mekanik.schedule.calendar', compact(
            'schedules',
            'month',
            'year',
            'daysInMonth',
            'firstDayOfMonth',
            'previousMonth',
            'previousYear',
            'nextMonth',
            'nextYear'
        ));
    }

    /**
     * Menampilkan jadwal berdasarkan tanggal tertentu
     */
    public function byDate($date)
    {
        $mekanik = Auth::user()->mekanik;

        $schedules = Booking::where('mekanik_id', $mekanik->id)
            ->whereDate('tanggal_booking', $date)
            ->with(['customer.user', 'jenisService'])
            ->orderBy('waktu_booking', 'asc')
            ->get();

        return view('pages.mekanik.schedule.by-date', compact('schedules', 'date'));
    }
}
