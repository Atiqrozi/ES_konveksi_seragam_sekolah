<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Stok Produk List - {{ now() }}</title>
    <style>
        table {
            width: 100%;
        }
    </style>
</head>
<body>
    <img src="{{ public_path('images/header.png') }}" style="max-width:100%">

    <h1 style="color: #800000; text-align: center; padding: 20px">Riwayat Stok Produk List - {{ now() }}</h1>
    
    <table border="1" style="border-collapse: collapse;">
        <thead style="color: #800000">
            <tr>
                <th style="padding: 10px; text-align: center">
                    ID
                </th>
                <th style="padding: 10px; min-width: 100px; text-align: center">
                    Nama Produk
                </th>
                <th style="padding: 10px; min-width: 100px; text-align: center">
                    Ukuran Produk
                </th>
                <th style="padding: 10px; min-width: 100px; text-align: center">
                    Stok Masuk
                </th>
                <th style="padding: 10px; min-width: 100px; text-align: center">
                    Catatan
                </th>
                <th style="padding: 10px; min-width: 100px; text-align: center">
                    Dibuat Pada
                </th>
                <th style="padding: 10px; min-width: 100px; text-align: center">
                    Diperbarui Pada
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayat_stok_produks as $riwayat_stok_produk)
                <tr>
                    <td style="padding: 10px;">
                        {{ $riwayat_stok_produk->id }}
                    </td>
                    <td style="padding: 10px;">
                        {{ $riwayat_stok_produk->produk->nama_produk }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $riwayat_stok_produk->ukuran_produk }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $riwayat_stok_produk->stok_masuk }}
                    </td>
                    <td style="padding: 10px; text-align:justify;">
                        {{ $riwayat_stok_produk->catatan }}
                    </td>
                    <td style="padding: 10px; text-align:center;">
                        {{ $riwayat_stok_produk->created_at }}
                    </td>
                    <td style="padding: 10px; text-align:center;">
                        {{ $riwayat_stok_produk->updated_at }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
