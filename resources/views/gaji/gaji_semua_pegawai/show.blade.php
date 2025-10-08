<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Show Gaji Pegawai
        </h2>
    </x-slot>

    <div class="bg">
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
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $detail_gaji_pegawai->nama_pekerjaan }}</td>
                                <td>{{ $detail_gaji_pegawai->total_jumlah_kegiatan }}</td>
                                <td>{{ IDR($detail_gaji_pegawai->gaji_per_pekerjaan) }}</td>
                                <td>{{ IDR($detail_gaji_pegawai->total_jumlah_kegiatan * $detail_gaji_pegawai->gaji_per_pekerjaan) }}</td>
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
