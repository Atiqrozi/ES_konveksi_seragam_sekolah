<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $invoice->invoice }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        @page {
            size: auto;
            margin: 5mm;
        }
        html, body {
            width: 100%;
            height: auto;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            max-width: 80mm;
            margin: 0 auto;
            padding: 5mm;
        }
        @media print {
            body {
                max-width: 100%;
                padding: 0;
            }
        }
        .container {
            width: 100%;
            height: auto;
            display: block;
        }
        .header {
            text-align: center;
            margin-bottom: 8px;
            border-bottom: 2px dashed #000;
            padding-bottom: 5px;
        }
        .header img {
            max-width: 50px;
            height: auto;
        }
        .header .title {
            font-weight: bold;
            font-size: 14px;
            margin-top: 3px;
        }
        .header .subtitle {
            font-size: 9px;
        }
        .info-row {
            margin: 3px 0;
            font-size: 10px;
            line-height: 1.4;
        }
        .label {
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            margin-top: 8px;
        }
        th {
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            padding: 4px 2px;
            text-align: left;
            font-weight: bold;
            font-size: 9px;
        }
        td {
            padding: 3px 2px;
            border-bottom: 1px dashed #ddd;
            font-size: 9px;
        }
        .total-section {
            border-top: 2px solid #000;
            margin-top: 5px;
            padding-top: 5px;
        }
        .total-row {
            font-size: 11px;
            margin: 2px 0;
        }
        .total-row table {
            margin: 0;
        }
        .total-row td {
            border: none;
            padding: 2px 0;
            font-size: 11px;
        }
        .grand-total {
            font-weight: bold;
            border-top: 2px solid #000;
            padding-top: 4px;
            margin-top: 4px;
            font-size: 12px;
        }
        .footer {
            text-align: center;
            margin-top: 8px;
            font-size: 9px;
            border-top: 1px dashed #000;
            padding-top: 5px;
        }
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="header">
        @if(file_exists(public_path('favicon.png')))
        <img src="{{ asset('favicon.png') }}" alt="Logo">
        @endif
        <div class="title">INVOICE</div>
        <div class="subtitle">{{ $invoice->invoice }}</div>
        <div class="subtitle">{{ date('d/m/Y H:i', strtotime($invoice->created_at)) }}</div>
    </div>

    <div class="info-row">
        <span class="label">Customer:</span> {{ $invoice->user->nama ?? 'N/A' }}
    </div>
    <div class="info-row">
        <span class="label">Telepon:</span> {{ $invoice->user->telepon ?? '-' }}
    </div>
    <div class="info-row">
        <span class="label">Alamat:</span> {{ $invoice->user->alamat ?? '-' }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:38%;">Produk</th>
                <th style="width:12%; text-align:center;">Size</th>
                <th style="width:8%; text-align:center;">Qty</th>
                <th style="width:20%; text-align:right;">Harga</th>
                <th style="width:22%; text-align:right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanans as $pesanan)
                <tr>
                    <td>{{ $pesanan->produk->nama_produk ?? 'N/A' }}</td>
                    <td style="text-align:center;">{{ $pesanan->ukuran ?? '-' }}</td>
                    <td style="text-align:center;">{{ $pesanan->jumlah }}</td>
                    <td style="text-align:right;">{{ number_format($pesanan->harga, 0, ',', '.') }}</td>
                    <td style="text-align:right;">{{ number_format($pesanan->sub_total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <table>
                <tr>
                    <td style="width:50%; text-align:left;">Sub Total:</td>
                    <td style="width:50%; text-align:right;">Rp {{ number_format($invoice->tagihan_total, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
        <div class="total-row">
            <table>
                <tr>
                    <td style="width:50%; text-align:left;">Jumlah Bayar:</td>
                    <td style="width:50%; text-align:right;">Rp {{ number_format($invoice->jumlah_bayar ?? 0, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
        <div class="total-row grand-total">
            <table>
                <tr>
                    <td style="width:50%; text-align:left;">SISA TAGIHAN:</td>
                    <td style="width:50%; text-align:right; font-weight:bold;">Rp {{ number_format($invoice->tagihan_sisa ?? $invoice->tagihan_total, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="footer">
        Terima Kasih
    </div>
    </div>

    <script>
        // Auto-trigger print dialog when page loads
        window.addEventListener('load', function() {
            // Small delay to ensure content is fully rendered
            setTimeout(function() {
                window.print();
            }, 250);
        });
    </script>
</body>
</html>
