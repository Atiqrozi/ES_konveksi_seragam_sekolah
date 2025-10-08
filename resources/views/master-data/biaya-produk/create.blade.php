<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Biaya Produk
        </h2>
    </x-slot>

    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('biaya-produk.index') }}" class="mr-4">
                            <i class="mr-1 icon ion-md-arrow-back"></i>
                        </a>
                        Tambah Biaya Produk
                    </x-slot>

                    <div class="mt-4">
                        <form
                            method="POST"
                            action="{{ route('biaya-produk.store') }}"
                            class="mt-4"
                        >
                            @csrf

                            <div class="flex flex-wrap">
                                <x-inputs.group class="w-full lg:w-1/2">
                                    <x-inputs.text
                                        name="produk_id"
                                        label="Pilih Produk*"
                                        type="hidden"
                                        value="{{ old('produk_id') }}"
                                        required
                                    ></x-inputs.text>
                                    
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Pilih Produk <span class="text-red-500">*</span>
                                    </label>
                                    <select 
                                        name="produk_id" 
                                        required
                                        class="form-control block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                        <option value="">Pilih Produk</option>
                                        @foreach($produks as $produk)
                                        <option value="{{ $produk->id }}" {{ old('produk_id') == $produk->id ? 'selected' : '' }}>
                                            {{ $produk->nama_produk }} - {{ $produk->kategori->nama ?? 'Tanpa Kategori' }}
                                        </option>
                                        @endforeach
                                    </select>
                                </x-inputs.group>

                                <x-inputs.group class="w-full lg:w-1/2">
                                    <x-inputs.textarea
                                        name="keterangan"
                                        label="Keterangan"
                                        placeholder="Keterangan untuk biaya produk ini (opsional)"
                                        rows="3"
                                    >{{ old('keterangan') }}</x-inputs.textarea>
                                </x-inputs.group>
                            </div>

                            <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-2">Informasi</h4>
                                <ul class="text-sm text-gray-600 space-y-1">
                                    <li>• Setelah memilih produk dan menyimpan, Anda dapat menambahkan komponen-komponen biaya</li>
                                    <li>• Sistem akan otomatis menghitung biaya berdasarkan ukuran dengan multiplier yang sudah ditentukan</li>
                                    <li>• S (1.0x), M (1.3x), L (1.6x), XL (1.9x), XXL (2.2x), JUMBO (2.5x)</li>
                                </ul>
                            </div>

                            <div class="mt-10">
                                <a href="{{ route('biaya-produk.index') }}" class="button">
                                    <i class="mr-1 icon ion-md-return-left text-primary"></i>
                                    @lang('crud.common.back')
                                </a>

                                <button
                                    type="submit"
                                    class="button button-primary float-right"
                                >
                                    <i class="mr-1 icon ion-md-save"></i>
                                    @lang('crud.common.create')
                                </button>
                            </div>
                        </form>
                    </div>
                </x-partials.card>
            </div>
        </div>
    </div>
</x-app-layout>