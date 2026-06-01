<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    protected $serverKey;
    protected $clientKey;
    protected $isProduction;

    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key');
        $this->clientKey = config('midtrans.client_key');
        $this->isProduction = config('midtrans.is_production');

        $this->configure();
    }

    protected function configure()
    {
        Config::$serverKey = $this->serverKey;
        Config::$clientKey = $this->clientKey;
        Config::$isProduction = $this->isProduction;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction(Booking $booking, array $params = [])
    {
        try {
            $orderId = 'BK-' . $booking->id . '-' . time();

            $transactionDetails = [
                'order_id' => $orderId,
                'gross_amount' => (int) $booking->total_bayar,
            ];

            $customerDetails = [
                'first_name' => $booking->customer->user->name,
                'email' => $booking->customer->user->email,
                'phone' => $booking->customer->no_hp,
                'billing_address' => [
                    'address' => $booking->customer->alamat,
                ],
            ];

            $itemDetails = [
                [
                    'id' => $booking->jenisService->id,
                    'price' => (int) $booking->jenisService->harga,
                    'quantity' => 1,
                    'name' => $booking->jenisService->nama_service,
                ]
            ];

            // Tambahkan sparepart jika ada
            if ($booking->service && $booking->service->spareparts->count() > 0) {
                foreach ($booking->service->spareparts as $sparepart) {
                    $itemDetails[] = [
                        'id' => $sparepart->id,
                        'price' => (int) $sparepart->harga_jual,
                        'quantity' => $sparepart->pivot->jumlah,
                        'name' => $sparepart->nama_sparepart,
                    ];
                }
            }

            $payload = [
                'transaction_details' => $transactionDetails,
                'customer_details' => $customerDetails,
                'item_details' => $itemDetails,
                'credit_card' => [
                    'secure' => true
                ]
            ];

            // Tambahan parameter spesifik
            if (isset($params['bank'])) {
                $payload['bank_transfer'] = ['bank' => $params['bank']];
            }

            if (isset($params['payment_type'])) {
                $payload['payment_type'] = $params['payment_type'];
            }

            $snapToken = Snap::getSnapToken($payload);

            // Simpan payment record
            $payment = Payment::updateOrCreate(
                ['booking_id' => $booking->id],
                [
                    'order_id' => $orderId,
                    'amount' => $booking->total_bayar,
                    'status' => 'pending',
                ]
            );

            return [
                'success' => true,
                'token' => $snapToken,
                'order_id' => $orderId,
                'payment_id' => $payment->id
            ];
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function handleNotification()
    {
        try {
            $notification = new Notification();

            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;
            $paymentType = $notification->payment_type;
            $transactionId = $notification->transaction_id;
            $transactionTime = $notification->transaction_time;
            $settlementTime = $notification->settlement_time ?? null;

            // Cari payment berdasarkan order_id
            $payment = Payment::where('order_id', $orderId)->first();

            if (!$payment) {
                Log::warning('Payment not found for order: ' . $orderId);
                return false;
            }

            $booking = $payment->booking;

            // Update payment
            $payment->transaction_id = $transactionId;
            $payment->payment_type = $paymentType;
            $payment->transaction_time = $transactionTime;
            $payment->settlement_time = $settlementTime;

            // Update status berdasarkan transaction_status
            switch ($transactionStatus) {
                case 'capture':
                    if ($fraudStatus == 'accept') {
                        $payment->status = 'capture';
                        $booking->status_pembayaran = 'lunas';
                        $booking->status = 'menunggu_pembayaran';
                        $booking->tanggal_pembayaran = now();
                    }
                    break;

                case 'settlement':
                    $payment->status = 'settlement';
                    $booking->status_pembayaran = 'lunas';
                    $booking->status = 'menunggu_pembayaran';
                    $booking->tanggal_pembayaran = now();
                    break;

                case 'pending':
                    $payment->status = 'pending';
                    $booking->status_pembayaran = 'pending';
                    break;

                case 'deny':
                    $payment->status = 'deny';
                    $booking->status_pembayaran = 'gagal';
                    break;

                case 'cancel':
                case 'expire':
                    $payment->status = $transactionStatus;
                    $booking->status_pembayaran = 'gagal';
                    break;

                case 'failure':
                    $payment->status = 'failure';
                    $booking->status_pembayaran = 'gagal';
                    break;
            }

            $payment->save();
            $booking->save();

            Log::info('Payment updated for order: ' . $orderId . ' Status: ' . $transactionStatus);

            return true;
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return false;
        }
    }

    public function checkTransactionStatus($orderId)
    {
        try {
            $status = \Midtrans\Transaction::status($orderId);
            return [
                'success' => true,
                'data' => $status
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
