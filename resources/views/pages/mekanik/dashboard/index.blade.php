{{-- resources/views/pages/mekanik/dashboard/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Mekanik')
@section('page-title', 'Dashboard Mekanik')

@section('content')
    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
            <!-- Total Tugas -->
            <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Tugas</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['total_tasks'] }}</p>
                    </div>
                    <div class="bg-gray-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Service Hari Ini -->
            <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Service Hari Ini</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $stats['today_services'] }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Dijadwalkan -->
            <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Dijadwalkan</p>
                        <p class="text-2xl font-bold text-indigo-600">{{ $stats['scheduled'] }}</p>
                    </div>
                    <div class="bg-indigo-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Sedang Diproses -->
            <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Sedang Diproses</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $stats['in_progress'] }}</p>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Menunggu Pembayaran -->
            <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Menunggu Pembayaran</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $stats['waiting_payment'] }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Service Selesai -->
            <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Service Selesai</p>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Ring/Circle (Opsional) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Progres Penyelesaian Tugas</h3>
                <div class="flex items-center justify-center">
                    <div class="relative w-48 h-48">
                        <svg class="w-full h-full" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="45" fill="none" stroke="#e5e7eb" stroke-width="8" />
                            <circle cx="50" cy="50" r="45" fill="none" stroke="#10b981" stroke-width="8"
                                stroke-dasharray="283"
                                stroke-dashoffset="{{ 283 - 283 * ($stats['completed'] / max($stats['total_tasks'], 1)) }}"
                                stroke-linecap="round" transform="rotate(-90 50 50)" />
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <p class="text-3xl font-bold text-green-600">
                                    {{ $stats['total_tasks'] > 0 ? round(($stats['completed'] / $stats['total_tasks']) * 100) : 0 }}%
                                </p>
                                <p class="text-xs text-gray-500">Terselesaikan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Ringkasan Status</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Selesai</span>
                        <div class="flex items-center gap-2">
                            <div class="w-32 bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full"
                                    style="width: {{ $stats['total_tasks'] > 0 ? ($stats['completed'] / $stats['total_tasks']) * 100 : 0 }}%">
                                </div>
                            </div>
                            <span class="text-sm font-semibold">{{ $stats['completed'] }}</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Sedang Diproses</span>
                        <div class="flex items-center gap-2">
                            <div class="w-32 bg-gray-200 rounded-full h-2">
                                <div class="bg-yellow-500 h-2 rounded-full"
                                    style="width: {{ $stats['total_tasks'] > 0 ? ($stats['in_progress'] / $stats['total_tasks']) * 100 : 0 }}%">
                                </div>
                            </div>
                            <span class="text-sm font-semibold">{{ $stats['in_progress'] }}</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Dijadwalkan</span>
                        <div class="flex items-center gap-2">
                            <div class="w-32 bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full"
                                    style="width: {{ $stats['total_tasks'] > 0 ? ($stats['scheduled'] / $stats['total_tasks']) * 100 : 0 }}%">
                                </div>
                            </div>
                            <span class="text-sm font-semibold">{{ $stats['scheduled'] }}</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Menunggu Pembayaran</span>
                        <div class="flex items-center gap-2">
                            <div class="w-32 bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-500 h-2 rounded-full"
                                    style="width: {{ $stats['total_tasks'] > 0 ? ($stats['waiting_payment'] / $stats['total_tasks']) * 100 : 0 }}%">
                                </div>
                            </div>
                            <span class="text-sm font-semibold">{{ $stats['waiting_payment'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Services -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h3 class="text-lg font-semibold">Service Terbaru</h3>
                <a href="{{ route('mekanik.tasks.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">Lihat
                    semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentServices as $service)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-mono">{{ $service->booking_code }}</td>
                                <td class="px-6 py-4 text-sm">{{ $service->customer->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm">{{ $service->jenisService->nama_service ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    {{ \Carbon\Carbon::parse($service->tanggal_booking)->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full 
                                @if ($service->status == 'dijadwalkan') bg-blue-100 text-blue-800
                                @elseif($service->status == 'diproses') bg-yellow-100 text-yellow-800
                                @elseif($service->status == 'menunggu_pembayaran') bg-purple-100 text-purple-800
                                @elseif($service->status == 'selesai') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $service->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('mekanik.services.detail', $service) }}"
                                        class="text-blue-600 hover:text-blue-800">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    Belum ada service
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
