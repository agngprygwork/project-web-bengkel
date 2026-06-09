<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Sparepart;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Bookings report
     */
    public function bookings(Request $request)
    {
        $query = Booking::with(['customer.user', 'jenisService']);

        // Date range filter
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        $query->whereBetween('tanggal_booking', [$dateFrom, $dateTo]);

        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $bookings = $query->orderBy('tanggal_booking', 'desc')->paginate(20);

        // Statistics
        $stats = [
            'total' => $query->count(),
            'total_revenue' => $query->where('status_pembayaran', 'lunas')->sum('total_bayar'),
            'pending_payment' => $query->where('status_pembayaran', 'pending')->sum('total_bayar'),
            'by_status' => Booking::select('status', DB::raw('count(*) as total'))
                ->whereBetween('tanggal_booking', [$dateFrom, $dateTo])
                ->groupBy('status')
                ->get(),
            'by_day' => Booking::select(DB::raw('DATE(tanggal_booking) as date'), DB::raw('count(*) as total'))
                ->whereBetween('tanggal_booking', [$dateFrom, $dateTo])
                ->groupBy(DB::raw('DATE(tanggal_booking)'))
                ->get(),
        ];

        return view('pages.admin.reports.bookings', compact('bookings', 'stats', 'dateFrom', 'dateTo'));
    }

    /**
     * Payments report
     */
    public function payments(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        $payments = Booking::with(['customer.user', 'jenisService', 'payment'])
            ->where('status_pembayaran', 'lunas')
            ->whereBetween('updated_at', [$dateFrom, $dateTo])
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        $stats = [
            'total_transactions' => $payments->total(),
            'total_amount' => Booking::where('status_pembayaran', 'lunas')
                ->whereBetween('updated_at', [$dateFrom, $dateTo])
                ->sum('total_bayar'),
            'by_payment_method' => Booking::select('metode_pembayaran', DB::raw('count(*) as total'), DB::raw('sum(total_bayar) as amount'))
                ->where('status_pembayaran', 'lunas')
                ->whereBetween('updated_at', [$dateFrom, $dateTo])
                ->whereNotNull('metode_pembayaran')
                ->groupBy('metode_pembayaran')
                ->get(),
            'daily' => Booking::select(DB::raw('DATE(updated_at) as date'), DB::raw('count(*) as total'), DB::raw('sum(total_bayar) as amount'))
                ->where('status_pembayaran', 'lunas')
                ->whereBetween('updated_at', [$dateFrom, $dateTo])
                ->groupBy(DB::raw('DATE(updated_at)'))
                ->orderBy(DB::raw('DATE(updated_at)'), 'desc')
                ->get(),
        ];

        return view('pages.admin.reports.payments', compact('payments', 'stats', 'dateFrom', 'dateTo'));
    }

    /**
     * Services report
     */
    public function services(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        // Popular services
        $popularServices = Booking::select('jenis_service_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->with('jenisService')
            ->groupBy('jenis_service_id')
            ->orderBy('total', 'desc')
            ->get();

        // Mekanik performance
        $mekanikPerformance = Booking::select('mekanik_id', DB::raw('count(*) as total'), DB::raw('sum(total_bayar) as revenue'))
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->whereNotNull('mekanik_id')
            ->with('mekanik.user')
            ->groupBy('mekanik_id')
            ->orderBy('total', 'desc')
            ->get();

        // Sparepart usage
        $sparepartUsage = DB::table('service_spareparts')
            ->join('services', 'service_spareparts.service_id', '=', 'services.id')
            ->join('bookings', 'services.booking_id', '=', 'bookings.id')
            ->join('spareparts', 'service_spareparts.sparepart_id', '=', 'spareparts.id')
            ->whereBetween('services.created_at', [$dateFrom, $dateTo])
            ->select(
                'spareparts.nama_sparepart',
                DB::raw('sum(service_spareparts.jumlah) as total_used'),
                DB::raw('sum(service_spareparts.subtotal) as total_value')
            )
            ->groupBy('spareparts.id', 'spareparts.nama_sparepart')
            ->orderBy('total_used', 'desc')
            ->get();

        return view('pages.admin.reports.services', compact('popularServices', 'mekanikPerformance', 'sparepartUsage', 'dateFrom', 'dateTo'));
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'bookings');
        $format = $request->get('format', 'pdf');

        switch ($type) {
            case 'bookings':
                return $this->exportBookings($request, $format);
            case 'payments':
                return $this->exportPayments($request, $format);
            case 'services':
                return $this->exportServices($request, $format);
            default:
                return redirect()->back()->with('error', 'Invalid report type');
        }
    }

    protected function exportBookings(Request $request, $format)
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        $query = Booking::with(['customer.user', 'jenisService'])
            ->whereBetween('tanggal_booking', [$dateFrom, $dateTo]);

        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $bookings = $query->orderBy('tanggal_booking', 'desc')->get();

        $stats = [
            'total' => $bookings->count(),
            'total_revenue' => $bookings->where('status_pembayaran', 'lunas')->sum('total_bayar'),
            'pending_payment' => $bookings->where('status_pembayaran', 'pending')->sum('total_bayar'),
            'by_status' => $bookings->groupBy('status')->map->count(),
        ];

        $data = [
            'title' => 'Laporan Booking',
            'subtitle' => 'Periode: ' . date('d/m/Y', strtotime($dateFrom)) . ' - ' . date('d/m/Y', strtotime($dateTo)),
            'bookings' => $bookings,
            'stats' => $stats,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'generated_at' => now()->format('d/m/Y H:i:s'),
            'generated_by' => auth()->user()->name,
        ];

        $pdf = Pdf::loadView('pages.admin.reports.pdf.bookings', $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('laporan_booking_' . date('Ymd_His') . '.pdf');
    }

    protected function exportPayments(Request $request, $format)
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        $payments = Booking::with(['customer.user', 'jenisService', 'payment'])
            ->where('status_pembayaran', 'lunas')
            ->whereBetween('updated_at', [$dateFrom, $dateTo])
            ->orderBy('updated_at', 'desc')
            ->get();

        $stats = [
            'total_transactions' => $payments->count(),
            'total_amount' => $payments->sum('total_bayar'),
            'by_payment_method' => $payments->groupBy('metode_pembayaran')->map(function ($items) {
                return [
                    'total' => $items->count(),
                    'amount' => $items->sum('total_bayar')
                ];
            }),
            'daily' => $payments->groupBy(function ($item) {
                return $item->updated_at->format('Y-m-d');
            })->map(function ($items) {
                return [
                    'total' => $items->count(),
                    'amount' => $items->sum('total_bayar')
                ];
            }),
        ];

        $data = [
            'title' => 'Laporan Pembayaran',
            'subtitle' => 'Periode: ' . date('d/m/Y', strtotime($dateFrom)) . ' - ' . date('d/m/Y', strtotime($dateTo)),
            'payments' => $payments,
            'stats' => $stats,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'generated_at' => now()->format('d/m/Y H:i:s'),
            'generated_by' => auth()->user()->name,
        ];

        $pdf = Pdf::loadView('pages.admin.reports.pdf.payments', $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('laporan_pembayaran_' . date('Ymd_His') . '.pdf');
    }

    protected function exportServices(Request $request, $format)
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        // Popular services
        $popularServices = Booking::select('jenis_service_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->with('jenisService')
            ->groupBy('jenis_service_id')
            ->orderBy('total', 'desc')
            ->get();

        // Mekanik performance
        $mekanikPerformance = Booking::select('mekanik_id', DB::raw('count(*) as total'), DB::raw('sum(total_bayar) as revenue'))
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->whereNotNull('mekanik_id')
            ->with('mekanik.user')
            ->groupBy('mekanik_id')
            ->orderBy('total', 'desc')
            ->get();

        // Sparepart usage
        $sparepartUsage = DB::table('service_spareparts')
            ->join('services', 'service_spareparts.service_id', '=', 'services.id')
            ->join('bookings', 'services.booking_id', '=', 'bookings.id')
            ->join('spareparts', 'service_spareparts.sparepart_id', '=', 'spareparts.id')
            ->whereBetween('services.created_at', [$dateFrom, $dateTo])
            ->select(
                'spareparts.nama_sparepart',
                DB::raw('sum(service_spareparts.jumlah) as total_used'),
                DB::raw('sum(service_spareparts.subtotal) as total_value')
            )
            ->groupBy('spareparts.id', 'spareparts.nama_sparepart')
            ->orderBy('total_used', 'desc')
            ->get();

        $data = [
            'title' => 'Laporan Service',
            'subtitle' => 'Periode: ' . date('d/m/Y', strtotime($dateFrom)) . ' - ' . date('d/m/Y', strtotime($dateTo)),
            'popularServices' => $popularServices,
            'mekanikPerformance' => $mekanikPerformance,
            'sparepartUsage' => $sparepartUsage,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'generated_at' => now()->format('d/m/Y H:i:s'),
            'generated_by' => auth()->user()->name,
        ];

        $pdf = Pdf::loadView('pages.admin.reports.pdf.services', $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('laporan_service_' . date('Ymd_His') . '.pdf');
    }
}
