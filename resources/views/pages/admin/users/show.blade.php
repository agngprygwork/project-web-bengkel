{{-- resources/views/admin/users/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Customer')
@section('page-title', 'Detail Customer: ' . $user->name)

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Profile Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h3 class="text-white font-semibold">Profil Customer</h3>
            </div>
            <div class="p-6">
                <div class="flex items-start gap-6">
                    <div
                        class="w-20 h-20 bg-blue-500 rounded-full flex items-center justify-center text-white text-3xl font-bold">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-gray-500">Nama Lengkap</label>
                            <p class="font-semibold">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Email</label>
                            <p>{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">No. Telepon</label>
                            <p>{{ $user->customer->no_hp ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Bergabung Sejak</label>
                            <p>{{ $user->created_at->format('d F Y') }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-sm text-gray-500">Alamat</label>
                            <p>{{ $user->customer->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Total Booking</p>
                <p class="text-2xl font-bold">{{ $bookingStats['total'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Selesai</p>
                <p class="text-2xl font-bold text-green-600">{{ $bookingStats['completed'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Pending</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $bookingStats['pending'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Total Belanja</p>
                <p class="text-2xl font-bold text-blue-600">Rp
                    {{ number_format($bookingStats['total_spent'], 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h3 class="font-semibold">Riwayat Booking Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($user->customer->bookings->take(5) as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-mono">{{ $booking->booking_code }}</td>
                                <td class="px-6 py-4 text-sm">{{ $booking->jenisService->nama_service ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm">{{ $booking->tanggal_booking->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm text-right font-semibold">Rp
                                    {{ number_format($booking->total_bayar, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full 
                                @if ($booking->status == 'selesai') bg-green-100 text-green-800
                                @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                @else bg-blue-100 text-blue-800 @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    Belum ada booking
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between gap-4">
            <a href="{{ route('admin.users.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                Kembali
            </a>
            <div class="flex gap-2">
                <a href="{{ route('admin.users.edit', $user) }}"
                    class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">
                    Edit Customer
                </a>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus customer ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                        Hapus Customer
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
