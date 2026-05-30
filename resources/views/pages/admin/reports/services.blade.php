{{-- resources/views/admin/reports/services.blade.php --}}
@extends('layouts.app')

@section('title', 'Laporan Service')
@section('page-title', 'Laporan Service')

@section('content')
    <div class="space-y-6">
        <!-- Filter Form -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <form method="GET" action="{{ route('admin.reports.services') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Filter</button>
                    <a href="{{ route('admin.reports.services') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Reset</a>
                    <a href="{{ route('admin.reports.export', ['type' => 'services', 'date_from' => $dateFrom, 'date_to' => $dateTo, 'status' => request('status')]) }}"
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

        <!-- Popular Services Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h3 class="font-semibold">Detail Service Terpopuler</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis Service</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah Booking</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Pendapatan</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($popularServices as $service)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium">
                                    {{ $service->jenisService->nama_service ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-right">{{ number_format($service->total) }}</td>
                                <td class="px-6 py-4 text-sm text-right font-semibold text-green-600">
                                    Rp
                                    {{ number_format($service->total * ($service->jenisService->harga ?? 0), 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-right">
                                    {{ number_format(($service->total / $popularServices->sum('total')) * 100, 1) }}%
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mekanik Performance Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h3 class="font-semibold">Detail Performa Mekanik</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Mekanik</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Spesialis</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah Service</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Pendapatan
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Rata-rata per
                                Service</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($mekanikPerformance as $mekanik)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium">{{ $mekanik->mekanik->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm">{{ $mekanik->mekanik->spesialis ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-right">{{ number_format($mekanik->total) }}</td>
                                <td class="px-6 py-4 text-sm text-right font-semibold text-green-600">
                                    Rp {{ number_format($mekanik->revenue, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-right">
                                    Rp
                                    {{ number_format($mekanik->total > 0 ? $mekanik->revenue / $mekanik->total : 0, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sparepart Usage Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h3 class="font-semibold">Sparepart Paling Sering Digunakan</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Sparepart</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah Digunakan
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($sparepartUsage as $sparepart)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium">{{ $sparepart->nama_sparepart }}</td>
                                <td class="px-6 py-4 text-sm text-right">{{ number_format($sparepart->total_used) }} pcs
                                </td>
                                <td class="px-6 py-4 text-sm text-right font-semibold text-purple-600">
                                    Rp {{ number_format($sparepart->total_value, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Popular Services Chart
            const serviceCtx = document.getElementById('popularServicesChart').getContext('2d');
            const serviceData = @json($popularServices);

            new Chart(serviceCtx, {
                type: 'bar',
                data: {
                    labels: serviceData.map(item => item.jenisService?.nama_service || 'N/A'),
                    datasets: [{
                        label: 'Jumlah Booking',
                        data: serviceData.map(item => item.total),
                        backgroundColor: 'rgba(139, 92, 246, 0.8)',
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Mekanik Performance Chart
            const mekanikCtx = document.getElementById('mekanikPerformanceChart').getContext('2d');
            const mekanikData = @json($mekanikPerformance);

            new Chart(mekanikCtx, {
                type: 'bar',
                data: {
                    labels: mekanikData.map(item => item.mekanik?.user?.name || 'N/A'),
                    datasets: [{
                        label: 'Jumlah Service',
                        data: mekanikData.map(item => item.total),
                        backgroundColor: 'rgba(16, 185, 129, 0.8)',
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection
