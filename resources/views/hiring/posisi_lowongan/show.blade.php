<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Show Posisi Lowongan
        </h2>
    </x-slot>

    <div class="bg">
        <style>
            /* Mobile-specific layout fixes for posisi lowongan show (only affects <=768px) */
            @media (max-width: 768px) {
                .py-12.bg-grey.min-h-screen { padding-top: 1rem !important; padding-bottom: 1rem !important; }
                .max-w-7xl.mx-auto.sm\:px-6.lg\:px-8 { padding-left: 0.75rem !important; padding-right: 0.75rem !important; }
                
                .mt-4.px-4.row { padding-left: 0 !important; padding-right: 0 !important; }
                .col-md-6 { width: 100% !important; max-width: 100% !important; }
                
                .mb-4 { margin-bottom: 1rem !important; }
                .mb-4 h5 { 
                    font-size: 14px !important;
                    font-weight: 600 !important;
                    color: #800000 !important;
                    margin-bottom: 0.5rem !important;
                }
                
                .mb-4 span {
                    font-size: 15px !important;
                    word-wrap: break-word !important;
                }
                
                .mt-10 { 
                    margin-top: 1.5rem !important;
                    display: flex !important;
                    flex-direction: column !important;
                    gap: 10px !important;
                }
                
                .mt-10 a.button {
                    width: 100% !important;
                    text-align: center !important;
                    justify-content: center !important;
                    display: inline-flex !important;
                    align-items: center !important;
                }
            }
        </style>
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('posisi_lowongan.index') }}" class="mr-4"
                            ><i class="mr-1 icon ion-md-arrow-back"></i
                        ></a>
                    </x-slot>

                    <div class="mt-4 px-4 row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Nama Posisi
                                </h5>
                                <span>{{ $posisi_lowongan->nama_posisi ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Deskripsi Posisi
                                </h5>
                                <span>{{ $posisi_lowongan->deskripsi_posisi ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Created At
                                </h5>
                                <span>{{ $posisi_lowongan->created_at ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Updated At
                                </h5>
                                <span>{{ $posisi_lowongan->updated_at ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <a href="{{ route('posisi_lowongan.index') }}" class="button">
                            <i class="mr-1 icon ion-md-return-left"></i>
                            @lang('crud.common.back')
                        </a>

                        @can('create', App\Models\PosisiLowongan::class)
                        <a href="{{ route('posisi_lowongan.create') }}" class="button">
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
