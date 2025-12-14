<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $invoice->invoice ?? '' }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 20px;
        }

        table .invoice:nth-child(odd) {
            background-color: #fdf1f1;
        }
        
        img {
            max-width: 80px;
            height: auto;
        }
    </style>
</head>
<body>
    @php
        // Optimasi: hitung total di PHP untuk mengurangi loop
        $total_subtotal = 0;
        foreach($pesanans as $pesanan) {
            if (isset($pesanan->jumlah_pesanan) && isset($pesanan->harga)) {
                $total_subtotal += $pesanan->jumlah_pesanan * $pesanan->harga;
            }
        }
    @endphp
    
    @if(file_exists(public_path('favicon.png')))
    <img src="{{ public_path('favicon.png') }}" alt="Logo">
    @endif
    
    <div class="page-content container">
        <div class="container px-0">
            <div>
                <div>
                    <table style="width: 100%; margin-top: 30px;">
                        <tr>
                            <td style="width:70%; height: 25px;">
                                To :<span style="font-weight:bold; color:#800000; font-size: 16px;">
                                    {{ $invoice->user->nama ?? 'N/A' }}
                                </span>
                            </td>
                            <td style="font-weight:bold;">Invoice</td>
                        </tr>
                        <tr>
                            <td style="height: 25px;">{{ $invoice->user->alamat ?? 'N/A' }}</td>
                            <td>
                                <span style="font-weight:bold;">ID :</span>
                                {{ $invoice->invoice ?? 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 25px;">{{ $invoice->user->email ?? 'N/A' }}</td>
                            <td>
                                <span style="font-weight:bold;">Date :</span>
                                {{ $invoice->created_at ?? now() }}
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 25px; font-weight:bold;">
                                {{ $invoice->user->no_telepon ?? 'N/A' }}
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
                            
                            @foreach($pesanans as $index => $pesanan)
                                @if (isset($pesanan->jumlah_pesanan) && isset($pesanan->harga))
                                    <tr class="invoice">
                                        <td style="height: 35px; padding-left: 10px;">{{ $index+1 }}</td>
                                        <td style="padding-left: 10px;">{{ $pesanan->produk->nama_produk ?? 'N/A' }}</td>
                                        <td style="padding-left: 10px;">{{ $pesanan->ukuran ?? 'N/A' }}</td>
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
                                <td style="padding-left: 10px; font-size: 16px; color:#800000;">{{ IDR($invoice->tagihan_sebelumnya ?? 0) }}</td>
                            </tr>
                            <tr>
                                <td colspan="5" style="font-size: 16px; height: 40px; text-align: right;">Sub Total</td>
                                <td style="padding-left: 10px; font-size: 16px; color:#800000;">{{ IDR($invoice->tagihan_total ?? 0) }}</td>
                            </tr>
                            <tr>
                                <td colspan="5" style="font-size: 16px; height: 40px; text-align: right;">Jumlah Bayar</td>
                                <td style="padding-left: 10px; font-size: 16px; color:#800000;">{{ IDR($invoice->jumlah_bayar ?? 0) }}</td>
                            </tr>
                            <tr>
                                <td colspan="5" style="font-size: 16px; height: 40px; text-align: right;">Tagihan Sisa</td>
                                <td style="padding-left: 10px; font-size: 16px; color:#800000;">{{ IDR($invoice->tagihan_sisa ?? 0) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
