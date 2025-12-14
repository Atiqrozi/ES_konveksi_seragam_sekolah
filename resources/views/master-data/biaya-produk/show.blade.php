<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Biaya Produk
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
                        Detail Biaya: {{ $produk->nama_produk }}
                    </x-slot>

                    <div class="mt-4">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Informasi Produk -->
                            <x-partials.card>
                                <x-slot name="title">Informasi Produk</x-slot>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $produk->nama_produk ?? '-' }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $produk->kategori->nama ?? '-' }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $produk->deskripsi ?? '-' }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Total Komponen</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $produk->produkKomponens->count() }} komponen</p>
                                    </div>
                                </div>
                            </x-partials.card>

                            <!-- Harga Berdasarkan Ukuran -->
                            <x-partials.card>
                                <x-slot name="title">Harga Berdasarkan Ukuran</x-slot>
                                
                                <div class="space-y-3">
                                    @php
                                        // Dapatkan semua ukuran yang ada di produk_komponens untuk produk ini
                                        $ukuranTersedia = $produk->produkKomponens->pluck('ukuran')->unique()->sort();
                                        
                                        // Jika tidak ada data ukuran, gunakan default
                                        if ($ukuranTersedia->isEmpty()) {
                                            $ukuranTersedia = collect(['S', 'M', 'L', 'XL', 'XXL', 'JUMBO']);
                                        }
                                    @endphp
                                    
                                    @forelse($ukuranTersedia as $ukuran)
                                    @php
                                        // Hitung total biaya untuk ukuran tertentu dari produk_komponens
                                        $komponenUkuran = $produk->produkKomponens->where('ukuran', $ukuran);
                                        $totalBiaya = $komponenUkuran->sum('total_harga');
                                        
                                        // Jika total_harga tidak tersedia, hitung manual
                                        if ($totalBiaya == 0 && $komponenUkuran->count() > 0) {
                                            $totalBiaya = $komponenUkuran->sum(function($komponen) {
                                                $harga = $komponen->harga_per_unit ?? $komponen->komponen->harga ?? 0;
                                                $qty = $komponen->quantity ?? 1;
                                                return $harga * $qty;
                                            });
                                        }
                                        
                                        $jumlahKomponen = $komponenUkuran->count();
                                    @endphp
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <div>
                                            <span class="font-medium">{{ $ukuran }}</span>
                                            <span class="text-sm text-gray-500">({{ $jumlahKomponen }} komponen)</span>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-medium text-green-600">
                                                {{ $totalBiaya > 0 ? 'Rp ' . number_format($totalBiaya, 0, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-4">
                                        <p class="text-gray-500">Belum ada data harga berdasarkan ukuran</p>
                                    </div>
                                    @endforelse
                                </div>
                            </x-partials.card>
                        </div>

                        <!-- Daftar Komponen -->
                        <div class="mt-6">
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
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($produk->produkKomponens as $produkKomponen)
                                            <tr>
                                                <td class="px-4 py-4 whitespace-nowrap">
                                                    <div class="font-medium text-gray-900">
                                                        {{ $produkKomponen->komponen->nama_komponen ?? $produkKomponen->nama_komponen ?? 'N/A' }}
                                                    </div>
                                                    @if($produkKomponen->komponen && $produkKomponen->komponen->deskripsi)
                                                    <div class="text-sm text-gray-500">
                                                        {{ Str::limit($produkKomponen->komponen->deskripsi, 50) }}
                                                    </div>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                                    <div class="text-gray-900">
                                                        Rp {{ number_format($produkKomponen->harga_per_unit ?? $produkKomponen->komponen->harga ?? 0, 0, ',', '.') }}
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                                    <div class="text-gray-900">{{ $produkKomponen->quantity ?? 1 }}</div>
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                                        {{ $produkKomponen->ukuran ?? 'S' }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                                    @php
                                                        // Hitung total harga komponen ini
                                                        $hargaSatuan = $produkKomponen->harga_per_unit ?? $produkKomponen->komponen->harga ?? 0;
                                                        $quantity = $produkKomponen->quantity ?? 1;
                                                        
                                                        // Dapatkan multiplier berdasarkan ukuran
                                                        $ukuranMultipliers = [
                                                            'S' => 1.0,
                                                            'M' => 1.3,
                                                            'L' => 1.6,
                                                            'XL' => 1.9,
                                                            'XXL' => 2.2,
                                                            'JUMBO' => 2.5
                                                        ];
                                                        $multiplier = $ukuranMultipliers[$produkKomponen->ukuran ?? 'S'] ?? 1.0;
                                                        
                                                        // Hitung total
                                                        $totalKomponen = $produkKomponen->total_harga ?? ($hargaSatuan * $quantity * $multiplier);
                                                    @endphp
                                                    <div class="font-medium text-green-600">
                                                        Rp {{ number_format($totalKomponen, 0, ',', '.') }}
                                                    </div>
                                                    @if($multiplier != 1.0)
                                                    <div class="text-xs text-gray-500">
                                                        ({{ $multiplier }}x ukuran)
                                                    </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                            
                                            <!-- Total Row -->
                                            <tr class="bg-gray-50 font-semibold">
                                                <td class="px-4 py-4 text-right" colspan="4">
                                                    <div class="font-medium text-gray-900">Total Keseluruhan:</div>
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                                    @php
                                                        $grandTotal = $produk->produkKomponens->sum(function($produkKomponen) {
                                                            $hargaSatuan = $produkKomponen->harga_per_unit ?? $produkKomponen->komponen->harga ?? 0;
                                                            $quantity = $produkKomponen->quantity ?? 1;
                                                            $ukuranMultipliers = [
                                                                'S' => 1.0, 'M' => 1.3, 'L' => 1.6, 
                                                                'XL' => 1.9, 'XXL' => 2.2, 'JUMBO' => 2.5
                                                            ];
                                                            $multiplier = $ukuranMultipliers[$produkKomponen->ukuran ?? 'S'] ?? 1.0;
                                                            return $produkKomponen->total_harga ?? ($hargaSatuan * $quantity * $multiplier);
                                                        });
                                                    @endphp
                                                    <div class="font-bold text-green-600 text-lg">
                                                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <div class="text-center py-8">
                                    <p class="text-gray-500">Belum ada komponen yang ditambahkan untuk produk ini</p>
                                </div>
                                @endif
                            </x-partials.card>
                        </div>

                        <div class="mt-10">
                            <a href="{{ route('biaya-produk.index') }}" class="button">
                                <i class="mr-1 icon ion-md-return-left text-primary"></i>
                                @lang('crud.common.back')
                            </a>
                        </div>
                    </div>
                </x-partials.card>
            </div>
        </div>
    </div>
</x-app-layout>
