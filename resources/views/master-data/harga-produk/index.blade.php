<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Harga Produk Berdasarkan Komponen
        </h2>
    </x-slot>

    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <div class="flex justify-between items-center">
                            <span>Daftar Harga Produk</span>
                            <form method="GET" action="{{ route('harga-produk.index') }}" class="flex items-center space-x-2">
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Cari produk..."
                                    class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                                <button type="submit" class="button">
                                    <i class="icon ion-md-search"></i>
                                </button>
                            </form>
                        </div>
                    </x-slot>

                    @foreach($produks as $produk)
                    <div class="mb-8 border border-gray-200 rounded-lg">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $produk->nama_produk }}</h3>
                                    <p class="text-sm text-gray-600">Kategori: {{ $produk->kategori->nama ?? '-' }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('harga-produk.manage-komponen', $produk->id) }}" class="button button-sm">
                                        <i class="icon ion-md-settings mr-1"></i>
                                        Kelola Komponen
                                    </a>
                                    <form action="{{ route('harga-produk.update-harga-from-komponen', $produk->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="button button-sm bg-green-500 hover:bg-green-600" 
                                                onclick="return confirm('Apakah Anda yakin ingin memperbarui harga berdasarkan komponen?')">
                                            <i class="icon ion-md-refresh mr-1"></i>
                                            Update dari Komponen
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @if($produk->ukuran_data && $produk->ukuran_data->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ukuran</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Komponen</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga 1 (Asli)</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga 2 (+10%)</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga 3 (+10%)</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga 4 (+10%)</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Saat Ini</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($produk->ukuran_data as $ukuran)
                                    <tr>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $ukuran['ukuran'] }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                            Rp {{ number_format($ukuran['harga_komponen'], 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-green-600 font-semibold">
                                            Rp {{ number_format($ukuran['harga_1'], 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-blue-600 font-semibold">
                                            Rp {{ number_format($ukuran['harga_2'], 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-blue-600 font-semibold">
                                            Rp {{ number_format($ukuran['harga_3'], 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-blue-600 font-semibold">
                                            Rp {{ number_format($ukuran['harga_4'], 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                            <div class="text-xs space-y-1">
                                                <div>H1: Rp {{ number_format($ukuran['current_harga_1'] ?? 0, 0, ',', '.') }}</div>
                                                <div>H2: Rp {{ number_format($ukuran['current_harga_2'] ?? 0, 0, ',', '.') }}</div>
                                                <div>H3: Rp {{ number_format($ukuran['current_harga_3'] ?? 0, 0, ',', '.') }}</div>
                                                <div>H4: Rp {{ number_format($ukuran['current_harga_4'] ?? 0, 0, ',', '.') }}</div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="px-6 py-4 text-center text-gray-500">
                            Belum ada data ukuran untuk produk ini
                        </div>
                        @endif
                    </div>
                    @endforeach

                    @if($produks->count() == 0)
                    <div class="text-center py-8">
                        <p class="text-gray-500">Tidak ada data produk ditemukan</p>
                    </div>
                    @endif

                    <div class="mt-4">
                        {!! $produks->links() !!}
                    </div>
                </x-partials.card>
            </div>
        </div>
    </div>
</x-app-layout>