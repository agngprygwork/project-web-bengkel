{{-- resources/views/admin/reports/pdf/master.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Laporan' }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
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

        .info {
            margin-bottom: 20px;
        }

        .info-table {
            width: 100%;
            font-size: 11px;
        }

        .info-table td {
            padding: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th {
            background-color: #2563eb;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }

        table td {
            border: 1px solid #ddd;
            padding: 6px;
            font-size: 10px;
        }

        table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #999;
            padding: 10px;
            border-top: 1px solid #ddd;
        }

        .summary {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f3f4f6;
            border-radius: 5px;
        }

        .summary h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
        }

        .summary-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .summary-card {
            flex: 1;
            padding: 8px;
            background-color: white;
            border-radius: 4px;
            text-align: center;
        }

        .summary-card .label {
            font-size: 10px;
            color: #666;
        }

        .summary-card .value {
            font-size: 16px;
            font-weight: bold;
            color: #2563eb;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
        }

        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-warning {
            background-color: #fed7aa;
            color: #92400e;
        }

        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .badge-info {
            background-color: #dbeafe;
            color: #1e40af;
        }

        @page {
            margin: 15mm;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ $title ?? 'Laporan' }}</h1>
        <p>{{ $subtitle ?? '' }}</p>
        <p>Sistem Booking Servis Bengkel Motor</p>
    </div>

    <div class="info">
        <table class="info-table">
            <tr>
                <td width="50%"><strong>Dicetak oleh:</strong> {{ $generated_by ?? 'System' }}</td>
                <td width="50%" class="text-right"><strong>Tanggal cetak:</strong>
                    {{ $generated_at ?? now()->format('d/m/Y H:i:s') }}</td>
            </tr>
        </table>
    </div>

    @yield('content')

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh Sistem Booking Servis Bengkel Motor</p>
    </div>
</body>

</html>
