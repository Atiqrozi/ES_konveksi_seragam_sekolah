<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lihat Sales
        </h2>
    </x-slot>

    <div class="bg">
            <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('sales.index') }}" class="mr-4"
                            ><i class="mr-1 icon ion-md-arrow-back"></i
                        ></a>
                    </x-slot>

                    <div class="mt-4 px-4 row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Nama
                                </h5>
                                <span>{{ $sale->nama ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Email
                                </h5>
                                <span>{{ $sale->email ?? '-' }}</span>
                            </div>
                        
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Alamat
                                </h5>
                                <span>{{ $sale->alamat ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    No Telepon
                                </h5>
                                <span>{{ $sale->no_telepon ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Jenis Kelamin
                                </h5>
                                <span>{{ $sale->jenis_kelamin ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Tanggal Lahir
                                </h5>
                                <span>{{ optional($sale->tanggal_lahir)->format('Y-m-d') ?? '-' }}</span>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Tagihan
                                </h5>
                                <span>{{ IDR($sale->tagihan) ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Dibuat Pada
                                </h5>
                                <span>{{ $sale->created_at ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Diperbarui Pada
                                </h5>
                                <span>{{ $sale->updated_at ?? '-' }}</span>
                            </div>
                    
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Roles
                                </h5>
                                <div>
                                    @forelse ($sale->roles as $role)
                                        @if ($role->name == 'Admin')
                                            <div
                                                style="min-width: 80px;"
                                                class="
                                                    inline-block
                                                    py-1
                                                    text-center text-sm
                                                    rounded
                                                    bg-rose-600
                                                    text-white
                                                "
                                            >
                                                <span>{{ $role->name }}</span>
                                            </div>
                                        @elseif ($role->name == 'Pegawai')
                                            <div
                                                style="min-width: 80px;"
                                                class="
                                                    inline-block
                                                    py-1
                                                    text-center text-sm
                                                    rounded
                                                    bg-lime-600
                                                    text-white
                                                "
                                            >
                                                <span>{{ $role->name }}</span>
                                            </div>
                                        @elseif ($role->name == 'Sales')
                                            <div
                                                style="min-width: 80px;"
                                                class="
                                                    inline-block
                                                    py-1
                                                    text-center text-sm
                                                    rounded
                                                    bg-slate-600
                                                    text-white
                                                "
                                            >
                                                <span>{{ $role->name }}</span>
                                            </div>
                                        @endif
                                    <br />
                                    @empty - @endforelse
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Riwayat Transaksi <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#exampleModal" style="background-color: #800000; border:black 0;"><i class="fa-solid fa-eye"></i></button>
                                </h5>  
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <a href="{{ route('sales.index') }}" class="button">
                            <i class="mr-1 icon ion-md-return-left"></i>
                            @lang('crud.common.back')
                        </a>

                        @can('create_sales', App\Models\User::class)
                        <a href="{{ route('sales.create') }}" class="button">
                            <i class="mr-1 icon ion-md-add"></i>
                            @lang('crud.common.create')
                        </a>
                        @endcan
                    </div>
                </x-partials.card>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            // Event untuk modal kedua
            $('#exampleModal .btn-info').on('click', function() {
                $('#exampleModal').modal('hide'); // Tutup modal pertama
            });
    
            // Event untuk menutup modal kedua
            $('[id^=detailModal-]').on('hidden.bs.modal', function () {
                $('#exampleModal').modal('show'); // Buka kembali modal pertama jika diperlukan
            });
        });
    </script>
</x-app-layout>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Riwayat Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Isi modal di sini -->
                <table class="table">
                    <thead>
                        <tr>
                            <th style="min-width: 100px; max-width: 100px;">Nomor</th>
                            <th style="min-width: 250px;">Invoice</th>
                            <th style="min-width: 150px;">Total Harga</th>
                            <th style="min-width: 200px;">Tanggal</th>
                            <th style="min-width: 150px;">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detail_transaksis as $key => $detail_transaksi)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $detail_transaksi->invoice }}</td>
                                <td>{{ IDR($detail_transaksi->sub_total) }}</td>
                                <td>{{ $detail_transaksi->created_at }}</td>
                                <td>
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#detailModal-{{ $detail_transaksi->id }}" style="background-color: #800000; border:black 0;">Detail</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


@foreach($detail_transaksis as $detail_transaksi)
    <!-- Inner Modal -->
    <div class="modal fade" id="detailModal-{{ $detail_transaksi->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel-{{ $detail_transaksi->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel-{{ $detail_transaksi->id }}">Detail Transaksi {{ $detail_transaksi->invoice }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="min-width: 100px; max-width: 100px;">Nomor</th>
                                <th style="min-width: 250px;">Nama Produk</th>
                                <th style="min-width: 150px;">Quantity</th>
                                <th style="min-width: 150px;">Satuan</th>
                                <th style="min-width: 150px;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $detail_invoices = DB::table('pesanans')
                                    ->where('invoice_id', $detail_transaksi->id)   
                                    ->get();
                            @endphp

                            @foreach($detail_invoices as $key => $detail_invoice)
                                @if (isset($detail_invoice->jumlah_pesanan) && isset($detail_invoice->harga))
                                    @php
                                        $nama_produk = DB::table('produks')
                                            ->where('id', $detail_invoice->produk_id)   
                                            ->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $nama_produk->nama_produk }}</td>
                                        <td>{{ $detail_invoice->jumlah_pesanan }}</td>
                                        <td>{{ IDR($detail_invoice->harga) }}</td>
                                        <td>{{ IDR($detail_invoice->jumlah_pesanan * $detail_invoice->harga) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3"></th>
                                <th style="text-align:left;">TOTAL TRANSAKSI</th>
                                <th>{{ IDR($detail_transaksi->sub_total) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
