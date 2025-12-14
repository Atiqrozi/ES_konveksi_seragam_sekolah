<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lihat Kegiatan
        </h2>
    </x-slot>

    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('kegiatan.index') }}" class="mr-4"
                            ><i class="mr-1 icon ion-md-arrow-back"></i
                        ></a>
                    </x-slot>

                    <div class="mt-4 px-4 row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Kegiatan
                                </h5>
                                <span>{{ optional($kegiatan->pekerjaan)->nama_pekerjaan ?? '-'}}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Pegawai
                                </h5>
                                <span>{{ optional($kegiatan->user)->nama ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Jumlah
                                </h5>
                                <span>{{ $kegiatan->jumlah_kegiatan ?? '-' }}</span>
                                <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#exampleModal" style="background-color: #800000; border:black 0;"><i class="fa-solid fa-eye"></i></button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Catatan
                                </h5>
                                <span>{{ $kegiatan->catatan ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Kegiatan Dibuat
                                </h5>
                                <span>{{ $kegiatan->kegiatan_dibuat ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <a href="{{ route('kegiatan.index') }}" class="button">
                            <i class="mr-1 icon ion-md-return-left"></i>
                            @lang('crud.common.back')
                        </a>

                        @can('create', App\Models\Kegiatan::class)
                        <a href="{{ route('kegiatan.create') }}" class="button">
                            <i class="mr-1 icon ion-md-add"></i>
                            @lang('crud.common.create')
                        </a>
                        @endcan
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
                <h5 class="modal-title" id="exampleModalLabel">Detail Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Isi modal di sini -->
                <table class="table">
                    <thead>
                        <tr>
                            <th style="min-width: 200px;">Nama Kegiatan</th>
                            <th style="min-width: 150px;">Jumlah</th>
                            <th style="min-width: 150px;">Gaji Per Kegiatan</th>
                            <th style="min-width: 150px;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kegiatans as $key => $kegiatan)
                            <tr>
                                <td>{{ $kegiatan->pekerjaan->nama_pekerjaan }}</td>
                                <td>{{ $kegiatan->jumlah_kegiatan }}</td>
                                <td>{{ IDR($kegiatan->pekerjaan->gaji_per_pekerjaan) }}</td>
                                <td>{{ IDR($kegiatan->jumlah_kegiatan * $kegiatan->pekerjaan->gaji_per_pekerjaan) }}</td>

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
