<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Master Data Komponen
        </h2>
    </x-slot>

    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <div class="flex justify-between items-center">
                            <span>Daftar Komponen</span>
                            <a href="{{ route('komponen.create') }}" class="button">
                                <i class="mr-1 icon ion-md-add"></i>
                                Tambah Komponen
                            </a>
                        </div>
                    </x-slot>

                    <div class="block w-full overflow-auto scrolling-touch">
                        <table class="w-full max-w-full mb-4 bg-transparent">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                        #
                                    </th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                        Nama Komponen
                                    </th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                        Harga
                                    </th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($komponens as $index => $komponen)
                                <tr class="border-b border-gray-200">
                                    <td class="px-4 py-3">{{ $komponens->firstItem() + $index }}</td>
                                    <td class="px-4 py-3">{{ $komponen->nama_komponen }}</td>
                                    <td class="px-4 py-3">{{ $komponen->formatted_harga }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('komponen.show', $komponen) }}" class="button button-sm">
                                                <i class="icon ion-md-eye"></i>
                                            </a>
                                            <a href="{{ route('komponen.edit', $komponen) }}" class="button button-sm">
                                                <i class="icon ion-md-create"></i>
                                            </a>
                                            <form action="{{ route('komponen.destroy', $komponen) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="button button-sm bg-red-500 hover:bg-red-600" 
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus komponen ini?')">
                                                    <i class="icon ion-md-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-center text-gray-500">
                                        Tidak ada data komponen
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {!! $komponens->links() !!}
                    </div>
                </x-partials.card>
            </div>
        </div>
    </div>
</x-app-layout>