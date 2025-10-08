<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.produks.show_title')
        </h2>
    </x-slot>

    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('produks.index') }}" class="mr-4">
                            <i class="mr-1 icon ion-md-arrow-back"></i>
                        </a>
                    </x-slot>

                    <div class="mt-4 px-4 row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">Nama</h5>
                                <span>{{ $produk->nama_produk ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">Nama</h5>
                                <span>{{ $produk->kategori->nama ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">Deskripsi</h5>
                                <span>{{ $produk->deskripsi_produk ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">Created At</h5>
                                <span>{{ $produk->created_at ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">Updated At</h5>
                                <span>{{ $produk->updated_at ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">Media Produk</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Jenis</th>
                                            <th>Preview</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Foto Sampul (wajib) --}}
                                        <tr>
                                            <td>Foto Sampul</td>
                                            <td>
                                                @if($produk->foto_sampul)
                                                    <img src="{{ Storage::url($produk->foto_sampul) }}" width="150" class="img-thumbnail">
                                                @else
                                                    <span>-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($produk->foto_sampul)
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalFotoSampul" style="background-color: #800000; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#700000'; this.style.color='white';" onmouseout="this.style.backgroundColor='#800000'; this.style.color='white';">
                                                        Lihat
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>

                                        {{-- Foto Lain --}}
                                        @foreach (['foto_lain_1', 'foto_lain_2', 'foto_lain_3'] as $fotoField)
                                            @if($produk->$fotoField)
                                                <tr>
                                                    <td>{{ ucfirst(str_replace('_', ' ', $fotoField)) }}</td>
                                                    <td>
                                                        <img src="{{ Storage::url($produk->$fotoField) }}" width="150" class="img-thumbnail">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal{{ $fotoField }}" style="background-color: #800000; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#700000'; this.style.color='white';" onmouseout="this.style.backgroundColor='#800000'; this.style.color='white';">
                                                            Lihat
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach

                                        {{-- Video --}}
                                        @if($produk->video)
                                            <tr>
                                                <td>Video</td>
                                                <td>
                                                    <video width="250" controls>
                                                        <source src="{{ Storage::url($produk->video) }}" type="video/mp4">
                                                        Browser Anda tidak mendukung tag video.
                                                    </video>
                                                </td>
                                                <td>-</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <a href="{{ route('produks.index') }}" class="button">
                            <i class="mr-1 icon ion-md-return-left"></i>
                            @lang('crud.common.back')
                        </a>

                        @can('create', App\Models\Produk::class)
                        <a href="{{ route('produks.create') }}" class="button">
                            <i class="mr-1 icon ion-md-add"></i>
                            @lang('crud.common.create')
                        </a>
                        @endcan
                    </div>
                </x-partials.card>
            </div>
        </div>
    </div>

    {{-- Modal Foto Sampul --}}
    @if($produk->foto_sampul)
    <div class="modal fade" id="modalFotoSampul" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Foto Sampul</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ Storage::url($produk->foto_sampul) }}" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Modal Foto Lain --}}
    @foreach (['foto_lain_1', 'foto_lain_2', 'foto_lain_3'] as $fotoField)
        @if($produk->$fotoField)
        <div class="modal fade" id="modal{{ $fotoField }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ ucfirst(str_replace('_', ' ', $fotoField)) }}</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ Storage::url($produk->$fotoField) }}" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endforeach
</x-app-layout>
