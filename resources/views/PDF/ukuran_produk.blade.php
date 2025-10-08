<!-- resources/views/produks/pdf.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ukuran Produk List - {{ now() }}</title>
    <style>
        table {
            width: 100%;
        }
    </style>
</head>
<body>
    <img src="{{ public_path('images/header.png') }}" style="max-width:100%">

    <h1 style="color: #800000; text-align: center; padding: 20px">Ukuran Produk List - {{ now() }}</h1>
    
    <table border="1" style="border-collapse: collapse;">
        <thead style="color: #800000">
            <tr>
                <th style="padding: 10px; text-align: center">
                    ID
                </th>
                <th style="padding: 10px; text-align: center">
                    Nama Produk
                </th>
                <th style="padding: 10px; text-align: center">
                    Ukuran
                </th>
                <th style="padding: 10px; text-align: center">
                    Stok
                </th>
                <th style="padding: 10px; text-align: center">
                    Harga Produk 1
                </th>
                <th style="padding: 10px; text-align: center">
                    Harga Produk 2
                </th>
                <th style="padding: 10px; text-align: center">
                    Harga Produk 3
                </th>
                <th style="padding: 10px; text-align: center">
                    Harga Produk 4
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
            @foreach($ukuran_produks as $ukuran_produk)
                <tr>
                    <td style="padding: 10px; text-align:center">
                        {{ $ukuran_produk->id }}
                    </td>
                    <td style="padding: 10px;">
                        {{ $ukuran_produk->produk->nama_produk }}
                    </td>
                    <td style="padding: 10px; text-align:center">
                        {{ $ukuran_produk->ukuran }}
                    </td>
                    <td style="padding: 10px; text-align:center">
                        {{ $ukuran_produk->stok }}
                    </td>
                    <td style="padding: 10px; text-align:center">
                        {{ IDR($ukuran_produk->harga_produk_1) }}
                    </td>
                    <td style="padding: 10px; text-align:center">
                        {{ IDR($ukuran_produk->harga_produk_2) }}
                    </td>
                    <td style="padding: 10px; text-align:center">
                        {{ IDR($ukuran_produk->harga_produk_3) }}
                    </td>
                    <td style="padding: 10px; text-align:center">
                        {{ IDR($ukuran_produk->harga_produk_4) }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $ukuran_produk->created_at }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $ukuran_produk->updated_at }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
