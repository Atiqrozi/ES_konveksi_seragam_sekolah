<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pegawai List - {{ now() }}</title>
</head>
<body>
    <img src="{{ public_path('images/header.png') }}" style="max-width:100%">
    
    <h1 style="color: #800000; text-align: center; padding: 20px">Pegawai List - {{ now() }}</h1>

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
                    Gaji Yang Bisa Ditarik
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
            @foreach($pegawais as $pegawai)
                <tr>
                    <td style="padding: 10px; max-width: 150px; text-align:center">
                        {{ $pegawai->id }}
                    </td>
                    <td style="padding: 10px; max-width: 200px;">
                        {{ $pegawai->nama }}
                    </td>
                    <td style="padding: 10px; max-width: 200px;">
                        {{ $pegawai->email }}
                    </td>
                    <td style="padding: 10px; max-width: 200px;">
                        {{ $pegawai->alamat }}
                    </td>
                    <td style="padding: 10px; max-width: 150px;">
                        {{ $pegawai->no_telepon }}
                    </td>
                    <td style="padding: 10px; max-width: 150px; text-align: center;">
                        {{ $pegawai->jenis_kelamin }}
                    </td>
                    <td style="padding: 10px; max-width: 150px; text-align: center;">
                        {{ IDR(optional($pegawai->GajiPegawai)->total_gaji_yang_bisa_diajukan) }}
                    </td>
                    <td style="padding: 10px; max-width: 150px; text-align: center;">
                        {{ optional($pegawai->tanggal_lahir)->format('Y-m-d') }}
                    </td>
                    <td style="padding: 10px; max-width: 250px; text-align: center;">
                        {{ $pegawai->created_at }}
                    </td>
                    <td style="padding: 10px; max-width: 250px; text-align: center;">
                        {{ $pegawai->updated_at }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
