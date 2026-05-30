{{-- resources/views/admin/mekaniks/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Mekanik')
@section('page-title', 'Manajemen Mekanik')

@section('content')
    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Total Mekanik</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Aktif</p>
                <p class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Rata-rata Pengalaman</p>
                <p class="text-2xl font-bold text-blue-600">{{ round($stats['avg_experience']) }} tahun</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Spesialisasi</p>
                <p class="text-2xl font-bold text-purple-600">{{ $stats['spesialis_list']->count() }}</p>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="flex flex-col md:flex-row justify-between gap-4">
                <div>
                    <a href="{{ route('admin.mekaniks.create') }}"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                        + Tambah Mekanik
                    </a>
                </div>
                <form method="GET" action="{{ route('admin.mekaniks.index') }}" class="flex gap-2">
                    <select name="spesialis" class="border-gray-300 rounded-lg">
                        <option value="">Semua Spesialis</option>
                        @foreach ($stats['spesialis_list'] as $spesialis)
                            <option value="{{ $spesialis }}" {{ request('spesialis') == $spesialis ? 'selected' : '' }}>
                                {{ $spesialis }}
                            </option>
                        @endforeach
                    </select>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama/spesialis..." class="border-gray-300 rounded-lg w-64">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Cari</button>
                    <a href="{{ route('admin.mekaniks.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Reset</a>
                </form>
            </div>
        </div>

        <!-- Mekaniks Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($mekaniks as $mekanik)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div
                                class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                                {{ substr($mekanik->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg">{{ $mekanik->user->name }}</h3>
                                <p class="text-sm text-purple-600">{{ $mekanik->spesialis }}</p>
                            </div>
                        </div>

                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Email:</span>
                                <span>{{ $mekanik->user->email }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">No. HP:</span>
                                <span>{{ $mekanik->no_hp }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Pengalaman:</span>
                                <span>{{ $mekanik->pengalaman_tahun }} tahun</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Bergabung:</span>
                                <span>{{ $mekanik->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t flex gap-2">
                            <a href="{{ route('admin.mekaniks.show', $mekanik) }}"
                                class="flex-1 text-center bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 text-sm">
                                Detail
                            </a>
                            <a href="{{ route('admin.mekaniks.edit', $mekanik) }}"
                                class="flex-1 text-center bg-yellow-600 text-white px-3 py-2 rounded-lg hover:bg-yellow-700 text-sm">
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-lg shadow-md p-12 text-center">
                    <p class="text-gray-500">Tidak ada data mekanik</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $mekaniks->links() }}
        </div>
    </div>
@endsection
