{{-- resources/views/admin/bookings/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Booking')
@section('page-title', 'Manajemen Booking')

@section('content')
    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Total</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Pending</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Diproses</p>
                <p class="text-2xl font-bold text-purple-600">{{ $stats['in_progress'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Selesai</p>
                <p class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Lunas</p>
                <p class="text-2xl font-bold text-green-600">{{ $stats['paid'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Belum Bayar</p>
                <p class="text-2xl font-bold text-red-600">{{ $stats['unpaid'] }}</p>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <form method="GET" action="{{ route('admin.bookings.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Booking</label>
                    <select name="status" class="w-full border-gray-300 rounded-lg">
                        <option value="all">Semua</option>
                        @foreach ($statuses as $value => $label)
                            <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran</label>
                    <select name="payment_status" class="w-full border-gray-300 rounded-lg">
                        <option value="all">Semua</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="lunas" {{ request('payment_status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="gagal" {{ request('payment_status') == 'gagal' ? 'selected' : '' }}>Gagal</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tgl</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                        class="w-full border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tgl</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                        class="w-full border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode/Customer"
                        class="w-full border-gray-300 rounded-lg">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Filter</button>
                    <a href="{{ route('admin.bookings.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Reset</a>
                </div>
            </form>
        </div>

        <!-- Bookings Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mekanik</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pembayaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-mono">{{ $booking->booking_code }}</td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium">{{ $booking->customer->user->name ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->customer->no_hp ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm">{{ $booking->jenisService->nama_service ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm">{{ $booking->mekanik->user->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm font-semibold">Rp
                                    {{ number_format($booking->total_bayar, 0, ',', '.') }}</td>
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
                                    <a href="{{ route('admin.bookings.show', $booking) }}"
                                        class="text-blue-600 hover:text-blue-800">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                                    Tidak ada data booking
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
@endsection
