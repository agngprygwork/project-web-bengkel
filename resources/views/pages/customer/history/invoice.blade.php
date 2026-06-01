{{-- resources/views/pages/customer/history/invoice.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice {{ $booking->booking_code }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 2px solid #2563eb;
        }

        .header h1 {
            color: #2563eb;
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .info-section {
            margin-bottom: 20px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 5px;
        }

        .service-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .service-table th {
            background-color: #2563eb;
            color: white;
            padding: 10px;
            text-align: left;
        }

        .service-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .service-table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .total-section {
            text-align: right;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #ddd;
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>INVOICE</h1>
        <p>Sistem Booking Servis Bengkel Motor</p>
        <p>Jl. Merdeka No. 123, Jakarta</p>
    </div>

    <div class="info-section">
        <table class="info-table">
            <tr>
                <td width="50%">
                    <strong>Invoice No:</strong> {{ $booking->booking_code }}<br>
                    <strong>Tanggal:</strong> {{ $booking->updated_at->format('d/m/Y H:i') }}
                </td>
                <td width="50%" class="text-right">
                    <strong>Customer:</strong> {{ $booking->customer->user->name }}<br>
                    <strong>Email:</strong> {{ $booking->customer->user->email }}
                </td>
            </tr>
        </table>
    </div>

    <h3>Detail Service</h3>
    <table class="service-table">
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th class="text-right">Quantity</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $booking->jenisService->nama_service }}</td>
                <td class="text-right">1</td>
                <td class="text-right">Rp {{ number_format($booking->jenisService->harga, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($booking->jenisService->harga, 0, ',', '.') }}</td>
            </tr>
            @foreach ($usedSpareparts as $sparepart)
                <tr>
                    <td>{{ $sparepart->nama_sparepart }} ({{ $sparepart->satuan }})</td>
                    <td class="text-right">{{ number_format($sparepart->quantity) }}</td>
                    <td class="text-right">Rp {{ number_format($sparepart->price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($sparepart->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <table width="100%">
            <tr>
                <td width="70%" class="text-right"><strong>Subtotal:</strong></td>
                <td width="30%" class="text-right">Rp
                    {{ number_format($booking->jenisService->harga, 0, ',', '.') }}</td>
            </tr>
            @if ($usedSpareparts->sum('subtotal') > 0)
                <tr>
                    <td class="text-right"><strong>Biaya Sparepart:</strong></td>
                    <td class="text-right">Rp {{ number_format($usedSpareparts->sum('subtotal'), 0, ',', '.') }}</td>
                </tr>
            @endif
            <tr>
                <td class="text-right"><strong>Total Dibayar:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($booking->total_bayar, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td class="text-right"><strong>Status Pembayaran:</strong></td>
                <td class="text-right">
                    <strong>{{ $booking->status_pembayaran == 'lunas' ? 'LUNAS' : strtoupper($booking->status_pembayaran) }}</strong>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Terima kasih telah menggunakan layanan kami!</p>
        <p>Dokumen ini dicetak secara otomatis oleh sistem.</p>
    </div>
</body>

</html>
