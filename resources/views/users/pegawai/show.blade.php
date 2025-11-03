<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Show Pegawai
        </h2>
    </x-slot>

    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('pegawai.index') }}" class="mr-4"
                            ><i class="mr-1 icon ion-md-arrow-back"></i
                        ></a>
                    </x-slot>

                    <div class="mt-4 px-4 row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Nama
                                </h5>
                                <span>{{ $pegawai->nama ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Email
                                </h5>
                                <span>{{ $pegawai->email ?? '-' }}</span>
                            </div>
                        
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Alamat
                                </h5>
                                <span>{{ $pegawai->alamat ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    No Telepon
                                </h5>
                                <span>{{ $pegawai->no_telepon ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Jenis Kelamin
                                </h5>
                                <span>{{ $pegawai->jenis_kelamin ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Gaji Yang Bisa Ditarik
                                </h5>
                                <span>{{ IDR($gaji_pegawai->total_gaji_yang_bisa_diajukan) ?? '-' }}</span>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Tanggal Lahir
                                </h5>
                                <span>{{ optional($pegawai->tanggal_lahir)->format('Y-m-d') ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Created At
                                </h5>
                                <span>{{ $pegawai->created_at ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Updated At
                                </h5>
                                <span>{{ $pegawai->updated_at ?? '-' }}</span>
                            </div>
                    
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Roles
                                </h5>
                                <div>
                                    @forelse ($pegawai->roles as $role)
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
                                    Riwayat Kegiatan <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#exampleModal" style="background-color: #800000; border:black 0;"><i class="fa-solid fa-eye"></i></button>
                                </h5>  
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <a href="{{ route('pegawai.index') }}" class="button">
                            <i class="mr-1 icon ion-md-return-left"></i>
                            @lang('crud.common.back')
                        </a>

                        @can('create_pegawai', App\Models\User::class)
                        <a href="{{ route('pegawai.create') }}" class="button">
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
                <h5 class="modal-title" id="exampleModalLabel">Riwayat Kegiatan</h5>
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
                            <th style="min-width: 200px;">Nama Kegiatan</th>
                            <th style="min-width: 150px;">Jumlah</th>
                            <th style="min-width: 150px;">Gaji Per Kegiatan</th>
                            <th style="min-width: 150px;">Total</th>
                            <th style="min-width: 200px;">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kegiatans as $key => $kegiatan)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $kegiatan->item->nama_item ?? '-' }}</td>
                                <td>{{ $kegiatan->jumlah_kegiatan ?? '-' }}</td>
                                <td>{{ $kegiatan->item ? IDR($kegiatan->item->gaji_per_item) : '-' }}</td>
                                <td>{{ $kegiatan->item ? IDR($kegiatan->jumlah_kegiatan * $kegiatan->item->gaji_per_item) : '-' }}</td>
                                <td>{{ $kegiatan->kegiatan_dibuat ?? '-' }}</td>
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