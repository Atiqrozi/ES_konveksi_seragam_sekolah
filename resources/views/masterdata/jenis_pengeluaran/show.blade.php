<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lihat Jenis Pengeluaran
        </h2>
    </x-slot>

    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('jenis_pengeluaran.index') }}" class="mr-4"
                            ><i class="mr-1 icon ion-md-arrow-back"></i
                        ></a>
                    </x-slot>

                    <div class="mt-4 px-4 row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Nama Jenis Pengeluaran
                                </h5>
                                <span>{{ $jenis_pengeluaran->nama_pengeluaran ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Keterangan
                                </h5>
                                <span>{{ $jenis_pengeluaran->keterangan ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Dibuat Pada
                                </h5>
                                <span>{{ $jenis_pengeluaran->created_at ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Diperbarui Pada
                                </h5>
                                <span>{{ $jenis_pengeluaran->updated_at ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <a href="{{ route('jenis_pengeluaran.index') }}" class="button">
                            <i class="mr-1 icon ion-md-return-left"></i>
                            @lang('crud.common.back')
                        </a>

                        @can('create', App\Models\JenisPengeluaran::class)
                        <a href="{{ route('jenis_pengeluaran.create') }}" class="button">
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
