<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\BookingRequest;
use App\Models\JenisService;
use App\Models\Booking;
use App\Models\Mekanik;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;
        $bookings = Booking::where('customer_id', $customer->id)
            ->with(['jenisService', 'mekanik.user', 'payment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.customer.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $jenisServices = JenisService::where('is_active', true)->get();
        $mekaniks = Mekanik::with('user')->get();

        return view('pages.customer.bookings.create', compact('jenisServices', 'mekaniks'));
    }

    public function store(BookingRequest $request)
    {
        DB::beginTransaction();

        try {
            $customer = Auth::user()->customer;
            $jenisService = JenisService::findOrFail($request->jenis_service_id);

            $booking = Booking::create([
                'booking_code' => 'BKG-' . strtoupper(uniqid()),
                'customer_id' => $customer->id,
                'mekanik_id' => $request->mekanik_id,
                'jenis_service_id' => $request->jenis_service_id,
                'tanggal_booking' => $request->tanggal_booking,
                'waktu_booking' => $request->waktu_booking,
                'keluhan' => $request->keluhan,
                'status' => 'pending',
                'status_pembayaran' => 'pending',
                'total_bayar' => $jenisService->harga,
                'catatan' => $request->catatan,
            ]);

            // Simpan data kendaraan ke session atau cache untuk sementara
            session(['vehicle_data' => [
                'motor_brand' => $request->motor_brand,
                'motor_type' => $request->motor_type,
                'license_plate' => $request->license_plate,
                'booking_id' => $booking->id
            ]]);

            DB::commit();

            return redirect()->route('customer.bookings.show', $booking)
                ->with('success', 'Booking berhasil dibuat! Silahkan lanjutkan ke pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat booking: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Booking $booking)
    {
        $this->authorizeBooking($booking);

        $booking->load(['jenisService', 'mekanik.user', 'payment', 'service.spareparts']);

        return view('pages.customer.bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        $this->authorizeBooking($booking);

        if ($booking->status == 'pending') {
            $booking->update(['status' => 'ditolak']);
            return redirect()->back()->with('success', 'Booking berhasil dibatalkan.');
        }

        return redirect()->back()->with('error', 'Booking tidak dapat dibatalkan.');
    }

    protected function authorizeBooking(Booking $booking)
    {
        if ($booking->customer_id !== Auth::user()->customer->id) {
            abort(403, 'Unauthorized access.');
        }
    }
}
