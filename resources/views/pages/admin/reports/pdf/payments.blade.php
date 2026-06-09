{{-- resources/views/admin/reports/pdf/payments.blade.php --}}
@extends('pages.admin.reports.pdf.master')

@section('content')
    <div class="summary">
        <h3>Ringkasan Pembayaran</h3>
        <div class="summary-grid">
            <div class="summary-card">
                <div class="label">Total Transaksi</div>
                <div class="value">{{ number_format($stats['total_transactions']) }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Total Pendapatan</div>
                <div class="value">Rp {{ number_format($stats['total_amount'], 0, ',', '.') }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Rata-rata per Transaksi</div>
                <div class="value">Rp
                    {{ number_format($stats['total_transactions'] > 0 ? $stats['total_amount'] / $stats['total_transactions'] : 0, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    @if ($stats['by_payment_method']->count() > 0)
        <div style="margin-bottom: 20px;">
            <h3 style="font-size: 12px; margin-bottom: 10px;">Statistik per Metode Pembayaran</h3>
            <table style="width: 400px;">
                <thead>
                    <tr>
                        <th>Metode Pembayaran</th>
                        <th class="text-right">Jumlah</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stats['by_payment_method'] as $method => $data)
                        <tr>
                            <td>{{ ucfirst(str_replace('_', ' ', $method)) }}</td>
                            <td class="text-right">{{ number_format($data['total']) }}</td>
                            <td class="text-right">Rp {{ number_format($data['amount'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background-color: #f3f4f6;">
                        <td class="text-right"><strong>Total</strong></td>
                        <td class="text-right"><strong>{{ number_format($stats['total_transactions']) }}</strong></td>
                        <td class="text-right"><strong>Rp {{ number_format($stats['total_amount'], 0, ',', '.') }}</strong>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Kode Booking</th>
                <th>Customer</th>
                <th>Service</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->booking_code }}</td>
                    <td>{{ $payment->customer->user->name ?? 'N/A' }}</td>
                    <td>{{ $payment->jenisService->nama_service ?? 'N/A' }}</td>
                    <td class="text-right">Rp {{ number_format($payment->total_bayar, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data pembayaran</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="background-color: #f3f4f6;">
                <td colspan="3" class="text-right"><strong>Grand Total</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($stats['total_amount'], 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>
@endsection
