<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lihat Calon Mitra
        </h2>
    </x-slot>

    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('calon_mitra.index') }}" class="mr-4"
                            ><i class="mr-1 icon ion-md-arrow-back"></i
                        ></a>
                    </x-slot>

                    <div class="mt-4 px-4 row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Nama
                                </h5>
                                <span>{{ $calon_mitra->nama ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Nomor Whatapp
                                </h5>
                                <span>{{ $calon_mitra->nomor_wa ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Alamat
                                </h5>
                                <span>{{ $calon_mitra->alamat ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Dibuat Pada
                                </h5>
                                <span>{{ $calon_mitra->created_at ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <a href="{{ route('calon_mitra.index') }}" class="button">
                            <i class="mr-1 icon ion-md-return-left"></i>
                            @lang('crud.common.back')
                        </a>
                    </div>
                </x-partials.card>
            </div>
        </div>
    </div>
</x-app-layout>
