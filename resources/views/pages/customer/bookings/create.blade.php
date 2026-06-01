{{-- resources/views/customer/bookings/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Booking Service')
@section('page-title', 'Booking Service Baru')

@section('content')
    <div class="max-w-4xl mx-auto">
        <form action="{{ route('customer.bookings.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Data Kendaraan -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Data Kendaraan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Merk Motor*</label>
                        <input type="text" name="motor_brand" value="{{ old('motor_brand') }}" required
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('motor_brand') border-red-500 @enderror"
                            placeholder="Contoh: Honda, Yamaha, Suzuki">
                        @error('motor_brand')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Motor*</label>
                        <input type="text" name="motor_type" value="{{ old('motor_type') }}" required
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('motor_type') border-red-500 @enderror"
                            placeholder="Contoh: Beat, Mio, Satria">
                        @error('motor_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Plat Nomor*</label>
                        <input type="text" name="license_plate" value="{{ old('license_plate') }}" required
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('license_plate') border-red-500 @enderror"
                            placeholder="Contoh: B 1234 ABC">
                        @error('license_plate')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Data Service -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    Detail Service
                </h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Service*</label>
                        <select name="jenis_service_id" id="jenis_service_id" required
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('jenis_service_id') border-red-500 @enderror">
                            <option value="">Pilih Jenis Service</option>
                            @foreach ($jenisServices as $service)
                                <option value="{{ $service->id }}" data-harga="{{ $service->harga }}"
                                    {{ old('jenis_service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->nama_service }} - Rp {{ number_format($service->harga, 0, ',', '.') }}
                                    ({{ $service->estimasi_waktu }} menit)
                                </option>
                            @endforeach
                        </select>
                        @error('jenis_service_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Mekanik (Opsional)</label>
                        <select name="mekanik_id"
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Mekanik (Sistem akan memilihkan)</option>
                            @foreach ($mekaniks as $mekanik)
                                <option value="{{ $mekanik->id }}"
                                    {{ old('mekanik_id') == $mekanik->id ? 'selected' : '' }}>
                                    {{ $mekanik->user->name }} - Spesialis: {{ $mekanik->spesialis }}
                                    ({{ $mekanik->pengalaman_tahun }} tahun)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Booking*</label>
                            <input type="date" name="tanggal_booking" value="{{ old('tanggal_booking') }}" required
                                min="{{ date('Y-m-d') }}"
                                class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('tanggal_booking') border-red-500 @enderror">
                            @error('tanggal_booking')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Waktu Booking*</label>
                            <input type="time" name="waktu_booking" value="{{ old('waktu_booking') }}" required
                                class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('waktu_booking') border-red-500 @enderror">
                            @error('waktu_booking')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Keluhan / Deskripsi Masalah*</label>
                        <textarea name="keluhan" rows="4" required
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('keluhan') border-red-500 @enderror"
                            placeholder="Jelaskan masalah motor Anda secara detail...">{{ old('keluhan') }}</textarea>
                        @error('keluhan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Tambahan (Opsional)</label>
                        <textarea name="catatan" rows="2"
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Informasi tambahan yang perlu diketahui mekanik...">{{ old('catatan') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Summary -->
            <div class="bg-blue-50 rounded-lg p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-600">Total Pembayaran</p>
                        <p class="text-2xl font-bold text-blue-600" id="total_price">Rp 0</p>
                    </div>
                    <div>
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                            Booking Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            const hargaService = @json($jenisServices->pluck('harga', 'id'));
            const priceElement = document.getElementById('total_price');
            const serviceSelect = document.getElementById('jenis_service_id');

            function updatePrice() {
                const selectedService = serviceSelect.value;
                if (selectedService && hargaService[selectedService]) {
                    const price = new Intl.NumberFormat('id-ID').format(hargaService[selectedService]);
                    priceElement.textContent = `Rp ${price}`;
                } else {
                    priceElement.textContent = 'Rp 0';
                }
            }

            serviceSelect.addEventListener('change', updatePrice);
            updatePrice();
        </script>
    @endpush
@endsection
