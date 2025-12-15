<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            width: 300px;
            margin: 0 auto;
            padding: 15px;
            font-size: 12px;
            background: #f5f5f5;
        }

        .receipt {
            background: white;
            padding: 15px;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #333;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .store-name {
            font-size: 18px;
            font-weight: bold;
            margin: 5px 0;
        }

        .store-info {
            font-size: 10px;
            color: #666;
            line-height: 1.3;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
            font-size: 11px;
        }

        .divider {
            border-top: 1px dashed #999;
            margin: 8px 0;
        }

        .item {
            margin: 8px 0;
        }

        .item-name {
            font-weight: bold;
            font-size: 11px;
        }

        .item-detail {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            color: #555;
        }

        .total-section {
            margin-top: 10px;
            padding-top: 8px;
            border-top: 1px solid #333;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 4px 0;
            font-size: 11px;
        }

        .total-row.grand {
            font-size: 13px;
            font-weight: bold;
            margin-top: 6px;
            padding-top: 6px;
            border-top: 1px solid #999;
        }

        .footer {
            text-align: center;
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px solid #333;
        }

        .thank-you {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .footer-note {
            font-size: 9px;
            color: #888;
            line-height: 1.4;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="receipt">
        <div class="header">
            <div class="store-name">SATURN MART</div>
            <div class="store-info">
                Jl. Saturnus Sono No. 123<br>
                Telp: 0812-3456-7890
            </div>
        </div>

        <div style="text-align: center; font-weight: bold; font-size: 11px; margin-bottom: 8px;">
            STRUK PEMBELIAN
        </div>

        <div class="info-row">
            <span>No. Transaksi</span>
            <span>#{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="info-row">
            <span>Tanggal</span>
            <span>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d/m/Y H:i') }}</span>
        </div>
        <div class="info-row">
            <span>Kasir</span>
            <span>{{ $transaction->user->name }}</span>
        </div>

        <div class="divider"></div>

        @foreach($transaction->items as $item)
        <div class="item">
            <div class="item-name">{{ $item->product->name }}</div>
            <div class="item-detail">
                <span>{{ $item->quantity }} x Rp {{ number_format($item->price_at_sale) }}</span>
                <span>Rp {{ number_format($item->subtotal) }}</span>
            </div>
        </div>
        @endforeach

        <div class="total-section">
            <div class="total-row">
                <span>Total</span>
                <span>Rp {{ number_format($transaction->total_amount) }}</span>
            </div>
            <div class="total-row">
                <span>Dibayar</span>
                <span>Rp {{ number_format($transaction->paid_amount) }}</span>
            </div>
            <div class="total-row grand">
                <span>Kembalian</span>
                <span>Rp {{ number_format($transaction->change_amount) }}</span>
            </div>
        </div>

        <div class="footer">
            <div class="thank-you">Terima Kasih</div>
            <div class="footer-note">
                Barang yang sudah dibeli tidak dapat<br>
                ditukar atau dikembalikan
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            // Auto download PDF saat halaman load
            const { jsPDF } = window.jspdf;

            html2canvas(document.querySelector('.receipt'), {
                scale: 3,
                backgroundColor: '#ffffff',
                logging: false
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF({
                    orientation: 'portrait',
                    unit: 'mm',
                    format: [80, 297] // Ukuran thermal printer (80mm width)
                });

                const imgWidth = 80;
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
                pdf.save('Struk-{{ str_pad($transaction->id, 6, "0", STR_PAD_LEFT) }}.pdf');

                // Redirect setelah download
                setTimeout(function() {
                    window.location.href = "{{ route('kasir.history') }}";
                }, 500);
            });
        };
    </script>
</body>
</html>
