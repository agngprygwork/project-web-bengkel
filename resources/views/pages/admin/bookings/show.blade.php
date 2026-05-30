{{-- resources/views/admin/bookings/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Booking')
@section('page-title', 'Detail Booking #' . $booking->booking_code)

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Status Update Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h3 class="text-white font-semibold">Update Status Booking</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST"
                    class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full border-gray-300 rounded-lg">
                            @foreach ($statuses as $value => $label)
                                <option value="{{ $value }}" {{ $booking->status == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Assign Mekanik</label>
                        <select name="mekanik_id" class="w-full border-gray-300 rounded-lg">
                            <option value="">Pilih Mekanik</option>
                            @foreach ($mekaniks as $mekanik)
                                <option value="{{ $mekanik->id }}"
                                    {{ $booking->mekanik_id == $mekanik->id ? 'selected' : '' }}>
                                    {{ $mekanik->user->name }} - {{ $mekanik->spesialis }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                        <textarea name="catatan" rows="1" class="w-full border-gray-300 rounded-lg" placeholder="Catatan internal...">{{ $booking->catatan }}</textarea>
                    </div>
                    <div class="md:col-span-3">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Update
                            Status</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Customer & Booking Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Customer Info -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                    <h3 class="text-white font-semibold">Informasi Customer</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div>
                        <label class="text-sm text-gray-500">Nama</label>
                        <p class="font-medium">{{ $booking->customer->user->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Email</label>
                        <p>{{ $booking->customer->user->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">No. HP</label>
                        <p>{{ $booking->customer->no_hp ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Alamat</label>
                        <p>{{ $booking->customer->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Booking Info -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                    <h3 class="text-white font-semibold">Informasi Booking</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div>
                        <label class="text-sm text-gray-500">Kode Booking</label>
                        <p class="font-mono">{{ $booking->booking_code }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Jenis Service</label>
                        <p>{{ $booking->jenisService->nama_service ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Tanggal & Waktu</label>
                        <p>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }} -
                            {{ $booking->waktu_booking }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Keluhan</label>
                        <p class="text-gray-700">{{ $booking->keluhan }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Catatan</label>
                        <p>{{ $booking->catatan ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment & Service Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Payment Info -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-yellow-600 to-yellow-700 px-6 py-4">
                    <h3 class="text-white font-semibold">Informasi Pembayaran</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div>
                        <label class="text-sm text-gray-500">Total Tagihan</label>
                        <p class="text-2xl font-bold text-green-600">Rp
                            {{ number_format($booking->total_bayar, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Status Pembayaran</label>
                        <p>
                            <span
                                class="px-2 py-1 text-xs rounded-full 
                            @if ($booking->status_pembayaran == 'lunas') bg-green-100 text-green-800
                            @elseif($booking->status_pembayaran == 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($booking->status_pembayaran) }}
                            </span>
                        </p>
                    </div>
                    @if ($booking->payment)
                        <div>
                            <label class="text-sm text-gray-500">Metode Pembayaran</label>
                            <p>{{ $booking->payment->payment_type_text ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Tanggal Bayar</label>
                            <p>{{ $booking->payment->settlement_time ? \Carbon\Carbon::parse($booking->payment->settlement_time)->format('d M Y H:i') : '-' }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Service Result -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <h3 class="text-white font-semibold">Hasil Service</h3>
                </div>
                <div class="p-6 space-y-3">
                    @if ($booking->service)
                        <div>
                            <label class="text-sm text-gray-500">Hasil Pemeriksaan</label>
                            <p>{{ $booking->service->hasil_pemeriksaan ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Tindakan Service</label>
                            <p>{{ $booking->service->tindakan_service ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Catatan Mekanik</label>
                            <p>{{ $booking->service->catatan_mekanik ?? '-' }}</p>
                        </div>
                        @if ($booking->service->spareparts->count() > 0)
                            <div>
                                <label class="text-sm text-gray-500">Sparepart Digunakan</label>
                                <div class="mt-1 space-y-1">
                                    @foreach ($booking->service->spareparts as $sparepart)
                                        <div class="text-sm">
                                            {{ $sparepart->nama_sparepart }} (x{{ $sparepart->pivot->jumlah }}) -
                                            Rp {{ number_format($sparepart->pivot->subtotal, 0, ',', '.') }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @else
                        <p class="text-gray-500">Service belum dilakukan</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between">
            <a href="{{ route('admin.bookings.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                Kembali
            </a>
            <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus booking ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                    Hapus Booking
                </button>
            </form>
        </div>
    </div>
@endsection
