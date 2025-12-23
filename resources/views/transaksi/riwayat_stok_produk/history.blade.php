@extends('layouts.app')

@section('content')
<div class="container">
    <div class="flex justify-between">
        <h1 class="mb-3 text-3xl font-bold">
            History Stok: {{ $stok_produk->produk->nama_produk }} ({{ $stok_produk->ukuran_produk }})
        </h1>
        <div>
            <a href="{{ route('riwayat_stok_produk.index') }}">
                <button type="button" class="button">
                    <i class="mr-1 icon ion-md-return-left"></i>
                    Kembali
                </button>
            </a>
        </div>
    </div>

    <div class="mt-4 px-4 py-3 bg-blue-100 rounded">
        <div class="flex justify-between items-center">
            <div>
                <span class="text-gray-700 font-semibold">Stok Terkini:</span>
                <span class="ml-2 px-4 py-2 text-lg font-bold rounded bg-blue-600 text-white">
                    {{ $stok_produk->stok_tersedia }} pcs
                </span>
            </div>
            <div class="text-sm text-gray-600">
                Terakhir update: {{ $stok_produk->updated_at->format('d M Y H:i') }}
            </div>
        </div>
    </div>

    <div class="block w-full mt-6 overflow-auto scrolling-touch">
        <table class="w-full max-w-full mb-4 bg-transparent">
            <thead style="color: #800000">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Tanggal</th>
                    <th class="px-4 py-3 text-left">Tipe</th>
                    <th class="px-4 py-3 text-left">Jumlah</th>
                    <th class="px-4 py-3 text-left">Catatan</th>
                    <th class="px-4 py-3 text-left">Oleh</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @forelse($histories as $key => $history)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $histories->firstItem() + $key }}</td>
                    <td class="px-4 py-3" style="white-space: nowrap;">
                        {{ $history->created_at->format('d M Y H:i') }}
                    </td>
                    <td class="px-4 py-3">
                        @if($history->tipe_transaksi == 'masuk')
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">
                                <i class="fas fa-arrow-down"></i> Stok Masuk
                            </span>
                        @else
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-800">
                                <i class="fas fa-arrow-up"></i> Stok Keluar
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <span class="font-semibold {{ $history->tipe_transaksi == 'masuk' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $history->tipe_transaksi == 'masuk' ? '+' : '-' }}
                            {{ $history->tipe_transaksi == 'masuk' ? $history->stok_masuk : $history->stok_keluar }} pcs
                        </span>
                    </td>
                    <td class="px-4 py-3" style="max-width: 300px;">
                        {{ $history->catatan ?? '-' }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $history->user->nama ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                        <i class="icon ion-md-file-text" style="font-size: 2rem;"></i>
                        <p class="mt-2">Belum ada history transaksi</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $histories->links() }}
    </div>
</div>
@endsection
