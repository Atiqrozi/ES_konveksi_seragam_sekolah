<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Master Data Komponen
        </h2>
    </x-slot>

    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <style>
                @media (max-width: 768px) {
                    .py-12.bg-grey.min-h-screen { padding-top: 1rem !important; padding-bottom: 1rem !important; }
                    .max-w-7xl.mx-auto.sm\:px-6.lg\:px-8 { padding-left: 0.75rem !important; padding-right: 0.75rem !important; }
                    .flex.justify-between.items-center { flex-direction: column !important; gap: 12px; align-items: flex-start !important; }
                    .flex.justify-between.items-center a.button { width: 100% !important; text-align: center !important; justify-content: center !important; display: inline-flex !important; }
                    .block.w-full.overflow-auto { padding: 0; overflow-x: hidden !important; }
                    .block.w-full.overflow-auto table { display: block; width: 100%; }
                    .block.w-full.overflow-auto thead { display: none; }
                    .block.w-full.overflow-auto tbody { display: block; }
                    .block.w-full.overflow-auto tbody tr { display: block; border: 1px solid #e5e7eb; margin-bottom: 16px; padding: 12px; border-radius: 8px; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
                    .block.w-full.overflow-auto tbody tr td { display: block !important; padding: 8px 0 !important; width: 100% !important; max-width: 100% !important; box-sizing: border-box; border-bottom: 1px solid #f3f4f6; text-align: left !important; }
                    .block.w-full.overflow-auto tbody tr td:last-child { border-bottom: none; }
                    .block.w-full.overflow-auto tbody tr td[data-label]::before { content: attr(data-label); display: block; font-weight: 600; color: #800000; margin-bottom: 4px; font-size: 0.875rem; }
                    .block.w-full.overflow-auto tbody tr td[data-label="Aksi"] { text-align: center !important; padding-top: 12px !important; }
                    .block.w-full.overflow-auto tbody tr td[data-label="Aksi"] .flex { display: flex !important; justify-content: center !important; align-items: center !important; gap: 8px !important; }
                    .block.w-full.overflow-auto tbody tr td[data-label="Aksi"] button.button { min-width: 40px !important; height: 40px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; }
                    .mt-4 { margin-top: 12px !important; }
                }
            </style>
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
                                        No.
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
                                    <td class="px-4 py-3" data-label="No.">{{ $komponens->firstItem() + $index }}</td>
                                    <td class="px-4 py-3" data-label="Nama Komponen">{{ $komponen->nama_komponen }}</td>
                                    <td class="px-4 py-3" data-label="Harga">{{ $komponen->formatted_harga }}</td>
                                    <td class="px-4 py-3" data-label="Aksi">
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