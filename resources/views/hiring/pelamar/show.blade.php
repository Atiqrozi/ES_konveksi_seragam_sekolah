<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lihat Pelamar
        </h2>
    </x-slot>

    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('pelamar.index') }}" class="mr-4"
                            ><i class="mr-1 icon ion-md-arrow-back"></i
                        ></a>
                    </x-slot>

                    <div class="mt-4 px-4 row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Nama
                                </h5>
                                <span>{{ $pelamar->nama ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Email
                                </h5>
                                <span>{{ $pelamar->email ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Alamat
                                </h5>
                                <span>{{ $pelamar->alamat ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    No Telepon
                                </h5>
                                <span>{{ $pelamar->no_telepon ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Jenis Kelamin
                                </h5>
                                <span>{{ $pelamar->jenis_kelamin ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Tanggal Lahir
                                </h5>
                                <span>{{ $pelamar->tanggal_lahir ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Pendidikan Terakhir
                                </h5>
                                <span>{{ $pelamar->pendidikan_terakhir ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Pengalaman Kerja
                                </h5>
                                <span>{{ $pelamar->pengalaman ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Status Lamaran
                                </h5>
                                @if ($pelamar->status == 'Diajukan')
                                    <div
                                        style="min-width: 80px;"
                                        class="
                                            inline-block
                                            py-1
                                            text-center text-sm
                                            rounded
                                            bg-gray-500
                                            text-white
                                        "
                                    >
                                        <span>{{ $pelamar->status ?? '-' }}</span>
                                    </div>
                                @elseif ($pelamar->status == 'Belum Wawancara')
                                    <div
                                        style="min-width: 150px;"
                                        class=" 
                                            inline-block
                                            py-1
                                            text-center text-sm
                                            rounded
                                            bg-indigo-600
                                            text-white
                                        "
                                    >
                                        <span>{{ $pelamar->status ?? '-' }}</span>
                                    </div>
                                @elseif ($pelamar->status == 'Sudah Wawancara')
                                    <div
                                        style="min-width: 150px;"
                                        class=" 
                                            inline-block
                                            py-1
                                            text-center text-sm
                                            rounded
                                            bg-yellow-600
                                            text-white
                                        "
                                    >
                                        <span>{{ $pelamar->status ?? '-' }}</span>
                                    </div>
                                @elseif ($pelamar->status == 'Diterima')
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
                                        <span>{{ $pelamar->status ?? '-' }}</span>
                                    </div>
                                @elseif ($pelamar->status == 'Ditolak')
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
                                        <span>{{ $pelamar->status ?? '-' }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Foto
                                </h5>
                                <x-partials.thumbnail
                                    src="{{ $pelamar->foto ? \Storage::url($pelamar->foto) : '' }}"
                                    size="150"
                                />
                                <button type="button" class="button mt-1" data-toggle="modal" data-target=".modal_foto" style="background-color: #800000; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#700000'; this.style.color='white';" onmouseout="this.style.backgroundColor='#800000'; this.style.color='white';">
                                    Lihat Foto
                                </button>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    CV
                                </h5>
                                <button type="button" class="button mt-1" data-toggle="modal" data-target=".modal_cv" style="background-color: #800000; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#700000'; this.style.color='white';" onmouseout="this.style.backgroundColor='#800000'; this.style.color='white';">
                                    Lihat CV
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Posisi
                                </h5>
                                <span>{{ $pelamar->posisi_lowongan->nama_posisi ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Jadwal Wawancara
                                </h5>
                                <span> 
                                    {{ ($pelamar->mulai_wawancara instanceof \DateTime ? $pelamar->mulai_wawancara->format('Y-m-d') : '-') }}
                                    ( {{ ($pelamar->mulai_wawancara instanceof \DateTime ? $pelamar->mulai_wawancara->format('H:i') : '-') }}
                                    -
                                    {{ ($pelamar->selesai_wawancara instanceof \DateTime ? $pelamar->selesai_wawancara->format('H:i') : '-') }} )
                                </span>
                            </div>

                            @foreach ($kriteria as $kriterium)
                                <div class="mb-4">
                                    <h5 class="font-medium text-gray-700">
                                        {{ $kriterium->nama }} ({{ $kriterium->bobot }})
                                    </h5>
                                    <span>{{ $pelamar->wsmPelamar->where('kriteria_id', $kriterium->id)->first()->skor ?? '-' }}</span>
                                </div>
                            @endforeach
        
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Skor
                                </h5>
                                <span>{{ $pelamar->weighted_sum_model ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Apply At
                                </h5>
                                <span>{{ $pelamar->created_at ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <a href="{{ route('pelamar.index') }}" class="button">
                            <i class="mr-1 icon ion-md-return-left"></i>
                            @lang('crud.common.back')
                        </a>
                    </div>
                </x-partials.card>
            </div>
        </div>
    </div>


    <!-- Modal Foto -->
    <div class="modal fade modal_foto" tabindex="-1" role="dialog" aria-labelledby="modalFotoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFotoLabel">Foto Pelamar</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center"> <!-- tambahkan kelas text-center untuk meratakan ke tengah -->
                    <img src="{{ $pelamar->foto ? \Storage::url($pelamar->foto) : '' }}" class="img-fluid mx-auto d-block" alt="Foto Pelamar"> <!-- tambahkan kelas mx-auto d-block untuk meratakan ke tengah -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal CV -->
    <div class="modal fade modal_cv" tabindex="-1" role="dialog" aria-labelledby="modalCVLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCVLabel">CV Pelamar</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <embed src="{{ $pelamar->cv ? \Storage::url($pelamar->cv) : '' }}" type="application/pdf" class="w-100" style="height: 80vh;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
