<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role List - {{ now() }}</title>
</head>
<body>
    <img src="{{ public_path('images/header.png') }}" style="max-width:100%">
    
    <h1 style="color: #800000; text-align: center; padding: 20px">Role List - {{ now() }}</h1>

    <table border="1" style="border-collapse: collapse; width:100%;">
        <thead style="color: #800000">
            <tr>
                <th style="padding: 10px; text-align: center;">
                    ID
                </th>
                <th style="padding: 10px; text-align: center;">
                    Nama
                </th>
                <th style="padding: 10px; text-align: center;">
                    Permission
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
            @foreach($roles as $role)
                <tr>
                    <td style="padding: 10px; max-width: 250px; text-align:center">
                        {{ $role->id }}
                    </td>
                    <td style="padding: 10px; max-width: 250px; text-align:center">
                        {{ $role->name }}
                    </td>
                    <td style="padding: 10px; max-width: 250px; text-align: left;">
                        <ul style="list-style-type: square; margin-left: -20px;">
                            @foreach ($permissions[$role->id] as $permission)
                                <li style="margin: 5px 0">
                                    {{ ucwords($permission ?? '-') }}
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td style="padding: 10px; max-width: 250px; text-align: center;">
                        {{ $role->created_at }}
                    </td>
                    <td style="padding: 10px; max-width: 250px; text-align: center;">
                        {{ $role->updated_at }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
