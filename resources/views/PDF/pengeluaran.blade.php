<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengeluaran List - {{ now() }}</title>
    <style>
        table {
            width: 100%;
        }
    </style>
</head>
<body>
    <img src="{{ public_path('images/header.png') }}" style="max-width:100%">

    <h1 style="color: #800000; text-align: center; padding: 20px">Pengeluaran List - {{ now() }}</h1>

    <table border="1" style="border-collapse: collapse;">
        <thead style="color: #800000">
            <tr>
                <th style="padding: 10px; text-align: center">
                    ID
                </th>
                <th style="padding: 10px; text-align: center">
                    Jenis Pengeluaran
                </th>
                <th style="padding: 10px; min-width: 50px; text-align: center">
                    Rincian
                </th>
                <th style="padding: 10px; text-align: center; min-width: 100px;">
                    Jumlah
                </th>
                <th style="padding: 10px; text-align: center; min-width: 100px;">
                    Tanggal
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengeluarans as $pengeluaran)
                <tr>
                    <td style="padding: 10px; text-align:center">
                        {{ $pengeluaran->id }}
                    </td>
                    <td style="padding: 10px;">
                        {{ $pengeluaran->jenis_pengeluaran->nama_pengeluaran }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $pengeluaran->keterangan }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ IDR($pengeluaran->jumlah) }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $pengeluaran->tanggal }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
