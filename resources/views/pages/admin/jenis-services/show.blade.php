{{-- resources/views/admin/jenis-services/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Jenis Service')
@section('page-title', 'Detail Service: ' . $jenisService->nama_service)

@section('content')
    <div class="space-y-6">
        <!-- Service Info Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h3 class="text-white font-semibold">Informasi Service</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-500">Nama Service</label>
                        <p class="font-semibold text-lg">{{ $jenisService->nama_service }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Status</label>
                        <p>
                            <span
                                class="px-2 py-1 text-xs rounded-full {{ $jenisService->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $jenisService->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Harga</label>
                        <p class="text-2xl font-bold text-green-600">Rp
                            {{ number_format($jenisService->harga, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Estimasi Waktu</label>
                        <p>{{ $jenisService->estimasi_waktu }} menit</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm text-gray-500">Deskripsi</label>
                        <p>{{ $jenisService->deskripsi ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Total Booking</p>
                <p class="text-2xl font-bold">{{ $bookingStats['total'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Selesai</p>
                <p class="text-2xl font-bold text-green-600">{{ $bookingStats['completed'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Pending</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $bookingStats['pending'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Total Pendapatan</p>
                <p class="text-2xl font-bold text-purple-600">Rp
                    {{ number_format($bookingStats['total_revenue'], 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h3 class="font-semibold">Booking Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Booking</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($recentBookings as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-mono">{{ $booking->booking_code }}</td>
                                <td class="px-6 py-4 text-sm">{{ $booking->customer->user->name }}</td>
                                <td class="px-6 py-4 text-sm">{{ $booking->created_at->format('d/m/Y') }}</td>
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
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between gap-4">
            <a href="{{ route('admin.jenis-services.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                Kembali
            </a>
            <div class="flex gap-2">
                <a href="{{ route('admin.jenis-services.edit', $jenisService) }}"
                    class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">
                    Edit Service
                </a>
                <form action="{{ route('admin.jenis-services.destroy', $jenisService) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus service ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700"
                        {{ $bookingStats['total'] > 0 ? 'disabled' : '' }}>
                        Hapus Service
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            @if ($monthlyTrend->count() > 0)
                const ctx = document.getElementById('monthlyTrendChart').getContext('2d');
                const trendData = @json($monthlyTrend);

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: trendData.map(item => item.month),
                        datasets: [{
                            label: 'Jumlah Booking',
                            data: trendData.map(item => item.total),
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
            @endif
        </script>
    @endpush
@endsection
