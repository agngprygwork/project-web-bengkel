{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Admin ')
@section('page-title', 'Admin ')

@section('content')
    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Pendapatan -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-green-600">
                            Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">Bulan ini</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Customers -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Customers</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $totalCustomers ?? 0 }}</p>
                        <p class="text-xs text-green-500 mt-1">
                            +{{ $newCustomersThisMonth ?? 0 }} bulan ini
                        </p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Mekaniks -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Mekaniks</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $totalMekaniks ?? 0 }}</p>
                        <p class="text-xs text-gray-400 mt-1">Tersedia: {{ $availableMekaniks ?? 0 }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Bookings -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Bookings</p>
                        <p class="text-2xl font-bold text-orange-600">{{ $totalBookings ?? 0 }}</p>
                        <p class="text-xs text-yellow-500 mt-1">
                            Pending: {{ $pendingBookings ?? 0 }}
                        </p>
                    </div>
                    <div class="bg-orange-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Booking Statistics Chart -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Statistik Booking</h3>
                    <select id="chartPeriod" class="text-sm border-gray-300 rounded-lg">
                        <option value="weekly">Minggu Ini</option>
                        <option value="monthly">Bulan Ini</option>
                        <option value="yearly">Tahun Ini</option>
                    </select>
                </div>
                <canvas id="bookingChart" height="250"></canvas>
            </div>

            <!-- Payment Statistics Chart -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Statistik Pembayaran</h3>
                <canvas id="paymentChart" height="250"></canvas>
            </div>
        </div>

        <!-- Recent Bookings & Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Bookings -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-white font-semibold">Booking Terbaru</h3>
                        <a href="{{ route('admin.bookings.index') }}" class="text-white/80 hover:text-white text-sm">
                            Lihat semua →
                        </a>
                    </div>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($recentBookings ?? [] as $booking)
                        <div class="p-4 hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-xs font-mono bg-gray-100 px-2 py-1 rounded">
                                            {{ $booking->booking_code }}
                                        </span>
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
                                    </div>
                                    <p class="font-medium text-gray-800">{{ $booking->customer->user->name ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-500">{{ $booking->jenisService->nama_service ?? 'N/A' }}
                                    </p>
                                    <div class="flex items-center gap-4 mt-1 text-xs text-gray-400">
                                        <span>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</span>
                                        <span>Rp {{ number_format($booking->total_bayar, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <a href="{{ route('admin.bookings.show', $booking) }}"
                                        class="text-blue-600 hover:text-blue-800 text-sm">Detail</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            Belum ada booking
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Actions & Stats -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.users.create') }}"
                            class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="bg-blue-100 rounded-lg p-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Tambah Customer Baru</p>
                                <p class="text-xs text-gray-500">Registrasi customer baru</p>
                            </div>
                        </a>
                        <a href="{{ route('admin.mekaniks.create') }}"
                            class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="bg-green-100 rounded-lg p-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Tambah Mekanik</p>
                                <p class="text-xs text-gray-500">Registrasi mekanik baru</p>
                            </div>
                        </a>
                        <a href="{{ route('admin.jenis-services.create') }}"
                            class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="bg-purple-100 rounded-lg p-2">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Tambah Jenis Service</p>
                                <p class="text-xs text-gray-500">Tambah layanan service baru</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Pending Bookings Alert -->
                @if (($pendingBookings ?? 0) > 0)
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Terdapat <strong>{{ $pendingBookings }}</strong> booking pending yang perlu
                                    dikonfirmasi.
                                </p>
                                <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}"
                                    class="text-sm text-yellow-700 font-medium hover:underline">
                                    Konfirmasi sekarang →
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Low Stock Alert -->
                @if (($lowStockSpareparts ?? 0) > 0)
                    <div class="bg-red-50 border-l-4 border-red-400 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 12H4M12 4v16"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    Terdapat <strong>{{ $lowStockSpareparts }}</strong> sparepart dengan stok menipis.
                                </p>
                                <a href="{{ route('admin.spareparts.index', ['low_stock' => 1]) }}"
                                    class="text-sm text-red-700 font-medium hover:underline">
                                    Lihat dan restock →
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Customers & Mekaniks -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Recent Customers -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-white font-semibold">Customer Baru</h3>
                        <a href="{{ route('admin.users.index') }}" class="text-white/80 hover:text-white text-sm">
                            Lihat semua →
                        </a>
                    </div>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($recentCustomers ?? [] as $customer)
                        <div class="p-4 hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $customer->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $customer->user->email }}</p>
                                    <p class="text-xs text-gray-400">{{ $customer->no_hp }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-400">
                                        Bergabung: {{ \Carbon\Carbon::parse($customer->created_at)->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            Belum ada customer
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Mekaniks -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-white font-semibold">Mekanik Baru</h3>
                        <a href="{{ route('admin.mekaniks.index') }}" class="text-white/80 hover:text-white text-sm">
                            Lihat semua →
                        </a>
                    </div>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($recentMekaniks ?? [] as $mekanik)
                        <div class="p-4 hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $mekanik->user->name }}</p>
                                    <p class="text-sm text-gray-500">Spesialis: {{ $mekanik->spesialis }}</p>
                                    <p class="text-xs text-gray-400">Pengalaman: {{ $mekanik->pengalaman_tahun }} tahun
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-400">
                                        Bergabung: {{ \Carbon\Carbon::parse($mekanik->created_at)->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            Belum ada mekanik
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Booking Chart
            const bookingCtx = document.getElementById('bookingChart').getContext('2d');
            const bookingChart = new Chart(bookingCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels ?? []) !!},
                    datasets: [{
                        label: 'Total Booking',
                        data: {!! json_encode($bookingChartData ?? []) !!},
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });

            // Payment Chart
            const paymentCtx = document.getElementById('paymentChart').getContext('2d');
            const paymentChart = new Chart(paymentCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Lunas', 'Pending', 'Gagal'],
                    datasets: [{
                        data: {{ json_encode([$paymentStats['lunas'] ?? 0, $paymentStats['pending'] ?? 0, $paymentStats['gagal'] ?? 0]) }},
                        backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
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

            // Chart period change
            document.getElementById('chartPeriod').addEventListener('change', function() {
                // Implement AJAX call to update chart based on period
                const period = this.value;
                fetch(`/admin/chart-data?period=${period}`)
                    .then(response => response.json())
                    .then(data => {
                        bookingChart.data.labels = data.labels;
                        bookingChart.data.datasets[0].data = data.bookings;
                        bookingChart.update();
                    });
            });
        </script>
    @endpush
@endsection
