<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Komponen
        </h2>
    </x-slot>

    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('komponen.index') }}" class="mr-4">
                            <i class="mr-1 icon ion-md-arrow-back"></i>
                        </a>
                        Detail Komponen: {{ $komponen->nama_komponen }}
                    </x-slot>

                    <div class="mt-4">
                        <div class="flex flex-wrap">
                            <x-partials.card class="w-full lg:w-1/2 mr-4">
                                <x-slot name="title">Informasi Komponen</x-slot>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nama Komponen</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $komponen->nama_komponen }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Harga</label>
                                        <p class="mt-1 text-sm text-gray-900">Rp {{ number_format($komponen->harga, 0, ',', '.') }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Dibuat</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $komponen->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Diperbarui</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $komponen->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </x-partials.card>

                            @if($komponen->produks->count() > 0)
                            <x-partials.card class="w-full lg:w-1/2">
                                <x-slot name="title">Produk yang Menggunakan Komponen Ini</x-slot>
                                
                                <div class="space-y-2">
                                    @foreach($komponen->produks as $produk)
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <p class="font-medium">{{ $produk->nama_produk }}</p>
                                        <p class="text-sm text-gray-600">
                                            Ukuran: {{ $produk->pivot->ukuran }} | 
                                            Quantity: {{ $produk->pivot->quantity }}
                                        </p>
                                    </div>
                                    @endforeach
                                </div>
                            </x-partials.card>
                            @endif
                        </div>

                        <div class="mt-10">
                            <a href="{{ route('komponen.index') }}" class="button">
                                <i class="mr-1 icon ion-md-return-left text-primary"></i>
                                @lang('crud.common.back')
                            </a>

                            <a href="{{ route('komponen.edit', $komponen) }}" class="button float-right" style="background-color: #800000; color: white;">
                                <i class="mr-1 icon ion-md-create"></i>
                                @lang('crud.common.edit')
                            </a>
                        </div>
                    </div>
                </x-partials.card>
            </div>
        </div>
    </div>
</x-app-layout>
