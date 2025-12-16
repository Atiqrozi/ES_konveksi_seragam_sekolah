<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $invoice->invoice ?? '' }}</title>
    <style>
        @page {
            margin: 0;
            size: 80mm auto;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 5px;
            width: 80mm;
            height: auto;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
        }
        .info-row {
            margin: 3px 0;
            font-size: 8px;
        }
        .label {
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }
        th {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 3px 2px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 2px;
            border-bottom: 1px dashed #ddd;
        }
        .total-section {
            border-top: 1px solid #000;
            margin-top: 5px;
            padding-top: 5px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 2px 0;
            font-size: 9px;
        }
        .grand-total {
            font-weight: bold;
            font-size: 10px;
            border-top: 1px solid #000;
            padding-top: 3px;
            margin-top: 3px;
        }
        img {
            max-width: 50px;
            height: auto;
        }
    </style>
</head>
<body>
    @php
        // Optimasi: hitung total di PHP untuk mengurangi loop
        $total_subtotal = 0;
        foreach($pesanans as $pesanan) {
            if (isset($pesanan->jumlah_pesanan) && isset($pesanan->harga)) {
                $total_subtotal += $pesanan->jumlah_pesanan * $pesanan->harga;
            }
        }
    @endphp
    
    <div class="header">
        @php
            $logoPath = public_path('favicon.png');
            $logoExists = file_exists($logoPath);
        @endphp
        
        @if($logoExists)
            <img src="{{ $logoPath }}" alt="Logo" style="max-width: 50px; height: auto; margin-bottom: 5px;">
        @endif
        
        <div style="font-weight:bold; font-size:11px; margin-top:3px;">INVOICE</div>
        <div style="font-size:8px;">{{ $invoice->invoice ?? 'N/A' }}</div>
        <div style="font-size:7px;">{{ date('d/m/Y H:i', strtotime($invoice->created_at ?? now())) }}</div>
    </div>

    <div class="info-row">
        <span class="label">Kepada:</span> {{ $invoice->user->nama ?? 'N/A' }}
    </div>
    <div class="info-row" style="font-size:7px;">
        {{ $invoice->user->alamat ?? 'N/A' }}
    </div>
    <div class="info-row" style="font-size:7px;">
        {{ $invoice->user->no_telepon ?? 'N/A' }}
    </div>

    <table style="margin-top:8px;">
        <thead>
            <tr>
                <th style="width:35%;">Item</th>
                <th style="width:15%; text-align:center;">Ukr</th>
                <th style="width:10%; text-align:center;">Qty</th>
                <th style="width:20%; text-align:right;">Harga</th>
                <th style="width:20%; text-align:right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanans as $pesanan)
                @if (isset($pesanan->jumlah_pesanan) && isset($pesanan->harga))
                    <tr>
                        <td style="font-size:7px;">{{ $pesanan->produk->nama_produk ?? 'N/A' }}</td>
                        <td style="text-align:center;">{{ $pesanan->ukuran ?? '-' }}</td>
                        <td style="text-align:center;">{{ $pesanan->jumlah_pesanan }}</td>
                        <td style="text-align:right; font-size:7px;">{{ number_format($pesanan->harga, 0, ',', '.') }}</td>
                        <td style="text-align:right; font-size:7px;">{{ number_format($pesanan->jumlah_pesanan * $pesanan->harga, 0, ',', '.') }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>Rp {{ number_format($total_subtotal, 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            <span>Tagihan Sebelumnya:</span>
            <span>Rp {{ number_format($invoice->tagihan_sebelumnya ?? 0, 0, ',', '.') }}</span>
        </div>
        <div class="total-row grand-total">
            <span>TOTAL TAGIHAN:</span>
            <span>Rp {{ number_format($invoice->tagihan_total ?? 0, 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            <span>Jumlah Bayar:</span>
            <span>Rp {{ number_format($invoice->jumlah_bayar ?? 0, 0, ',', '.') }}</span>
        </div>
        <div class="total-row" style="font-weight:bold;">
            <span>Sisa Tagihan:</span>
            <span>Rp {{ number_format($invoice->tagihan_sisa ?? 0, 0, ',', '.') }}</span>
        </div>
    </div>

    <div style="text-align:center; margin-top:10px; font-size:7px; border-top:1px dashed #000; padding-top:5px;">
        Terima Kasih
    </div>
</body>
</html>
