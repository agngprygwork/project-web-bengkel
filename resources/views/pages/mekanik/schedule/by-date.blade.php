{{-- resources/views/pages/mekanik/schedule/by-date.blade.php --}}
@extends('layouts.app')

@section('title', 'Jadwal Service - ' . \Carbon\Carbon::parse($date)->format('d F Y'))
@section('page-title', 'Jadwal Service: ' . \Carbon\Carbon::parse($date)->format('d F Y'))

@section('content')
    <div class="space-y-6">
        <!-- Date Navigation -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="flex flex-wrap justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <a href="{{ route('mekanik.schedule.by-date', \Carbon\Carbon::parse($date)->subDay()->format('Y-m-d')) }}"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 p-2 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </a>
                    <h2 class="text-xl font-bold text-gray-800">
                        {{ \Carbon\Carbon::parse($date)->format('l, d F Y') }}
                    </h2>
                    <a href="{{ route('mekanik.schedule.by-date', \Carbon\Carbon::parse($date)->addDay()->format('Y-m-d')) }}"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 p-2 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('mekanik.schedule.by-date', now()->format('Y-m-d')) }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Hari Ini
                    </a>
                    <a href="{{ route('mekanik.schedule.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                        Daftar Jadwal
                    </a>
                    <a href="{{ route('mekanik.schedule.calendar') }}"
                        class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                        Kalender
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Service</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $schedules->count() }}</p>
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

            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Dijadwalkan</p>
                        <p class="text-2xl font-bold text-blue-600">
                            {{ $schedules->where('status', 'dijadwalkan')->count() }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Diproses</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $schedules->where('status', 'diproses')->count() }}
                        </p>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Menunggu Bayar</p>
                        <p class="text-2xl font-bold text-purple-600">
                            {{ $schedules->where('status', 'menunggu_pembayaran')->count() }}</p>
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
        </div>

        <!-- Schedule List -->
        @if ($schedules->count() > 0)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h3 class="text-white font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Daftar Service
                    </h3>
                </div>

                <div class="divide-y divide-gray-200">
                    @foreach ($schedules->sortBy('waktu_booking') as $schedule)
                        <div class="p-5 hover:bg-gray-50 transition">
                            <div class="flex flex-wrap lg:flex-nowrap justify-between gap-4">
                                <!-- Time Column -->
                                <div class="lg:w-32 flex-shrink-0">
                                    <div class="bg-blue-100 rounded-lg p-3 text-center">
                                        <p class="text-2xl font-bold text-blue-600">
                                            {{ \Carbon\Carbon::parse($schedule->waktu_booking)->format('H:i') }}
                                        </p>
                                        <p class="text-xs text-gray-500">Waktu Service</p>
                                    </div>
                                </div>

                                <!-- Content Column -->
                                <div class="flex-1">
                                    <div class="flex flex-wrap items-center gap-3 mb-3">
                                        <span class="text-xs font-mono bg-gray-100 px-2 py-1 rounded">
                                            {{ $schedule->booking_code }}
                                        </span>
                                        <span
                                            class="px-2 py-1 text-xs rounded-full 
                                    @if ($schedule->status == 'dijadwalkan') bg-blue-100 text-blue-800
                                    @elseif($schedule->status == 'diproses') bg-yellow-100 text-yellow-800
                                    @elseif($schedule->status == 'menunggu_pembayaran') bg-purple-100 text-purple-800
                                    @else bg-green-100 text-green-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $schedule->status)) }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                        <div>
                                            <p class="text-sm text-gray-500">Customer</p>
                                            <p class="font-semibold">{{ $schedule->customer->user->name ?? 'N/A' }}</p>
                                            <p class="text-sm text-gray-600">{{ $schedule->customer->no_hp ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Jenis Service</p>
                                            <p class="font-semibold">{{ $schedule->jenisService->nama_service ?? 'N/A' }}
                                            </p>
                                            <p class="text-sm text-gray-600">Estimasi:
                                                {{ $schedule->jenisService->estimasi_waktu ?? 0 }} menit</p>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <p class="text-sm text-gray-500">Keluhan</p>
                                        <p class="text-gray-700">{{ Str::limit($schedule->keluhan, 150) }}</p>
                                    </div>

                                    @if ($schedule->catatan)
                                        <div class="mb-3">
                                            <p class="text-sm text-gray-500">Catatan</p>
                                            <p class="text-gray-600 italic">{{ $schedule->catatan }}</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Action Column -->
                                <div class="lg:w-40 flex-shrink-0">
                                    <div class="flex flex-col gap-2">
                                        <a href="{{ route('mekanik.services.detail', $schedule) }}"
                                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-center text-sm">
                                            Detail Service
                                        </a>

                                        @if ($schedule->status == 'dijadwalkan')
                                            <form action="{{ route('mekanik.tasks.start', $schedule) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm">
                                                    Mulai Service
                                                </button>
                                            </form>
                                        @endif

                                        @if ($schedule->status == 'diproses')
                                            <a href="{{ route('mekanik.services.detail', $schedule) }}#complete-form"
                                                class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition text-center text-sm">
                                                Selesaikan
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Timeline View -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-6 py-4">
                    <h3 class="text-white font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Timeline Service
                    </h3>
                </div>
                <div class="p-6">
                    <div class="relative">
                        <!-- Timeline Line -->
                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>

                        <div class="space-y-6 relative">
                            @foreach ($schedules->sortBy('waktu_booking') as $index => $schedule)
                                <div class="flex gap-4">
                                    <!-- Time Badge -->
                                    <div class="relative z-10">
                                        <div
                                            class="w-8 h-8 rounded-full flex items-center justify-center
                                    @if ($schedule->status == 'dijadwalkan') bg-blue-500 text-white
                                    @elseif($schedule->status == 'diproses') bg-yellow-500 text-white
                                    @else bg-purple-500 text-white @endif">
                                            {{ $index + 1 }}
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1 bg-gray-50 rounded-lg p-4">
                                        <div class="flex flex-wrap justify-between items-start gap-2">
                                            <div>
                                                <div class="flex items-center gap-3 mb-2">
                                                    <span class="text-lg font-bold text-blue-600">
                                                        {{ \Carbon\Carbon::parse($schedule->waktu_booking)->format('H:i') }}
                                                    </span>
                                                    <span
                                                        class="px-2 py-1 text-xs rounded-full 
                                                @if ($schedule->status == 'dijadwalkan') bg-blue-100 text-blue-800
                                                @elseif($schedule->status == 'diproses') bg-yellow-100 text-yellow-800
                                                @else bg-purple-100 text-purple-800 @endif">
                                                        {{ ucfirst(str_replace('_', ' ', $schedule->status)) }}
                                                    </span>
                                                </div>
                                                <p class="font-semibold">{{ $schedule->customer->user->name }}</p>
                                                <p class="text-sm text-gray-600">
                                                    {{ $schedule->jenisService->nama_service }}</p>
                                                <p class="text-sm text-gray-500 mt-1">
                                                    {{ Str::limit($schedule->keluhan, 100) }}</p>
                                            </div>
                                            <a href="{{ route('mekanik.services.detail', $schedule) }}"
                                                class="text-blue-600 hover:text-blue-800 text-sm">
                                                Detail →
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">Tidak Ada Jadwal Service</h3>
                <p class="text-gray-500 mb-4">
                    Tidak ada service yang dijadwalkan pada tanggal {{ \Carbon\Carbon::parse($date)->format('d F Y') }}
                </p>
                <div class="flex justify-center gap-3">
                    <a href="{{ route('mekanik.schedule.by-date', \Carbon\Carbon::parse($date)->subDay()->format('Y-m-d')) }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                        Hari Sebelumnya
                    </a>
                    <a href="{{ route('mekanik.schedule.by-date', \Carbon\Carbon::parse($date)->addDay()->format('Y-m-d')) }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Hari Berikutnya
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
