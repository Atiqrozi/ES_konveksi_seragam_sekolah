<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Biaya Produk
        </h2>
    </x-slot>

    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <style>
                @media (max-width: 768px) {
                    .py-12.bg-grey.min-h-screen { padding-top: 1rem !important; padding-bottom: 1rem !important; }
                    .max-w-7xl.mx-auto.sm\:px-6.lg\:px-8 { padding-left: 0.75rem !important; padding-right: 0.75rem !important; }
                    .flex.flex-wrap.justify-between { flex-direction: column !important; gap: 12px; }
                    .flex.flex-wrap.justify-between > .md\:w-1\/2 { width: 100% !important; }
                    .flex.items-center.w-full { flex-wrap: wrap; gap: 6px; }
                    .flex.items-center.w-full .ml-1 { margin-left: 6px !important; }
                    .md\:w-1\/2.text-right { text-align: left !important; display: flex !important; flex-direction: column !important; gap: 10px !important; width: 100% !important; }
                    .md\:w-1\/2.text-right a.button { width: 100% !important; text-align: center !important; justify-content: center !important; display: inline-flex !important; align-items: center !important; }
                    .block.w-full.overflow-auto { padding: 0; overflow-x: hidden !important; }
                    .block.w-full.overflow-auto table { display: block; width: 100%; }
                    .block.w-full.overflow-auto thead { display: none; }
                    .block.w-full.overflow-auto tbody { display: block; }
                    .block.w-full.overflow-auto tbody tr { display: block; border: 1px solid #e5e7eb; margin-bottom: 16px; padding: 12px; border-radius: 8px; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
                    .block.w-full.overflow-auto tbody tr td { display: block !important; padding: 8px 0 !important; width: 100% !important; max-width: 100% !important; box-sizing: border-box; border-bottom: 1px solid #f3f4f6; text-align: left !important; }
                    .block.w-full.overflow-auto tbody tr td:last-child { border-bottom: none; }
                    .block.w-full.overflow-auto tbody tr td[data-label]::before { content: attr(data-label); display: block; font-weight: 600; color: #800000; margin-bottom: 4px; font-size: 0.875rem; }
                    .block.w-full.overflow-auto tbody tr td[data-label="Aksi"] { text-align: center !important; padding-top: 12px !important; }
                    .block.w-full.overflow-auto tbody tr td[data-label="Aksi"] > div { display: flex !important; justify-content: center !important; align-items: center !important; gap: 8px !important; }
                    .block.w-full.overflow-auto tbody tr td[data-label="Aksi"] button.button { min-width: 40px !important; height: 40px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; }
                    .block.w-full.overflow-auto tbody tr td[data-label="Aksi"] a.mr-1 { margin-right: 0 !important; }
                    .mt-10.px-4 { margin-top: 12px !important; padding-left: 0.5rem !important; padding-right: 0.5rem !important; }
                }
            </style>
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
                                                style="background-color: #800000 !important; color: white !important; border-color: #800000 !important;"
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
                                    style="background-color: #800000 !important; color: white !important; border-color: #800000 !important;"
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
                                    <td class="px-4 py-3 text-left" data-label="Nama Produk">
                                        {{ $produk->nama_produk ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left" data-label="Kategori">
                                        {{ $produk->kategori->nama ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center" data-label="Ukuran Tersedia">
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
                                    <td class="px-4 py-3 text-center" data-label="Total Komponen">
                                        {{ $produk->produkKomponens->count() }} komponen
                                    </td>
                                    <td class="px-4 py-3 text-center" data-label="Harga Terendah">
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
                                    <td class="px-4 py-3 text-center" data-label="Harga Tertinggi">
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
                                    <td class="px-4 py-3 text-center" style="width: 134px;" data-label="Aksi">
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
                                                href="{{ $produk->biayaProduk ? route('biaya-produk.edit', $produk->biayaProduk->total_biaya_komponen) : route('biaya-produk.create', ['produk_id' => $produk->id]) }}"
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
