<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Pelamar List
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen">
        <style>
            /* Mobile-specific layout fixes for riwayat pelamar list (only affects <=768px) */
            @media (max-width: 768px) {
                .py-12.min-h-screen { padding-top: 1rem !important; padding-bottom: 1rem !important; }
                .max-w-7xl.mx-auto.sm\:px-6.lg\:px-8 { padding-left: 0.75rem !important; padding-right: 0.75rem !important; }
                
                .flex.flex-wrap.justify-between { flex-direction: column !important; gap: 12px; }
                .flex.flex-wrap.justify-between > .md\:w-1\/2 { width: 100% !important; }
                .flex.items-center.w-full { flex-wrap: wrap; gap: 6px; }
                .flex.items-center.w-full .ml-1 { margin-left: 6px !important; }
                
                .md\:w-1\/2.text-right { text-align: left !important; display: flex; flex-direction: column; gap: 8px; }
                .md\:w-1\/2.text-right a.button { width: 100%; text-align: center; justify-content: center; }

                .block.w-full.overflow-auto { padding: 0; overflow-x: hidden !important; }
                .block.w-full.overflow-auto table { display: block; width: 100%; }
                .block.w-full.overflow-auto thead { display: none; }
                .block.w-full.overflow-auto tbody { display: block; }
                .block.w-full.overflow-auto tbody tr { 
                    display: block; 
                    border: 1px solid #e5e7eb; 
                    margin-bottom: 16px; 
                    padding: 12px; 
                    border-radius: 8px; 
                    background: #fff;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                }
                
                .block.w-full.overflow-auto tbody tr td { 
                    display: block !important;
                    padding: 8px 0 !important;
                    width: 100% !important;
                    max-width: 100% !important;
                    box-sizing: border-box;
                    border-bottom: 1px solid #f3f4f6;
                    text-align: left !important;
                }
                
                .block.w-full.overflow-auto tbody tr td:last-child { border-bottom: none; }
                
                .block.w-full.overflow-auto tbody tr td[data-label]::before { 
                    content: attr(data-label);
                    display: block;
                    font-weight: 600;
                    color: #800000;
                    margin-bottom: 4px;
                    font-size: 0.875rem;
                }
                
                .block.w-full.overflow-auto tbody tr td > div.inline-block {
                    display: inline-block !important;
                    margin-top: 4px;
                }
                
                .block.w-full.overflow-auto tbody tr td[data-label="Action"] {
                    text-align: center !important;
                    padding-top: 12px !important;
                }
                
                .block.w-full.overflow-auto tbody tr td[data-label="Action"] > div {
                    display: flex !important;
                    justify-content: center !important;
                    gap: 8px !important;
                    flex-wrap: wrap !important;
                }

                .mt-10.px-4 { margin-top: 12px !important; padding-left: 0.5rem !important; padding-right: 0.5rem !important; }
            }
        </style>
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

                                <div class="flex items-center w-full mt-2 mb-2">
                                    <span style="color: rgb(88, 88, 88);">
                                        &nbsp; Menampilkan &nbsp;
                                    </span>
                                    <x-inputs.select name="paginate" id="paginate" class="form-select" style="width: 75px" onchange="window.location.href = this.value">
                                        @foreach([10, 25, 50, 100] as $value)
                                            <option value="{{ route('riwayat_pelamar.index', ['paginate' => $value, 'search' => $search]) }}" {{ $riwayat_pelamars->perPage() == $value ? 'selected' : '' }}>
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
                            <a href="{{ route('riwayat_pelamar.export_excel') }}" class="button" style="background-color: rgb(83, 138, 0); color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='rgb(72, 121, 0)'; this.style.color='white';" onmouseout="this.style.backgroundColor='rgb(83, 138, 0)'; this.style.color='white';">
                                <i class="mr-1 icon ion-md-download"></i>
                                Excel
                            </a>
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead style="color: #800000">
                            <tr >
                                @php
                                    $columns = [
                                        'id' => 'No',
                                        'nama' => 'Nama',
                                        'email' => 'Email',
                                        'alamat' => 'Alamat',
                                        'status' => 'Status Lamaran',
                                        'weighted_sum_model' => 'Skor',
                                        'mulai_wawancara' => 'Waktu Wawancara',
                                    ];
                                @endphp
                                @foreach($columns as $field => $label)
                                    <th class="px-4 py-3 text-left" style="min-width: 100px;">
                                        <a href="{{ route('riwayat_pelamar.index', array_merge(request()->query(), ['sort_by' => $field, 'sort_direction' => ($sortBy === $field && $sortDirection === 'asc') ? 'desc' : 'asc'])) }}">
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
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($riwayat_pelamars as $key => $riwayat_pelamar)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="No">
                                    {{ $riwayat_pelamars->firstItem() + $key }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="Nama">
                                    {{ $riwayat_pelamar->nama ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="Email">
                                    {{ $riwayat_pelamar->email ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="Alamat">
                                    {{ $riwayat_pelamar->alamat ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="Status Lamaran">
                                    @if ($riwayat_pelamar->status == 'Diajukan')
                                        <div
                                            style="min-width: 80px;"
                                            class="
                                                inline-block
                                                py-1
                                                text-center text-sm
                                                rounded
                                                bg-gray-500
                                                text-white
                                            "
                                        >
                                            {{ $riwayat_pelamar->status ?? '-' }}
                                        </div>
                                    @elseif ($riwayat_pelamar->status == 'Belum Wawancara')
                                        <div
                                            style="min-width: 130px;"
                                            class=" 
                                                inline-block
                                                py-1
                                                text-center text-sm
                                                rounded
                                                bg-indigo-600
                                                text-white
                                            "
                                        >
                                            {{ $riwayat_pelamar->status ?? '-' }}
                                        </div>
                                    @elseif ($riwayat_pelamar->status == 'Sudah Wawancara')
                                        <div
                                            style="min-width: 130px;"
                                            class=" 
                                                inline-block
                                                py-1
                                                text-center text-sm
                                                rounded
                                                bg-yellow-600
                                                text-white
                                            "
                                        >
                                            {{ $riwayat_pelamar->status ?? '-' }}
                                        </div>
                                    @elseif ($riwayat_pelamar->status == 'Diterima')
                                        <div
                                            style="min-width: 80px;"
                                            class=" 
                                                inline-block
                                                py-1
                                                text-center text-sm
                                                rounded
                                                bg-green-600
                                                text-white
                                            "
                                        >
                                            {{ $riwayat_pelamar->status ?? '-' }}
                                        </div>
                                    @elseif ($riwayat_pelamar->status == 'Ditolak')
                                        <div
                                            style="min-width: 80px;"
                                            class=" 
                                                inline-block
                                                py-1
                                                text-center text-sm
                                                rounded
                                                bg-rose-600
                                                text-white
                                            "
                                        >
                                            {{ $riwayat_pelamar->status ?? '-' }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 200px" data-label="Skor">
                                    {{ $riwayat_pelamar->weighted_sum_model ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left" style="min-width: 140px" data-label="Waktu Wawancara">
                                    {{ ($riwayat_pelamar->mulai_wawancara instanceof \DateTime ? $riwayat_pelamar->mulai_wawancara->format('Y-m-d') : '-') }}
                                    <br>
                                    {{ ($riwayat_pelamar->mulai_wawancara instanceof \DateTime ? $riwayat_pelamar->mulai_wawancara->format('H:i') : '-') }}
                                    -
                                    {{ ($riwayat_pelamar->selesai_wawancara instanceof \DateTime ? $riwayat_pelamar->selesai_wawancara->format('H:i') : '-') }}
                                </td>
                                <td class="px-4 py-3 text-center" style="width: 134px;" data-label="Action">
                                    <div role="group" aria-label="Row Actions" class=" relative inline-flex align-middle">
                                        @can('view_riwayat_pelamar', $riwayat_pelamar)
                                            <a href="{{ route('riwayat_pelamar.show', $riwayat_pelamar) }}" class="mr-1">
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
                                <td colspan="8" style="display: table-cell; text-align: center; vertical-align: middle;">
                                    No Riwayat Pelamar Found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <div class="mt-10 px-4">
                                        {!! $riwayat_pelamars->render() !!}
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