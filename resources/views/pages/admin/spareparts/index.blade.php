{{-- resources/views/admin/spareparts/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Sparepart')
@section('page-title', 'Manajemen Sparepart')

@section('content')
    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Total Sparepart</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Aktif</p>
                <p class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Tidak Aktif</p>
                <p class="text-2xl font-bold text-red-600">{{ $stats['inactive'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Stok Menipis</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $stats['low_stock'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Total Nilai Stok</p>
                <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($stats['total_value'], 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Header & Filter -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="flex flex-col md:flex-row justify-between gap-4">
                <div class="flex gap-2">
                    <a href="{{ route('admin.spareparts.create') }}"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                        + Tambah Sparepart
                    </a>
                    <a href="{{ route('admin.spareparts.index', ['low_stock' => 1]) }}"
                        class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">
                        Stok Menipis
                    </a>
                </div>
                <form method="GET" action="{{ route('admin.spareparts.index') }}" class="flex gap-2">
                    <select name="is_active" class="border-gray-300 rounded-lg">
                        <option value="all">Semua Status</option>
                        <option value="active" {{ request('is_active') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('is_active') == 'inactive' ? 'selected' : '' }}>Tidak Aktif
                        </option>
                    </select>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari sparepart..."
                        class="border-gray-300 rounded-lg w-64">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Cari</button>
                    <a href="{{ route('admin.spareparts.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Reset</a>
                </form>
            </div>
        </div>

        <!-- Spareparts Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Sparepart</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Merk</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Stok</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Min Stok</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Harga Beli</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Harga Jual</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($spareparts as $sparepart)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-mono">{{ $sparepart->kode_sparepart }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium">{{ $sparepart->nama_sparepart }}</div>
                                    <div class="text-xs text-gray-500">{{ $sparepart->satuan }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm">{{ $sparepart->merk ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-right">
                                    <span
                                        class="{{ $sparepart->stok <= $sparepart->stok_minimum ? 'text-red-600 font-bold' : '' }}">
                                        {{ number_format($sparepart->stok) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-right">{{ number_format($sparepart->stok_minimum) }}</td>
                                <td class="px-6 py-4 text-sm text-right">Rp
                                    {{ number_format($sparepart->harga_beli, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm text-right font-semibold">Rp
                                    {{ number_format($sparepart->harga_jual, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full {{ $sparepart->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $sparepart->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ route('admin.spareparts.show', $sparepart) }}"
                                            class="text-blue-600 hover:text-blue-800">Detail</a>
                                        <a href="{{ route('admin.spareparts.edit', $sparepart) }}"
                                            class="text-yellow-600 hover:text-yellow-800">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                                    Tidak ada data sparepart
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t">
                {{ $spareparts->links() }}
            </div>
        </div>
    </div>
@endsection
