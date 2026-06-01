{{-- resources/views/mekanik/tasks/today.blade.php --}}
@extends('layouts.app')

@section('title', 'Service Hari Ini')
@section('page-title', 'Service Hari Ini')

@section('content')
    <div class="space-y-6">
        <!-- Header Info -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-md p-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold">{{ \Carbon\Carbon::today()->format('l, d F Y') }}</h3>
                    <p class="text-blue-100 mt-1">Daftar service yang dijadwalkan hari ini</p>
                </div>
                <div class="bg-white/20 rounded-lg px-4 py-2 text-center">
                    <p class="text-2xl font-bold">{{ $tasks->count() }}</p>
                    <p class="text-xs">Total Service</p>
                </div>
            </div>
        </div>

        <!-- Tasks List -->
        @forelse($tasks as $task)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <div
                    class="border-l-4 
            @if ($task->status == 'dijadwalkan') border-blue-500
            @elseif($task->status == 'diproses') border-yellow-500
            @elseif($task->status == 'selesai') border-green-500
            @else border-gray-500 @endif">

                    <div class="p-5">
                        <!-- Header -->
                        <div class="flex flex-wrap justify-between items-start gap-3 mb-4">
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-mono bg-gray-100 px-2 py-1 rounded">
                                    {{ $task->booking_code }}
                                </span>
                                <span
                                    class="px-2 py-1 text-xs rounded-full 
                            @if ($task->status == 'dijadwalkan') bg-blue-100 text-blue-800
                            @elseif($task->status == 'diproses') bg-yellow-100 text-yellow-800
                            @elseif($task->status == 'menunggu_pembayaran') bg-purple-100 text-purple-800
                            @elseif($task->status == 'selesai') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($task->waktu_booking)->format('H:i') }}</span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-500">Customer</p>
                                <p class="font-semibold">{{ $task->customer->user->name ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-600">{{ $task->customer->no_hp ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Jenis Service</p>
                                <p class="font-semibold">{{ $task->jenisService->nama_service ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-600">Estimasi: {{ $task->jenisService->estimasi_waktu ?? 0 }}
                                    menit</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-sm text-gray-500">Keluhan</p>
                                <p class="text-gray-700">{{ Str::limit($task->keluhan, 150) }}</p>
                            </div>
                            @if ($task->catatan)
                                <div class="md:col-span-2">
                                    <p class="text-sm text-gray-500">Catatan Tambahan</p>
                                    <p class="text-gray-600 italic">{{ $task->catatan }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-3 pt-3 border-t">
                            @if ($task->status == 'dijadwalkan')
                                <form action="{{ route('mekanik.tasks.start', $task) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Mulai Service
                                    </button>
                                </form>
                            @endif

                            @if ($task->status == 'diproses')
                                <a href="{{ route('mekanik.services.detail', $task) }}"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    Lanjutkan Service
                                </a>
                            @endif

                            <a href="{{ route('mekanik.services.detail', $task) }}"
                                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">Tidak Ada Service Hari Ini</h3>
                <p class="text-gray-500">Selamat! Tidak ada service yang dijadwalkan untuk hari ini.</p>
            </div>
        @endforelse

        <!-- Quick Stats -->
        @if ($tasks->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-4">
                <h4 class="font-semibold text-gray-700 mb-3">Ringkasan Hari Ini</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-blue-600">
                            {{ $tasks->where('status', 'dijadwalkan')->count() }}
                        </p>
                        <p class="text-xs text-gray-500">Belum Dimulai</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-yellow-600">
                            {{ $tasks->where('status', 'diproses')->count() }}
                        </p>
                        <p class="text-xs text-gray-500">Sedang Diproses</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-purple-600">
                            {{ $tasks->where('status', 'menunggu_pembayaran')->count() }}
                        </p>
                        <p class="text-xs text-gray-500">Menunggu Bayar</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-green-600">
                            {{ $tasks->where('status', 'selesai')->count() }}
                        </p>
                        <p class="text-xs text-gray-500">Selesai</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
