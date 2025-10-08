<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            List Jenis Pengeluaran
        </h2>
    </x-slot>

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

                                <div class="flex items-center w-full mt-2 mb-2">
                                    <span style="color: rgb(88, 88, 88);">
                                        &nbsp; Menampilkan &nbsp;
                                    </span>
                                    <x-inputs.select name="paginate" id="paginate" class="form-select" style="width: 75px" onchange="window.location.href = this.value">
                                        @foreach([10, 25, 50, 100] as $value)
                                            <option value="{{ route('jenis_pengeluaran.index', ['paginate' => $value, 'search' => $search]) }}" {{ $jenis_pengeluarans->perPage() == $value ? 'selected' : '' }}>
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
                            @can('create', App\Models\JenisPengeluaran::class)
                                <a href="{{ route('jenis_pengeluaran.create') }}" class="button" style="background-color: #800000; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#700000'; this.style.color='white';" onmouseout="this.style.backgroundColor='#800000'; this.style.color='white';">
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
                            <tr >
                                @php
                                    $columns = [
                                        'id' => 'No',
                                        'nama_pengeluaran' => 'Nama Jenis Pengeluaran',
                                        'keterangan' => 'Keterangan',
                                        'updated_at' => 'Updated At',
                                    ];
                                @endphp
                                @foreach($columns as $field => $label)
                                    <th class="px-4 py-3 text-left">
                                        <a href="{{ route('jenis_pengeluaran.index', array_merge(request()->query(), ['sort_by' => $field, 'sort_direction' => ($sortBy === $field && $sortDirection === 'asc') ? 'desc' : 'asc'])) }}">
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
                            @forelse($jenis_pengeluarans as $key => $jenis_pengeluaran)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left" style="max-width: 400px">
                                    {{ $jenis_pengeluarans->firstItem() + $key }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px">
                                    {{ $jenis_pengeluaran->nama_pengeluaran ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px">
                                    {{ $jenis_pengeluaran->keterangan ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px">
                                    {{ $jenis_pengeluaran->updated_at ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-center" style="width: 134px;">
                                    <div role="group" aria-label="Row Actions" class=" relative inline-flex align-middle">
                                        @can('update', $jenis_pengeluaran)
                                            <a href="{{ route('jenis_pengeluaran.edit', $jenis_pengeluaran) }}" class="mr-1">
                                                <button type="button" class="button">
                                                    <i class="icon ion-md-create"></i>
                                                </button>
                                            </a>
                                        @endcan
                                        @can('view', $jenis_pengeluaran)
                                            <a href="{{ route('jenis_pengeluaran.show', $jenis_pengeluaran) }}" class="mr-1">
                                                <button type="button" class="button">
                                                    <i class="icon ion-md-eye"></i>
                                                </button>
                                            </a>
                                        @endcan
                                        @can('delete', $jenis_pengeluaran)
                                            <form id="deleteForm" action="{{ route('jenis_pengeluaran.destroy', $jenis_pengeluaran->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div role="group" aria-label="Row Actions" class=" relative inline-flex align-middle">
                                                    <button type="button" class="button" onclick="confirmDelete('{{ $jenis_pengeluaran->id }}')">
                                                        <i class=" icon ion-md-trash text-red-600"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="display: table-cell; text-align: center; vertical-align: middle;">
                                    No Jenis Pengeluaran Found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <div class="mt-10 px-4">
                                        {!! $jenis_pengeluarans->render() !!}
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
        function confirmDelete(jenis_pengeluaranId) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: 'Konfirmasi hapus jenis pengeluaran',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika konfirmasi, submit formulir secara manual
                    document.getElementById('deleteForm').action = '{{ route('jenis_pengeluaran.destroy', '') }}/' + jenis_pengeluaranId;
                    document.getElementById('deleteForm').submit();
                }
            });
        }
    </script>
</x-app-layout>
