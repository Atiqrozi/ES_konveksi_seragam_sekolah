<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Stok Produk List
        </h2>
    </x-slot>

    <style>
        .text-red-600 {
            display: none;
        }
        @media (max-width: 768px) {
            .py-12.min-h-screen { padding-top: 1rem !important; padding-bottom: 1rem !important; }
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

    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card> 
                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form>
                                <div class="flex items-center w-full">
                                    <x-inputs.text name="search" value="{{ $search ?? '' }}" placeholder="{{ __('crud.common.search') }}" autocomplete="off"></x-inputs.text>

                                    <div class="ml-1">
                                        <button type="submit" class="button" style="background-color: #800000; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#700000'; this.style.color='white';" onmouseout="this.style.backgroundColor='#800000'; this.style.color='white';">
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="flex items-center w-1/2 mt-2">
                                    <x-inputs.basic 
                                        type="date" 
                                        id="start_date" 
                                        :name="'start_date'" 
                                        :value="$start_date ?? ''">
                                    </x-inputs.basic>

                                    <x-inputs.basic 
                                        type="date" 
                                        id="end_date" 
                                        :name="'end_date'" 
                                        :value="$end_date ?? ''">
                                    </x-inputs.basic>
                                </div>
                                <div class="flex items-center w-1/2 mt-2">
                                    @if ($errors->has('end_date'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('end_date') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="flex items-center w-full mt-2 mb-2">
                                    <span style="color: rgb(88, 88, 88);">
                                        &nbsp; Menampilkan &nbsp;
                                    </span>
                                    <x-inputs.select name="paginate" id="paginate" class="form-select" style="width: 75px" onchange="window.location.href = this.value">
                                        @foreach([10, 25, 50, 100] as $value)
                                            <option value="{{ route('riwayat_stok_produk.index', ['paginate' => $value, 'search' => $search]) }}" {{ $riwayat_stok_produks->perPage() == $value ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </x-inputs.select>
                                    <span style="color: rgb(88, 88, 88);">
                                        &nbsp;Data
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div class="md:w-1/2 text-right">
                            <a href="{{ route('riwayat_stok_produk.export_pdf') }}" class="button" style="background-color: rgb(129, 129, 129); color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='rgb(120, 120, 120)'; this.style.color='white';" onmouseout="this.style.backgroundColor='rgb(129, 129, 129)'; this.style.color='white';">
                                <i class="mr-1 icon ion-md-download"></i>
                                PDF
                            </a>

                            <a href="{{ route('riwayat_stok_produk.export_excel') }}" class="button" style="background-color: rgb(83, 138, 0); color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='rgb(72, 121, 0)'; this.style.color='white';" onmouseout="this.style.backgroundColor='rgb(83, 138, 0)'; this.style.color='white';">
                                <i class="mr-1 icon ion-md-download"></i>
                                Excel
                            </a>
                            @can('create', App\Models\Produk::class)
                                <a href="{{ route('riwayat_stok_produk.create') }}" class="button" style="background-color: #800000; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#700000'; this.style.color='white';" onmouseout="this.style.backgroundColor='#800000'; this.style.color='white';">
                                    <i class="mr-1 icon ion-md-add"></i>
                                    @lang('crud.common.create')
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead style="color: #800000">
                            <tr>
                                @php
                                    $columns = [
                                        'id' => 'No',
                                        'nama_produk' => 'Nama Produk',
                                        'ukuran_produk' => 'Ukuran Produk',
                                        'stok_masuk' => 'Stok Masuk',
                                        'catatan' => 'Catatan',
                                        'created_at' => 'Tanggal',
                                    ];
                                @endphp
                                @foreach($columns as $field => $label)
                                    <th class="px-4 py-3 text-left">
                                        <a href="{{ route('riwayat_stok_produk.index', array_merge(request()->query(), ['sort_by' => $field, 'sort_direction' => ($sortBy === $field && $sortDirection === 'asc') ? 'desc' : 'asc'])) }}">
                                            {{ $label }}
                                            @if($sortBy === $field)
                                                @if($sortDirection === 'asc')
                                                    <i class="icon ion-md-arrow-up"></i>
                                                @else
                                                    <i class="icon ion-md-arrow-down"></i>
                                                @endif
                                            @endif
                                        </a>
                                    </th>
                                @endforeach
                                <th class="px-4 py-3 text-left">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($riwayat_stok_produks as $key => $riwayat_stok_produk)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="No">
                                    {{ $riwayat_stok_produks->firstItem() + $key }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="Nama Produk">
                                    {{ optional($riwayat_stok_produk->produk)->nama_produk ?? '-'}}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="Ukuran Produk">
                                    {{ $riwayat_stok_produk->ukuran_produk ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="Stok Masuk">
                                    {{ $riwayat_stok_produk->stok_masuk ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="Catatan">
                                    {{ $riwayat_stok_produk->catatan ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="Tanggal">
                                    {{ $riwayat_stok_produk->updated_at ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-center" style="width: 134px;" data-label="Aksi">
                                    <div role="group" aria-label="Row Actions" class=" relative inline-flex align-middle">
                                        @can('view', $riwayat_stok_produk)
                                            <a href="{{ route('riwayat_stok_produk.show', $riwayat_stok_produk) }}" class="mr-1">
                                                <button type="button" class="button">
                                                    <i class="icon ion-md-eye"></i>
                                                </button>
                                            </a>
                                        @endcan 
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="display: table-cell; text-align: center; vertical-align: middle;">
                                    No Riwayat Stok Produk Found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <div class="mt-10 px-4">
                                        {{ $riwayat_stok_produks->links('vendor.pagination.tailwind') }}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>    
</x-app-layout>
