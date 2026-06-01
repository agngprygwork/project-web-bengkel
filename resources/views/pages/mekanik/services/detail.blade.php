{{-- resources/views/mekanik/services/detail.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Service')
@section('page-title', 'Detail Service #' . $booking->booking_code)

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Customer & Service Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h3 class="text-white font-semibold">Informasi Customer</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div>
                        <label class="text-sm text-gray-500">Nama</label>
                        <p class="font-medium">{{ $booking->customer->user->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">No. Telepon</label>
                        <p>{{ $booking->customer->no_hp ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Alamat</label>
                        <p>{{ $booking->customer->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                    <h3 class="text-white font-semibold">Informasi Service</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div>
                        <label class="text-sm text-gray-500">Jenis Service</label>
                        <p class="font-medium">{{ $booking->jenisService->nama_service }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Tanggal & Waktu</label>
                        <p>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }} -
                            {{ $booking->waktu_booking }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Keluhan Customer</label>
                        <p class="text-gray-700">{{ $booking->keluhan }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Update -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-yellow-600 to-yellow-700 px-6 py-4">
                <h3 class="text-white font-semibold">Update Status</h3>
            </div>
            <div class="p-6">
                <div class="flex gap-3">
                    @if ($booking->status == 'dijadwalkan')
                        <form action="{{ route('mekanik.services.start', $booking) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                                Mulai Service
                            </button>
                        </form>
                    @endif

                    @if ($booking->status == 'diproses')
                        <button onclick="openCompleteModal()"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                            Selesaikan Service
                        </button>
                    @endif

                    <span
                        class="px-3 py-2 text-sm rounded-full 
                    @if ($booking->status == 'dijadwalkan') bg-blue-100 text-blue-800
                    @elseif($booking->status == 'diproses') bg-yellow-100 text-yellow-800
                    @elseif($booking->status == 'menunggu_pembayaran') bg-purple-100 text-purple-800
                    @elseif($booking->status == 'selesai') bg-green-100 text-green-800 @endif">
                        Status: {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Complete Service -->
    <div id="completeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-lg bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Selesaikan Service</h3>
                <button onclick="closeCompleteModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>

            <form action="{{ route('mekanik.services.complete', $booking) }}" method="POST" id="completeForm">
                @csrf
                <div class="space-y-4 max-h-96 overflow-y-auto p-2">
                    <!-- Hasil Pemeriksaan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hasil Pemeriksaan *</label>
                        <textarea name="hasil_pemeriksaan" rows="3" required
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Jelaskan hasil pemeriksaan kendaraan..."></textarea>
                    </div>

                    <!-- Tindakan Service -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tindakan Service *</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2 mb-3">
                            @foreach (['Tune Up', 'Ganti Oli', 'Ganti Busi', 'Service CVT', 'Service Karburator', 'Ganti Kampas Rem', 'Service Kelistrikan'] as $tindakan)
                                <label class="flex items-center">
                                    <input type="checkbox" value="{{ $tindakan }}" onclick="addTindakan(this)"
                                        class="mr-2">
                                    <span class="text-sm">{{ $tindakan }}</span>
                                </label>
                            @endforeach
                        </div>
                        <textarea name="tindakan_service" id="tindakan_service" rows="3" required
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Atau tulis tindakan service secara manual..."></textarea>
                    </div>

                    <!-- Sparepart -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sparepart yang Digunakan</label>
                        <div id="sparepartContainer">
                            <div class="flex gap-2 mb-2">
                                <select name="spareparts[0][id]" class="flex-1 border-gray-300 rounded-lg sparepart-select">
                                    <option value="">Pilih Sparepart</option>
                                    @foreach ($spareparts as $sparepart)
                                        <option value="{{ $sparepart->id }}" data-price="{{ $sparepart->harga_jual }}"
                                            data-stock="{{ $sparepart->stok }}">
                                            {{ $sparepart->nama_sparepart }} - Rp
                                            {{ number_format($sparepart->harga_jual, 0, ',', '.') }} (Stok:
                                            {{ $sparepart->stok }})
                                        </option>
                                    @endforeach
                                </select>
                                <input type="number" name="spareparts[0][quantity]" placeholder="Jumlah" min="1"
                                    class="w-24 border-gray-300 rounded-lg sparepart-qty">
                                <button type="button" onclick="removeSparepart(this)"
                                    class="bg-red-500 text-white px-2 rounded">×</button>
                            </div>
                        </div>
                        <button type="button" onclick="addSparepart()" class="text-blue-600 text-sm mt-2">+ Tambah
                            Sparepart</button>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
                    <button type="button" onclick="closeCompleteModal()"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Selesaikan Service
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            let sparepartIndex = 1;

            function openCompleteModal() {
                document.getElementById('completeModal').classList.remove('hidden');
            }

            function closeCompleteModal() {
                document.getElementById('completeModal').classList.add('hidden');
                document.getElementById('completeForm').reset();
                sparepartIndex = 1;
                document.getElementById('sparepartContainer').innerHTML = `
            <div class="flex gap-2 mb-2">
                <select name="spareparts[0][id]" class="flex-1 border-gray-300 rounded-lg sparepart-select">
                    <option value="">Pilih Sparepart</option>
                    @foreach ($spareparts as $sparepart)
                    <option value="{{ $sparepart->id }}" data-price="{{ $sparepart->harga_jual }}" data-stock="{{ $sparepart->stok }}">
                        {{ $sparepart->nama_sparepart }} - Rp {{ number_format($sparepart->harga_jual, 0, ',', '.') }} (Stok: {{ $sparepart->stok }})
                    </option>
                    @endforeach
                </select>
                <input type="number" name="spareparts[0][quantity]" placeholder="Jumlah" min="1" class="w-24 border-gray-300 rounded-lg sparepart-qty">
                <button type="button" onclick="removeSparepart(this)" class="bg-red-500 text-white px-2 rounded">×</button>
            </div>
        `;
            }

            function addSparepart() {
                const container = document.getElementById('sparepartContainer');
                const newDiv = document.createElement('div');
                newDiv.className = 'flex gap-2 mb-2';
                newDiv.innerHTML = `
            <select name="spareparts[${sparepartIndex}][id]" class="flex-1 border-gray-300 rounded-lg sparepart-select">
                <option value="">Pilih Sparepart</option>
                @foreach ($spareparts as $sparepart)
                <option value="{{ $sparepart->id }}" data-price="{{ $sparepart->harga_jual }}" data-stock="{{ $sparepart->stok }}">
                    {{ $sparepart->nama_sparepart }} - Rp {{ number_format($sparepart->harga_jual, 0, ',', '.') }} (Stok: {{ $sparepart->stok }})
                </option>
                @endforeach
            </select>
            <input type="number" name="spareparts[${sparepartIndex}][quantity]" placeholder="Jumlah" min="1" class="w-24 border-gray-300 rounded-lg sparepart-qty">
            <button type="button" onclick="removeSparepart(this)" class="bg-red-500 text-white px-2 rounded">×</button>
        `;
                container.appendChild(newDiv);
                sparepartIndex++;
            }

            function removeSparepart(btn) {
                btn.parentElement.remove();
            }

            function addTindakan(checkbox) {
                const textarea = document.getElementById('tindakan_service');
                let currentValue = textarea.value;
                const value = checkbox.value;

                if (checkbox.checked) {
                    if (currentValue) {
                        textarea.value = currentValue + ', ' + value;
                    } else {
                        textarea.value = value;
                    }
                } else {
                    textarea.value = currentValue.replace(value, '').replace(',,', ',').replace(/^,/, '').replace(/,$/, '')
                        .trim();
                }
            }
        </script>
    @endpush
@endsection
