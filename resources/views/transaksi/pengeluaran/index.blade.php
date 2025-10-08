<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pengeluaran
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

                                    <x-inputs.date
                                        name="start_date"
                                        value="{{ request('start_date') }}"
                                        class="ml-1 mr-1"
                                        placeholder="Dari Tanggal"
                                    />
                                    -
                                    <x-inputs.date
                                        name="end_date"
                                        value="{{ request('end_date') }}"
                                        class="ml-1"
                                        placeholder="Sampai Tanggal"
                                    />

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
                                            <option value="{{ route('pengeluaran.index', ['paginate' => $value, 'search' => $search]) }}" {{ $pengeluarans->perPage() == $value ? 'selected' : '' }}>
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
                            <a href="{{ route('pengeluaran.export_pdf') }}" class="button" style="background-color: rgb(129, 129, 129); color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='rgb(120, 120, 120)'; this.style.color='white';" onmouseout="this.style.backgroundColor='rgb(129, 129, 129)'; this.style.color='white';">
                                <i class="mr-1 icon ion-md-download"></i>
                                Pdf
                            </a>

                            <a href="{{ route('pengeluaran.export_excel') }}" class="button" style="background-color: rgb(83, 138, 0); color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='rgb(72, 121, 0)'; this.style.color='white';" onmouseout="this.style.backgroundColor='rgb(83, 138, 0)'; this.style.color='white';">
                                <i class="mr-1 icon ion-md-download"></i>
                                Excel
                            </a>
                            @can('create', App\Models\Pengeluaran::class)
                                <a href="{{ route('pengeluaran.create') }}" class="button" style="background-color: #800000; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#700000'; this.style.color='white';" onmouseout="this.style.backgroundColor='#800000'; this.style.color='white';">
                                    <i class="mr-1 icon ion-md-add"></i>
                                    @lang('crud.common.create')
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>

                @if($ringkasanPengeluaran->count())
                    <div class="mb-6 p-4 bg-gray-100 rounded shadow-sm">
                        @php                            $judulRangkuman = 'Rangkuman Pengeluaran';

                            $search = request('search');
                            $start = request('start_date');
                            $end = request('end_date');

                            if ($search) {
                                $judulRangkuman .= ' untuk pencarian: "' . $search . '"';
                            }

                            if ($start && $end) {
                                $judulRangkuman .= ' dari tanggal ' . Carbon\Carbon::parse($start)->format('d M Y') .
                                                ' sampai ' . Carbon\Carbon::parse($end)->format('d M Y');
                            } elseif ($start) {
                                $judulRangkuman .= ' dari tanggal ' . Carbon\Carbon::parse($start)->format('d M Y');
                            } elseif ($end) {
                                $judulRangkuman .= ' sampai tanggal ' . Carbon\Carbon::parse($end)->format('d M Y');
                            }

                            if (!$search && !$start && !$end) {
                                $judulRangkuman .= ' bulan ini';
                            }
                        @endphp

                        <h3 class="text-lg font-semibold text-gray-800 mb-2">
                            {{ $judulRangkuman }}
                        </h3>


                        <ul class="list-disc list-inside text-gray-700">
                            @foreach($ringkasanPengeluaran as $item)
                                <li>{{ $item->nama_pengeluaran }}: <strong>{{ IDR($item->total) }}</strong></li>
                            @endforeach
                        </ul>
                        <div class="mt-2 text-gray-900 font-bold">
                            Total Pengeluaran: {{ IDR($totalPengeluaran) }}
                        </div>
                    </div>
                @endif

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead style="color: #800000">
                            <tr >
                                @php
                                    $columns = [
                                        'id' => 'No',
                                        'nama_pengeluaran' => 'Jenis Pengeluaran',
                                        'keterangan' => 'Rincian',
                                        'jumlah' => 'Jumlah',
                                        'tanggal' => 'Tanggal',
                                    ];
                                @endphp
                                @foreach($columns as $field => $label)
                                    <th class="px-4 py-3 text-left">
                                        <a href="{{ route('pengeluaran.index', array_merge(request()->query(), ['sort_by' => $field, 'sort_direction' => ($sortBy === $field && $sortDirection === 'asc') ? 'desc' : 'asc'])) }}">
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
                            @forelse($pengeluarans as $key => $pengeluaran)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left" style="max-width: 400px">
                                    {{ $pengeluarans->firstItem() + $key }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px">
                                    {{ $pengeluaran->jenis_pengeluaran->nama_pengeluaran ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px">
                                    {{ $pengeluaran->keterangan ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px">
                                    {{ IDR($pengeluaran->jumlah) ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px">
                                    {{ $pengeluaran->tanggal }}
                                </td>
                                <td class="px-4 py-3 text-center" style="width: 134px;">
                                    <div role="group" aria-label="Row Actions" class=" relative inline-flex align-middle">
                                        @can('view', $pengeluaran)
                                            <a href="{{ route('pengeluaran.show', $pengeluaran) }}" class="mr-1">
                                                <button type="button" class="button">
                                                    <i class="icon ion-md-eye"></i>
                                                </button>
                                            </a>
                                        @endcan
                                        @can('update', $pengeluaran)
                                                <a href="{{ route('pengeluaran.edit', $pengeluaran) }}" class="mr-1">
                                                    <button type="button" class="button">
                                                        <i class="icon ion-md-create"></i>
                                                    </button>
                                                </a>
                                            @endcan
                                        @can('delete', $pengeluaran)
                                            <form id="deleteForm" action="{{ route('pengeluaran.destroy', $pengeluaran->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div role="group" aria-label="Row Actions" class=" relative inline-flex align-middle">
                                                    <button type="button" class="button" onclick="confirmDelete('{{ $pengeluaran->id }}')">
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
                                <td colspan="7" style="display: table-cell; text-align: center; vertical-align: middle;">
                                    No pengeluaran Found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <div class="mt-10 px-4">
                                        {!! $pengeluarans->render() !!}
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
        function confirmDelete(pengeluaranId) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: 'Konfirmasi hapus pengeluaran',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika konfirmasi, submit formulir secara manual
                    document.getElementById('deleteForm').action = '{{ route('pengeluaran.destroy', '') }}/' + pengeluaranId;
                    document.getElementById('deleteForm').submit();
                }
            });
        }
    </script>
</x-app-layout>
