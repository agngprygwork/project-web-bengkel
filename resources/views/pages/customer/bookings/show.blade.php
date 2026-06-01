{{-- resources/views/customer/bookings/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Booking')
@section('page-title', 'Detail Booking #' . $booking->booking_code)

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Status Timeline -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Status Progres Booking</h3>
            <div class="relative">
                <!-- Timeline line -->
                <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>

                <div class="space-y-6 relative">
                    <!-- Step 1: Booking Created -->
                    <div class="flex gap-4">
                        <div class="relative z-10">
                            <div
                                class="w-8 h-8 rounded-full flex items-center justify-center
                            {{ in_array($booking->status, ['pending', 'dijadwalkan', 'diproses', 'menunggu_pembayaran', 'selesai'])
                                ? 'bg-green-500 text-white'
                                : 'bg-gray-300 text-gray-500' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-800">Booking Dibuat</h4>
                            <p class="text-sm text-gray-500">{{ $booking->created_at->format('d M Y H:i') }}</p>
                            <p class="text-sm text-gray-600 mt-1">Booking telah berhasil dibuat dan menunggu konfirmasi</p>
                        </div>
                    </div>

                    <!-- Step 2: Confirmed/Scheduled -->
                    <div class="flex gap-4">
                        <div class="relative z-10">
                            <div
                                class="w-8 h-8 rounded-full flex items-center justify-center
                            {{ in_array($booking->status, ['dijadwalkan', 'diproses', 'menunggu_pembayaran', 'selesai'])
                                ? 'bg-green-500 text-white'
                                : 'bg-gray-300 text-gray-500' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-800">Booking Dijadwalkan</h4>
                            <p class="text-sm text-gray-500">
                                {{ $booking->status == 'dijadwalkan' ? $booking->updated_at->format('d M Y H:i') : '-' }}
                            </p>
                            <p class="text-sm text-gray-600 mt-1">
                                Booking telah dikonfirmasi dan dijadwalkan pada
                                {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }} pukul
                                {{ $booking->waktu_booking }}
                            </p>
                            @if ($booking->mekanik)
                                <p class="text-sm text-blue-600 mt-1">Mekanik: {{ $booking->mekanik->user->name }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Step 3: In Progress -->
                    <div class="flex gap-4">
                        <div class="relative z-10">
                            <div
                                class="w-8 h-8 rounded-full flex items-center justify-center
                            {{ in_array($booking->status, ['diproses', 'menunggu_pembayaran', 'selesai'])
                                ? 'bg-green-500 text-white'
                                : 'bg-gray-300 text-gray-500' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-800">Service Diproses</h4>
                            <p class="text-sm text-gray-500">
                                {{ $booking->status == 'diproses' ? $booking->updated_at->format('d M Y H:i') : '-' }}
                            </p>
                            <p class="text-sm text-gray-600 mt-1">Service sedang dikerjakan oleh mekanik</p>
                        </div>
                    </div>

                    <!-- Step 4: Payment -->
                    <div class="flex gap-4">
                        <div class="relative z-10">
                            <div
                                class="w-8 h-8 rounded-full flex items-center justify-center
                            {{ in_array($booking->status, ['menunggu_pembayaran', 'selesai'])
                                ? 'bg-green-500 text-white'
                                : 'bg-gray-300 text-gray-500' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-800">Pembayaran</h4>
                            <p class="text-sm text-gray-500">
                                @if ($booking->tanggal_pembayaran)
                                    {{ \Carbon\Carbon::parse($booking->tanggal_pembayaran)->format('d M Y H:i') }}
                                @else
                                    Belum dibayar
                                @endif
                            </p>
                            <p class="text-sm text-gray-600 mt-1">
                                Status Pembayaran:
                                <span
                                    class="px-2 py-0.5 rounded-full text-xs
                                @if ($booking->status_pembayaran == 'lunas') bg-green-100 text-green-700
                                @elseif($booking->status_pembayaran == 'pending') bg-yellow-100 text-yellow-700
                                @else bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($booking->status_pembayaran) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Step 5: Completed -->
                    <div class="flex gap-4">
                        <div class="relative z-10">
                            <div
                                class="w-8 h-8 rounded-full flex items-center justify-center
                            {{ $booking->status == 'selesai' ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-500' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-800">Service Selesai</h4>
                            <p class="text-sm text-gray-500">
                                {{ $booking->status == 'selesai' ? $booking->updated_at->format('d M Y H:i') : '-' }}
                            </p>
                            <p class="text-sm text-gray-600 mt-1">Service telah selesai dilakukan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Details -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h3 class="text-white font-semibold">Detail Booking</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Kode Booking</label>
                        <p class="text-gray-900 font-mono">{{ $booking->booking_code }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Dibuat</label>
                        <p class="text-gray-900">{{ $booking->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Jenis Service</label>
                        <p class="text-gray-900 font-semibold">{{ $booking->jenisService->nama_service }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $booking->jenisService->deskripsi }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Estimasi Waktu</label>
                        <p class="text-gray-900">{{ $booking->jenisService->estimasi_waktu }} menit</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal & Waktu Service</label>
                        <p class="text-gray-900">{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }} -
                            {{ $booking->waktu_booking }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Mekanik</label>
                        <p class="text-gray-900">{{ $booking->mekanik->user->name ?? 'Akan ditentukan' }}</p>
                        @if ($booking->mekanik)
                            <p class="text-sm text-gray-600">Spesialis: {{ $booking->mekanik->spesialis }}</p>
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Keluhan</label>
                        <p class="text-gray-900">{{ $booking->keluhan }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Catatan</label>
                        <p class="text-gray-900">{{ $booking->catatan ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service Result (if completed) -->
        @if ($booking->service && $booking->status == 'selesai')
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                    <h3 class="text-white font-semibold">Hasil Service</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Hasil Pemeriksaan</label>
                        <p class="text-gray-900">{{ $booking->service->hasil_pemeriksaan }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Tindakan Service</label>
                        <p class="text-gray-900">{{ $booking->service->tindakan_service }}</p>
                    </div>
                    @if ($booking->service->spareparts->count() > 0)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Sparepart Yang Digunakan</label>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Sparepart
                                            </th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Jumlah</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Harga</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($booking->service->spareparts as $sparepart)
                                            <tr>
                                                <td class="px-4 py-2 text-sm">{{ $sparepart->nama_sparepart }}</td>
                                                <td class="px-4 py-2 text-sm">{{ $sparepart->pivot->jumlah }}</td>
                                                <td class="px-4 py-2 text-sm">Rp
                                                    {{ number_format($sparepart->harga_jual, 0, ',', '.') }}</td>
                                                <td class="px-4 py-2 text-sm">Rp
                                                    {{ number_format($sparepart->pivot->subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    @if ($booking->service->catatan_mekanik)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Catatan Mekanik</label>
                            <p class="text-gray-900">{{ $booking->service->catatan_mekanik }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Payment Summary -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                <h3 class="text-white font-semibold">Ringkasan Pembayaran </h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div class="flex justify-between items-center pb-2 border-b">
                        <span class="text-gray-600">Harga Service</span>
                        <span class="font-semibold">Rp
                            {{ number_format($booking->jenisService->harga, 0, ',', '.') }}</span>
                    </div>

                    @if ($booking->service && $booking->service->spareparts->count() > 0)
                        <div class="flex justify-between items-center pb-2 border-b">
                            <span class="text-gray-600">Biaya Sparepart</span>
                            <span class="font-semibold">Rp
                                {{ number_format($booking->service->calculateTotalSpareparts(), 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between items-center pt-2">
                        <span class="text-lg font-bold text-gray-800">Total Pembayaran</span>
                        <span class="text-2xl font-bold text-blue-600">Rp
                            {{ number_format($booking->total_bayar, 0, ',', '.') }}</span>
                    </div>

                    @if ($booking->status == 'menunggu_pembayaran' && $booking->status != 'selesai' && $booking->status != 'ditolak')
                        <div class="mt-4 pt-4 border-t">
                            <a href="{{ route('customer.payments.create', $booking) }}"
                                class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition text-center block font-semibold">
                                Bayar Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between gap-4">
            <a href="{{ route('customer.bookings.index') }}"
                class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition text-center">
                Kembali ke Daftar
            </a>

            @if ($booking->status == 'pending')
                <form action="{{ route('customer.bookings.cancel', $booking) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                    @csrf
                    <button type="submit" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                        Batalkan Booking
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection
