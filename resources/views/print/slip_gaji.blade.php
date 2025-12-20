<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - {{ $penarikan_gaji->user->nama ?? '' }}</title>
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
        .signature-section {
            margin-top: 10px;
            text-align: right;
            font-size: 9px;
        }
        .signature-box {
            display: inline-block;
            text-align: center;
            margin-top: 5px;
        }
        .signature-box img {
            max-width: 60px;
            height: auto;
            margin: 5px 0;
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
    @php
        $nama_pegawai = $penarikan_gaji->user->nama ?? 'N/A';
        $tanggal_mulai = $penarikan_gaji->mulai_tanggal ?? now();
        $tanggal_akhir = $penarikan_gaji->akhir_tanggal ?? now();
    @endphp

    <div class="header">
        @if(file_exists(public_path('favicon.png')))
        <img src="{{ asset('favicon.png') }}" alt="Logo">
        @endif
        <div class="title">SLIP GAJI</div>
        <div class="subtitle">{{ date('d/m/Y', strtotime($tanggal_mulai)) }} - {{ date('d/m/Y', strtotime($tanggal_akhir)) }}</div>
    </div>

    <div class="info-row">
        <span class="label">Nama:</span> {{ $nama_pegawai }}
    </div>
    <div class="info-row">
        <strong>Periode:</strong> {{ date('d M Y', strtotime($tanggal_mulai)) }} - {{ date('d M Y', strtotime($tanggal_akhir)) }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:40%;">Pekerjaan</th>
                <th style="width:12%; text-align:center;">Qty</th>
                <th style="width:24%; text-align:right;">Upah</th>
                <th style="width:24%; text-align:right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_gaji = 0;
            @endphp
            @foreach($detail_gaji_pegawais as $detail)
                @php
                    $total_gaji += $detail->total_gaji_per_pekerjaan;
                @endphp
                <tr>
                    <td>{{ $detail->nama_pekerjaan }}</td>
                    <td style="text-align:center;">{{ $detail->total_jumlah_kegiatan }}</td>
                    <td style="text-align:right;">{{ number_format($detail->gaji_per_pekerjaan, 0, ',', '.') }}</td>
                    <td style="text-align:right;">{{ number_format($detail->total_gaji_per_pekerjaan, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row grand-total">
            <table>
                <tr>
                    <td style="width:50%; text-align:left;">TOTAL GAJI:</td>
                    <td style="width:50%; text-align:right; font-weight:bold;">Rp {{ number_format($total_gaji, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="signature-section">
        <div style="border-top:1px dashed #000; padding-top:8px; margin-top:8px;">
            <div class="signature-box">
                <div style="margin-bottom:3px;">Mengetahui,</div>
                @if(file_exists(public_path('images/ttd.png')))
                <img src="{{ asset('images/ttd.png') }}" alt="TTD">
                @else
                <div style="height:40px; margin:5px 0;"></div>
                @endif
                <div style="border-top:1px solid #000; padding-top:3px; font-weight:bold;">
                    Owner/Pimpinan
                </div>
            </div>
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
