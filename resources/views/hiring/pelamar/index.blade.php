<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Pelamar
        </h2>
    </x-slot>

    <div class="mb-1" style="padding-top: 50px;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                    <form id="recruitment_form" action="{{ route('recruitment.update', 1) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="flex flex-wrap">
                            <x-inputs.group class="w-full">
                                <x-inputs.label-with-asterisk label="Buka Recruitment"/>
                                <x-inputs.select name="active">
                                    <option disabled selected>Pilih</option>
                                    @php $selected = old('active', $recruitment->active ?? ''); @endphp
                                    <option value="1" {{ $selected == '1' ? 'selected' : '' }} >Open</option>
                                    <option value="0" {{ $selected == '0' ? 'selected' : '' }} >Close</option>
                                </x-inputs.select>
                            </x-inputs.group>
                        </div>
                        
                        <div role="group" aria-label="Row Actions" class="text-right mt-10">
                            <button type="submit" id="createButton" class="button" style="background-color: #800000; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#700000'; this.style.color='white';" onmouseout="this.style.backgroundColor='#800000'; this.style.color='white';">
                                <i class="mr-1 icon ion-md-save"></i>
                                Update
                            </button>
                        </div>
                    </form>              
            </x-partials.card>
        </div>
    </div>

    <div class="py-12 min-h-screen">
        <style>
            /* Mobile-specific layout fixes for Daftar Pelamar (only affects <=768px) */
            @media (max-width: 768px) {
                /* Reduce page padding on mobile */
                .py-12.min-h-screen { padding-top: 1rem !important; padding-bottom: 1rem !important; }
                
                /* Stack the search/actions area into a column */
                .flex.flex-wrap.justify-between { flex-direction: column !important; gap: 12px; }
                .flex.flex-wrap.justify-between > .md\:w-1\/2 { width: 100% !important; }
                .flex.items-center.w-full { flex-direction: row; gap: 6px; flex-wrap: wrap; }
                .flex.items-center.w-full .ml-1 { margin-left: 6px !important; }
                .flex.items-center.w-full .ml-3 { margin-left: 0 !important; margin-top: 0.5rem !important; width: 100% !important; }
                
                /* Make action buttons stack vertically on mobile */
                .md\:w-1\/2.text-right { text-align: left !important; display: flex; flex-direction: column; gap: 8px; }
                .md\:w-1\/2.text-right a.button { width: 100%; text-align: center; justify-content: center; }

                /* Make table responsive: convert rows to block cards */
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
                
                /* Make each cell a row with label: value format */
                .block.w-full.overflow-auto tbody tr td { 
                    display: block !important;
                    padding: 8px 0 !important;
                    width: 100% !important;
                    max-width: 100% !important;
                    box-sizing: border-box;
                    border-bottom: 1px solid #f3f4f6;
                    text-align: left !important;
                }
                
                .block.w-full.overflow-auto tbody tr td:last-child {
                    border-bottom: none;
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
                
                /* Status badges - ensure proper display */
                .block.w-full.overflow-auto tbody tr td > div.inline-block {
                    display: inline-block !important;
                    margin-top: 4px;
                }
                
                /* Make action buttons display inline and centered */
                .block.w-full.overflow-auto tbody tr td[data-label="Aksi"] {
                    text-align: center !important;
                    padding-top: 12px !important;
                }
                
                .block.w-full.overflow-auto tbody tr td[data-label="Aksi"] > div {
                    display: flex !important;
                    justify-content: center !important;
                    gap: 8px !important;
                    flex-wrap: wrap !important;
                }

                /* Reduce paging footer spacing */
                .mt-10.px-4 { margin-top: 12px !important; padding-left: 0.5rem !important; padding-right: 0.5rem !important; }
                
                /* Adjust card container padding */
                .max-w-7xl.mx-auto.sm\:px-6.lg\:px-8 { padding-left: 0.75rem !important; padding-right: 0.75rem !important; }
                
                /* Recruitment form at top - make it mobile friendly */
                .mb-1 { margin-bottom: 1rem !important; padding-top: 1rem !important; }
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
                                            <option value="{{ route('pelamar.index', ['paginate' => $value, 'search' => $search]) }}" {{ $pelamars->perPage() == $value ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </x-inputs.select>
                                    <span style="color: rgb(88, 88, 88);">
                                        &nbsp;Data
                                    </span>

                                    <div class="flex items-center w-full ml-3">
                                        <x-inputs.select name="posisi_nama" id="posisi_nama" class="form-select" style="width: 150px" onchange="this.form.submit()">
                                            <option value="">SEMUA</option>
                                            @foreach($posisi_lowongans as $value => $label)
                                                <option value="{{ $value }}" {{ request('posisi_nama') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </x-inputs.select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="md:w-1/2 text-right">
                            <a href="{{ route('pelamar.export_excel') }}" class="button" style="background-color: rgb(83, 138, 0); color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='rgb(72, 121, 0)'; this.style.color='white';" onmouseout="this.style.backgroundColor='rgb(83, 138, 0)'; this.style.color='white';">
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
                                        'posisi_id' => 'Posisi',
                                        'status' => 'Status Lamaran',
                                        'weighted_sum_model' => 'Skor',
                                        'mulai_wawancara' => 'Waktu Wawancara',
                                    ];
                                @endphp
                                @foreach($columns as $field => $label)
                                    <th class="px-4 py-3 text-left">
                                        <a href="{{ route('pelamar.index', array_merge(request()->query(), ['sort_by' => $field, 'sort_direction' => ($sortBy === $field && $sortDirection === 'asc') ? 'desc' : 'asc'])) }}">
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
                            @forelse($pelamars as $key => $pelamar)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="No">
                                    {{ $pelamars->firstItem() + $key }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="Nama">
                                    {{ $pelamar->nama ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="Email">
                                    {{ $pelamar->email ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="Posisi">
                                    {{ $pelamar->posisi_lowongan->nama_posisi ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="Status Lamaran">
                                    @if ($pelamar->status == 'Diajukan')
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
                                            {{ $pelamar->status ?? '-' }}
                                        </div>
                                    @elseif ($pelamar->status == 'Belum Wawancara')
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
                                            {{ $pelamar->status ?? '-' }}
                                        </div>
                                    @elseif ($pelamar->status == 'Sudah Wawancara')
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
                                            {{ $pelamar->status ?? '-' }}
                                        </div>
                                    @elseif ($pelamar->status == 'Diterima')
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
                                            {{ $pelamar->status ?? '-' }}
                                        </div>
                                    @elseif ($pelamar->status == 'Ditolak')
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
                                            {{ $pelamar->status ?? '-' }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 200px" data-label="Skor">
                                    {{ $pelamar->weighted_sum_model ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left" style="min-width: 150px" data-label="Waktu Wawancara">
                                    {{ ($pelamar->mulai_wawancara instanceof \DateTime ? $pelamar->mulai_wawancara->format('Y-m-d') : '-') }}
                                    <br>
                                    {{ ($pelamar->mulai_wawancara instanceof \DateTime ? $pelamar->mulai_wawancara->format('H:i') : '-') }}
                                    -
                                    {{ ($pelamar->selesai_wawancara instanceof \DateTime ? $pelamar->selesai_wawancara->format('H:i') : '-') }}
                                </td>
                                <td class="px-4 py-3 text-center" style="width: 134px;" data-label="Aksi">
                                    <div role="group" aria-label="Row Actions" class=" relative inline-flex align-middle">
                                        @if ($pelamar->status == 'Sudah Wawancara')
                                            @can('update', $pelamar)
                                                <form id="terimaForm{{ $pelamar->id }}" action="{{ route('pelamar.terima_lamaran', $pelamar->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                                        <button type="button" class="button mr-1" onclick="confirmTerima('{{ $pelamar->id }}')">
                                                            <i class="icon ion-md-checkmark text-green-600"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            @endcan
                                        @endif
                                        @if ($pelamar->status == 'Sudah Wawancara')
                                            @can('update', $pelamar)
                                                <form id="tolakForm{{ $pelamar->id }}" action="{{ route('pelamar.tolak_lamaran', $pelamar->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                                        <button type="button" class="button mr-1" onclick="confirmTolak('{{ $pelamar->id }}')">
                                                            <i class="icon ion-md-close text-red-600"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            @endcan
                                        @endif
                                        @if ($pelamar->status != 'Sudah Wawancara')
                                            @can('update', $pelamar)
                                                <a href="{{ route('pelamar.edit_waktu', $pelamar) }}" class="mr-1">
                                                    <button type="button" class="button">
                                                        <i class="icoon ion-md-alarm"></i>
                                                    </button>
                                                </a>
                                            @endcan 
                                        @endif
                                        @if ($pelamar->status != 'Diajukan')
                                            @can('update', $pelamar)
                                                <a href="{{ route('pelamar.edit', $pelamar) }}" class="mr-1">
                                                    <button type="button" class="button">
                                                        <i class="icon ion-md-book"></i>
                                                    </button>
                                                </a>
                                            @endcan
                                        @endif
                                        @can('view', $pelamar)
                                            <a href="{{ route('pelamar.show', $pelamar) }}" class="mr-1">
                                                <button type="button" class="button">
                                                    <i class="icon ion-md-eye"></i>
                                                </button>
                                            </a>
                                        @endcan 
                                        @if ($pelamar->status == 'Diajukan')
                                            @can('delete', $pelamar)
                                                <form id="deleteForm" action="{{ route('pelamar.destroy', $pelamar->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div role="group" aria-label="Row Actions" class=" relative inline-flex align-middle">
                                                        <button type="button" class="button" onclick="confirmDelete('{{ $pelamar->id }}')">
                                                            <i class=" icon ion-md-trash text-red-600"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            @endcan
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" style="display: table-cell; text-align: center; vertical-align: middle;">
                                    No Pelamar Found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <div class="mt-10 px-4">
                                        {!! $pelamars->render() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>    
    
    <script>
        function confirmDelete(pelamarId) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: 'Konfirmasi hapus pelamar',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika konfirmasi, submit formulir secara manual
                    document.getElementById('deleteForm').action = '{{ route('pelamar.destroy', '') }}/' + pelamarId;
                    document.getElementById('deleteForm').submit();
                }
            });
        }

        function confirmTolak(id) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menolak pelamar ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('tolakForm' + id).submit();
                }
            });
        }
    
        function confirmTerima(id) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menerima pelamar ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('terimaForm' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>
