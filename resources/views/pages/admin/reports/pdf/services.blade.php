{{-- resources/views/admin/reports/pdf/services.blade.php --}}
@extends('pages.admin.reports.pdf.master')

@section('content')
    <!-- Popular Services -->
    @if ($popularServices->count() > 0)
        <div style="margin-bottom: 20px;">
            <h3 style="font-size: 12px; margin-bottom: 10px;">Service Terpopuler</h3>
            <table>
                <thead>
                    <tr>
                        <th>Jenis Service</th>
                        <th class="text-right">Jumlah Booking</th>
                        <th class="text-right">Pendapatan</th>
                        <th class="text-right">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalBookings = $popularServices->sum('total');
                    @endphp
                    @foreach ($popularServices as $service)
                        <tr>
                            <td>{{ $service->jenisService->nama_service ?? 'N/A' }}</td>
                            <td class="text-right">{{ number_format($service->total) }}</td>
                            <td class="text-right">Rp
                                {{ number_format($service->total * ($service->jenisService->harga ?? 0), 0, ',', '.') }}
                            </td>
                            <td class="text-right">{{ number_format(($service->total / $totalBookings) * 100, 1) }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Mekanik Performance -->
    @if ($mekanikPerformance->count() > 0)
        <div style="margin-bottom: 20px;">
            <h3 style="font-size: 12px; margin-bottom: 10px;">Performa Mekanik</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nama Mekanik</th>
                        <th>Spesialis</th>
                        <th class="text-right">Jumlah Service</th>
                        <th class="text-right">Total Pendapatan</th>
                        <th class="text-right">Rata-rata per Service</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mekanikPerformance as $mekanik)
                        <tr>
                            <td>{{ $mekanik->mekanik->user->name ?? 'N/A' }}</td>
                            <td>{{ $mekanik->mekanik->spesialis ?? '-' }}</td>
                            <td class="text-right">{{ number_format($mekanik->total) }}</td>
                            <td class="text-right">Rp {{ number_format($mekanik->revenue, 0, ',', '.') }}</td>
                            <td class="text-right">Rp
                                {{ number_format($mekanik->total > 0 ? $mekanik->revenue / $mekanik->total : 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Sparepart Usage -->
    @if ($sparepartUsage->count() > 0)
        <div style="margin-bottom: 20px;">
            <h3 style="font-size: 12px; margin-bottom: 10px;">Sparepart Paling Sering Digunakan</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nama Sparepart</th>
                        <th class="text-right">Jumlah Digunakan</th>
                        <th class="text-right">Total Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sparepartUsage as $sparepart)
                        <tr>
                            <td>{{ $sparepart->nama_sparepart }}</td>
                            <td class="text-right">{{ number_format($sparepart->total_used) }} pcs</td>
                            <td class="text-right">Rp {{ number_format($sparepart->total_value, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background-color: #f3f4f6;">
                        <td class="text-right"><strong>Total</strong></td>
                        <td class="text-right"><strong>{{ number_format($sparepartUsage->sum('total_used')) }} pcs</strong>
                        </td>
                        <td class="text-right"><strong>Rp
                                {{ number_format($sparepartUsage->sum('total_value'), 0, ',', '.') }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif
@endsection
