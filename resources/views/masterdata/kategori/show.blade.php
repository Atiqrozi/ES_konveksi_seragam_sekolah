<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Show Kategori
        </h2>
    </x-slot>

    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('kategoris.index') }}" class="mr-4"
                            ><i class="mr-1 icon ion-md-arrow-back"></i
                        ></a>
                    </x-slot>

                    <div class="mt-4 px-4 row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Nama Kategori
                                </h5>
                                <span>{{ $kategori->nama ?? '-' }}</span>
                            </div>


                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Foto Kategori
                                </h5>
                                <x-partials.thumbnail
                                    src="{{ $kategori->foto ? \Storage::url($kategori->foto) : '' }}"
                                    size="150"
                                />
                                <button type="button" class="button mt-1" data-toggle="modal" data-target=".modal_foto" style="background-color: #800000; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#700000'; this.style.color='white';" onmouseout="this.style.backgroundColor='#800000'; this.style.color='white';">
                                    Lihat Foto
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Keterangan
                                </h5>
                                <span>{{ $kategori->keterangan ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Created At
                                </h5>
                                <span>{{ $kategori->created_at ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Updated At
                                </h5>
                                <span>{{ $kategori->updated_at ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <a href="{{ route('kategoris.index') }}" class="button">
                            <i class="mr-1 icon ion-md-return-left"></i>
                            @lang('crud.common.back')
                        </a>

                        @can('create', App\Models\Kategori::class)
                        <a href="{{ route('kategoris.create') }}" class="button">
                            <i class="mr-1 icon ion-md-add"></i>
                            @lang('crud.common.create')
                        </a>
                        @endcan
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
                    <h5 class="modal-title" id="modalFotoLabel">Foto Kategori</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center"> <!-- tambahkan kelas text-center untuk meratakan ke tengah -->
                    <img src="{{ $kategori->foto ? \Storage::url($kategori->foto) : '' }}" class="img-fluid mx-auto d-block" alt="Foto Kategori"> <!-- tambahkan kelas mx-auto d-block untuk meratakan ke tengah -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
