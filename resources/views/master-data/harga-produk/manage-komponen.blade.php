<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Komponen Produk: {{ $produk->nama_produk }}
        </h2>
    </x-slot>

    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Form Tambah Komponen -->
                <x-partials.card class="mb-6">
                    <x-slot name="title">
                        <a href="{{ route('harga-produk.index') }}" class="mr-4">
                            <i class="mr-1 icon ion-md-arrow-back"></i>
                        </a>
                        Tambah Komponen Baru
                    </x-slot>

                    <x-form method="POST" action="{{ route('harga-produk.store-komponen', $produk->id) }}" class="mt-4">
                        <div class="flex flex-wrap">
                            <x-inputs.group class="w-full lg:w-1/4">
                                <x-inputs.label-with-asterisk label="Komponen"/>
                                <x-inputs.select name="komponen_id" required>
                                    <option value="">Pilih Komponen</option>
                                    @foreach($komponens as $komponen)
                                        <option value="{{ $komponen->id }}">
                                            {{ $komponen->nama_komponen }} ({{ $komponen->formatted_harga }}/{{ $komponen->satuan }})
                                        </option>
                                    @endforeach
                                </x-inputs.select>
                            </x-inputs.group>

                            <x-inputs.group class="w-full lg:w-1/4">
                                <x-inputs.label-with-asterisk label="Ukuran"/>
                                <x-inputs.select name="ukuran" required>
                                    <option value="">Pilih Ukuran</option>
                                    @foreach($ukuranProduks as $ukuran)
                                        <option value="{{ $ukuran->ukuran }}">{{ $ukuran->ukuran }}</option>
                                    @endforeach
                                </x-inputs.select>
                            </x-inputs.group>

                            <x-inputs.group class="w-full lg:w-1/4">
                                <x-inputs.label-with-asterisk label="Quantity"/>
                                <x-inputs.number
                                    name="quantity"
                                    placeholder="Masukkan quantity"
                                    step="0.001"
                                    min="0"
                                    required
                                ></x-inputs.number>
                            </x-inputs.group>

                            <x-inputs.group class="w-full lg:w-1/4">
                                <x-inputs.label label="Keterangan"/>
                                <x-inputs.text
                                    name="keterangan"
                                    placeholder="Keterangan (opsional)"
                                ></x-inputs.text>
                            </x-inputs.group>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="button" style="background-color: #800000; color: white;">
                                <i class="mr-1 icon ion-md-add"></i>
                                Tambah Komponen
                            </button>
                        </div>
                    </x-form>
                </x-partials.card>

                <!-- Daftar Komponen -->
                <x-partials.card>
                    <x-slot name="title">Daftar Komponen Produk</x-slot>

                    @if($produk->produkKomponens->count() > 0)
                        <!-- Group by ukuran -->
                        @php
                            $komponensByUkuran = $produk->produkKomponens->groupBy('ukuran');
                        @endphp

                        @foreach($komponensByUkuran as $ukuran => $komponens)
                        <div class="mb-6 border border-gray-200 rounded-lg">
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                                <h4 class="text-lg font-semibold text-gray-900">Ukuran: {{ $ukuran }}</h4>
                                @php
                                    $totalBiaya = $komponens->sum(function($pk) {
                                        return $pk->quantity * $pk->komponen->harga;
                                    });
                                @endphp
                                <p class="text-sm text-gray-600">
                                    Total Biaya: <span class="font-semibold">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</span>
                                </p>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komponen</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($komponens as $produkKomponen)
                                        <tr>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $produkKomponen->komponen->nama_komponen }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ ucfirst($produkKomponen->komponen->satuan) }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $produkKomponen->komponen->formatted_harga }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <form action="{{ route('harga-produk.update-komponen', $produkKomponen->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input
                                                        type="number"
                                                        name="quantity"
                                                        value="{{ $produkKomponen->quantity }}"
                                                        step="0.001"
                                                        min="0"
                                                        class="w-20 px-2 py-1 text-sm border border-gray-300 rounded"
                                                        onchange="this.form.submit()"
                                                    >
                                                </form>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                {{ $produkKomponen->formatted_total_biaya }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <form action="{{ route('harga-produk.update-komponen', $produkKomponen->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="quantity" value="{{ $produkKomponen->quantity }}">
                                                    <input
                                                        type="text"
                                                        name="keterangan"
                                                        value="{{ $produkKomponen->keterangan }}"
                                                        placeholder="Keterangan"
                                                        class="w-32 px-2 py-1 text-sm border border-gray-300 rounded"
                                                        onchange="this.form.submit()"
                                                    >
                                                </form>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                                <form action="{{ route('harga-produk.delete-komponen', $produkKomponen->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="button button-sm bg-red-500 hover:bg-red-600" 
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus komponen ini?')">
                                                        <i class="icon ion-md-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">Belum ada komponen ditambahkan untuk produk ini</p>
                        </div>
                    @endif

                    <div class="mt-6 flex justify-between">
                        <a href="{{ route('harga-produk.index') }}" class="button">
                            <i class="mr-1 icon ion-md-return-left text-primary"></i>
                            Kembali ke Daftar Harga
                        </a>

                        @if($produk->produkKomponens->count() > 0)
                        <form action="{{ route('harga-produk.update-harga-from-komponen', $produk->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="button bg-green-500 hover:bg-green-600" 
                                    onclick="return confirm('Apakah Anda yakin ingin memperbarui harga produk berdasarkan komponen?')">
                                <i class="mr-1 icon ion-md-refresh"></i>
                                Update Harga Produk
                            </button>
                        </form>
                        @endif
                    </div>
                </x-partials.card>
            </div>
        </div>
    </div>
</x-app-layout>