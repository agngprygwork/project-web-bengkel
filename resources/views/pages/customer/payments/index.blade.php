{{-- resources/views/customer/payments/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Pembayaran')
@section('page-title', 'Daftar Pembayaran')

@section('content')
    <div class="space-y-6">
        <!-- Header Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Tagihan -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Tagihan</p>
                        <p class="text-2xl font-bold text-gray-800">
                            Rp {{ number_format($pendingPayments->sum('total_bayar'), 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Tagihan Pending -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Tagihan Pending</p>
                        <p class="text-2xl font-bold text-orange-600">{{ $pendingPayments->count() }}</p>
                    </div>
                    <div class="bg-orange-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Riwayat Pembayaran -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Riwayat Pembayaran</p>
                        <p class="text-2xl font-bold text-green-600">{{ $paymentHistory->total() }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="flex flex-wrap gap-2">
                <button onclick="filterPayments('all')"
                    class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-blue-600 text-white"
                    data-filter="all">
                    Semua
                </button>
                <button onclick="filterPayments('pending')"
                    class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300"
                    data-filter="pending">
                    Pending
                </button>
                <button onclick="filterPayments('lunas')"
                    class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300"
                    data-filter="lunas">
                    Lunas
                </button>
                <button onclick="filterPayments('gagal')"
                    class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300"
                    data-filter="gagal">
                    Gagal
                </button>
            </div>
        </div>

        <!-- Pending Payments Section -->
        @if ($pendingPayments->count() > 0)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-yellow-500 to-orange-500 px-6 py-4">
                    <h3 class="text-white font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Tagihan Menunggu Pembayaran
                    </h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach ($pendingPayments as $booking)
                        <div class="payment-item p-6 hover:bg-gray-50 transition"
                            data-status="{{ $booking->status_pembayaran }}">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <!-- Left Side - Info -->
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="text-xs font-mono bg-gray-100 px-2 py-1 rounded">
                                            {{ $booking->booking_code }}
                                        </span>
                                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                    <h4 class="font-semibold text-gray-800 mb-1">
                                        {{ $booking->jenisService->nama_service }}
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-gray-600">
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                            <span>{{ $booking->mekanik->user->name ?? 'Belum ditentukan' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Side - Amount & Action -->
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-blue-600">
                                        Rp {{ number_format($booking->total_bayar, 0, ',', '.') }}
                                    </p>
                                    <a href="{{ route('customer.payments.create', $booking) }}"
                                        class="inline-block mt-2 bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition text-sm font-semibold">
                                        Bayar Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Payment History Section -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                <h3 class="text-white font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    Riwayat Pembayaran
                </h3>
            </div>

            @if ($paymentHistory->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kode Booking
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jenis Service
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal Booking
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Metode
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($paymentHistory as $booking)
                                <tr class="payment-item hover:bg-gray-50 transition"
                                    data-status="{{ $booking->status_pembayaran }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-mono text-gray-900">{{ $booking->booking_code }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $booking->jenisService->nama_service }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">
                                            Rp {{ number_format($booking->total_bayar, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if ($booking->status_pembayaran == 'lunas') bg-green-100 text-green-800
                                @elseif($booking->status_pembayaran == 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($booking->status_pembayaran) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($booking->payment && $booking->payment->payment_type)
                                            <div class="flex items-center gap-1 text-sm text-gray-600">
                                                @if ($booking->payment->payment_type == 'bank_transfer')
                                                    <svg class="w-4 h-4 text-blue-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                                        </path>
                                                    </svg>
                                                @elseif($booking->payment->payment_type == 'qris')
                                                    <svg class="w-4 h-4 text-green-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                                                        </path>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 text-purple-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                @endif
                                                <span>{{ $booking->payment->payment_type_text }}</span>
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex gap-2">
                                            <a href="{{ route('customer.payments.show', $booking) }}"
                                                class="text-blue-600 hover:text-blue-800 transition">
                                                Detail
                                            </a>
                                            <a href="{{ route('customer.bookings.show', $booking) }}"
                                                class="text-gray-600 hover:text-gray-800 transition">
                                                Booking
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $paymentHistory->links() }}
                </div>
            @else
                <div class="p-12 text-center">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-600 mb-2">Belum Ada Riwayat Pembayaran</h3>
                    <p class="text-gray-500 mb-4">Anda belum melakukan pembayaran apapun</p>
                    @if ($pendingPayments->count() > 0)
                        <a href="{{ route('customer.payments.create', $pendingPayments->first()) }}"
                            class="inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                            Lakukan Pembayaran
                        </a>
                    @else
                        <a href="{{ route('customer.bookings.create') }}"
                            class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                            Buat Booking
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            function filterPayments(status) {
                const payments = document.querySelectorAll('.payment-item');
                const buttons = document.querySelectorAll('.filter-btn');

                // Update button active state
                buttons.forEach(btn => {
                    if (btn.getAttribute('data-filter') === status) {
                        btn.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
                        btn.classList.add('bg-blue-600', 'text-white');
                    } else {
                        btn.classList.remove('bg-blue-600', 'text-white');
                        btn.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
                    }
                });

                // Filter payments
                if (status === 'all') {
                    payments.forEach(payment => {
                        payment.style.display = '';
                    });
                } else {
                    payments.forEach(payment => {
                        const paymentStatus = payment.getAttribute('data-status');
                        if (paymentStatus === status) {
                            payment.style.display = '';
                        } else {
                            payment.style.display = 'none';
                        }
                    });
                }
            }
        </script>
    @endpush
@endsection
