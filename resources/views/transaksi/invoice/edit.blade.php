<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lihat Pesanan
        </h2>
    </x-slot>

    <style>
        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            /* Reduce padding on mobile */
            .py-12 {
                padding-top: 1rem !important;
                padding-bottom: 1rem !important;
            }

            /* Page header mobile */
            .page-header {
                flex-direction: column !important;
            }

            .page-title {
                font-size: 1.25rem !important;
                margin-bottom: 1rem;
            }

            /* Customer info section */
            .col-sm-6 {
                margin-bottom: 20px;
            }

            /* Hide desktop table header */
            .bgc-default-tp1 {
                display: none !important;
            }

            /* Card-style layout for product items */
            .bg_kolom {
                display: block !important;
                border: 1px solid #e5e7eb;
                border-radius: 8px;
                padding: 12px !important;
                margin-bottom: 12px !important;
                background-color: #f9fafb;
            }

            .bg_kolom > div {
                display: block !important;
                width: 100% !important;
                padding: 6px 0;
            }

            /* Show labels on mobile */
            .bg_kolom > div:nth-child(1)::before {
                content: "No: ";
                font-weight: 600;
                color: #800000;
                margin-right: 8px;
            }

            .bg_kolom > div:nth-child(2)::before {
                content: "Nama Produk: ";
                font-weight: 600;
                color: #800000;
                display: block;
                margin-bottom: 4px;
            }

            .bg_kolom > div:nth-child(3)::before {
                content: "Ukuran: ";
                font-weight: 600;
                color: #800000;
                display: block;
                margin-bottom: 4px;
            }

            .bg_kolom > div:nth-child(4)::before {
                content: "Quantity: ";
                font-weight: 600;
                color: #800000;
                display: block;
                margin-bottom: 4px;
            }

            .bg_kolom > div:nth-child(5)::before {
                content: "Harga Satuan: ";
                font-weight: 600;
                color: #800000;
                display: block;
                margin-bottom: 4px;
            }

            .bg_kolom > div:nth-child(6)::before {
                content: "Total: ";
                font-weight: 600;
                color: #800000;
                display: block;
                margin-bottom: 4px;
                font-size: 1.1em;
            }

            /* Summary sections - vertical layout with better readability */
            .row.my-2 {
                display: flex !important;
                flex-direction: column !important;
                align-items: flex-start !important;
                margin-bottom: 16px !important;
            }

            .row.my-2 > div {
                width: 100% !important;
                text-align: left !important;
                padding: 4px 0;
            }

            .row.my-2 > div:first-child {
                font-weight: 600;
                color: #800000;
                font-size: 14px;
                margin-bottom: 4px;
            }

            .row.my-2 > div:last-child {
                font-size: 16px !important;
                padding-left: 0 !important;
            }

            .row.my-2 > div:last-child span {
                white-space: nowrap;
                font-size: 14px !important;
            }

            /* Input jumlah bayar - vertical layout */
            .row.my-2:has(#jumlah_bayar) {
                flex-direction: column !important;
            }

            .row.my-2:has(#jumlah_bayar) label {
                width: 100% !important;
                margin-bottom: 8px;
                text-align: left !important;
                font-weight: 600;
                color: #800000;
            }

            /* Input jumlah bayar */
            #jumlah_bayar {
                width: 100% !important;
                text-align: left !important;
                font-size: 14px !important;
            }

            /* Button full width on mobile */
            .button {
                width: 100% !important;
                text-align: center;
                padding: 12px !important;
                display: block;
                margin: 0 !important;
            }

            /* Container padding */
            .container.px-0 {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            .max-w-7xl {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            /* Make sure numbers don't break */
            .text-secondary-d1 {
                display: inline-block;
                white-space: nowrap;
                font-size: 14px !important;
            }

            /* Summary container */
            .col-12.text-120 {
                font-size: 14px !important;
            }
        }
    </style>

    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

                    <div class="page-content container">
                        <div class="page-header text-blue-d2">
                            <h1 class="page-title text-secondary-d1">
                                <small class="page-info">
                                    {{ $invoice->invoice }}
                                </small>
                            </h1>
                        </div>

                        <div class="container px-0">
                            <div class="row mt-4">
                                <div class="col-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div>
                                                <span class="text-sm align-middle">To :</span>
                                                <span class="text-600 text-110 text-blue align-middle">
                                                    {{ $invoice->user->nama }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="my-1">
                                                    {{ $invoice->user->alamat }}
                                                </div>
                                                <div class="my-1">
                                                    {{ $invoice->user->email }}
                                                </div>
                                                <div class="my-1"><i class="fa fa-phone fa-flip-horizontal" style="color: #800000;"></i> <b class="text-600">{{ $invoice->user->no_telepon }}</b></div>
                                            </div>
                                        </div>

                                        <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                                            <hr class="d-sm-none" />
                                            <div>
                                                <div class="mt-1 mb-2 text-secondary-m1 text-600 text-125">
                                                    Invoice
                                                </div>

                                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">ID :</span> {{ $invoice->invoice }}</div>

                                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Date :</span> {{ $invoice->created_at }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <div class="row text-600 text-white bgc-default-tp1 py-25">
                                            <div class="d-none d-sm-block col-1">#</div>
                                            <div class="col-9 col-sm-3">Nama Produk</div>
                                            <div class="d-none d-sm-block col-2">Ukuran</div>
                                            <div class="d-none d-sm-block col-2">Quantity</div>
                                            <div class="d-none d-sm-block col-2">Harga Satuan</div>
                                            <div class="col-2">Total</div>
                                        </div>
                                    
                                        <div class="text-95 text-secondary-d3">
                                            @php
                                                $total_subtotal = 0;
                                            @endphp
                                            
                                            @foreach($pesanans as $index => $pesanan)
                                                @if (isset($pesanan->jumlah_pesanan) && isset($pesanan->harga))
                                                    @php
                                                        $subtotal = $pesanan->jumlah_pesanan * $pesanan->harga;
                                                        $total_subtotal += $subtotal;
                                                    @endphp
                                                    <div class="row mb-2 mb-sm-0 py-25 bg_kolom">
                                                        <div class="col-12 col-sm-1">{{ $index + 1 }}</div>
                                                        <div class="col-12 col-sm-3">{{ $pesanan->produk->nama_produk }}</div>
                                                        <div class="col-12 col-sm-2">{{ $pesanan->ukuran }}</div>
                                                        <div class="col-12 col-sm-2">{{ $pesanan->jumlah_pesanan }}</div>
                                                        <div class="col-12 col-sm-2 text-95">Rp {{ number_format($pesanan->harga, 0, ',', '.') }}</div>
                                                        <div class="col-12 col-sm-2 text-secondary-d2">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                                                    </div> 
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class="row border-b-2 brc-default-l2"></div>

                                        <div class="row mt-3">
                                            <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
                                                
                                            </div>
                                            <div class="col-12 col-sm-5 text-120 order-first order-sm-last">
                                                <div class="row my-2">
                                                    <div class="col-7 text-right">
                                                        Total
                                                    </div>
                                                    <div class="col-5">
                                                        <span class="text-secondary-d1">Rp {{ number_format($total_subtotal, 0, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr />

                                        <div class="row mt-3">
                                            <div class="col-12 text-120">
                                                    <div class="row my-2">
                                                        <div class="col-10 text-right">
                                                            Tagihan Sebelumnya
                                                        </div>
                                                        <div class="col-2">
                                                            <span class="text-secondary-d1">Rp {{ number_format($invoice->tagihan_sebelumnya, 0, ',', '.') }}</span>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="row mt-1">
                                            <div class="col-12 text-120">
                                                    <div class="row my-2">
                                                        <div class="col-10 text-right">
                                                            Sub Total
                                                        </div>
                                                        <div class="col-2">
                                                            <span class="text-secondary-d1">Rp {{ number_format($invoice->tagihan_total, 0, ',', '.') }}</span>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="row mt-1">
                                            <div class="col-12 text-120">
                                                <form action="{{ route('invoice.update', $invoice) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row my-2">
                                                        <div class="col-12 col-sm-10 text-sm-right">
                                                            <label for="jumlah_bayar">Jumlah Bayar</label>
                                                        </div>
                                                        <div class="col-12 col-sm-2">
                                                            <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" placeholder="Masukkan jumlah">
                                                        </div>
                                                    </div>
                                                    <div class="row my-2">
                                                        <div class="col-12 text-center">
                                                            <button
                                                            type="submit"
                                                            class="button"
                                                            style="background-color: #800000; color: white; transition: background-color 0.3s, color 0.3s; padding: 12px 40px;" onmouseover="this.style.backgroundColor='#700000'; this.style.color='white';" onmouseout="this.style.backgroundColor='#800000'; this.style.color='white';"
                                                        >
                                                            Konfirmasi
                                                        </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        
                                        <!-- Print Button -->
                                        <div class="row mt-3">
                                            <div class="col-12 text-center">
                                                <a href="{{ route('pesanan.invoice_print', $invoice->id) }}" 
                                                   target="_blank"
                                                   class="button"
                                                   style="background-color: #1e7e34; color: white; padding: 12px 40px; text-decoration: none; display: inline-block; transition: background-color 0.3s;" 
                                                   onmouseover="this.style.backgroundColor='#155724';" 
                                                   onmouseout="this.style.backgroundColor='#1e7e34';">
                                                    <i class="fa fa-print"></i> Print Invoice
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-partials.card>
            </div>
        </div>
    </div>
</x-app-layout>
