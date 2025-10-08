<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice List - {{ now() }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }

        table .invoice:nth-child(odd) {
            background-color: #fdf1f1;
        }
    </style>
</head>
<body>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    
    <img src="{{ public_path('images/header.png') }}" style="max-width:100%">
    
    <div class="page-content container">
        <div class="container px-0">
            <div>
                <div>
                    <table style="width: 100%; margin-top: 30px;">
                        <tr>
                            <td style="width:70%; height: 25px;">
                                To :<span style="font-weight:bold; color:#800000; font-size: 16px;">
                                    {{ $invoice->user->nama }}
                                </span>
                            </td>
                            <td style="font-weight:bold;">Invoice</td>
                        </tr>
                        <tr>
                            <td style="height: 25px;">{{ $invoice->user->alamat }}</td>
                            <td>
                                <i class="fa fa-circle" style="color: #800000; font-size: 10px"></i>
                                <span style="font-weight:bold;">ID :</span>
                                {{ $invoice->invoice }}
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 25px;">{{ $invoice->user->email }}</td>
                            <td>
                                <i class="fa fa-circle" style="color: #800000; font-size: 10px"></i>
                                <span style="font-weight:bold;">Date :</span>
                                {{ $invoice->created_at }}
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 25px; font-weight:bold;">
                                <i class="fa fa-phone fa-flip-horizontal" style="color: #800000; font-size: 10px"></i>
                                {{ $invoice->user->no_telepon }}
                            </td>
                        </tr>
                    </table>

                    

                    <div style="margin-top: 30px;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr style="font-weight:bold; background-color: #800000; color: white;">
                                <th style="text-align: left; height: 35px; width: 8%; padding-left: 10px;">#</th>
                                <th style="text-align: left; padding-left: 10px;">Nama Produk</th>
                                <th style="text-align: left; padding-left: 10px;">Ukuran</th>
                                <th style="text-align: left; padding-left: 10px;">Quantity</th>
                                <th style="text-align: left; padding-left: 10px;">Harga Satuan</th>
                                <th style="text-align: left; padding-left: 10px;">Total</th>
                            </tr>

                            @php
                                $total_subtotal = 0;
                            @endphp
                            
                            @foreach($pesanans as $index => $pesanan)
                                @if (isset($pesanan->jumlah_pesanan) && isset($pesanan->harga))
                                    @php
                                        $subtotal = $pesanan->jumlah_pesanan * $pesanan->harga;
                                        $total_subtotal += $subtotal;
                                    @endphp

                                    <tr class="invoice">
                                        <td style="height: 35px; padding-left: 10px;">{{ $index+1 }}</td>
                                        <td style="padding-left: 10px;">{{ $pesanan->produk->nama_produk }}</td>
                                        <td style="padding-left: 10px;">{{ $pesanan->ukuran }}</td>
                                        <td style="padding-left: 10px;">{{ $pesanan->jumlah_pesanan }}</td>
                                        <td style="padding-left: 10px;">{{ IDR($pesanan->harga) }}</td>
                                        <td style="padding-left: 10px;">{{ IDR($pesanan->jumlah_pesanan * $pesanan->harga) }}</td>
                                    </tr>
                                @endif
                            @endforeach

                            <tr style="border-top: 1px solid rgb(202, 202, 202); border-bottom: 1px solid rgb(202, 202, 202);">
                                <td colspan="5" style="font-size: 16px; height: 50px; text-align: right;">Total</td>
                                <td style="padding-left: 10px; font-size: 16px; color:#800000;">{{ IDR($total_subtotal) }}</td>
                            </tr>

                            <tr>
                                <td colspan="5" style="font-size: 16px; height: 40px; text-align: right;">Tagihan Sebelumnya</td>
                                <td style="padding-left: 10px; font-size: 16px; color:#800000;">{{ IDR($invoice->tagihan_sebelumnya) }}</td>
                            </tr>
                            <tr>
                                <td colspan="5" style="font-size: 16px; height: 40px; text-align: right;">Sub Total</td>
                                <td style="padding-left: 10px; font-size: 16px; color:#800000;">{{ IDR($invoice->tagihan_total) }}</td>
                            </tr>
                            <tr>
                                <td colspan="5" style="font-size: 16px; height: 40px; text-align: right;">Jumlah Bayar</td>
                                <td style="padding-left: 10px; font-size: 16px; color:#800000;">{{ IDR($invoice->jumlah_bayar) }}</td>
                            </tr>
                            <tr>
                                <td colspan="5" style="font-size: 16px; height: 40px; text-align: right;">Tagihan Sisa</td>
                                <td style="padding-left: 10px; font-size: 16px; color:#800000;">{{ IDR($invoice->tagihan_sisa) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
