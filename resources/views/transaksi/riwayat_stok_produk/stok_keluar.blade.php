<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Stok Keluar
        </h2>
    </x-slot>

    <style>
        .text-red-600 {
            display: none;
        }
        
        /* Mobile-specific layout fixes (only affects <=768px) */
        @media (max-width: 768px) {
            /* Reduce page padding on mobile */
            .py-12.min-h-screen { padding-top: 1rem !important; padding-bottom: 1rem !important; }
            
            /* Adjust card container padding */
            .max-w-7xl.mx-auto.sm\:px-6.lg\:px-8 { padding-left: 0.75rem !important; padding-right: 0.75rem !important; }
            
            /* Stack the search/actions area into a column */
            .flex.flex-wrap.justify-between { flex-direction: column !important; gap: 12px; }
            .flex.flex-wrap.justify-between > .md\:w-1\/2 { width: 100% !important; }
            .flex.items-center.w-full { flex-direction: row; gap: 6px; }
            .flex.items-center.w-full .ml-1 { margin-left: 6px !important; }
            
            /* Make action buttons stack vertically on mobile */
            .md\:w-1\/2.text-right { 
                text-align: left !important; 
                display: flex !important; 
                flex-direction: column !important; 
                gap: 8px !important; 
            }
            .md\:w-1\/2.text-right a.button { 
                width: 100% !important; 
                text-align: center !important; 
                justify-content: center !important; 
                display: inline-flex !important;
                align-items: center !important;
            }

            /* Make table responsive: convert rows to block cards */
            .block.w-full.overflow-auto { 
                padding: 0 !important; 
                overflow-x: hidden !important; 
            }
            .block.w-full.overflow-auto table { 
                display: block !important; 
                width: 100% !important; 
            }
            .block.w-full.overflow-auto thead { 
                display: none !important; 
            }
            .block.w-full.overflow-auto tbody { 
                display: block !important; 
            }
            .block.w-full.overflow-auto tbody tr { 
                display: block !important; 
                border: 1px solid #e5e7eb; 
                margin-bottom: 16px; 
                padding: 12px; 
                border-radius: 8px; 
                background: #fff;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }
            
            /* Make each cell a row with label: value format */
            .block.w-full.overflow-auto tbody tr td { 
                display: block !important;
                padding: 8px 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
                border-bottom: 1px solid #f3f4f6;
                text-align: left !important;
            }
            
            .block.w-full.overflow-auto tbody tr td:last-child {
                border-bottom: none !important;
            }
            
            /* Add labels before cell content on mobile */
            .block.w-full.overflow-auto tbody tr td[data-label]::before { 
                content: attr(data-label);
                display: block;
                font-weight: 600;
                color: #800000;
                margin-bottom: 4px;
                font-size: 0.875rem;
            }
            
            /* Badge styling remains inline */
            .block.w-full.overflow-auto tbody tr td span.inline-flex {
                display: inline-flex !important;
            }

            /* Reduce paging footer spacing */
            .mt-10.px-4 { 
                margin-top: 12px !important; 
                padding-left: 0.5rem !important; 
                padding-right: 0.5rem !important; 
            }
        }
    </style>

    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Dashboard Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <a href="{{ route('riwayat_stok_produk.index') }}" class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow cursor-pointer">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-arrow-down text-green-500 text-3xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Stok Masuk</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($total_stok_masuk ?? 0) }}</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('riwayat_stok_produk.stok_keluar') }}" class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500 hover:shadow-lg transition-shadow cursor-pointer">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-arrow-up text-red-500 text-3xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Stok Keluar</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($total_stok_keluar ?? 0) }}</p>
                        </div>
                    </div>
                </a>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-list text-blue-500 text-3xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Data</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($total_transaksi ?? 0) }}</p>
                        </div>
                    </div>
                </div>
            </div>

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

                                <div class="flex items-center w-full mt-2 mb-2">
                                    <span style="color: rgb(88, 88, 88);">
                                        &nbsp; Menampilkan &nbsp;
                                    </span>
                                    <x-inputs.select name="paginate" id="paginate" class="form-select" style="width: 75px" onchange="window.location.href = this.value">
                                        @foreach([10, 25, 50, 100] as $value)
                                            <option value="{{ route('riwayat_stok_produk.stok_keluar', ['paginate' => $value, 'search' => $search]) }}" {{ $riwayat_stok_produks->perPage() == $value ? 'selected' : '' }}>
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
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-auto">
                    <table class="w-full mb-4 bg-transparent">
                        <thead style="color: #800000">
                            <tr>
                                @php
                                    $columns = [
                                        'id' => 'No',
                                        'nama_produk' => 'Produk',
                                        'ukuran_produk' => 'Ukuran',
                                        'created_at' => 'Tanggal',
                                        'jumlah_keluar' => 'Jumlah Keluar',
                                    ];
                                @endphp
                                @foreach($columns as $field => $label)
                                    <th class="px-4 py-3 text-left">
                                        <a href="{{ route('riwayat_stok_produk.stok_keluar', array_merge(request()->query(), ['sort_by' => $field, 'sort_direction' => ($sortBy === $field && $sortDirection === 'asc') ? 'desc' : 'asc'])) }}">
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
                                    Catatan
                                </th>
                                <th class="px-4 py-3 text-left">
                                    User
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse($riwayat_stok_produks as $riwayat_stok_produk)
                                <tr class="hover-bg-gray-50">
                                    <td data-label="No" class="px-4 py-3 text-left">
                                        {{ ($riwayat_stok_produks->currentPage() - 1) * $riwayat_stok_produks->perPage() + $loop->iteration }}
                                    </td>
                                    <td data-label="Produk" class="px-4 py-3 text-left">
                                        {{ $riwayat_stok_produk->produk->nama_produk ?? '-' }}
                                    </td>
                                    <td data-label="Ukuran" class="px-4 py-3 text-left">
                                        {{ $riwayat_stok_produk->ukuran_produk }}
                                    </td>
                                    <td data-label="Tanggal" class="px-4 py-3 text-left">
                                        {{ $riwayat_stok_produk->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td data-label="Jumlah Keluar" class="px-4 py-3 text-left">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            {{ $riwayat_stok_produk->jumlah_keluar }}
                                        </span>
                                    </td>
                                    <td data-label="Catatan" class="px-4 py-3 text-left">
                                        {{ $riwayat_stok_produk->catatan ?? '-' }}
                                    </td>
                                    <td data-label="User" class="px-4 py-3 text-left">
                                        {{ $riwayat_stok_produk->user->name ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-3 text-center">
                                        @lang('crud.common.no_items_found')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-10 px-4">{!! $riwayat_stok_produks->render() !!}</div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
