{{-- resources/views/pages/customer/history/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Riwayat Service')
@section('page-title', 'Detail Service #' . $booking->booking_code)

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Status Header -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div
                class="px-6 py-4 {{ $booking->status == 'selesai' ? 'bg-gradient-to-r from-green-600 to-green-700' : 'bg-gradient-to-r from-red-600 to-red-700' }}">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-white font-semibold text-lg">
                            {{ $booking->status == 'selesai' ? 'Service Selesai' : 'Service Ditolak' }}
                        </h3>
                        <p class="text-white/80 text-sm">Kode Booking: {{ $booking->booking_code }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-white text-sm">Tanggal Selesai</p>
                        <p class="text-white font-semibold">{{ $booking->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h3 class="text-white font-semibold">Informasi Service</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div>
                        <label class="text-sm text-gray-500">Jenis Service</label>
                        <p class="font-semibold">{{ $booking->jenisService->nama_service }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Tanggal Booking</label>
                        <p>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }} -
                            {{ $booking->waktu_booking }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Keluhan</label>
                        <p class="text-gray-700">{{ $booking->keluhan }}</p>
                    </div>
                    @if ($booking->catatan)
                        <div>
                            <label class="text-sm text-gray-500">Catatan Customer</label>
                            <p class="text-gray-700">{{ $booking->catatan }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                    <h3 class="text-white font-semibold">Informasi Mekanik</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div>
                        <label class="text-sm text-gray-500">Nama Mekanik</label>
                        <p class="font-semibold">{{ $booking->mekanik->user->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Spesialisasi</label>
                        <p>{{ $booking->mekanik->spesialis ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Pengalaman</label>
                        <p>{{ $booking->mekanik->pengalaman_tahun ?? 0 }} tahun</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hasil Pemeriksaan & Tindakan -->
        @if ($booking->hasil_pemeriksaan || $booking->tindakan_service)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if ($booking->hasil_pemeriksaan)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="bg-gradient-to-r from-yellow-600 to-yellow-700 px-6 py-4">
                            <h3 class="text-white font-semibold">Hasil Pemeriksaan</h3>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-700">{{ $booking->hasil_pemeriksaan }}</p>
                        </div>
                    </div>
                @endif

                @if ($booking->tindakan_service)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-600 to-orange-700 px-6 py-4">
                            <h3 class="text-white font-semibold">Tindakan Service</h3>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-700">{{ $booking->tindakan_service }}</p>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <!-- Sparepart Used -->
        @if ($usedSpareparts->count() > 0)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <h3 class="text-white font-semibold">Sparepart yang Digunakan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Sparepart
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Harga</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($usedSpareparts as $sparepart)
                                <tr>
                                    <td class="px-6 py-4 text-sm">{{ $sparepart->nama_sparepart }}
                                        ({{ $sparepart->satuan }})</td>
                                    <td class="px-6 py-4 text-sm text-right">{{ number_format($sparepart->quantity) }}</td>
                                    <td class="px-6 py-4 text-sm text-right">Rp
                                        {{ number_format($sparepart->price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-sm text-right font-semibold">Rp
                                        {{ number_format($sparepart->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right font-bold">Total Sparepart</td>
                                <td class="px-6 py-4 text-right font-bold text-blue-600">
                                    Rp {{ number_format($usedSpareparts->sum('subtotal'), 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        @endif

        <!-- Payment Summary -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h3 class="text-white font-semibold">Ringkasan Pembayaran</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">Harga Service</span>
                        <span class="font-semibold">Rp
                            {{ number_format($booking->jenisService->harga, 0, ',', '.') }}</span>
                    </div>
                    @if ($usedSpareparts->sum('subtotal') > 0)
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Biaya Sparepart</span>
                            <span class="font-semibold">Rp
                                {{ number_format($usedSpareparts->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between pt-2">
                        <span class="text-lg font-bold text-gray-800">Total Dibayar</span>
                        <span class="text-2xl font-bold text-green-600">Rp
                            {{ number_format($booking->total_bayar, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between pt-2">
                        <span class="text-gray-600">Status Pembayaran</span>
                        <span
                            class="px-2 py-1 text-xs rounded-full 
                        @if ($booking->status_pembayaran == 'lunas') bg-green-100 text-green-800
                        @elseif($booking->status_pembayaran == 'pending') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($booking->status_pembayaran) }}
                        </span>
                    </div>
                    @if ($booking->tanggal_pembayaran)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal Pembayaran</span>
                            <span>{{ \Carbon\Carbon::parse($booking->tanggal_pembayaran)->format('d M Y H:i') }}</span>
                        </div>
                    @endif
                    @if ($booking->payment && $booking->payment->payment_type)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Metode Pembayaran</span>
                            <span>{{ ucfirst(str_replace('_', ' ', $booking->payment->payment_type)) }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between gap-4">
            <a href="{{ route('customer.history.index') }}"
                class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                Kembali
            </a>
            @if ($booking->status == 'selesai')
                <a href="{{ route('customer.history.invoice', $booking) }}"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Download Invoice
                </a>
            @endif
        </div>
    </div>
@endsection
