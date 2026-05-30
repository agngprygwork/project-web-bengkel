{{-- resources/views/admin/mekaniks/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Mekanik')
@section('page-title', 'Detail Mekanik: ' . $mekanik->user->name)

@section('content')
    <div class="space-y-6">
        <!-- Profile Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                <h3 class="text-white font-semibold">Profil Mekanik</h3>
            </div>
            <div class="p-6">
                <div class="flex items-start gap-6">
                    <div
                        class="w-20 h-20 bg-purple-500 rounded-full flex items-center justify-center text-white text-3xl font-bold">
                        {{ substr($mekanik->user->name, 0, 1) }}
                    </div>
                    <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-gray-500">Nama Lengkap</label>
                            <p class="font-semibold">{{ $mekanik->user->name }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Email</label>
                            <p>{{ $mekanik->user->email }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Spesialisasi</label>
                            <p><span
                                    class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">{{ $mekanik->spesialis }}</span>
                            </p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">No. Telepon</label>
                            <p>{{ $mekanik->no_hp }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Pengalaman</label>
                            <p>{{ $mekanik->pengalaman_tahun }} tahun</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Bergabung Sejak</label>
                            <p>{{ $mekanik->created_at->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Stats -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Total Service</p>
                <p class="text-2xl font-bold">{{ $bookingStats['total'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Selesai</p>
                <p class="text-2xl font-bold text-green-600">{{ $bookingStats['completed'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Diproses</p>
                <p class="text-2xl font-bold text-blue-600">{{ $bookingStats['in_progress'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Pending</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $bookingStats['pending'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Total Pendapatan</p>
                <p class="text-2xl font-bold text-purple-600">Rp
                    {{ number_format($bookingStats['total_revenue'], 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Upcoming Schedule -->
        @if ($upcomingSchedule->count() > 0)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h3 class="font-semibold">Jadwal Mendatang</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach ($upcomingSchedule as $booking)
                        <div class="p-4 hover:bg-gray-50">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-medium">{{ $booking->customer->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $booking->jenisService->nama_service }}</p>
                                    <p class="text-xs text-gray-400">{{ $booking->tanggal_booking->format('d F Y') }} -
                                        {{ $booking->waktu_booking }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Recent Bookings -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h3 class="font-semibold">Riwayat Service Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($recentBookings as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-mono">{{ $booking->booking_code }}</td>
                                <td class="px-6 py-4 text-sm">{{ $booking->customer->user->name }}</td>
                                <td class="px-6 py-4 text-sm">{{ $booking->jenisService->nama_service }}</td>
                                <td class="px-6 py-4 text-sm">{{ $booking->tanggal_booking->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm text-right font-semibold">Rp
                                    {{ number_format($booking->total_bayar, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full 
                                @if ($booking->status == 'selesai') bg-green-100 text-green-800
                                @elseif($booking->status == 'diproses') bg-blue-100 text-blue-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between gap-4">
            <a href="{{ route('admin.mekaniks.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                Kembali
            </a>
            <div class="flex gap-2">
                <a href="{{ route('admin.mekaniks.edit', $mekanik) }}"
                    class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">
                    Edit Mekanik
                </a>
                <form action="{{ route('admin.mekaniks.destroy', $mekanik) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus mekanik ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                        Hapus Mekanik
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
