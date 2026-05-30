{{-- resources/views/admin/reports/pdf/bookings.blade.php --}}
@extends('pages.admin.reports.pdf.master')

@section('content')
    <div class="summary">
        <h3>Ringkasan Laporan</h3>
        <div class="summary-grid">
            <div class="summary-card">
                <div class="label">Total Booking</div>
                <div class="value">{{ number_format($stats['total']) }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Total Pendapatan</div>
                <div class="value">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Pending Payment</div>
                <div class="value">Rp {{ number_format($stats['pending_payment'], 0, ',', '.') }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Rata-rata per Booking</div>
                <div class="value">Rp
                    {{ number_format($stats['total'] > 0 ? $stats['total_revenue'] / $stats['total'] : 0, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal Booking</th>
                <th>Kode Booking</th>
                <th>Customer</th>
                <th>Service</th>
                <th>Mekanik</th>
                <th class="text-right">Total</th>
                <th>Status</th>
                <th>Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d/m/Y') }}</td>
                    <td>{{ $booking->booking_code }}</td>
                    <td>{{ $booking->customer->user->name ?? 'N/A' }}</td>
                    <td>{{ $booking->jenisService->nama_service ?? 'N/A' }}</td>
                    <td>{{ $booking->mekanik->user->name ?? '-' }}</td>
                    <td class="text-right">Rp {{ number_format($booking->total_bayar, 0, ',', '.') }}</td>
                    <td>
                        <span
                            class="badge 
                    @if ($booking->status == 'selesai') badge-success
                    @elseif($booking->status == 'pending') badge-warning
                    @elseif($booking->status == 'ditolak') badge-danger
                    @else badge-info @endif">
                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                        </span>
                    </td>
                    <td>
                        <span
                            class="badge 
                    @if ($booking->status_pembayaran == 'lunas') badge-success
                    @elseif($booking->status_pembayaran == 'pending') badge-warning
                    @else badge-danger @endif">
                            {{ ucfirst($booking->status_pembayaran) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data booking</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="background-color: #f3f4f6;">
                <td colspan="5" class="text-right"><strong>Grand Total</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>

    @if ($stats['by_status']->count() > 0)
        <div style="margin-top: 20px;">
            <h3 style="font-size: 12px; margin-bottom: 10px;">Statistik per Status</h3>
            <table style="width: 300px;">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th class="text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stats['by_status'] as $status => $total)
                        <tr>
                            <td>{{ ucfirst(str_replace('_', ' ', $status)) }}</td>
                            <td class="text-right">{{ number_format($total) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
