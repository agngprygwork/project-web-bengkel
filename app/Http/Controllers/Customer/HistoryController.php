<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    /**
     * Display a listing of customer service history.
     */
    public function index(Request $request)
    {
        $customer = Auth::user()->customer;

        if (!$customer) {
            return redirect()->route('customer.dashboard')
                ->with('error', 'Data customer tidak ditemukan.');
        }

        $query = Booking::where('customer_id', $customer->id)
            ->whereIn('status', ['selesai', 'ditolak'])
            ->with(['jenisService', 'mekanik.user', 'payment']);

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status != 'all') {
            $query->where('status_pembayaran', $request->payment_status);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('tanggal_booking', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('tanggal_booking', '<=', $request->date_to);
        }

        // Search by booking code
        if ($request->has('search') && $request->search) {
            $query->where('booking_code', 'like', "%{$request->search}%");
        }

        $histories = $query->orderBy('updated_at', 'desc')->paginate(10);

        // Statistics
        $stats = [
            'total' => Booking::where('customer_id', $customer->id)
                ->whereIn('status', ['selesai', 'ditolak'])
                ->count(),
            'completed' => Booking::where('customer_id', $customer->id)
                ->where('status', 'selesai')
                ->count(),
            'rejected' => Booking::where('customer_id', $customer->id)
                ->where('status', 'ditolak')
                ->count(),
            'total_spent' => Booking::where('customer_id', $customer->id)
                ->where('status', 'selesai')
                ->where('status_pembayaran', 'lunas')
                ->sum('total_bayar'),
            'most_frequent_service' => Booking::where('customer_id', $customer->id)
                ->where('status', 'selesai')
                ->with('jenisService')
                ->select('jenis_service_id', \DB::raw('count(*) as total'))
                ->groupBy('jenis_service_id')
                ->orderBy('total', 'desc')
                ->first(),
        ];

        return view('pages.customer.history.index', compact('histories', 'stats'));
    }

    /**
     * Display the specified service history detail.
     */
    public function show(Booking $booking)
    {
        $this->authorizeHistory($booking);

        $booking->load([
            'customer.user',
            'jenisService',
            'mekanik.user',
            'payment',
            'service.spareparts'
        ]);

        // Get spareparts used in this service
        $usedSpareparts = \DB::table('service_spareparts')
            ->where('service_id', $booking->id)
            ->join('spareparts', 'service_spareparts.sparepart_id', '=', 'spareparts.id')
            ->select('service_spareparts.*', 'spareparts.nama_sparepart', 'spareparts.satuan')
            ->get();

        return view('pages.customer.history.show', compact('booking', 'usedSpareparts'));
    }

    /**
     * Download invoice for completed service.
     */
    public function downloadInvoice(Booking $booking)
    {
        $this->authorizeHistory($booking);

        if ($booking->status != 'selesai') {
            return redirect()->back()->with('error', 'Invoice hanya tersedia untuk service yang sudah selesai.');
        }

        $booking->load(['customer.user', 'jenisService', 'payment']);

        $usedSpareparts = \DB::table('service_spareparts')
            ->where('service_id', $booking->id)
            ->join('spareparts', 'service_spareparts.sparepart_id', '=', 'spareparts.id')
            ->select('service_spareparts.*', 'spareparts.nama_sparepart', 'spareparts.satuan')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages.customer.history.invoice', compact('booking', 'usedSpareparts'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('invoice_' . $booking->booking_code . '.pdf');
    }

    /**
     * Authorize that the booking belongs to the authenticated customer.
     */
    protected function authorizeHistory(Booking $booking)
    {
        $customer = Auth::user()->customer;

        if (!$customer || $booking->customer_id !== $customer->id) {
            abort(403, 'Unauthorized access.');
        }

        if (!in_array($booking->status, ['selesai', 'ditolak'])) {
            abort(404, 'History not found.');
        }
    }
}
