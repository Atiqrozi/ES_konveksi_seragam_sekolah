<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posisi Lowongan List - {{ now() }}</title>
    <style>
        table {
            width: 100%;
        }
    </style>
</head>
<body>
    <img src="{{ public_path('images/header.png') }}" style="max-width:100%">

    <h1 style="color: #800000; text-align: center; padding: 20px">Posisi Lowongan List - {{ now() }}</h1>
    
    <table border="1" style="border-collapse: collapse;">
        <thead style="color: #800000">
            <tr>
                <th style="padding: 10px; text-align: center">
                    ID
                </th>
                <th style="padding: 10px; min-width:150px; text-align: center">
                    Nama Posisi
                </th>
                <th style="padding: 10px; text-align: center">
                    Deskripsi Posisi
                </th>
                <th style="padding: 10px; min-width:100px; text-align: center">
                    Created At
                </th>
                <th style="padding: 10px; min-width:100px; text-align: center">
                    Updated At
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($posisi_lowongans as $posisi_lowongan)
                <tr>
                    <td style="padding: 10px; text-align:center">
                        {{ $posisi_lowongan->id }}
                    </td>
                    <td style="padding: 10px;">
                        {{ $posisi_lowongan->nama_posisi }}
                    </td>
                    <td style="padding: 10px; text-align:justify">
                        {{ $posisi_lowongan->deskripsi_posisi }}
                    </td>
                    <td style="padding: 10px; text-align:center">
                        {{ $posisi_lowongan->created_at }}
                    </td>
                    <td style="padding: 10px; text-align:center">
                        {{ $posisi_lowongan->updated_at }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
