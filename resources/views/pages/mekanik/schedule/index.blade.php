{{-- resources/views/mekanik/schedule/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Jadwal Service')
@section('page-title', 'Jadwal Service')

@section('content')
    <div class="space-y-6">
        @forelse($schedules as $date => $scheduleList)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-3">
                    <h3 class="text-white font-semibold">
                        {{ \Carbon\Carbon::parse($date)->format('l, d F Y') }}
                    </h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach ($scheduleList as $schedule)
                        <div class="p-4 hover:bg-gray-50">
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="flex items-center gap-3 mb-2">
                                        <span
                                            class="text-sm font-mono bg-gray-100 px-2 py-1 rounded">{{ $schedule->booking_code }}</span>
                                        <span
                                            class="text-sm font-semibold text-blue-600">{{ $schedule->waktu_booking }}</span>
                                    </div>
                                    <p class="font-medium">{{ $schedule->customer->user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $schedule->jenisService->nama_service }}</p>
                                    <p class="text-sm text-gray-500 mt-1">Keluhan: {{ Str::limit($schedule->keluhan, 100) }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full 
                            @if ($schedule->status == 'dijadwalkan') bg-blue-100 text-blue-800
                            @elseif($schedule->status == 'diproses') bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $schedule->status)) }}
                                    </span>
                                    <div class="mt-2">
                                        <a href="{{ route('mekanik.services.detail', $schedule) }}"
                                            class="text-blue-600 hover:text-blue-800 text-sm">Detail →</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <p class="text-gray-500">Tidak ada jadwal service</p>
            </div>
        @endforelse
    </div>
@endsection
