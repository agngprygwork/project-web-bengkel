{{-- resources/views/customer/payments/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Pembayaran')
@section('page-title', 'Detail Pembayaran')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Payment Status Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div
                class="px-6 py-4 {{ $booking->status_pembayaran == 'lunas' ? 'bg-gradient-to-r from-green-600 to-green-700' : 'bg-gradient-to-r from-yellow-600 to-yellow-700' }}">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-white font-semibold text-lg">Status Pembayaran</h3>
                        <p class="text-white/90 text-sm mt-1">Booking #{{ $booking->booking_code }}</p>
                    </div>
                    <div class="text-right">
                        <span
                            class="inline-block px-4 py-2 rounded-lg text-sm font-semibold
                        {{ $booking->status_pembayaran == 'lunas' ? 'bg-green-800 text-white' : 'bg-yellow-800 text-white' }}">
                            {{ $booking->status_pembayaran == 'lunas' ? 'LUNAS' : strtoupper($booking->status_pembayaran) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <!-- Payment Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Order ID</label>
                        <p class="text-gray-900 font-mono text-sm">{{ $booking->payment->order_id ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Transaction ID</label>
                        <p class="text-gray-900 font-mono text-sm">{{ $booking->payment->transaction_id ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Metode Pembayaran</label>
                        <p class="text-gray-900">
                            @if ($booking->payment && $booking->payment->payment_type)
                                <span class="inline-flex items-center gap-2">
                                    @if ($booking->payment->payment_type == 'bank_transfer')
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                            </path>
                                        </svg>
                                    @elseif($booking->payment->payment_type == 'qris')
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                                            </path>
                                        </svg>
                                    @elseif($booking->payment->payment_type == 'gopay')
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                            </path>
                                        </svg>
                                    @endif
                                    {{ $booking->payment->payment_type_text }}
                                </span>
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Waktu Transaksi</label>
                        <p class="text-gray-900">
                            @if ($booking->payment && $booking->payment->transaction_time)
                                {{ \Carbon\Carbon::parse($booking->payment->transaction_time)->format('d M Y H:i:s') }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    @if ($booking->payment && $booking->payment->settlement_time)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Waktu Konfirmasi</label>
                            <p class="text-gray-900">
                                {{ \Carbon\Carbon::parse($booking->payment->settlement_time)->format('d M Y H:i:s') }}</p>
                        </div>
                    @endif
                    @if ($booking->payment && $booking->payment->expiry_time)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Batas Pembayaran</label>
                            <p class="text-red-600 font-semibold">
                                {{ \Carbon\Carbon::parse($booking->payment->expiry_time)->format('d M Y H:i:s') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- QRIS Code (if applicable) -->
        @if ($booking->payment && $booking->payment->payment_type == 'qris' && $booking->payment->qr_code_url)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                    <h3 class="text-white font-semibold">Scan QRIS untuk Membayar</h3>
                </div>
                <div class="p-6 text-center">
                    <div class="inline-block p-4 bg-white rounded-lg shadow-md">
                        <img src="{{ $booking->payment->qr_code_url }}" alt="QRIS Code" class="w-64 h-64 mx-auto">
                    </div>
                    <p class="mt-4 text-sm text-gray-600">
                        Scan QR Code di atas menggunakan aplikasi mobile banking atau e-wallet yang mendukung QRIS
                    </p>
                </div>
            </div>
        @endif

        <!-- Virtual Account Information (if applicable) -->
        @if ($booking->payment && $booking->payment->payment_type == 'bank_transfer' && $paymentDetails)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h3 class="text-white font-semibold">Informasi Transfer Bank</h3>
                </div>
                <div class="p-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Bank Tujuan</label>
                                <p class="text-lg font-bold text-gray-900">
                                    {{ strtoupper($paymentDetails->va_numbers[0]->bank ?? 'BCA') }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Nomor Virtual Account</label>
                                <p class="text-xl font-bold text-blue-600 font-mono">
                                    {{ $paymentDetails->va_numbers[0]->va_number ?? '-' }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Total Tagihan</label>
                                <p class="text-lg font-bold text-green-600">
                                    Rp {{ number_format($booking->total_bayar, 0, ',', '.') }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Batas Pembayaran</label>
                                <p class="text-red-600 font-semibold">
                                    @if ($booking->payment && $booking->payment->expiry_time)
                                        {{ \Carbon\Carbon::parse($booking->payment->expiry_time)->format('d M Y H:i:s') }}
                                    @else
                                        24 jam dari waktu transaksi
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-sm text-yellow-800">
                                <p class="font-semibold">Penting:</p>
                                <ul class="list-disc list-inside mt-1 space-y-1">
                                    <li>Lakukan pembayaran sebelum batas waktu yang ditentukan</li>
                                    <li>Transfer sesuai dengan jumlah tagihan yang tertera</li>
                                    <li>Gunakan nomor virtual account di atas sebagai nomor tujuan transfer</li>
                                    <li>Status pembayaran akan otomatis terupdate setelah transfer berhasil</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Payment Summary -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-6 py-4">
                <h3 class="text-white font-semibold">Ringkasan Pembayaran</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div class="flex justify-between items-center pb-2 border-b">
                        <span class="text-gray-600">Jenis Service</span>
                        <span class="font-medium">{{ $booking->jenisService->nama_service }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b">
                        <span class="text-gray-600">Harga Service</span>
                        <span class="font-medium">Rp {{ number_format($booking->jenisService->harga, 0, ',', '.') }}</span>
                    </div>

                    @if ($booking->service && $booking->service->spareparts->count() > 0)
                        <div class="pb-2 border-b">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Biaya Sparepart</span>
                                <span class="font-medium">Rp
                                    {{ number_format($booking->service->calculateTotalSpareparts(), 0, ',', '.') }}</span>
                            </div>
                            <div class="pl-4 space-y-1">
                                @foreach ($booking->service->spareparts as $sparepart)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">{{ $sparepart->nama_sparepart }}
                                            (x{{ $sparepart->pivot->jumlah }})</span>
                                        <span class="text-gray-600">Rp
                                            {{ number_format($sparepart->pivot->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="flex justify-between items-center pt-2">
                        <span class="text-lg font-bold text-gray-800">Total Dibayar</span>
                        <span class="text-2xl font-bold text-green-600">Rp
                            {{ number_format($booking->total_bayar, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Download Button -->
        @if ($booking->status_pembayaran == 'lunas')
            <div class="flex justify-center">
                <button onclick="downloadInvoice()"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download Invoice
                </button>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex justify-between gap-4">
            <a href="{{ route('customer.payments.index') }}"
                class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition text-center">
                Kembali ke Daftar Pembayaran
            </a>

            @if ($booking->status_pembayaran == 'pending' && !$booking->payment)
                <a href="{{ route('customer.payments.create', $booking) }}"
                    class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition text-center">
                    Lanjutkan Pembayaran
                </a>
            @endif

            <a href="{{ route('customer.bookings.show', $booking) }}"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-center">
                Lihat Detail Booking
            </a>
        </div>
    </div>

    @push('scripts')
        <script>
            function downloadInvoice() {
                // Create invoice HTML content
                const invoiceContent = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Invoice #{{ $booking->booking_code }}</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 40px; }
                    .header { text-align: center; margin-bottom: 30px; }
                    .invoice-title { font-size: 24px; font-weight: bold; color: #2563eb; }
                    .info-section { margin-bottom: 20px; }
                    .info-row { display: flex; justify-content: space-between; margin-bottom: 10px; }
                    .table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                    .table th, .table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
                    .table th { background-color: #f3f4f6; }
                    .total { font-size: 18px; font-weight: bold; text-align: right; margin-top: 20px; }
                    .footer { text-align: center; margin-top: 50px; font-size: 12px; color: #6b7280; }
                </style>
            </head>
            <body>
                <div class="header">
                    <h1 class="invoice-title">INVOICE</h1>
                    <p>Sistem Booking Servis Bengkel Motor</p>
                </div>
                
                <div class="info-section">
                    <div class="info-row">
                        <span><strong>Invoice No:</strong> {{ $booking->booking_code }}</span>
                        <span><strong>Date:</strong> {{ now()->format('d M Y') }}</span>
                    </div>
                    <div class="info-row">
                        <span><strong>Customer:</strong> {{ $booking->customer->user->name }}</span>
                        <span><strong>Booking Date:</strong> {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</span>
                    </div>
                </div>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $booking->jenisService->nama_service }}</td>
                            <td>1</td>
                            <td>Rp {{ number_format($booking->jenisService->harga, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($booking->jenisService->harga, 0, ',', '.') }}</td>
                        </tr>
                        @if ($booking->service && $booking->service->spareparts->count() > 0)
                            @foreach ($booking->service->spareparts as $sparepart)
                            <tr>
                                <td>{{ $sparepart->nama_sparepart }}</td>
                                <td>{{ $sparepart->pivot->jumlah }}</td>
                                <td>Rp {{ number_format($sparepart->harga_jual, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($sparepart->pivot->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: right;"><strong>Grand Total</strong></td>
                            <td><strong>Rp {{ number_format($booking->total_bayar, 0, ',', '.') }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
                
                <div class="total">
                    <p>Status: <strong>{{ strtoupper($booking->status_pembayaran) }}</strong></p>
                    <p>Payment Date: {{ $booking->tanggal_pembayaran ? \Carbon\Carbon::parse($booking->tanggal_pembayaran)->format('d M Y') : '-' }}</p>
                </div>
                
                <div class="footer">
                    <p>Thank you for using our service!</p>
                    <p>Sistem Booking Servis Bengkel Motor</p>
                </div>
            </body>
            </html>
        `;

                // Create blob and download
                const blob = new Blob([invoiceContent], {
                    type: 'text/html'
                });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = 'Invoice_{{ $booking->booking_code }}.html';
                link.click();
                URL.revokeObjectURL(link.href);
            }
        </script>
    @endpush
@endsection
