@extends('layouts.app')

@section('title', 'Manajemen Customer')
@section('page-title', 'Manajemen Customer')

@section('content')
    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Total Customer</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Lengkap Profil</p>
                <p class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Belum Lengkap</p>
                <p class="text-2xl font-bold text-red-600">{{ $stats['inactive'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-gray-500 text-sm">Baru Bulan Ini</p>
                <p class="text-2xl font-bold text-blue-600">{{ $stats['new_this_month'] }}</p>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="flex flex-col md:flex-row justify-between gap-4">
                <div>
                    <a href="{{ route('admin.users.create') }}"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                        + Tambah Customer
                    </a>
                </div>
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-2">
                    <select name="has_profile" class="border-gray-300 rounded-lg">
                        <option value="all">Semua Status</option>
                        <option value="yes" {{ request('has_profile') == 'yes' ? 'selected' : '' }}>Lengkap Profil
                        </option>
                        <option value="no" {{ request('has_profile') == 'no' ? 'selected' : '' }}>Belum Lengkap</option>
                    </select>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email..."
                        class="border-gray-300 rounded-lg w-64">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Cari</button>
                    <a href="{{ route('admin.users.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Reset</a>
                </form>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. HP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alamat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bergabung</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-500">ID: {{ $user->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm">{{ $user->customer->no_hp ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm">{{ Str::limit($user->customer->alamat ?? '-', 30) }}</td>
                                <td class="px-6 py-4 text-sm">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ route('admin.users.show', $user) }}"
                                            class="text-blue-600 hover:text-blue-800">Detail</a>
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            class="text-yellow-600 hover:text-yellow-800">Edit</a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Yakin ingin menghapus customer ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    Tidak ada data customer
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
