<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Biaya Produk
        </h2>
    </x-slot>

    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        Daftar Biaya Produk
                    </x-slot>

                    <div class="mb-5 mt-4">
                        <div class="flex flex-wrap justify-between">
                            <div class="md:w-1/2">
                                <form>
                                    <div class="flex items-center w-full">
                                        <x-inputs.text
                                            name="search"
                                            value="{{ $search ?? '' }}"
                                            placeholder="{{ __('crud.common.search') }}"
                                            autocomplete="off"
                                        ></x-inputs.text>

                                        <div class="ml-1">
                                            <button
                                                type="submit"
                                                class="button button-primary"
                                            >
                                                <i class="icon ion-md-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="md:w-1/2 text-right">
                                @can('create', App\Models\Produk::class)
                                <a
                                    href="{{ route('biaya-produk.create') }}"
                                    class="button button-primary"
                                >
                                    <i class="mr-1 icon ion-md-add"></i>
                                    Tambah Biaya Produk
                                </a>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <div class="block w-full overflow-auto scrolling-touch">
                        <table class="w-full max-w-full mb-4 bg-transparent">
                            <thead class="text-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left">
                                        Nama Produk
                                    </th>
                                    <th class="px-4 py-3 text-left">
                                        Kategori
                                    </th>
                                    <th class="px-4 py-3 text-center">
                                        Ukuran Tersedia
                                    </th>
                                    <th class="px-4 py-3 text-center">
                                        Total Komponen
                                    </th>
                                    <th class="px-4 py-3 text-center">
                                        Harga Terendah
                                    </th>
                                    <th class="px-4 py-3 text-center">
                                        Harga Tertinggi
                                    </th>
                                    <th class="px-4 py-3 text-center">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600">
                                @forelse($produks as $produk)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-left">
                                        {{ $produk->nama_produk ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $produk->kategori->nama ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @php
                                            $ukuranTersedia = ['S', 'M', 'L', 'XL', 'XXL', 'JUMBO'];
                                        @endphp
                                        <div class="flex flex-wrap gap-1 justify-center">
                                            @foreach($ukuranTersedia as $ukuran)
                                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded">
                                                    {{ $ukuran }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        {{ $produk->produkKomponens->count() }} komponen
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @php
                                            $hargaTerendah = null;
                                            foreach(['S', 'M', 'L', 'XL', 'XXL', 'JUMBO'] as $ukuran) {
                                                $harga = $produk->getTotalBiayaForUkuran($ukuran);
                                                if ($harga > 0 && ($hargaTerendah === null || $harga < $hargaTerendah)) {
                                                    $hargaTerendah = $harga;
                                                }
                                            }
                                        @endphp
                                        {{ $hargaTerendah ? 'Rp ' . number_format($hargaTerendah, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @php
                                            $hargaTertinggi = 0;
                                            foreach(['S', 'M', 'L', 'XL', 'XXL', 'JUMBO'] as $ukuran) {
                                                $harga = $produk->getTotalBiayaForUkuran($ukuran);
                                                if ($harga > $hargaTertinggi) {
                                                    $hargaTertinggi = $harga;
                                                }
                                            }
                                        @endphp
                                        {{ $hargaTertinggi > 0 ? 'Rp ' . number_format($hargaTertinggi, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                            @can('update', $produk)
                                            <a
                                                href="{{ route('biaya-produk.show', $produk) }}"
                                                class="mr-1"
                                            >
                                                <button type="button" class="button">
                                                    <i class="icon ion-md-eye"></i>
                                                </button>
                                            </a>
                                            <a
                                                href="{{ route('biaya-produk.edit', $produk) }}"
                                                class="mr-1"
                                            >
                                                <button type="button" class="button">
                                                    <i class="icon ion-md-create"></i>
                                                </button>
                                            </a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="flex justify-center items-center py-4">
                                            <p class="text-gray-500">Tidak ada data produk</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-10 px-4">
                        {!! $produks->render() !!}
                    </div>
                </x-partials.card>
            </div>
        </div>
    </div>
</x-app-layout>