<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Biaya Produk
        </h2>
    </x-slot>

    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('biaya-produk.index') }}" class="mr-4">
                            <i class="mr-1 icon ion-md-arrow-back"></i>
                        </a>
                        Kelola Biaya: {{ $produk->nama_produk }}
                    </x-slot>

                    <div class="mt-4">
                        <!-- Success/Error Messages -->
                        @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Berhasil!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                        @endif

                        @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Terjadi kesalahan:</strong>
                            <ul class="mt-2 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Informasi Produk -->
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $produk->nama_produk }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $produk->kategori->nama ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Total Komponen</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $produk->produkKomponens->count() }} komponen</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Total Biaya Saat Ini</label>
                                    <p class="mt-1 text-sm font-bold text-blue-600">
                                        @if(isset($biayaProduk) && $biayaProduk->total_biaya_komponen > 0)
                                            Rp {{ number_format($biayaProduk->total_biaya_komponen, 0, ',', '.') }}
                                        @else
                                            Belum dihitung
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Form Tambah Komponen -->
                        <div class="mb-6">
                            <x-partials.card>
                                <x-slot name="title">Tambah Komponen</x-slot>
                                
                                <form
                                    method="POST"
                                    action="{{ route('biaya-produk.update', $biayaProduk->total_biaya_komponen) }}"
                                    class="mt-4"
                                    id="updateBiayaProdukForm"
                                >
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Keterangan
                                        </label>
                                        <textarea
                                            name="keterangan"
                                            placeholder="Keterangan untuk biaya produk ini (opsional)"
                                            rows="2"
                                            class="form-control block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        >{{ old('keterangan', $produk->keterangan) }}</textarea>
                                    </div>

                                    <h4 class="font-medium text-gray-900 mb-4">Tambah Komponen Baru</h4>
                                    
                                    <div id="komponen-container-edit">
                                        <div class="komponen-row flex flex-wrap items-end gap-4 mb-4 p-4 bg-gray-50 rounded-lg">
                                            <div class="flex-1 min-w-0">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                                    Komponen
                                                </label>
                                                <select 
                                                    name="komponen_ids[]" 
                                                    class="komponen-select form-control block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                    onchange="updateTotalEdit()"
                                                >
                                                    <option value="">Pilih Komponen</option>
                                                    @foreach($komponens as $komponen)
                                                    <option value="{{ $komponen->id }}" data-harga="{{ $komponen->harga }}">
                                                        {{ $komponen->nama_komponen }} - Rp {{ number_format($komponen->harga, 0, ',', '.') }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="w-32">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                                    Quantity
                                                </label>
                                                <input 
                                                    type="number" 
                                                    name="quantities[]" 
                                                    step="0.01" 
                                                    min="0.01"
                                                    placeholder="0.00"
                                                    class="quantity-input form-control block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                    onchange="updateTotalEdit()"
                                                >
                                            </div>
                                            <div class="w-32">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                                    Subtotal
                                                </label>
                                                <input 
                                                    type="text" 
                                                    class="subtotal form-control block w-full rounded-md border-gray-300 bg-gray-100" 
                                                    readonly
                                                    placeholder="Rp 0"
                                                >
                                            </div>
                                            <div class="w-20">
                                                <button 
                                                    type="button" 
                                                    class="remove-komponen bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded"
                                                    style="background-color: #800000 !important; color: white !important; border-color: #800000 !important;"
                                                    onclick="removeKomponenRowEdit(this)"
                                                >
                                                    <i class="icon ion-md-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-center mb-4">
                                        <button 
                                            type="button" 
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                            style="background-color: #800000 !important; color: white !important; border-color: #800000 !important;"
                                            onclick="addKomponenRowEdit()"
                                        >
                                            <i class="mr-1 icon ion-md-add"></i>
                                            Tambah Komponen
                                        </button>
                                        
                                        <div class="text-right">
                                            <p class="text-lg font-semibold">Total Komponen Baru: <span id="total-biaya-edit" class="text-blue-600">Rp 0</span></p>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <button
                                            type="submit"
                                            class="button button-primary"
                                            style="background-color: #800000 !important; color: white !important; border-color: #800000 !important;"
                                        >
                                            <i class="mr-1 icon ion-md-save"></i>
                                            Simpan Komponen
                                        </button>
                                    </div>
                                    
                                    <!-- Informasi Penting -->
                                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                        <h5 class="font-medium text-yellow-800 mb-2">📝 Informasi Penting:</h5>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-yellow-700">
                                            <div>
                                                <strong>Cara Menambah Komponen:</strong>
                                                <ul class="mt-1 space-y-1">
                                                    <li>1. Pilih komponen dari dropdown</li>
                                                    <li>2. Masukkan quantity yang dibutuhkan</li>
                                                    <li>3. Klik "Tambah Komponen" untuk menambah lebih banyak</li>
                                                    <li>4. Klik "Simpan Komponen" untuk menyimpan</li>
                                                </ul>
                                            </div>
                                            <div>
                                                <strong>Multiplier Ukuran:</strong>
                                                <ul class="mt-1 space-y-1">
                                                    <li>• S (1.0x), M (1.3x), L (1.6x)</li>
                                                    <li>• XL (1.9x), XXL (2.2x), JUMBO (2.5x)</li>
                                                    <li>• Sistem otomatis menghitung untuk semua ukuran</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </x-partials.card>
                        </div>

                        <!-- Daftar Komponen -->
                        <x-partials.card>
                            <x-slot name="title">Daftar Komponen</x-slot>
                            
                            @if($produk->produkKomponens->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nama Komponen
                                            </th>
                                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Harga Satuan
                                            </th>
                                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Quantity
                                            </th>
                                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Ukuran
                                            </th>
                                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Total Harga
                                            </th>
                                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($produk->produkKomponens as $produkKomponen)
                                        <tr>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="font-medium text-gray-900">{{ $produkKomponen->komponen->nama_komponen }}</div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                                <div class="text-gray-900">Rp {{ number_format($produkKomponen->komponen->harga, 0, ',', '.') }}</div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                                <div class="text-gray-900">{{ $produkKomponen->quantity }}</div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                                    {{ $produkKomponen->ukuran }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                                @php
                                                    $totalKomponen = $produkKomponen->getTotalBiayaForUkuran();
                                                @endphp
                                                <div class="font-medium text-green-600">
                                                    Rp {{ number_format($totalKomponen, 0, ',', '.') }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                                <form
                                                    method="POST"
                                                    action="{{ route('biaya-produk.remove-komponen', ['produk' => $produk, 'komponen' => $produkKomponen->id]) }}"
                                                    class="inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus komponen ini?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="text-red-600 hover:text-red-900"
                                                    >
                                                        <i class="icon ion-md-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Summary Harga -->
                            <div class="mt-6 border-t pt-4">
                                <h4 class="text-lg font-medium mb-4">Ringkasan Harga Berdasarkan Ukuran dan Tipe</h4>
                                
                                @php
                                    $ukuranList = ['S', 'M', 'L', 'XL', 'XXL', 'JUMBO'];
                                    $multipliers = [
                                        'S' => 1.0, 'M' => 1.3, 'L' => 1.6,
                                        'XL' => 1.9, 'XXL' => 2.2, 'JUMBO' => 2.5
                                    ];
                                @endphp
                                
                                <!-- Tabel Harga -->
                                <div class="overflow-x-auto">
                                    <table class="w-full border border-gray-200 rounded-lg">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ukuran</th>
                                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Harga Tipe 1</th>
                                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Harga Tipe 2</th>
                                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Harga Tipe 3</th>
                                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Harga Tipe 4</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($ukuranList as $ukuran)
                                            @php
                                                $ukuranLower = strtolower($ukuran);
                                                $harga1 = $biayaProduk->{"harga_{$ukuranLower}_1"} ?? 0;
                                                $harga2 = $biayaProduk->{"harga_{$ukuranLower}_2"} ?? 0;
                                                $harga3 = $biayaProduk->{"harga_{$ukuranLower}_3"} ?? 0;
                                                $harga4 = $biayaProduk->{"harga_{$ukuranLower}_4"} ?? 0;
                                                $multiplier = $multipliers[$ukuran];
                                            @endphp
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-3">
                                                    <span class="font-medium text-gray-900">{{ $ukuran }}</span>
                                                    <span class="text-xs text-gray-500 ml-1">({{ $multiplier }}x)</span>
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    <span class="text-sm font-medium text-blue-600">
                                                        {{ $harga1 > 0 ? 'Rp ' . number_format($harga1, 0, ',', '.') : '-' }}
                                                    </span>
                                                    <div class="text-xs text-gray-500">Harga Asli</div>
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    <span class="text-sm font-medium text-green-600">
                                                        {{ $harga2 > 0 ? 'Rp ' . number_format($harga2, 0, ',', '.') : '-' }}
                                                    </span>
                                                    <div class="text-xs text-gray-500">+10%</div>
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    <span class="text-sm font-medium text-orange-600">
                                                        {{ $harga3 > 0 ? 'Rp ' . number_format($harga3, 0, ',', '.') : '-' }}
                                                    </span>
                                                    <div class="text-xs text-gray-500">+20%</div>
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    <span class="text-sm font-medium text-red-600">
                                                        {{ $harga4 > 0 ? 'Rp ' . number_format($harga4, 0, ',', '.') : '-' }}
                                                    </span>
                                                    <div class="text-xs text-gray-500">+30%</div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                @if($biayaProduk->harga_s_1 == null)
                                <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <p class="text-yellow-700">
                                        <i class="icon ion-md-information-circle mr-1"></i>
                                        <strong>Info:</strong> Harga tipe belum dihitung. Sistem akan menghitung otomatis setelah Anda menyimpan komponen baru.
                                    </p>
                                </div>
                                @endif
                            </div>
                            @else
                            <div class="text-center py-8">
                                <p class="text-gray-500">Belum ada komponen yang ditambahkan</p>
                                <p class="text-sm text-gray-400 mt-1">Gunakan form di atas untuk menambah komponen</p>
                            </div>
                            @endif
                        </x-partials.card>

                        <div class="mt-10">
                            <a href="{{ route('biaya-produk.index') }}" class="button">
                                <i class="mr-1 icon ion-md-return-left text-primary"></i>
                                @lang('crud.common.back')
                            </a>

                            <a href="{{ route('biaya-produk.show', $produk) }}" class="button float-right" style="background-color: #800000; color: white;">
                                <i class="mr-1 icon ion-md-eye"></i>
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </x-partials.card>
            </div>
        </div>
    </div>

    <style>
        /* Custom styling untuk form elements */
        .komponen-select {
            background-color: #ffffff !important;
            color: #1f2937 !important;
        }
        
        .komponen-select option {
            background-color: #ffffff !important;
            color: #1f2937 !important;
            padding: 8px 12px !important;
        }
        
        .komponen-select option:checked,
        .komponen-select option:selected {
            background-color: #dbeafe !important;
            color: #1e40af !important;
            font-weight: 600 !important;
        }
        
        .komponen-row {
            transition: all 0.3s ease;
        }
        
        .komponen-row:hover {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
        }
        
        .button-primary {
            background-color: #4f46e5;
            border-color: #4f46e5;
            color: white;
            transition: all 0.2s ease;
        }
        
        .button-primary:hover {
            background-color: #4338ca;
            border-color: #4338ca;
            transform: translateY(-1px);
        }
        
        .button-primary:disabled {
            background-color: #9ca3af;
            border-color: #9ca3af;
            cursor: not-allowed;
            transform: none;
        }
    </style>

    <!-- Data untuk JavaScript -->
    <script type="application/json" id="komponen-data">@json($komponens ?? [])</script>
    
    <script type="text/javascript">
        // Get data komponen dari script tag
        var komponenDataEdit = JSON.parse(document.getElementById('komponen-data').textContent);
        
        function addKomponenRowEdit() {
            const container = document.getElementById('komponen-container-edit');
            const firstRow = container.querySelector('.komponen-row');
            const newRow = firstRow.cloneNode(true);
            
            // Reset values
            newRow.querySelector('.komponen-select').value = '';
            newRow.querySelector('.quantity-input').value = '';
            newRow.querySelector('.subtotal').value = '';
            
            // Add event listeners to new row
            const select = newRow.querySelector('.komponen-select');
            const quantityInput = newRow.querySelector('.quantity-input');
            
            select.addEventListener('change', updateTotalEdit);
            quantityInput.addEventListener('input', updateTotalEdit);
            
            container.appendChild(newRow);
            updateTotalEdit();
            
            // Focus on the new komponen select
            setTimeout(() => {
                newRow.querySelector('.komponen-select').focus();
            }, 100);
        }
        
        function removeKomponenRowEdit(button) {
            const container = document.getElementById('komponen-container-edit');
            if (container.children.length > 1) {
                button.closest('.komponen-row').remove();
                updateTotalEdit();
            } else {
                // Reset the last remaining row instead of removing it
                const row = button.closest('.komponen-row');
                row.querySelector('.komponen-select').value = '';
                row.querySelector('.quantity-input').value = '';
                row.querySelector('.subtotal').value = '';
                updateTotalEdit();
            }
        }
        
        function updateTotalEdit() {
            let total = 0;
            const rows = document.querySelectorAll('#komponen-container-edit .komponen-row');
            
            rows.forEach(row => {
                const select = row.querySelector('.komponen-select');
                const quantityInput = row.querySelector('.quantity-input');
                const subtotalInput = row.querySelector('.subtotal');
                
                if (select.value && quantityInput.value) {
                    const harga = parseFloat(select.options[select.selectedIndex].dataset.harga || 0);
                    const quantity = parseFloat(quantityInput.value || 0);
                    const subtotal = harga * quantity;
                    
                    subtotalInput.value = 'Rp ' + subtotal.toLocaleString('id-ID');
                    total += subtotal;
                } else {
                    subtotalInput.value = '';
                }
            });
            
            document.getElementById('total-biaya-edit').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
        
        // Event listeners for existing elements
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listeners to initial elements
            const initialSelects = document.querySelectorAll('#komponen-container-edit .komponen-select');
            const initialQuantities = document.querySelectorAll('#komponen-container-edit .quantity-input');
            
            initialSelects.forEach(select => {
                select.addEventListener('change', updateTotalEdit);
            });
            
            initialQuantities.forEach(input => {
                input.addEventListener('input', updateTotalEdit);
            });
            
            // Form validation before submit
            document.getElementById('updateBiayaProdukForm').addEventListener('submit', function(e) {
                const komponenSelects = document.querySelectorAll('select[name="komponen_ids[]"]');
                const quantityInputs = document.querySelectorAll('input[name="quantities[]"]');
                let hasValidKomponen = false;
                
                komponenSelects.forEach((select, index) => {
                    const quantity = quantityInputs[index] ? quantityInputs[index].value : '';
                    
                    if (select.value && quantity && parseFloat(quantity) > 0) {
                        hasValidKomponen = true;
                    }
                });

                if (!hasValidKomponen) {
                    e.preventDefault();
                    alert('Harap pilih minimal satu komponen dan masukkan quantity yang valid!');
                    return false;
                }
                
                // Show loading indicator
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="mr-1 fas fa-spinner fa-spin"></i>Menyimpan...';
                submitBtn.disabled = true;
                
                // Re-enable button after 5 seconds (in case of error)
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 5000);
                
                return true;
            });
            
            updateTotalEdit();
        });
    </script>
</x-app-layout>