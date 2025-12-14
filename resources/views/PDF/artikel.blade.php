<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel List - {{ now() }}</title>
</head>
<body>
    <img src="{{ public_path('images/header.png') }}" style="max-width:100%">
    
    <h1 style="color: #800000; text-align: center; padding: 20px">Artikel List - {{ now() }}</h1>

    <table border="1" style="border-collapse: collapse; width: 100%;">
        <thead style="color: #800000">
            <tr>
                <th style="padding: 10px; text-align: center;">
                    ID
                </th>
                <th style="padding: 10px; text-align: center;">
                    Penulis
                </th>
                <th style="padding: 10px; text-align: center;">
                    Judul
                </th>
                <th style="padding: 10px; text-align: center;">
                    Slug
                </th>
                <th style="padding: 10px; text-align: center;">
                    Dibuat Pada
                </th>
                <th style="padding: 10px; text-align: center;">
                    Diperbarui Pada
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($artikels as $artikel)
                <tr>
                    <td style="padding: 10px; max-width: 150px; text-align:center">
                        {{ $artikel->id }}
                    </td>
                    <td style="padding: 10px; max-width: 200px;">
                        {{ $artikel->user->nama }}
                    </td>
                    <td style="padding: 10px; max-width: 200px;">
                        {{ $artikel->judul }}
                    </td>
                    <td style="padding: 10px; max-width: 200px;">
                        {{ $artikel->slug }}
                    </td>
                    <td style="padding: 10px; max-width: 250px; text-align: center;">
                        {{ $artikel->created_at }}
                    </td>
                    <td style="padding: 10px; max-width: 250px; text-align: center;">
                        {{ $artikel->updated_at }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
