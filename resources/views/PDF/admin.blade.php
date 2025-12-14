<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin List - {{ now() }}</title>
</head>
<body>
    <img src="{{ public_path('images/header.png') }}" style="max-width:100%">
    
    <h1 style="color: #800000; text-align: center; padding: 20px">Admin List - {{ now() }}</h1>

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
                    Tanggal Lahir
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
            @foreach($admins as $admin)
                <tr>
                    <td style="padding: 10px; max-width: 150px; text-align:center">
                        {{ $admin->id }}
                    </td>
                    <td style="padding: 10px; max-width: 200px;">
                        {{ $admin->nama }}
                    </td>
                    <td style="padding: 10px; max-width: 200px;">
                        {{ $admin->email }}
                    </td>
                    <td style="padding: 10px; max-width: 200px;">
                        {{ $admin->alamat }}
                    </td>
                    <td style="padding: 10px; max-width: 150px;">
                        {{ $admin->no_telepon }}
                    </td>
                    <td style="padding: 10px; max-width: 150px; text-align: center;">
                        {{ $admin->jenis_kelamin }}
                    </td>
                    <td style="padding: 10px; max-width: 150px; text-align: center;">
                        {{ optional($admin->tanggal_lahir)->format('Y-m-d') }}
                    </td>
                    <td style="padding: 10px; max-width: 250px; text-align: center;">
                        {{ $admin->created_at }}
                    </td>
                    <td style="padding: 10px; max-width: 250px; text-align: center;">
                        {{ $admin->updated_at }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
