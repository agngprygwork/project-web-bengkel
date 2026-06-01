@extends('layouts.app')

@section('title', 'Daftar Booking')
@section('page-title', 'Daftar Booking Saya')

@section('content')
    <div class="space-y-6">
        <!-- Header with Create Button -->
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-600">Kelola semua booking service motor Anda</p>
            </div>
            <a href="{{ route('customer.bookings.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Booking Baru
            </a>
        </div>

        <!-- Filter Tabs -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="flex flex-wrap gap-2">
                <button onclick="filterBookings('all')"
                    class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-blue-600 text-white"
                    data-filter="all">
                    Semua
                </button>
                <button onclick="filterBookings('pending')"
                    class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300"
                    data-filter="pending">
                    Pending
                </button>
                <button onclick="filterBookings('dijadwalkan')"
                    class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300"
                    data-filter="dijadwalkan">
                    Dijadwalkan
                </button>
                <button onclick="filterBookings('diproses')"
                    class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300"
                    data-filter="diproses">
                    Diproses
                </button>
                <button onclick="filterBookings('menunggu_pembayaran')"
                    class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300"
                    data-filter="menunggu_pembayaran">
                    Menunggu Pembayaran
                </button>
                <button onclick="filterBookings('selesai')"
                    class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300"
                    data-filter="selesai">
                    Selesai
                </button>
                <button onclick="filterBookings('ditolak')"
                    class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300"
                    data-filter="ditolak">
                    Ditolak
                </button>
            </div>
        </div>

        <!-- Bookings List -->
        <div class="space-y-4" id="bookingsContainer">
            @forelse($bookings as $booking)
                <div class="booking-item bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-all duration-300"
                    data-status="{{ $booking->status }}">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <!-- Left Side - Booking Info -->
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-xs font-mono bg-gray-100 px-2 py-1 rounded">
                                        {{ $booking->booking_code }}
                                    </span>
                                    <span
                                        class="px-2 py-1 text-xs rounded-full 
                                @if ($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking->status == 'dijadwalkan') bg-blue-100 text-blue-800
                                @elseif($booking->status == 'diproses') bg-purple-100 text-purple-800
                                @elseif($booking->status == 'menunggu_pembayaran') bg-orange-100 text-orange-800
                                @elseif($booking->status == 'selesai') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                    </span>
                                </div>

                                <h3 class="text-lg font-semibold text-gray-800 mb-2">
                                    {{ $booking->jenisService->nama_service }}
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }} -
                                            {{ $booking->waktu_booking }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        <span>Mekanik: {{ $booking->mekanik->user->name ?? 'Belum ditentukan' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                        <span>Total: Rp {{ number_format($booking->total_bayar, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                            </path>
                                        </svg>
                                        <span
                                            class="px-2 py-0.5 rounded-full text-xs 
                                    @if ($booking->status_pembayaran == 'lunas') bg-green-100 text-green-700
                                    @elseif($booking->status_pembayaran == 'pending') bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700 @endif">
                                            {{ ucfirst($booking->status_pembayaran) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Side - Actions -->
                            <div class="flex flex-col sm:flex-row gap-2">
                                <a href="{{ route('customer.bookings.show', $booking) }}"
                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-center">
                                    Detail
                                </a>

                                @if ($booking->status == 'pending')
                                    <form action="{{ route('customer.bookings.cancel', $booking) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                                        @csrf
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition w-full">
                                            Batalkan
                                        </button>
                                    </form>
                                @endif

                                @if ($booking->status_pembayaran == 'pending' && $booking->status != 'selesai' && $booking->status != 'ditolak')
                                    <a href="{{ route('customer.payments.create', $booking) }}"
                                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition text-center">
                                        Bayar Sekarang
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-600 mb-2">Belum Ada Booking</h3>
                    <p class="text-gray-500 mb-4">Anda belum membuat booking service apapun</p>
                    <a href="{{ route('customer.bookings.create') }}"
                        class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                        Buat Booking Pertama
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($bookings->hasPages())
            <div class="mt-6">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            function filterBookings(status) {
                const bookings = document.querySelectorAll('.booking-item');
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

                // Filter bookings
                if (status === 'all') {
                    bookings.forEach(booking => {
                        booking.style.display = '';
                    });
                } else {
                    bookings.forEach(booking => {
                        const bookingStatus = booking.getAttribute('data-status');
                        if (bookingStatus === status) {
                            booking.style.display = '';
                        } else {
                            booking.style.display = 'none';
                        }
                    });
                }
            }
        </script>
    @endpush
@endsection
