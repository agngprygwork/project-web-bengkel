@extends('layouts.app')

@section('title', 'Pembayaran Booking')
@section('page-title', 'Pembayaran Booking')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h3 class="text-white font-semibold">Detail Pembayaran</h3>
                <p class="text-blue-100 text-sm">Booking #{{ $booking->booking_code }}</p>
            </div>

            <div class="p-6">
                <!-- Booking Details -->
                <div class="border-b pb-4 mb-4">
                    <h4 class="font-semibold text-gray-800 mb-3">Detail Service</h4>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <p class="text-gray-500">Jenis Service</p>
                            <p class="font-medium">{{ $booking->jenisService->nama_service }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Tanggal Booking</p>
                            <p class="font-medium">{{ $booking->tanggal_booking->format('d M Y') }} -
                                {{ $booking->waktu_booking }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Keluhan</p>
                            <p class="font-medium">{{ Str::limit($booking->keluhan, 50) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Mekanik</p>
                            <p class="font-medium">{{ $booking->mekanik->user->name ?? 'Akan ditentukan' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Details -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-gray-600">Harga Service</span>
                        <span class="font-semibold">Rp
                            {{ number_format($booking->jenisService->harga, 0, ',', '.') }}</span>
                    </div>

                    @if ($booking->service && $booking->service->spareparts->count() > 0)
                        <div class="border-t pt-3 mb-3">
                            <p class="text-gray-600 mb-2">Sparepart yang digunakan:</p>
                            @foreach ($booking->service->spareparts as $sparepart)
                                <div class="flex justify-between text-sm ml-4">
                                    <span>{{ $sparepart->nama_sparepart }} (x{{ $sparepart->pivot->jumlah }})</span>
                                    <span>Rp {{ number_format($sparepart->pivot->subtotal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="border-t pt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-800">Total Pembayaran</span>
                            <span class="text-2xl font-bold text-blue-600">Rp
                                {{ number_format($booking->total_bayar, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Button -->
                <button id="pay-button"
                    class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition font-semibold">
                    Bayar Sekarang
                </button>
            </div>
        </div>
    </div>

    <!-- Midtrans Snap Script -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>

    <script>
        document.getElementById('pay-button').onclick = function() {
            fetch('{{ route('customer.payments.process', $booking) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        payment_type: 'bank_transfer'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                console.log('Payment Success:', result);

                                fetch('{{ route('customer.payments.callback', $booking) }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify(result)
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        console.log(data);

                                        window.location.href =
                                            '{{ route('customer.payments.show', $booking) }}';
                                    });
                            },
                            onPending: function(result) {
                                console.log('Payment Pending:', result);
                                // window.location.href =
                                //     '{{ route('customer.payments.show', $booking) }}';
                            },
                            onError: function(result) {
                                console.log('Payment Error:', result);
                                // alert('Pembayaran gagal! Silakan coba lagi.');
                                // console.log(result);
                            }
                        });
                    } else {
                        alert('Gagal memproses pembayaran: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
        };
    </script>
@endsection
