<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Komponen Baru
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
                        Tambah Komponen
                    </x-slot>

                    <x-form method="POST" action="{{ route('komponen.store') }}" class="mt-4">
                        <div class="flex flex-wrap">
                            <x-inputs.group class="w-full lg:w-1/2">
                                <x-inputs.label-with-asterisk label="Nama Komponen"/>
                                <x-inputs.text
                                    name="nama_komponen"
                                    value="{{ old('nama_komponen') }}"
                                    placeholder="Masukkan nama komponen"
                                    required
                                ></x-inputs.text>
                            </x-inputs.group>

                            <x-inputs.group class="w-full lg:w-1/2">
                                <x-inputs.label-with-asterisk label="Harga"/>
                                <x-inputs.number
                                    name="harga"
                                    value="{{ old('harga') }}"
                                    placeholder="Masukkan harga"
                                    step="0.01"
                                    min="0"
                                    required
                                ></x-inputs.number>
                            </x-inputs.group>
                        </div>

                        <div class="mt-10">
                            <a href="{{ route('komponen.index') }}" class="button">
                                <i class="mr-1 icon ion-md-return-left text-primary"></i>
                                @lang('crud.common.back')
                            </a>

                            <button
                                type="submit"
                                class="button float-right"
                                style="background-color: #800000; color: white;"
                            >
                                <i class="mr-1 icon ion-md-save"></i>
                                @lang('crud.common.create')
                            </button>
                        </div>
                    </x-form>
                </x-partials.card>
            </div>
        </div>
    </div>
</x-app-layout>