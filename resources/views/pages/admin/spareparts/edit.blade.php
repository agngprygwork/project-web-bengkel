{{-- resources/views/admin/spareparts/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Sparepart')
@section('page-title', 'Edit Sparepart: ' . $sparepart->nama_sparepart)

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-yellow-600 to-yellow-700 px-6 py-4">
                <h3 class="text-white font-semibold">Form Edit Sparepart</h3>
            </div>

            <form action="{{ route('admin.spareparts.update', $sparepart) }}" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Sparepart</label>
                        <input type="text" value="{{ $sparepart->kode_sparepart }}" disabled
                            class="w-full bg-gray-100 border-gray-300 rounded-lg">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Sparepart *</label>
                        <input type="text" name="nama_sparepart"
                            value="{{ old('nama_sparepart', $sparepart->nama_sparepart) }}" required
                            class="w-full border-gray-300 rounded-lg @error('nama_sparepart') border-red-500 @enderror">
                        @error('nama_sparepart')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Merk</label>
                        <input type="text" name="merk" value="{{ old('merk', $sparepart->merk) }}"
                            class="w-full border-gray-300 rounded-lg">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok *</label>
                        <input type="number" name="stok" value="{{ old('stok', $sparepart->stok) }}" required
                            min="0"
                            class="w-full border-gray-300 rounded-lg @error('stok') border-red-500 @enderror">
                        @error('stok')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok Minimum *</label>
                        <input type="number" name="stok_minimum"
                            value="{{ old('stok_minimum', $sparepart->stok_minimum) }}" required min="0"
                            class="w-full border-gray-300 rounded-lg @error('stok_minimum') border-red-500 @enderror">
                        @error('stok_minimum')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Beli *</label>
                        <input type="number" name="harga_beli" value="{{ old('harga_beli', $sparepart->harga_beli) }}"
                            required min="0" step="1000"
                            class="w-full border-gray-300 rounded-lg @error('harga_beli') border-red-500 @enderror">
                        @error('harga_beli')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Jual *</label>
                        <input type="number" name="harga_jual" value="{{ old('harga_jual', $sparepart->harga_jual) }}"
                            required min="0" step="1000"
                            class="w-full border-gray-300 rounded-lg @error('harga_jual') border-red-500 @enderror">
                        @error('harga_jual')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Satuan *</label>
                        <select name="satuan" required class="w-full border-gray-300 rounded-lg">
                            <option value="pcs" {{ $sparepart->satuan == 'pcs' ? 'selected' : '' }}>Pcs</option>
                            <option value="buah" {{ $sparepart->satuan == 'buah' ? 'selected' : '' }}>Buah</option>
                            <option value="unit" {{ $sparepart->satuan == 'unit' ? 'selected' : '' }}>Unit</option>
                            <option value="liter" {{ $sparepart->satuan == 'liter' ? 'selected' : '' }}>Liter</option>
                            <option value="kg" {{ $sparepart->satuan == 'kg' ? 'selected' : '' }}>Kg</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="is_active" class="w-full border-gray-300 rounded-lg">
                            <option value="1" {{ $sparepart->is_active ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !$sparepart->is_active ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="w-full border-gray-300 rounded-lg">{{ old('deskripsi', $sparepart->deskripsi) }}</textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('admin.spareparts.index') }}"
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
