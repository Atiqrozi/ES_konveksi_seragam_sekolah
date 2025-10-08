<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gaji Per Produk List - {{ now() }}</title>
    <style>
        table {
            width: 100%;
        }
    </style>
</head>
<body>
    <img src="{{ public_path('images/header.png') }}" style="max-width:100%">

    <h1 style="color: #800000; text-align: center; padding: 20px">Gaji Per Produk List List - {{ now() }}</h1>
    
    <table border="1" style="border-collapse: collapse;">
        <thead style="color: #800000">
            <tr>
                <th style="padding: 10px; text-align: center">
                    ID
                </th>
                <th style="padding: 10px; text-align: center">
                    Nama Produk
                </th>
                <th style="padding: 10px; min-width: 50px; text-align: center">
                    Gaji Per Produk
                </th>
                <th style="padding: 10px; text-align: center; min-width: 100px;">
                    Created At
                </th>
                <th style="padding: 10px; text-align: center; min-width: 100px;">
                    Updated At
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($gaji_per_produks as $gaji_per_produk)
                <tr>
                    <td style="padding: 10px; text-align:center">
                        {{ $gaji_per_produk->id }}
                    </td>
                    <td style="padding: 10px;">
                        {{ $gaji_per_produk->produk->nama_produk }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ IDR($gaji_per_produk->gaji_per_produk) }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $gaji_per_produk->created_at }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $gaji_per_produk->updated_at }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
