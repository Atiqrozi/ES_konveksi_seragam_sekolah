<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Biaya Produk
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
                        Kelola Biaya: {{ $produk->nama_produk }}
                    </x-slot>

                    <div class="mt-4">
                        <!-- Informasi Produk -->
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $produk->nama_produk }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $produk->kategori->nama ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Total Komponen</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $produk->produkKomponens->count() }} komponen</p>
                                </div>
                            </div>
                        </div>

                        <!-- Form Tambah Komponen -->
                        <div class="mb-6">
                            <x-partials.card>
                                <x-slot name="title">Tambah Komponen</x-slot>
                                
                                <form
                                    method="POST"
                                    action="{{ route('biaya-produk.update', $produk) }}"
                                    class="mt-4"
                                >
                                    @csrf
                                    @method('PUT')

                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Komponen <span class="text-red-500">*</span>
                                            </label>
                                            <select 
                                                name="komponen_id" 
                                                required
                                                class="form-control block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            >
                                                <option value="">Pilih Komponen</option>
                                                @foreach($komponens as $komponen)
                                                <option value="{{ $komponen->id }}" data-harga="{{ $komponen->harga }}">
                                                    {{ $komponen->nama_komponen }} - Rp {{ number_format($komponen->harga, 0, ',', '.') }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Ukuran <span class="text-red-500">*</span>
                                            </label>
                                            <select 
                                                name="ukuran" 
                                                required
                                                class="form-control block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            >
                                                <option value="">Pilih Ukuran</option>
                                                <option value="S">S (1.0x)</option>
                                                <option value="M">M (1.3x)</option>
                                                <option value="L">L (1.6x)</option>
                                                <option value="XL">XL (1.9x)</option>
                                                <option value="XXL">XXL (2.2x)</option>
                                                <option value="JUMBO">JUMBO (2.5x)</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Quantity <span class="text-red-500">*</span>
                                            </label>
                                            <input
                                                type="number"
                                                name="quantity"
                                                placeholder="Masukkan quantity"
                                                step="0.01"
                                                min="0.01"
                                                required
                                                class="form-control block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            />
                                        </div>

                                        <div class="flex items-end">
                                            <button
                                                type="submit"
                                                class="button button-primary w-full"
                                            >
                                                <i class="mr-1 icon ion-md-add"></i>
                                                Tambah
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </x-partials.card>
                        </div>

                        <!-- Daftar Komponen -->
                        <x-partials.card>
                            <x-slot name="title">Daftar Komponen</x-slot>
                            
                            @if($produk->produkKomponens->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nama Komponen
                                            </th>
                                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Harga Satuan
                                            </th>
                                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Quantity
                                            </th>
                                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Ukuran
                                            </th>
                                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Total Harga
                                            </th>
                                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($produk->produkKomponens as $produkKomponen)
                                        <tr>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="font-medium text-gray-900">{{ $produkKomponen->komponen->nama_komponen }}</div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                                <div class="text-gray-900">Rp {{ number_format($produkKomponen->komponen->harga, 0, ',', '.') }}</div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                                <div class="text-gray-900">{{ $produkKomponen->quantity }}</div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                                    {{ $produkKomponen->ukuran }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                                @php
                                                    $totalKomponen = $produkKomponen->getTotalBiayaForUkuran();
                                                @endphp
                                                <div class="font-medium text-green-600">
                                                    Rp {{ number_format($totalKomponen, 0, ',', '.') }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                                <form
                                                    method="POST"
                                                    action="{{ route('biaya-produk.remove-komponen', ['produk' => $produk, 'komponen' => $produkKomponen->id]) }}"
                                                    class="inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus komponen ini?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="text-red-600 hover:text-red-900"
                                                    >
                                                        <i class="icon ion-md-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Summary Harga -->
                            <div class="mt-6 border-t pt-4">
                                <h4 class="text-lg font-medium mb-4">Ringkasan Harga Berdasarkan Ukuran</h4>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                                    @php
                                        $ukuranList = ['S', 'M', 'L', 'XL', 'XXL', 'JUMBO'];
                                        $multipliers = [
                                            'S' => 1.0,
                                            'M' => 1.3,
                                            'L' => 1.6,
                                            'XL' => 1.9,
                                            'XXL' => 2.2,
                                            'JUMBO' => 2.5
                                        ];
                                    @endphp
                                    
                                    @foreach($ukuranList as $ukuran)
                                    @php
                                        $totalBiaya = $produk->getTotalBiayaForUkuran($ukuran);
                                        $multiplier = $multipliers[$ukuran];
                                    @endphp
                                    <div class="bg-gray-50 p-3 rounded-lg text-center">
                                        <div class="font-medium text-gray-900">{{ $ukuran }}</div>
                                        <div class="text-xs text-gray-500">({{ $multiplier }}x)</div>
                                        <div class="mt-1 font-medium text-green-600">
                                            {{ $totalBiaya > 0 ? 'Rp ' . number_format($totalBiaya, 0, ',', '.') : '-' }}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @else
                            <div class="text-center py-8">
                                <p class="text-gray-500">Belum ada komponen yang ditambahkan</p>
                                <p class="text-sm text-gray-400 mt-1">Gunakan form di atas untuk menambah komponen</p>
                            </div>
                            @endif
                        </x-partials.card>

                        <div class="mt-10">
                            <a href="{{ route('biaya-produk.index') }}" class="button">
                                <i class="mr-1 icon ion-md-return-left text-primary"></i>
                                @lang('crud.common.back')
                            </a>

                            <a href="{{ route('biaya-produk.show', $produk) }}" class="button float-right" style="background-color: #800000; color: white;">
                                <i class="mr-1 icon ion-md-eye"></i>
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </x-partials.card>
            </div>
        </div>
    </div>
</x-app-layout>