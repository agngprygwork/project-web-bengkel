{{-- resources/views/admin/reports/payments.blade.php --}}
@extends('layouts.app')

@section('title', 'Laporan Pembayaran')
@section('page-title', 'Laporan Pembayaran')

@section('content')
    <div class="space-y-6">
        <!-- Filter Form -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <form method="GET" action="{{ route('admin.reports.payments') }}" class="flex justify-between">
                <div class="flex space-x-10">
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
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Filter</button>
                    <a href="{{ route('admin.reports.payments') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Reset</a>
                    <a href="{{ route('admin.reports.export', ['type' => 'payments', 'date_from' => $dateFrom, 'date_to' => $dateTo, 'status' => request('status')]) }}"
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
                <p class="text-gray-500 text-sm">Total Transaksi</p>
                <p class="text-2xl font-bold">{{ $stats['total_transactions'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Total Pendapatan</p>
                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($stats['total_amount'], 0, ',', '.') }}
                </p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Rata-rata per Transaksi</p>
                <p class="text-2xl font-bold text-blue-600">
                    Rp
                    {{ number_format($stats['total_transactions'] > 0 ? $stats['total_amount'] / $stats['total_transactions'] : 0, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- Detail Transactions Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gray-50">
                <h3 class="font-semibold">Detail Transaksi</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Booking</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($payments as $payment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-mono">{{ $payment->booking_code }}</td>
                                <td class="px-6 py-4 text-sm">{{ $payment->customer->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-right font-semibold">Rp
                                    {{ number_format($payment->total_bayar, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 ">
                {{ $payments->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Payment Method Chart
            const methodCtx = document.getElementById('paymentMethodChart').getContext('2d');
            const methodData = @json($stats['by_payment_method']);

            new Chart(methodCtx, {
                type: 'doughnut',
                data: {
                    labels: methodData.map(item => ucfirst(item.metode_pembayaran?.replace('_', ' ') || 'Lainnya')),
                    datasets: [{
                        data: methodData.map(item => item.amount),
                        backgroundColor: ['#10b981', '#3b82f6', '#8b5cf6', '#f59e0b', '#ef4444'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Daily Revenue Chart
            const revenueCtx = document.getElementById('dailyRevenueChart').getContext('2d');
            const dailyData = @json($stats['daily']);

            new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: dailyData.map(item => item.date),
                    datasets: [{
                        label: 'Pendapatan',
                        data: dailyData.map(item => item.amount),
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    }
                }
            });

            function ucfirst(str) {
                if (!str) return '';
                return str.charAt(0).toUpperCase() + str.slice(1);
            }
        </script>
    @endpush
@endsection
