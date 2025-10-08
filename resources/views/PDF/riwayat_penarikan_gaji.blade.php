<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Penarikan Gaji (Semua) List - {{ now() }}</title>
    <style>
        table {
            width: 100%;
        }
    </style>
</head>
<body>
    <img src="{{ public_path('images/header.png') }}" style="max-width:100%">

    <h1 style="color: #800000; text-align: center; padding: 20px">Riwayat Penarikan Penarikan Gaji (Semua) List - {{ now() }}</h1>
    
    <table border="1" style="border-collapse: collapse;">
        <thead style="color: #800000">
            <tr>
                <th style="padding: 10px; text-align: center;">
                    ID
                </th>
                <th style="padding: 10px; text-align: center;">
                    Nama Pegawai
                </th>
                <th style="padding: 10px; text-align: center;">
                    Gaji Ditarik
                </th>
                <th style="padding: 10px; text-align: center;">
                    Status
                </th>
                <th style="padding: 10px; text-align: center;">
                    Terhitung Tanggal
                </th>
                <th style="padding: 10px; text-align: center;">
                    Sampai Tanggal
                </th>
                <th style="padding: 10px; text-align: center;">
                    Gaji Diberikan Tanggal
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayat_penarikan_gajis as $riwayat_penarikan_gaji)
                <tr>
                    <td style="padding: 10px; text-align:center">
                        {{ $riwayat_penarikan_gaji->id }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $riwayat_penarikan_gaji->user->nama }}
                    </td>
                    <td style="padding: 10px; text-align: center">
                        {{ IDR($riwayat_penarikan_gaji->gaji_yang_diajukan) }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $riwayat_penarikan_gaji->status }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $riwayat_penarikan_gaji->mulai_tanggal }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $riwayat_penarikan_gaji->akhir_tanggal }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $riwayat_penarikan_gaji->gaji_diberikan }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
