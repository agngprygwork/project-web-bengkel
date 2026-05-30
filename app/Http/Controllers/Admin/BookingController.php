<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Mekanik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of bookings.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['customer.user', 'mekanik.user', 'jenisService']);

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

        // Search by booking code or customer name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                    ->orWhereHas('customer.user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistics
        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'in_progress' => Booking::where('status', 'diproses')->count(),
            'completed' => Booking::where('status', 'selesai')->count(),
            'paid' => Booking::where('status_pembayaran', 'lunas')->count(),
            'unpaid' => Booking::where('status_pembayaran', 'pending')->count(),
        ];

        $statuses = [
            'pending' => 'Pending',
            'dijadwalkan' => 'Dijadwalkan',
            'diproses' => 'Diproses',
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak'
        ];

        return view('pages.admin.bookings.index', compact('bookings', 'stats', 'statuses'));
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        $booking->load(['customer.user', 'mekanik.user', 'jenisService', 'payment', 'service.spareparts']);

        $mekaniks = Mekanik::with('user')->get();

        $statuses = [
            'pending' => 'Pending',
            'dijadwalkan' => 'Dijadwalkan',
            'diproses' => 'Diproses',
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak'
        ];

        return view('pages.admin.bookings.show', compact('booking', 'mekaniks', 'statuses'));
    }

    /**
     * Update booking status.
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,dijadwalkan,diproses,menunggu_pembayaran,selesai,ditolak',
            'mekanik_id' => 'nullable|exists:mekaniks,id',
            'catatan' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();

        try {
            $oldStatus = $booking->status;
            $booking->status = $request->status;

            if ($request->has('mekanik_id') && $request->mekanik_id) {
                $booking->mekanik_id = $request->mekanik_id;
            }

            if ($request->has('catatan')) {
                $booking->catatan = $request->catatan;
            }

            $booking->save();

            // Log activity (optional)
            // ActivityLog::create([
            //     'user_id' => auth()->id(),
            //     'action' => 'update_booking_status',
            //     'description' => "Status booking {$booking->booking_code} diubah dari {$oldStatus} menjadi {$request->status}"
            // ]);

            DB::commit();

            return redirect()->back()->with('success', 'Status booking berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified booking.
     */
    public function destroy(Booking $booking)
    {
        DB::beginTransaction();

        try {
            $bookingCode = $booking->booking_code;
            $booking->delete();

            DB::commit();

            return redirect()->route('admin.bookings.index')
                ->with('success', "Booking {$bookingCode} berhasil dihapus.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus booking: ' . $e->getMessage());
        }
    }

    /**
     * Export bookings to Excel/CSV
     */
    public function export(Request $request)
    {
        // Implementation for export functionality
        // You can use Maatwebsite/Excel package
    }
}
