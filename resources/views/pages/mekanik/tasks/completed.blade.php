{{-- resources/views/mekanik/tasks/completed.blade.php --}}
@extends('layouts.app')

@section('title', 'Riwayat Pekerjaan')
@section('page-title', 'Riwayat Pekerjaan')

@section('content')
    <div class="space-y-6">
        <!-- Filter -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <form method="GET" class="flex flex-wrap gap-4">
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="border-gray-300 rounded-lg">
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="border-gray-300 rounded-lg">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Filter</button>
                <a href="{{ route('mekanik.tasks.completed') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Reset</a>
            </form>
        </div>

        <!-- Tasks Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Service</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Selesai Pada</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($tasks as $task)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-mono">{{ $task->booking_code }}</td>
                            <td class="px-6 py-4 text-sm">{{ $task->customer->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm">{{ $task->jenisService->nama_service ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm">
                                {{ \Carbon\Carbon::parse($task->tanggal_booking)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm">{{ $task->updated_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-sm text-right font-semibold">Rp
                                {{ number_format($task->total_bayar, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('mekanik.services.detail', $task) }}"
                                    class="text-blue-600 hover:text-blue-800">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                Belum ada riwayat pekerjaan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-6 py-4 border-t">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
@endsection
