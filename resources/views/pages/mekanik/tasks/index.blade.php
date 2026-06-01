{{-- resources/views/mekanik/tasks/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Service')
@section('page-title', 'Daftar Service')

@section('content')
    <div class="space-y-6">
        <!-- Filter -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <form method="GET" class="flex gap-4">
                <select name="status" class="border-gray-300 rounded-lg">
                    <option value="all">Semua Status</option>
                    <option value="dijadwalkan" {{ request('status') == 'dijadwalkan' ? 'selected' : '' }}>Dijadwalkan
                    </option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="menunggu_pembayaran" {{ request('status') == 'menunggu_pembayaran' ? 'selected' : '' }}>
                        Menunggu Pembayaran</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode/customer..."
                    class="border-gray-300 rounded-lg w-64">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Filter</button>
                <a href="{{ route('mekanik.tasks.index') }}"
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
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
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="px-2 py-1 text-xs rounded-full 
                            @if ($task->status == 'dijadwalkan') bg-blue-100 text-blue-800
                            @elseif($task->status == 'diproses') bg-yellow-100 text-yellow-800
                            @elseif($task->status == 'menunggu_pembayaran') bg-purple-100 text-purple-800
                            @elseif($task->status == 'selesai') bg-green-100 text-green-800 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('mekanik.services.detail', $task) }}"
                                    class="text-blue-600 hover:text-blue-800">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                Tidak ada service
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
