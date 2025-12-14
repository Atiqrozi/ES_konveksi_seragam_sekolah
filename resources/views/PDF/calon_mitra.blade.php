<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calon Mitra List - {{ now() }}</title>
</head>
<body>
    <img src="{{ public_path('images/header.png') }}" style="max-width:100%">
    
    <h1 style="color: #800000; text-align: center; padding: 20px">Calon Mitra List - {{ now() }}</h1>

    <table border="1" style="border-collapse: collapse; width: 100%;">
        <thead style="color: #800000">
            <tr>
                <th style="padding: 10px; text-align: center;">
                    ID
                </th>
                <th style="padding: 10px; text-align: center;">
                    Nama
                </th>
                <th style="padding: 10px; text-align: center;">
                    Nomor Whatsapp
                </th>
                <th style="padding: 10px; text-align: center;">
                    Alamat
                </th>
                <th style="padding: 10px; text-align: center;">
                    Dibuat Pada
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($calon_mitras as $calon_mitra)
                <tr>
                    <td style="padding: 10px; text-align:center">
                        {{ $calon_mitra->id }}
                    </td>
                    <td style="padding: 10px;">
                        {{ $calon_mitra->nama }}
                    </td>
                    <td style="padding: 10px;">
                        {{ $calon_mitra->nomor_wa }}
                    </td>
                    <td style="padding: 10px;">
                        {{ $calon_mitra->alamat }}
                    </td>
                    <td style="padding: 10px; max-width: 250px; text-align: center;">
                        {{ $calon_mitra->created_at }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
