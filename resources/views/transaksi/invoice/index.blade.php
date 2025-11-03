<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pesanan List
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
            .block.w-full.overflow-auto tbody tr td[data-label="Action"] { text-align: center !important; padding-top: 12px !important; }
            .block.w-full.overflow-auto tbody tr td[data-label="Action"] > div { display: flex !important; justify-content: center !important; align-items: center !important; gap: 8px !important; }
            .block.w-full.overflow-auto tbody tr td[data-label="Action"] button.button { min-width: 40px !important; height: 40px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; }
            .block.w-full.overflow-auto tbody tr td[data-label="Action"] a.mr-1 { margin-right: 0 !important; }
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

                                    {{-- product dropdown for Admin only --}}
                                    @if(auth()->user()->hasRole('Admin'))
                                        <div class="ml-2">
                                            <x-inputs.select name="product_id" id="product_id">
                                                <option value="">Pilih Produk</option>
                                                @foreach($produks as $id => $name)
                                                    <option value="{{ $id }}" {{ (isset($product_id) && $product_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </x-inputs.select>
                                        </div>
                                    @endif

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

                                    @unless(auth()->user()->hasRole('Sales'))
                                        <div class="flex items-center w-full ml-3">
                                            <x-inputs.select name="customer_input" id="customer_input" class="form-select" style="width: 150px" onchange="this.form.submit()">
                                                <option value="">SEMUA</option>
                                                @foreach($customers as $value => $label)
                                                    <option value="{{ $value }}" {{ request('customer_input') == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </x-inputs.select>
                                        </div>
                                    @endunless
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
                                            @php
                                                $query = array_merge(request()->query(), ['paginate' => $value]);
                                            @endphp
                                            <option value="{{ route('invoice.index', $query) }}" {{ $invoices->perPage() == $value ? 'selected' : '' }}>
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
                            <a href="{{ route('pesanan.export_pdf') }}" class="button" style="background-color: rgb(129, 129, 129); color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='rgb(120, 120, 120)'; this.style.color='white';" onmouseout="this.style.backgroundColor='rgb(129, 129, 129)'; this.style.color='white';">
                                <i class="mr-1 icon ion-md-download"></i>
                                Pdf
                            </a>

                            <a href="{{ route('pesanan.export_excel') }}" class="button" style="background-color: rgb(83, 138, 0); color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='rgb(72, 121, 0)'; this.style.color='white';" onmouseout="this.style.backgroundColor='rgb(83, 138, 0)'; this.style.color='white';">
                                <i class="mr-1 icon ion-md-download"></i>
                                Excel
                            </a>
                            @can('create', App\Models\Invoice::class)
                                <a href="{{ route('invoice.create') }}" class="button" style="background-color: #800000; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#700000'; this.style.color='white';" onmouseout="this.style.backgroundColor='#800000'; this.style.color='white';">
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
                                        'invoice' => 'Invoice',
                                        'customer' => 'Customer',
                                        'sub_total' => 'Total Transaksi',
                                        'created_at' => 'Tanggal',
                                    ];
                                @endphp
                                @foreach($columns as $field => $label)
                                    <th class="px-4 py-3 text-left">
                                        <a href="{{ route('invoice.index', array_merge(request()->query(), ['sort_by' => $field, 'sort_direction' => ($sortBy === $field && $sortDirection === 'asc') ? 'desc' : 'asc'])) }}">
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
                            @forelse($invoices as $key => $invoice)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="No">
                                    {{ $invoices->firstItem() + $key }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="Invoice">
                                    {{ $invoice->invoice ?? '-'}}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="Customer">
                                    {{ optional($invoice->user)->nama ?? '-'}}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="Total Transaksi">
                                    {{ IDR($invoice->sub_total) ?? '-'}}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px" data-label="Tanggal">
                                    {{ $invoice->created_at ?? '-'}}
                                </td>
                                
                                <td class="px-4 py-3 text-center" style="width: 134px;" data-label="Action">
                                    <div role="group" aria-label="Row Actions" class=" relative inline-flex align-middle">
                                       
                                        @can('view', $invoice)
                                            <a href="{{ route('invoice.show', $invoice) }}" class="mr-1">
                                                <button type="button" class="button">
                                                    <i class="icon ion-md-eye"></i>
                                                </button>
                                            </a>
                                        @endcan 

                                        @can('update', $invoice)
                                            <a href="{{ route('invoice.edit', $invoice) }}" class="mr-1">
                                                <button type="button" class="button">
                                                    <i class="icon ion-md-create "></i>
                                                </button>
                                            </a>
                                        @endcan

                                        @can('delete', $invoice)
                                            <form id="deleteForm{{ $invoice->id }}" action="{{ route('invoice.destroy', $invoice->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div role="group" aria-label="Row Actions" class=" relative inline-flex align-middle">
                                                    <button type="button" class="button" onclick="confirmDelete('{{ $invoice->id }}')">
                                                        <i class="icon ion-md-trash text-red-500"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="display: table-cell; text-align: center; vertical-align: middle;">
                                    No Invoice Found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">
                                    <div class="mt-10 px-4">
                                        {!! $invoices->render() !!}
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
        function confirmDelete(produkId) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: 'Konfirmasi hapus pesanan',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika konfirmasi, submit formulir yang id-nya mengandung id pesanan
                    document.getElementById('deleteForm' + produkId).submit();
                }
            });
        }
    </script>
</x-app-layout>