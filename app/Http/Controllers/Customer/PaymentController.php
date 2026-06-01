<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function index()
    {
        $customer = Auth::user()->customer;
        $pendingPayments = Booking::where('customer_id', $customer->id)
            ->where('status_pembayaran', 'pending')
            ->where('status', '!=', 'selesai')
            ->with(['jenisService', 'payment'])
            ->get();

        $paymentHistory = Booking::where('customer_id', $customer->id)
            ->where('status_pembayaran', 'lunas')
            ->orWhere('status_pembayaran', 'gagal')
            ->with(['jenisService', 'payment'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('pages.customer.payments.index', compact('pendingPayments', 'paymentHistory'));
    }

    public function create(Booking $booking)
    {
        $this->authorizeBooking($booking);

        if ($booking->status_pembayaran == 'lunas') {
            return redirect()->route('customer.payments.show', $booking)
                ->with('info', 'Pembayaran sudah lunas.');
        }

        return view('pages.customer.payments.create', compact('booking'));
    }

    public function process(Request $request, Booking $booking)
    {
        $this->authorizeBooking($booking);

        $params = [];
        if ($request->has('bank') && $request->payment_type == 'bank_transfer') {
            $params['bank'] = $request->bank;
        }

        $result = $this->midtransService->createTransaction($booking, $params);
        $cekTransaksi = $this->midtransService->checkTransactionStatus($booking->id);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'snap_token' => $result['token'],
                'order_id' => $result['order_id']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message']
        ], 500);
    }

    public function show(Booking $booking)
    {
        $this->authorizeBooking($booking);

        $booking->load(['jenisService', 'payment', 'service.spareparts']);

        $paymentDetails = null;
        if ($booking->payment && $booking->payment->order_id) {
            $status = $this->midtransService->checkTransactionStatus($booking->payment->order_id);
            if ($status['success']) {
                $paymentDetails = $status['data'];
            }
        }

        return view('pages.customer.payments.show', compact('booking', 'paymentDetails'));
    }

    public function notification(Request $request)
    {
        Log::info('MIDTRANS NOTIFICATION HIT');
        Log::info($request->all());

        $result = $this->midtransService->handleNotification();

        if ($result) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 500);
    }

    protected function authorizeBooking(Booking $booking)
    {
        if ($booking->customer_id !== Auth::user()->customer->id) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function callback(Request $request, Booking $booking)
    {
        Log::info('MIDTRANS CALLBACK');
        Log::info($request->all());

        $payment = $booking->payment;

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found'
            ], 404);
        }

        $payment->transaction_id = $request->transaction_id;
        $payment->payment_type = $request->payment_type;
        $payment->status = $request->transaction_status;

        if ($request->transaction_status == 'settlement') {

            $payment->status = 'settlement';

            $booking->status_pembayaran = 'lunas';
            $booking->status = 'selesai';
            $booking->save();
        }

        $payment->save();

        return response()->json([
            'success' => true
        ]);
    }
}
