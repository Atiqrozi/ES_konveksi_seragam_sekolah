<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kriteria List - {{ now() }}</title>
    <style>
        table {
            width: 100%;
        }
    </style>
</head>
<body>
    <img src="{{ public_path('images/header.png') }}" style="max-width:100%">

    <h1 style="color: #800000; text-align: center; padding: 20px">Kriteria List - {{ now() }}</h1>
    
    <table border="1" style="border-collapse: collapse;">
        <thead style="color: #800000">
            <tr>
                <th style="padding: 10px; text-align: center">
                    ID
                </th>
                <th style="padding: 10px; min-width:150px; text-align: center">
                    Nama Kriteria
                </th>
                <th style="padding: 10px; min-width:100px; text-align: center">
                    Bobot
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
            @foreach($kriterias as $kriteria)
                <tr>
                    <td style="padding: 10px; text-align:center">
                        {{ $kriteria->id }}
                    </td>
                    <td style="padding: 10px;">
                        {{ $kriteria->nama }}
                    </td>
                    <td style="padding: 10px; text-align:center">
                        {{ $kriteria->bobot }}
                    </td>
                    <td style="padding: 10px; text-align:center">
                        {{ $kriteria->created_at }}
                    </td>
                    <td style="padding: 10px; text-align:center">
                        {{ $kriteria->updated_at }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
