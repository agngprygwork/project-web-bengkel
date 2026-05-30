{{-- resources/views/admin/jenis-services/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Jenis Service')
@section('page-title', 'Tambah Jenis Service Baru')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h3 class="text-white font-semibold">Form Tambah Jenis Service</h3>
            </div>

            <form action="{{ route('admin.jenis-services.store') }}" method="POST" class="p-6 space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Service *</label>
                    <input type="text" name="nama_service" value="{{ old('nama_service') }}" required
                        class="w-full border-gray-300 rounded-lg @error('nama_service') border-red-500 @enderror">
                    @error('nama_service')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="w-full border-gray-300 rounded-lg">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga *</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                            <input type="number" name="harga" value="{{ old('harga') }}" required min="0"
                                step="1000"
                                class="w-full pl-10 border-gray-300 rounded-lg @error('harga') border-red-500 @enderror">
                        </div>
                        @error('harga')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estimasi Waktu (menit) *</label>
                        <input type="number" name="estimasi_waktu" value="{{ old('estimasi_waktu', 60) }}" required
                            min="15" max="480" step="15"
                            class="w-full border-gray-300 rounded-lg @error('estimasi_waktu') border-red-500 @enderror">
                        @error('estimasi_waktu')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                    <select name="is_active" required class="w-full border-gray-300 rounded-lg">
                        <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('admin.jenis-services.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
