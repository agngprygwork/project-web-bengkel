{{-- resources/views/admin/mekaniks/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Mekanik')
@section('page-title', 'Edit Mekanik: ' . $mekanik->user->name)

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-yellow-600 to-yellow-700 px-6 py-4">
                <h3 class="text-white font-semibold">Form Edit Mekanik</h3>
            </div>

            <form action="{{ route('admin.mekaniks.update', $mekanik) }}" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                        <input type="text" name="name" value="{{ old('name', $mekanik->user->name) }}" required
                            class="w-full border-gray-300 rounded-lg @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $mekanik->user->email) }}" required
                            class="w-full border-gray-300 rounded-lg @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password (kosongkan jika tidak
                            diubah)</label>
                        <input type="password" name="password"
                            class="w-full border-gray-300 rounded-lg @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-lg">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Spesialisasi *</label>
                        <select name="spesialis" required
                            class="w-full border-gray-300 rounded-lg @error('spesialis') border-red-500 @enderror">
                            <option value="">Pilih Spesialisasi</option>
                            @foreach ($spesialisOptions as $key => $value)
                                <option value="{{ $key }}"
                                    {{ old('spesialis', $mekanik->spesialis) == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('spesialis')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon *</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $mekanik->no_hp) }}" required
                            class="w-full border-gray-300 rounded-lg @error('no_hp') border-red-500 @enderror">
                        @error('no_hp')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pengalaman (tahun) *</label>
                        <input type="number" name="pengalaman_tahun"
                            value="{{ old('pengalaman_tahun', $mekanik->pengalaman_tahun) }}" required min="0"
                            max="50"
                            class="w-full border-gray-300 rounded-lg @error('pengalaman_tahun') border-red-500 @enderror">
                        @error('pengalaman_tahun')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('admin.mekaniks.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
