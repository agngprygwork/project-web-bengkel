{{-- resources/views/pages/customer/history/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Riwayat Service')
@section('page-title', 'Riwayat Service')

@section('content')
    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Total Riwayat</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Service Selesai</p>
                <p class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Dibatalkan/Ditolak</p>
                <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Total Belanja</p>
                <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Service Favorit</p>
                <p class="text-lg font-bold text-purple-600 truncate">
                    {{ $stats['most_frequent_service']?->jenisService?->nama_service ?? '-' }}
                </p>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <form method="GET" action="{{ route('customer.history.index') }}"
                class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Service</label>
                    <select name="status" class="w-full border-gray-300 rounded-lg">
                        <option value="all">Semua</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran</label>
                    <select name="payment_status" class="w-full border-gray-300 rounded-lg">
                        <option value="all">Semua</option>
                        <option value="lunas" {{ request('payment_status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="gagal" {{ request('payment_status') == 'gagal' ? 'selected' : '' }}>Gagal</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                        class="w-full border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                        class="w-full border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cari Kode</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode booking..."
                        class="w-full border-gray-300 rounded-lg">
                </div>
                <div class="flex items-end gap-2 md:col-span-5">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Filter</button>
                    <a href="{{ route('customer.history.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Reset</a>
                </div>
            </form>
        </div>

        <!-- History List -->
        <div class="space-y-4">
            @forelse($histories as $history)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <div class="p-5">
                        <div class="flex flex-wrap justify-between items-start gap-3 mb-3">
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-mono bg-gray-100 px-2 py-1 rounded">
                                    {{ $history->booking_code }}
                                </span>
                                <span
                                    class="px-2 py-1 text-xs rounded-full 
                            @if ($history->status == 'selesai') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                                    {{ $history->status == 'selesai' ? 'Selesai' : 'Ditolak' }}
                                </span>
                                <span
                                    class="px-2 py-1 text-xs rounded-full 
                            @if ($history->status_pembayaran == 'lunas') bg-green-100 text-green-800
                            @elseif($history->status_pembayaran == 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($history->status_pembayaran) }}
                                </span>
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($history->tanggal_booking)->format('d M Y') }}
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-500">Jenis Service</p>
                                <p class="font-semibold">{{ $history->jenisService->nama_service ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Mekanik</p>
                                <p class="font-semibold">{{ $history->mekanik->user->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Biaya</p>
                                <p class="text-xl font-bold text-green-600">Rp
                                    {{ number_format($history->total_bayar, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Tanggal Selesai</p>
                                <p class="font-semibold">{{ $history->updated_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-3 pt-3 border-t">
                            <a href="{{ route('customer.history.show', $history) }}"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                Lihat Detail
                            </a>
                            @if ($history->status == 'selesai')
                                <a href="{{ route('customer.history.invoice', $history) }}"
                                    class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                                    Download Invoice
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-600 mb-2">Belum Ada Riwayat Service</h3>
                    <p class="text-gray-500 mb-4">Anda belum memiliki riwayat service yang selesai</p>
                    <a href="{{ route('customer.bookings.create') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Booking Sekarang
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($histories->hasPages())
            <div class="mt-6">
                {{ $histories->links() }}
            </div>
        @endif
    </div>
@endsection
