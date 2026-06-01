{{-- resources/views/pages/mekanik/schedule/calendar.blade.php --}}
@extends('layouts.app')

@section('title', 'Kalender Jadwal')
@section('page-title', 'Kalender Jadwal Service')

@section('content')
    <div class="space-y-6">
        <!-- Month Navigation -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="flex flex-wrap justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <a href="{{ route('mekanik.schedule.calendar', ['month' => $previousMonth, 'year' => $previousYear]) }}"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 p-2 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </a>
                    <h2 class="text-xl font-bold text-gray-800">
                        {{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}
                    </h2>
                    <a href="{{ route('mekanik.schedule.calendar', ['month' => $nextMonth, 'year' => $nextYear]) }}"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 p-2 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('mekanik.schedule.calendar') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Bulan Ini
                    </a>
                    <a href="{{ route('mekanik.schedule.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                        Daftar Jadwal
                    </a>
                </div>
            </div>
        </div>

        <!-- Calendar Legend -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded-full bg-green-500"></div>
                    <span class="text-sm text-gray-600">Ada Service</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded-full bg-blue-500"></div>
                    <span class="text-sm text-gray-600">Hari Ini</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded-full bg-yellow-500"></div>
                    <span class="text-sm text-gray-600">Service Diproses</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded-full bg-red-500"></div>
                    <span class="text-sm text-gray-600">Service Tertunda</span>
                </div>
            </div>
        </div>

        <!-- Calendar Grid -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Day Names -->
            <div class="grid grid-cols-7 bg-gray-100 border-b">
                <div class="p-3 text-center text-sm font-semibold text-gray-600 border-r">Minggu</div>
                <div class="p-3 text-center text-sm font-semibold text-gray-600 border-r">Senin</div>
                <div class="p-3 text-center text-sm font-semibold text-gray-600 border-r">Selasa</div>
                <div class="p-3 text-center text-sm font-semibold text-gray-600 border-r">Rabu</div>
                <div class="p-3 text-center text-sm font-semibold text-gray-600 border-r">Kamis</div>
                <div class="p-3 text-center text-sm font-semibold text-gray-600 border-r">Jumat</div>
                <div class="p-3 text-center text-sm font-semibold text-gray-600">Sabtu</div>
            </div>

            <!-- Calendar Days -->
            <div class="grid grid-cols-7 auto-rows-fr">
                @php
                    $currentDay = 1;
                    $dayCounter = 1;
                    $isFirstWeek = true;
                @endphp

                @for ($week = 0; $week < 6; $week++)
                    @for ($day = 1; $day <= 7; $day++)
                        @php
                            $isValidDay = !$isFirstWeek || ($isFirstWeek && $day >= $firstDayOfMonth);
                            $currentDate = null;

                            if ($isValidDay && $currentDay <= $daysInMonth) {
                                $currentDate = \Carbon\Carbon::create($year, $month, $currentDay);
                                $hasSchedule = isset($schedules[$currentDay]);
                                $schedulesForDay = $hasSchedule ? $schedules[$currentDay] : collect();
                                $isToday = $currentDate->isToday();
                                $isPast = $currentDate->isPast() && !$isToday;
                                $statusCounts = [
                                    'dijadwalkan' => $schedulesForDay->where('status', 'dijadwalkan')->count(),
                                    'diproses' => $schedulesForDay->where('status', 'diproses')->count(),
                                ];
                                $currentDay++;
                            }
                        @endphp

                        <div
                            class="min-h-[120px] p-2 border-r border-b 
                        @if ($isValidDay && $currentDate && $isToday) bg-blue-50
                        @elseif($isValidDay && $currentDate && $isPast) bg-gray-50
                        @else bg-white @endif
                        @if ($day == 7) border-r-0 @endif">

                            @if ($isValidDay && $currentDate)
                                <div class="flex justify-between items-start">
                                    <span
                                        class="text-sm font-semibold 
                                    @if ($isToday) text-blue-600 bg-blue-100 w-7 h-7 rounded-full flex items-center justify-center
                                    @else text-gray-700 @endif">
                                        {{ $currentDay - 1 }}
                                    </span>
                                    @if ($hasSchedule)
                                        <span class="text-xs bg-green-100 text-green-600 px-2 py-0.5 rounded-full">
                                            {{ $schedulesForDay->count() }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Schedule Indicators -->
                                <div class="mt-2 space-y-1">
                                    @if ($statusCounts['dijadwalkan'] > 0)
                                        <div class="text-xs text-blue-600 truncate" title="Dijadwalkan">
                                            <span class="inline-block w-2 h-2 rounded-full bg-blue-500 mr-1"></span>
                                            {{ $statusCounts['dijadwalkan'] }} Dijadwalkan
                                        </div>
                                    @endif
                                    @if ($statusCounts['diproses'] > 0)
                                        <div class="text-xs text-yellow-600 truncate" title="Diproses">
                                            <span class="inline-block w-2 h-2 rounded-full bg-yellow-500 mr-1"></span>
                                            {{ $statusCounts['diproses'] }} Diproses
                                        </div>
                                    @endif
                                </div>

                                <!-- Quick Link -->
                                @if ($hasSchedule)
                                    <div class="mt-2">
                                        <a href="{{ route('mekanik.schedule.by-date', $currentDate->format('Y-m-d')) }}"
                                            class="text-xs text-blue-600 hover:text-blue-800">
                                            Lihat detail →
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="h-full"></div>
                            @endif
                        </div>
                    @endfor
                    @php $isFirstWeek = false; @endphp
                @endfor
            </div>
        </div>

        <!-- Schedule List for Selected Date (if any) -->
        @if (request()->has('view_date'))
            @php
                $selectedDate = request('view_date');
                $selectedSchedules = $schedules[\Carbon\Carbon::parse($selectedDate)->day] ?? collect();
            @endphp
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-white font-semibold">
                        Jadwal {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}
                    </h3>
                    <a href="{{ route('mekanik.schedule.calendar') }}" class="text-white/80 hover:text-white text-sm">
                        Tutup
                    </a>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($selectedSchedules as $schedule)
                        <div class="p-4 hover:bg-gray-50 transition">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="text-sm font-mono bg-gray-100 px-2 py-1 rounded">
                                            {{ $schedule->booking_code }}
                                        </span>
                                        <span class="text-sm font-semibold text-blue-600">
                                            {{ \Carbon\Carbon::parse($schedule->waktu_booking)->format('H:i') }}
                                        </span>
                                        <span
                                            class="px-2 py-1 text-xs rounded-full 
                                    @if ($schedule->status == 'dijadwalkan') bg-blue-100 text-blue-800
                                    @elseif($schedule->status == 'diproses') bg-yellow-100 text-yellow-800
                                    @else bg-green-100 text-green-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $schedule->status)) }}
                                        </span>
                                    </div>
                                    <p class="font-medium">{{ $schedule->customer->user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $schedule->jenisService->nama_service }}</p>
                                    <p class="text-sm text-gray-500 mt-1">{{ Str::limit($schedule->keluhan, 100) }}</p>
                                </div>
                                <div>
                                    <a href="{{ route('mekanik.services.detail', $schedule) }}"
                                        class="text-blue-600 hover:text-blue-800 text-sm">
                                        Detail →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            Tidak ada jadwal service pada tanggal ini
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

        <!-- Summary Statistics -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Ringkasan Bulan
                {{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $totalSchedules = 0;
                    $totalScheduled = 0;
                    $totalInProgress = 0;
                    foreach ($schedules as $daySchedules) {
                        $totalSchedules += $daySchedules->count();
                        $totalScheduled += $daySchedules->where('status', 'dijadwalkan')->count();
                        $totalInProgress += $daySchedules->where('status', 'diproses')->count();
                    }
                @endphp
                <div class="text-center p-3 bg-blue-50 rounded-lg">
                    <p class="text-2xl font-bold text-blue-600">{{ $totalSchedules }}</p>
                    <p class="text-xs text-gray-600">Total Service</p>
                </div>
                <div class="text-center p-3 bg-green-50 rounded-lg">
                    <p class="text-2xl font-bold text-green-600">{{ $totalScheduled }}</p>
                    <p class="text-xs text-gray-600">Dijadwalkan</p>
                </div>
                <div class="text-center p-3 bg-yellow-50 rounded-lg">
                    <p class="text-2xl font-bold text-yellow-600">{{ $totalInProgress }}</p>
                    <p class="text-xs text-gray-600">Diproses</p>
                </div>
                <div class="text-center p-3 bg-purple-50 rounded-lg">
                    <p class="text-2xl font-bold text-purple-600">
                        {{ $totalSchedules > 0 ? round(($totalInProgress / $totalSchedules) * 100) : 0 }}%</p>
                    <p class="text-xs text-gray-600">Progress</p>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .calendar-grid {
                display: grid;
                grid-template-columns: repeat(7, 1fr);
            }

            .calendar-day {
                min-height: 120px;
            }
        </style>
    @endpush
@endsection
