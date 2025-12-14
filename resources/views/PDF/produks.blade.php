<!-- resources/views/produks/pdf.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk List - {{ now() }}</title>
    <style>
        table {
            width: 100%;
        }
    </style>
</head>
<body>
    <img src="{{ public_path('images/header.png') }}" style="max-width:100%">

    <h1 style="color: #800000; text-align: center; padding: 20px">Produk List - {{ now() }}</h1>

    <table border="1" style="border-collapse: collapse;">
        <thead style="color: #800000">
            <tr>
                <th style="padding: 10px; text-align: center">
                    ID
                </th>
                <th style="padding: 10px; text-align: center">
                    Nama
                </th>
                <th style="padding: 10px; text-align: center">
                    Kategori
                </th>
                <th style="padding: 10px; text-align: center">
                    Deskripsi
                </th>
                <th style="padding: 10px; text-align: center; min-width: 100px;">
                    Dibuat Pada
                </th>
                <th style="padding: 10px; text-align: center; min-width: 100px;">
                    Diperbarui Pada
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($produks as $produk)
                <tr>
                    <td style="padding: 10px; text-align:center">
                        {{ $produk->id }}
                    </td>
                    <td style="padding: 10px; text-align:center; min-width: 200px;">
                        {{ $produk->nama_produk }}
                    </td>
                    <td style="padding: 10px; text-align:center; min-width: 200px;">
                        {{ $produk->kategori->nama }}
                    </td>
                    <td style="padding: 10px; text-align: justify;">
                        {{ $produk->deskripsi_produk }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $produk->created_at }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $produk->updated_at }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
