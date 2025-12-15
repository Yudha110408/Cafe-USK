<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .info {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .total {
            margin-top: 20px;
            text-align: right;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENJUALAN</h1>
        <p>Saturn Mart POS System</p>
    </div>

    <div class="info">
        @if($startDate && $endDate)
            <strong>Periode:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
        @elseif($startDate)
            <strong>Dari:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}
        @elseif($endDate)
            <strong>Sampai:</strong> {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
        @else
            <strong>Periode:</strong> Semua
        @endif
        <br>
        <strong>Dicetak:</strong> {{ now()->format('d/m/Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No. Transaksi</th>
                <th>Kasir</th>
                <th>Items</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $i => $trx)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d/m/Y H:i') }}</td>
                <td>#{{ str_pad($trx->id, 6, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $trx->user->name }}</td>
                <td>{{ $trx->items->count() }}</td>
                <td>Rp {{ number_format($trx->total_amount) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total Penjualan: Rp {{ number_format($totalSales) }}
    </div>
</body>
</html>
