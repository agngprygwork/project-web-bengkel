{{-- resources/views/admin/reports/bookings.blade.php --}}
@extends('layouts.app')

@section('title', 'Laporan Booking')
@section('page-title', 'Laporan Booking')

@section('content')
    <div class="space-y-6">
        <!-- Filter Form -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <form method="GET" action="{{ route('admin.reports.bookings') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ $dateFrom }}"
                        class="w-full border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="{{ $dateTo }}"
                        class="w-full border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded-lg">
                        <option value="all">Semua</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="dijadwalkan" {{ request('status') == 'dijadwalkan' ? 'selected' : '' }}>Dijadwalkan
                        </option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Filter</button>
                    <a href="{{ route('admin.reports.bookings') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Reset</a>
                    <a href="{{ route('admin.reports.export', ['type' => 'bookings', 'date_from' => $dateFrom, 'date_to' => $dateTo, 'status' => request('status')]) }}"
                        class="bg-green-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-green-700 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Export PDF
                    </a>
                </div>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Total Booking</p>
                <p class="text-2xl font-bold">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Total Pendapatan</p>
                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                </p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Pending Payment</p>
                <p class="text-2xl font-bold text-yellow-600">Rp
                    {{ number_format($stats['pending_payment'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Rata-rata per Booking</p>
                <p class="text-2xl font-bold text-blue-600">
                    Rp
                    {{ number_format($stats['total'] > 0 ? $stats['total_revenue'] / $stats['total'] : 0, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- Bookings Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 ">
                <h3 class="font-semibold">Detail Booking</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Booking</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($bookings as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm">
                                    {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm font-mono">{{ $booking->booking_code }}</td>
                                <td class="px-6 py-4 text-sm">{{ $booking->customer->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm">{{ $booking->jenisService->nama_service ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-right font-semibold">Rp
                                    {{ number_format($booking->total_bayar, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full 
                                @if ($booking->status == 'selesai') bg-green-100 text-green-800
                                @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                @else bg-blue-100 text-blue-800 @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 ">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('bookingChart').getContext('2d');
            const chartData = @json($stats['by_day']);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.map(item => item.date),
                    datasets: [{
                        label: 'Jumlah Booking',
                        data: chartData.map(item => item.total),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true
                }
            });
        </script>
    @endpush
@endsection
