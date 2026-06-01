@extends('layouts.app')

@section('title', 'Dashboard Customer')
@section('page-title', 'Dashboard Customer')

@section('content')
    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Booking</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['total_bookings'] }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Booking Pending</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending_bookings'] }}</p>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Booking Selesai</p>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['completed_bookings'] }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Tagihan Pending</p>
                        <p class="text-2xl font-bold text-red-600">{{ $stats['pending_payments'] }}</p>
                    </div>
                    <div class="bg-red-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Bookings -->
        @if ($activeBookings->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Booking Aktif
                </h3>
                <div class="space-y-3">
                    @foreach ($activeBookings as $booking)
                        <div class="border rounded-lg p-4 hover:shadow transition">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold">{{ $booking->jenisService->nama_service }}</p>
                                    <p class="text-sm text-gray-600">{{ $booking->tanggal_booking->format('d M Y') }} -
                                        {{ $booking->waktu_booking }}</p>
                                    <p class="text-sm text-gray-500">Kode: {{ $booking->booking_code }}</p>
                                </div>
                                <div class="text-right">
                                    <span
                                        class="inline-block px-2 py-1 text-xs rounded-full 
                            @if ($booking->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($booking->status == 'dijadwalkan') bg-blue-100 text-blue-800
                            @elseif($booking->status == 'diproses') bg-purple-100 text-purple-800
                            @elseif($booking->status == 'menunggu_pembayaran') bg-orange-100 text-orange-800 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                    </span>
                                    <p class="text-sm mt-1 font-semibold text-green-600">Rp
                                        {{ number_format($booking->total_bayar, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @if ($booking->status_pembayaran == 'pending' && $booking->status != 'selesai')
                                <div class="mt-3">
                                    <a href="{{ route('customer.payments.create', $booking) }}"
                                        class="inline-block bg-green-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-600 transition">
                                        Bayar Sekarang
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Recent Bookings -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Riwayat Booking Terbaru</h3>
                <a href="{{ route('customer.bookings.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">Lihat
                    semua →</a>
            </div>

            @if ($recentBookings->isEmpty())
                <p class="text-gray-500 text-center py-8">Belum ada booking. Buat booking pertama Anda!</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pembayaran</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($recentBookings as $booking)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm">{{ $booking->booking_code }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $booking->jenisService->nama_service }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $booking->tanggal_booking->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4">
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
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full 
                                    @if ($booking->status_pembayaran == 'lunas') bg-green-100 text-green-800
                                    @elseif($booking->status_pembayaran == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($booking->status_pembayaran) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('customer.bookings.show', $booking) }}"
                                            class="text-blue-600 hover:text-blue-800">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
