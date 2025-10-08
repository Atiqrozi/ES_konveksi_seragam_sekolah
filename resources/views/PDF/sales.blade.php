<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales List - {{ now() }}</title>
</head>
<body>
    <img src="{{ public_path('images/header.png') }}" style="max-width:100%">
    
    <h1 style="color: #800000; text-align: center; padding: 20px">Sales List - {{ now() }}</h1>

    <table border="1" style="border-collapse: collapse;">
        <thead style="color: #800000">
            <tr>
                <th style="padding: 10px; text-align: center;">
                    ID
                </th>
                <th style="padding: 10px; text-align: center;">
                    Nama
                </th>
                <th style="padding: 10px; text-align: center;">
                    Email
                </th>
                <th style="padding: 10px; text-align: center;">
                    Alamat
                </th>
                <th style="padding: 10px; text-align: center;">
                    No Telepon
                </th>
                <th style="padding: 10px; text-align: center;">
                    Jenis Kelamin
                </th>
                <th style="padding: 10px; text-align: center;">
                    Tagihan
                </th>
                <th style="padding: 10px; text-align: center;">
                    Tanggal Lahir
                </th>
                <th style="padding: 10px; text-align: center;">
                    Created At
                </th>
                <th style="padding: 10px; text-align: center;">
                    Updated At
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td style="padding: 10px; max-width: 150px; text-align:center">
                        {{ $sale->id }}
                    </td>
                    <td style="padding: 10px; max-width: 200px;">
                        {{ $sale->nama }}
                    </td>
                    <td style="padding: 10px; max-width: 200px;">
                        {{ $sale->email }}
                    </td>
                    <td style="padding: 10px; max-width: 200px;">
                        {{ $sale->alamat }}
                    </td>
                    <td style="padding: 10px; max-width: 150px;">
                        {{ $sale->no_telepon }}
                    </td>
                    <td style="padding: 10px; max-width: 150px; text-align: center;">
                        {{ $sale->jenis_kelamin }}
                    </td>
                    <td style="padding: 10px; max-width: 150px; text-align: center;">
                        {{ IDR($sale->tagihan) }}
                    </td>
                    <td style="padding: 10px; max-width: 150px; text-align: center;">
                        {{ optional($sale->tanggal_lahir)->format('Y-m-d') }}
                    </td>
                    <td style="padding: 10px; max-width: 250px; text-align: center;">
                        {{ $sale->created_at }}
                    </td>
                    <td style="padding: 10px; max-width: 250px; text-align: center;">
                        {{ $sale->updated_at }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
