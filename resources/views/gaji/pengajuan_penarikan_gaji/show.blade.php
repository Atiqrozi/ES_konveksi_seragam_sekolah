<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Show Pengajuan Penarikan Gaji
        </h2>
    </x-slot>

    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('pengajuan_penarikan_gaji.index') }}" class="mr-4"
                            ><i class="mr-1 icon ion-md-arrow-back"></i
                        ></a>
                    </x-slot>

                    <div class="mt-4 px-4 row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Nama Pegawai
                                </h5>
                                <span>{{ $pengajuan_penarikan_gaji->user->nama ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Gaji Ditarik
                                </h5>
                                @php
                                    $total_gaji_real = 0;
                                    foreach($detail_gaji_pegawais as $detail) {
                                        $total_gaji_real += $detail->total_jumlah_kegiatan * $detail->gaji_per_pekerjaan;
                                    }
                                @endphp
                                <span>{{ IDR($total_gaji_real) ?? '-' }}</span>
                                <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#detailGajiModal" style="background-color: #800000; border:black 0; padding: ;"><i class="fa-solid fa-eye"></i></button>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Status
                                </h5>
                                @if ($pengajuan_penarikan_gaji->status == 'Diajukan')
                                    <div
                                        style="min-width: 80px;"
                                        class="
                                            inline-block
                                            py-1
                                            text-center text-sm
                                            rounded
                                            bg-yellow-600
                                            text-white
                                        "
                                    >
                                        <span>{{ $pengajuan_penarikan_gaji->status ?? '-' }}</span>
                                    </div>
                                @elseif ($pengajuan_penarikan_gaji->status == 'Diterima')
                                    <div
                                        style="min-width: 80px;"
                                        class=" 
                                            inline-block
                                            py-1
                                            text-center text-sm
                                            rounded
                                            bg-green-600
                                            text-white
                                        "
                                    >
                                        <span>{{ $pengajuan_penarikan_gaji->status ?? '-' }}</span>
                                    </div>
                                @elseif ($pengajuan_penarikan_gaji->status == 'Ditolak')
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
                                        <span>{{ $pengajuan_penarikan_gaji->status ?? '-' }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Terhitung Tanggal
                                </h5>
                                <span>{{ $pengajuan_penarikan_gaji->mulai_tanggal ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Sampai Tanggal
                                </h5>
                                <span>{{ $pengajuan_penarikan_gaji->akhir_tanggal ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Gaji Diberikan Tanggal
                                </h5>
                                <span>{{ $pengajuan_penarikan_gaji->gaji_diberikan ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        @if($pengajuan_penarikan_gaji->status == 'Diterima')
                            <a href="{{ route('pengajuan_penarikan_gaji.print_slip_gaji', $pengajuan_penarikan_gaji->id) }}" 
                               target="_blank"
                               class="button" 
                               style="background-color: #1e7e34; color: white; border: none; padding: 10px 20px; margin-right: 10px; text-decoration: none; display: inline-block;">
                                <i class="fas fa-print mr-1"></i>
                                Print Slip Gaji
                            </a>
                            
                            <a href="{{ route('pengajuan_penarikan_gaji.export_slip_gaji', $pengajuan_penarikan_gaji->id) }}" 
                               class="button" 
                               style="background-color: #800000; color: white; border: none; padding: 10px 20px; margin-right: 10px; text-decoration: none; display: inline-block;">
                                <i class="fas fa-download mr-1"></i>
                                Download Slip Gaji
                            </a>
                        @endif
                        
                        <a href="{{ route('pengajuan_penarikan_gaji.index') }}" class="button">
                            <i class="mr-1 icon ion-md-return-left"></i>
                            @lang('crud.common.back')
                        </a>
                    </div>
                </x-partials.card>
            </div>
        </div>
    </div>

    <!-- Modal for Detail Gaji -->
    <div class="modal fade" id="detailGajiModal" tabindex="-1" role="dialog" aria-labelledby="detailGajiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailGajiModalLabel">Detail Gaji</h5>
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
                            @php
                                $total_gaji_calculated = 0;
                            @endphp
                            @foreach($detail_gaji_pegawais as $key => $detail_gaji_pegawai)
                                @php
                                    $subtotal = $detail_gaji_pegawai->total_jumlah_kegiatan * $detail_gaji_pegawai->gaji_per_pekerjaan;
                                    $total_gaji_calculated += $subtotal;
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $detail_gaji_pegawai->nama_pekerjaan }}</td>
                                    <td>{{ $detail_gaji_pegawai->total_jumlah_kegiatan }}</td>
                                    <td>{{ IDR($detail_gaji_pegawai->gaji_per_pekerjaan) }}</td>
                                    <td>{{ IDR($subtotal) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3"></th>
                                <th style="text-align:left;">TOTAL GAJI</th>
                                <th>{{ IDR($total_gaji_calculated) }}</th>
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

    <!-- Modal for Viewing Image -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lihat Gambar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="fullImage" src="" alt="Bukti Transfer" class="img-fluid" style="display: block; margin: auto;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const viewImageButtons = document.querySelectorAll('.view-image-btn');
        viewImageButtons.forEach(button => {
            button.addEventListener('click', function () {
                const imageUrl = this.getAttribute('data-image');
                document.getElementById('fullImage').setAttribute('src', imageUrl);
            });
        });
    });
</script>
