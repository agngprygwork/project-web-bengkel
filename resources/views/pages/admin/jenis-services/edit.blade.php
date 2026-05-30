{{-- resources/views/admin/jenis-services/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Jenis Service')
@section('page-title', 'Edit Service: ' . $jenisService->nama_service)

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-yellow-600 to-yellow-700 px-6 py-4">
                <h3 class="text-white font-semibold">Form Edit Jenis Service</h3>
            </div>

            <form action="{{ route('admin.jenis-services.update', $jenisService) }}" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Service *</label>
                    <input type="text" name="nama_service" value="{{ old('nama_service', $jenisService->nama_service) }}"
                        required class="w-full border-gray-300 rounded-lg @error('nama_service') border-red-500 @enderror">
                    @error('nama_service')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="w-full border-gray-300 rounded-lg">{{ old('deskripsi', $jenisService->deskripsi) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga *</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                            <input type="number" name="harga" value="{{ old('harga', $jenisService->harga) }}" required
                                min="0" step="1000"
                                class="w-full pl-10 border-gray-300 rounded-lg @error('harga') border-red-500 @enderror">
                        </div>
                        @error('harga')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estimasi Waktu (menit) *</label>
                        <input type="number" name="estimasi_waktu"
                            value="{{ old('estimasi_waktu', $jenisService->estimasi_waktu) }}" required min="15"
                            max="480" step="15"
                            class="w-full border-gray-300 rounded-lg @error('estimasi_waktu') border-red-500 @enderror">
                        @error('estimasi_waktu')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                    <select name="is_active" required class="w-full border-gray-300 rounded-lg">
                        <option value="1" {{ old('is_active', $jenisService->is_active) ? 'selected' : '' }}>Aktif
                        </option>
                        <option value="0" {{ old('is_active', $jenisService->is_active) ? '' : 'selected' }}>Tidak
                            Aktif</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('admin.jenis-services.index') }}"
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
