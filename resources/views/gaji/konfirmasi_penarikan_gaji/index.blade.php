<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Konfirmasi Ajuan Penarikan Gaji List
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen">
        <style>
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
                .block.w-full.overflow-auto tbody tr td[data-label="Action"] { text-align: center !important; padding-top: 12px !important; }
                .block.w-full.overflow-auto tbody tr td[data-label="Action"] > div { display: flex !important; justify-content: center !important; align-items: center !important; gap: 8px !important; }
                .block.w-full.overflow-auto tbody tr td[data-label="Action"] button.button { min-width: 40px !important; height: 40px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; }
                .block.w-full.overflow-auto tbody tr td[data-label="Action"] a.mr-1 { margin-right: 0 !important; }
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
                                            <option value="{{ route('konfirmasi_penarikan_gaji.index', ['paginate' => $value, 'search' => $search]) }}" {{ $konfirmasi_ajuans->perPage() == $value ? 'selected' : '' }}>
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
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead style="color: #800000">
                            <tr>
                                @php
                                    $columns = [
                                        'id' => 'No',
                                        'nama_pegawai' => 'Nama Pegawai',
                                        'gaji_yang_diajukan' => 'Gaji Ditarik',
                                        'status' => 'status',
                                        'mulai_tanggal' => 'Terhitung Tanggal',
                                        'akhir_tanggal' => 'Sampai Tanggal',
                                    ];
                                @endphp
                                @foreach($columns as $field => $label)
                                    <th class="px-4 py-3 text-left">
                                        <a href="{{ route('konfirmasi_penarikan_gaji.index', array_merge(request()->query(), ['sort_by' => $field, 'sort_direction' => ($sortBy === $field && $sortDirection === 'asc') ? 'desc' : 'asc'])) }}">
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
                            @forelse($konfirmasi_ajuans as $key => $konfirmasi_ajuan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="No">
                                    {{ $konfirmasi_ajuans->firstItem() + $key }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="Nama Pegawai">
                                    {{ $konfirmasi_ajuan->user->nama ?? '-'}}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="Gaji Ditarik">
                                    {{ IDR($konfirmasi_ajuan->gaji_yang_diajukan) ?? '-'}}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="status">
                                    @if ($konfirmasi_ajuan->status == 'Diajukan')
                                        <div
                                            style="min-width: 80px;"
                                            class="
                                                inline-block
                                                py-1
                                                text-center text-sm
                                                rounded
                                                bg-yellow-600
                                                text-white
                                            "
                                        >
                                            {{ $konfirmasi_ajuan->status ?? '-' }}
                                        </div>
                                    @elseif ($konfirmasi_ajuan->status == 'Diterima')
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
                                            {{ $konfirmasi_ajuan->status ?? '-' }}
                                        </div>
                                    @elseif ($konfirmasi_ajuan->status == 'Ditolak')
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
                                            {{ $konfirmasi_ajuan->status ?? '-' }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="Terhitung Tanggal">
                                    {{ $konfirmasi_ajuan->mulai_tanggal ?? '-'}}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="Sampai Tanggal">
                                    {{ $konfirmasi_ajuan->akhir_tanggal ?? '-'}}
                                </td>
                                
                                <td class="px-4 py-3 text-center" style="width: 134px;" data-label="Action">
                                    <div role="group" aria-label="Row Actions" class=" relative inline-flex align-middle">
                                        @can('list_ajuan', $konfirmasi_ajuan)
                                            <a href="{{ route('konfirmasi_penarikan_gaji.show', $konfirmasi_ajuan) }}" class="mr-1">
                                                <button type="button" class="button">
                                                    <i class="icon ion-md-eye"></i>
                                                </button>
                                            </a>
                                        @endcan 
                                        @can('terima_ajuan', $konfirmasi_ajuan)
                                            <form id="terimaForm{{ $konfirmasi_ajuan->id }}" action="{{ route('konfirmasi_penarikan_gaji.terima_ajuan', $konfirmasi_ajuan->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                                    <button type="button" class="button mr-1" onclick="confirmTerima('{{ $konfirmasi_ajuan->id }}')">
                                                        <i class="icon ion-md-checkmark text-green-600"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        @endcan
                                        @can('tolak_ajuan', $konfirmasi_ajuan)
                                            <form id="tolakForm{{ $konfirmasi_ajuan->id }}" action="{{ route('konfirmasi_penarikan_gaji.tolak_ajuan', $konfirmasi_ajuan->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                                    <button type="button" class="button" onclick="confirmTolak('{{ $konfirmasi_ajuan->id }}')">
                                                        <i class="icon ion-md-close text-red-600"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        @endcan
                                    </div>
                                </td>                                
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="display: table-cell; text-align: center; vertical-align: middle;">
                                    No Ajuan Penarikan Gaji Found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <div class="mt-10 px-4">
                                        {!! $konfirmasi_ajuans->render() !!}
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
        function confirmTolak(id) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menolak penarikan gaji ini?',
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
                text: 'Apakah Anda yakin ingin menerima penarikan gaji ini?',
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