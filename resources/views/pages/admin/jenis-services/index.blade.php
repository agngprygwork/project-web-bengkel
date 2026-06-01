{{-- resources/views/admin/jenis-services/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Jenis Service')
@section('page-title', 'Manajenis Jenis Service')

@section('content')
    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Total Service</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Aktif</p>
                <p class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Tidak Aktif</p>
                <p class="text-2xl font-bold text-red-600">{{ $stats['inactive'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Rata-rata Harga</p>
                <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($stats['avg_price'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Harga Terendah</p>
                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($stats['min_price'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Harga Tertinggi</p>
                <p class="text-2xl font-bold text-red-600">Rp {{ number_format($stats['max_price'], 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Popular Service Alert -->
        @if ($stats['most_popular'])
            <div class="bg-blue-50 border-l-4 border-blue-400 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Service terpopuler: <strong>{{ $stats['most_popular']->nama_service }}</strong>
                            dengan {{ $stats['most_popular']->bookings_count }} booking
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Filter & Search -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="flex flex-col md:flex-row justify-between gap-4">
                <div>
                    <a href="{{ route('admin.jenis-services.create') }}"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                        + Tambah Service
                    </a>
                </div>
                <form method="GET" action="{{ route('admin.jenis-services.index') }}" class="flex gap-2">
                    <select name="is_active" class="border-gray-300 rounded-lg">
                        <option value="all">Semua Status</option>
                        <option value="active" {{ request('is_active') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('is_active') == 'inactive' ? 'selected' : '' }}>Tidak Aktif
                        </option>
                    </select>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama service..."
                        class="border-gray-300 rounded-lg w-64">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Cari</button>
                    <a href="{{ route('admin.jenis-services.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Reset</a>
                </form>
            </div>
        </div>

        <!-- Services Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Harga</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Estimasi</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($jenisServices as $service)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $service->nama_service }}</p>
                                        <p class="text-xs text-gray-500">ID: {{ $service->id }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm">{{ Str::limit($service->deskripsi, 50) ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-right font-semibold text-green-600">
                                    Rp {{ number_format($service->harga, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-right">{{ $service->estimasi_waktu }} menit</td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $service->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ route('admin.jenis-services.show', $service) }}"
                                            class="text-blue-600 hover:text-blue-800">Detail</a>
                                        <a href="{{ route('admin.jenis-services.edit', $service) }}"
                                            class="text-yellow-600 hover:text-yellow-800">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    Tidak ada data service
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t">
                {{ $jenisServices->links() }}
            </div>
        </div>
    </div>
@endsection
