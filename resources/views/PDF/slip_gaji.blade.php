<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - {{ $gaji_pegawai->user->nama ?? $penarikan_gaji->user->nama ?? '' }}</title>
    <style>
        @page {
            margin: 0;
            size: 80mm auto;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8px;
            margin: 0;
            padding: 3mm;
            width: 74mm;
            max-width: 74mm;
            height: auto;
            box-sizing: border-box;
        }
        * {
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            margin-bottom: 6px;
            border-bottom: 1px dashed #000;
            padding-bottom: 3px;
        }
        .info-row {
            margin: 1px 0;
            font-size: 7px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .label {
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 6px;
            margin-top: 4px;
            table-layout: fixed;
        }
        th {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 2px 0px;
            text-align: left;
            font-weight: bold;
            font-size: 6px;
        }
        td {
            padding: 1px 0px;
            border-bottom: 1px dashed #ddd;
            font-size: 6px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .total-section {
            border-top: 1px solid #000;
            margin-top: 3px;
            padding-top: 3px;
        }
        .total-row {
            font-size: 8px;
            overflow: hidden;
        }
        .total-row table {
            width: 100%;
            margin: 0;
        }
        .total-row td {
            border: none;
            padding: 1px 0;
            font-size: 8px;
        }
        .grand-total {
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 2px;
            margin-top: 2px;
        }
        .signature-section {
            margin-top: 6px;
            text-align: right;
            font-size: 6px;
        }
        .signature-box {
            display: inline-block;
            text-align: center;
            margin-top: 2px;
        }
        img.logo {
            max-width: 35px;
            height: auto;
        }
        img.ttd {
            max-width: 40px;
            height: auto;
            margin: 2px 0;
        }
    </style>
</head>
<body>
    @php
        // Support untuk dua jenis data: gaji_pegawai (dari admin) atau penarikan_gaji (dari pegawai)
        $nama_pegawai = $gaji_pegawai->user->nama ?? $penarikan_gaji->user->nama ?? 'N/A';
        $tanggal_mulai = $gaji_pegawai->terhitung_tanggal ?? $penarikan_gaji->mulai_tanggal ?? now();
        $tanggal_akhir = $penarikan_gaji->akhir_tanggal ?? now();
        $total_gaji_value = $gaji_pegawai->total_gaji_yang_bisa_diajukan ?? $penarikan_gaji->gaji_yang_diajukan ?? 0;
    @endphp

    <div class="header">
        @if(file_exists(public_path('favicon.png')))
        <img src="{{ public_path('favicon.png') }}" alt="Logo" class="logo">
        @endif
        <div style="font-weight:bold; font-size:9px; margin-top:1px;">SLIP GAJI</div>
        <div style="font-size:5px;">{{ date('d/m/Y', strtotime($tanggal_mulai)) }} - {{ date('d/m/Y', strtotime($tanggal_akhir)) }}</div>
    </div>

    <div class="info-row">
        <span class="label">Nama:</span> {{ $nama_pegawai }}
    </div>
    <div class="info-row" style="font-size:5px;">
        Periode: {{ date('d M Y', strtotime($tanggal_mulai)) }} - {{ date('d M Y', strtotime($tanggal_akhir)) }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:38%;">Pekerjaan</th>
                <th style="width:10%; text-align:center;">Qty</th>
                <th style="width:24%; text-align:right; padding-right:2px;">Upah</th>
                <th style="width:28%; text-align:right; padding-right:2px;">Total</th>
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
                    <td style="padding-right:2px;">{{ $detail->nama_pekerjaan }}</td>
                    <td style="text-align:center;">{{ $detail->total_jumlah_kegiatan }}</td>
                    <td style="text-align:right; padding-right:2px;">{{ number_format($detail->gaji_per_pekerjaan, 0, ',', '.') }}</td>
                    <td style="text-align:right; padding-right:2px;">{{ number_format($detail->total_gaji_per_pekerjaan, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row grand-total">
            <table>
                <tr>
                    <td style="width:50%; text-align:left;">TOTAL GAJI:</td>
                    <td style="width:50%; text-align:right; font-weight:bold; padding-right:2px;">Rp {{ number_format($total_gaji, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="signature-section">
        <div style="border-top:1px dashed #000; padding-top:4px; margin-top:4px;">
            <div class="signature-box">
                <div style="margin-bottom:1px; font-size:5px;">Mengetahui,</div>
                @if(file_exists(public_path('images/ttd.png')))
                <img src="{{ public_path('images/ttd.png') }}" alt="TTD" class="ttd">
                @else
                <div style="height:30px; margin:2px 0;"></div>
                @endif
                <div style="border-top:1px solid #000; padding-top:1px; font-weight:bold; font-size:5px;">
                    Owner/Pimpinan
                </div>
            </div>
        </div>
    </div>

    <div style="text-align:center; margin-top:4px; font-size:5px; border-top:1px dashed #000; padding-top:2px;">
        Terima Kasih
    </div>
</body>
</html>
