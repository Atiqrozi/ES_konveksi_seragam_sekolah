<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Show Gaji Pegawai
        </h2>
    </x-slot>

    <div class="bg">
        <style>
            @media (max-width: 768px) {
                /* Main content responsive */
                .row {
                    display: block !important;
                }
                .col-md-6 {
                    width: 100% !important;
                    margin-bottom: 15px;
                }
                
                /* Table in modal to card layout */
                .modal-body table {
                    border: 0;
                }
                .modal-body table thead {
                    display: none;
                }
                .modal-body table tbody,
                .modal-body table tfoot {
                    display: block;
                    width: 100%;
                }
                .modal-body table tbody tr {
                    display: block;
                    margin-bottom: 15px;
                    border: 1px solid #ddd;
                    border-radius: 8px;
                    padding: 10px;
                    background-color: #fff;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }
                .modal-body table tbody td {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    text-align: right;
                    padding: 8px 10px !important;
                    border-bottom: 1px solid #f0f0f0;
                }
                .modal-body table tbody td:last-child {
                    border-bottom: none;
                }
                .modal-body table tbody td::before {
                    content: attr(data-label);
                    font-weight: bold;
                    text-align: left;
                    color: #800000;
                    flex: 1;
                }
                
                /* Footer total section */
                .modal-body table tfoot tr {
                    display: block;
                    margin-top: 20px;
                    padding: 15px;
                    background-color: #f8f9fa;
                    border-radius: 8px;
                    border: 2px solid #800000;
                }
                .modal-body table tfoot th {
                    display: block;
                    text-align: center !important;
                    padding: 5px 0 !important;
                }
                .modal-body table tfoot th:first-child {
                    display: none;
                }
                .modal-body table tfoot th:nth-child(2) {
                    font-size: 14px;
                    color: #800000;
                    margin-bottom: 5px;
                }
                .modal-body table tfoot th:nth-child(3) {
                    font-size: 18px;
                    font-weight: bold;
                    color: #800000;
                }
            }
        </style>
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('gaji_semua_pegawai.index') }}" class="mr-4"
                            ><i class="mr-1 icon ion-md-arrow-back"></i
                        ></a>
                    </x-slot>

                    <div class="mt-4 px-4 row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Nama Pegawai
                                </h5>
                                <span>{{ $gaji_semua_pegawai->user->nama ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Gaji Tersedia
                                </h5>
                                <span>{{ IDR($gaji_semua_pegawai->total_gaji_yang_bisa_diajukan) ?? '-' }}</span>
                                <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#exampleModal" style="background-color: #800000; border:black 0; padding: ;"><i class="fa-solid fa-eye"></i></button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Terhitung Tanggal
                                </h5>
                                <span>{{ $gaji_semua_pegawai->terhitung_tanggal ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <a href="{{ route('gaji_semua_pegawai.index') }}" class="button">
                            <i class="mr-1 icon ion-md-return-left"></i>
                            @lang('crud.common.back')
                        </a>
                    </div>
                </x-partials.card>
            </div>
        </div>
    </div>
</x-app-layout>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Gaji</h5>
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
                            <th style="min-width: 250px;">Nama Kegiatan</th>
                            <th style="min-width: 250px;">Jumlah Kegiatan Selesai</th>
                            <th style="min-width: 150px;">Gaji Per Pekerjaan</th>
                            <th style="min-width: 150px;">Total Gaji</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detail_gaji_pegawais as $key => $detail_gaji_pegawai)
                            <tr>
                                <td data-label="Nomor">{{ $key + 1 }}</td>
                                <td data-label="Nama Kegiatan">{{ $detail_gaji_pegawai->nama_pekerjaan }}</td>
                                <td data-label="Jumlah Kegiatan Selesai">{{ $detail_gaji_pegawai->total_jumlah_kegiatan }}</td>
                                <td data-label="Gaji Per Pekerjaan">{{ IDR($detail_gaji_pegawai->gaji_per_pekerjaan) }}</td>
                                <td data-label="Total Gaji">{{ IDR($detail_gaji_pegawai->total_jumlah_kegiatan * $detail_gaji_pegawai->gaji_per_pekerjaan) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3"></th>
                            <th style="text-align:left;">TOTAL GAJI</th>
                            <th>{{ IDR($gaji_semua_pegawai->total_gaji_yang_bisa_diajukan) }}</th>
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
