<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice List - {{ now() }}</title>
    <style>
        table {
            width: 100%;
        }
    </style>
</head>
<body>
    <img src="{{ public_path('images/header.png') }}" style="max-width:100%">

    <h1 style="color: #800000; text-align: center; padding: 20px">Invoice List - {{ now() }}</h1>
    
    <table border="1" style="border-collapse: collapse;">
        <thead style="color: #800000">
            <tr>
                <th style="padding: 10px; text-align: center;">
                    ID
                </th>
                <th style="padding: 10px; text-align: center;">
                    Invoice
                </th>
                <th style="padding: 10px; text-align: center;">
                    Nama Customer
                </th>
                <th style="padding: 10px; text-align: center;">
                    Total Transaksi
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
            @foreach($invoices as $invoice)
                <tr>
                    <td style="padding: 10px; text-align:center">
                        {{ $invoice->id }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $invoice->invoice }}
                    </td>
                    <td style="padding: 10px;">
                        {{ $invoice->user->nama }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ IDR($invoice->sub_total) }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $invoice->created_at }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $invoice->updated_at }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
