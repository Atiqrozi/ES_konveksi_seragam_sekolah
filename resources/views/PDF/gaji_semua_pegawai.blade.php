<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gaji Semua Pegawai - {{ now() }}</title>
    <style>
        table {
            width: 100%;
        }
    </style>
</head>
<body>
    <img src="{{ public_path('images/header.png') }}" style="max-width:100%">

    <h1 style="color: #800000; text-align: center; padding: 20px">Gaji Semua Pegawai - {{ now() }}</h1>
    
    <table border="1" style="border-collapse: collapse;">
        <thead style="color: #800000">
            <tr>
                <th style="padding: 10px; text-align: center">
                    ID
                </th>
                <th style="padding: 10px; text-align: center">
                    Nama Pegawai
                </th>
                <th style="padding: 10px; min-width: 50px; text-align: center">
                    Gaji Tersedia
                </th>
                <th style="padding: 10px; text-align: center; min-width: 100px;">
                    Terhitung Tanggal
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($gaji_semua_pegawais as $gaji_semua_pegawai)
                <tr>
                    <td style="padding: 10px; text-align:center">
                        {{ $gaji_semua_pegawai->id }}
                    </td>
                    <td style="padding: 10px;">
                        {{ $gaji_semua_pegawai->user->nama }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ IDR($gaji_semua_pegawai->total_gaji_yang_bisa_diajukan) }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $gaji_semua_pegawai->updated_at }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
