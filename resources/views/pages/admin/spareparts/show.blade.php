{{-- resources/views/admin/spareparts/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Sparepart')
@section('page-title', 'Detail Sparepart: ' . $sparepart->nama_sparepart)

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Kode</p>
                <p class="font-mono font-semibold">{{ $sparepart->kode_sparepart }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Status</p>
                <span
                    class="px-2 py-1 text-xs rounded-full {{ $sparepart->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $sparepart->is_active ? 'Aktif' : 'Tidak Aktif' }}
                </span>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Stok Saat Ini</p>
                <p
                    class="text-2xl font-bold {{ $sparepart->stok <= $sparepart->stok_minimum ? 'text-red-600' : 'text-green-600' }}">
                    {{ number_format($sparepart->stok) }} {{ $sparepart->satuan }}
                </p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Stok Minimum</p>
                <p class="text-2xl font-bold text-yellow-600">{{ number_format($sparepart->stok_minimum) }}
                    {{ $sparepart->satuan }}</p>
            </div>
        </div>

        <!-- Main Info -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h3 class="text-white font-semibold">Informasi Sparepart</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nama Sparepart</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $sparepart->nama_sparepart }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Merk</label>
                        <p class="text-gray-800">{{ $sparepart->merk ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Satuan</label>
                        <p class="text-gray-800">{{ ucfirst($sparepart->satuan) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Dibuat Pada</label>
                        <p class="text-gray-800">{{ $sparepart->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Terakhir Update</label>
                        <p class="text-gray-800">{{ $sparepart->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        @if ($sparepart->deskripsi)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-6 py-4">
                    <h3 class="text-white font-semibold">Deskripsi</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700">{{ $sparepart->deskripsi }}</p>
                </div>
            </div>
        @endif

        <!-- Usage History -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-orange-600 to-orange-700 px-6 py-4">
                <h3 class="text-white font-semibold">Riwayat Penggunaan</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Booking</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($usageHistory as $usage)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm">
                                    {{ \Carbon\Carbon::parse($usage->created_at)->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm font-mono">{{ $usage->booking->booking_code ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm">{{ $usage->booking->customer->user->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-right">{{ number_format($usage->pivot->jumlah) }}
                                    {{ $sparepart->satuan }}</td>
                                <td class="px-6 py-4 text-sm text-right font-semibold">Rp
                                    {{ number_format($usage->pivot->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    Belum ada riwayat penggunaan sparepart ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>



        <!-- Action Buttons -->
        <div class="flex justify-between gap-4">
            <a href="{{ route('admin.spareparts.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                Kembali
            </a>
            <div class="flex gap-2">
                <a href="{{ route('admin.spareparts.edit', $sparepart) }}"
                    class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">
                    Edit Sparepart
                </a>
                <form action="{{ route('admin.spareparts.destroy', $sparepart) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus sparepart ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
