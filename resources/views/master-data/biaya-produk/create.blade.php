<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($produk) ? 'Tambah Biaya Produk: ' . $produk->nama_produk : 'Tambah Biaya Produk' }}
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
                        {{ isset($produk) ? 'Tambah Biaya Produk: ' . $produk->nama_produk : 'Tambah Biaya Produk' }}
                    </x-slot>

                    <div class="mt-4">
                        <form
                            method="POST"
                            action="{{ route('biaya-produk.store') }}"
                            class="mt-4"
                            id="biayaProdukForm"
                        >
                            @csrf

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                                @if(isset($produk))
                                    <!-- Produk sudah ditentukan -->
                                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">
                                            Produk Terpilih
                                        </label>
                                        <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                                            <p class="text-green-800 font-medium text-lg">{{ $produk->nama_produk }}</p>
                                            <p class="text-green-600 text-sm mt-1">{{ $produk->kategori->nama ?? 'Tanpa Kategori' }}</p>
                                        </div>
                                    </div>
                                @else
                                    <!-- Pilih produk -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">
                                            Pilih Produk <span class="text-red-500">*</span>
                                        </label>
                                        <select 
                                            name="produk_id" 
                                            required
                                            class="block w-full rounded-lg border-2 border-gray-300 bg-white px-4 py-3 text-base text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none transition duration-200 ease-in-out hover:border-gray-400"
                                            style="background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTQiIGhlaWdodD0iOCIgdmlld0JveD0iMCAwIDE0IDgiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxwYXRoIGQ9Ik0xIDFMNyA3TDEzIDEiIHN0cm9rZT0iIzk0YTNiOCIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPC9zdmc+'); background-repeat: no-repeat; background-position: right 12px center; background-size: 14px 8px; appearance: none;"
                                        >
                                            <option value="" disabled selected style="color: #9ca3af;">Pilih Produk</option>
                                            @foreach($produks as $produkOption)
                                            <option 
                                                value="{{ $produkOption->id }}" 
                                                {{ old('produk_id') == $produkOption->id ? 'selected' : '' }}
                                                style="color: #1f2937; background-color: #ffffff; padding: 8px;"
                                                class="text-gray-900 bg-white hover:bg-blue-50"
                                            >
                                                {{ $produkOption->nama_produk }} - {{ $produkOption->kategori->nama ?? 'Tanpa Kategori' }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <p class="text-xs text-gray-500 mt-1">Pilih produk untuk menghitung biaya produksi</p>
                                    </div>
                                @endif

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">
                                        Keterangan
                                    </label>
                                    <textarea
                                        name="keterangan"
                                        placeholder="Keterangan untuk biaya produk ini (opsional)"
                                        rows="4"
                                        class="form-control block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-base resize-none"
                                    >{{ old('keterangan') }}</textarea>
                                    <p class="text-xs text-gray-500 mt-1">Catatan tambahan untuk biaya produk (opsional)</p>
                                </div>
                            </div>

                            <!-- Form Komponen - Selalu tampil jika ada komponen -->
                            @if(isset($komponens) && count($komponens) > 0)
                            <div class="border-t border-gray-200 pt-8">
                                <div class="mb-6">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Tambah Komponen Biaya</h3>
                                    <p class="text-sm text-gray-600">Pilih komponen-komponen yang dibutuhkan untuk membuat produk ini</p>
                                </div>
                                
                                <div id="komponen-container">
                                    <div class="komponen-row flex flex-wrap items-end gap-4 mb-4 p-4 bg-gray-50 rounded-lg">
                                        <div class="flex-1 min-w-0">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Komponen
                                            </label>
                                            <select 
                                                name="komponen_ids[]" 
                                                class="komponen-select block w-full rounded-lg border-2 border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none transition duration-200 ease-in-out hover:border-gray-400"
                                                onchange="updateTotal()"
                                                style="background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTQiIGhlaWdodD0iOCIgdmlld0JveD0iMCAwIDE0IDgiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxwYXRoIGQ9Ik0xIDFMNyA3TDEzIDEiIHN0cm9rZT0iIzk0YTNiOCIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPC9zdmc+'); background-repeat: no-repeat; background-position: right 8px center; background-size: 12px 6px; appearance: none;"
                                            >
                                                <option value="" disabled selected style="color: #9ca3af;">Pilih Komponen</option>
                                                @foreach($komponens as $komponen)
                                                <option 
                                                    value="{{ $komponen->id }}" 
                                                    data-harga="{{ $komponen->harga }}"
                                                    style="color: #1f2937; background-color: #ffffff;"
                                                    class="text-gray-900 bg-white"
                                                >
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
                                                onchange="updateTotal()"
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
                                                onclick="removeKomponenRow(this)"
                                            >
                                                <i class="icon ion-md-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="flex justify-between items-center mb-3">
                                        <div>
                                            <button 
                                                type="button" 
                                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105"
                                                style="background-color: #800000 !important; color: white !important; border-color: #800000 !important;"
                                                onclick="addKomponenRow()"
                                                id="addKomponenBtn"
                                            >
                                                <i class="mr-2 icon ion-md-add"></i>
                                                Tambah Komponen Baru
                                            </button>
                                            <p class="text-sm text-gray-600 mt-2">
                                                <i class="icon ion-md-information-circle mr-1"></i>
                                                Klik tombol di atas untuk menambahkan komponen lainnya
                                            </p>
                                        </div>
                                        
                                        <div class="text-right">
                                            <div class="bg-blue-100 p-3 rounded-lg">
                                                <p class="text-sm text-gray-600 mb-1">Total Biaya Produk:</p>
                                                <p class="text-xl font-bold text-blue-600" id="total-biaya">Rp 0</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                                        <h5 class="font-medium text-yellow-800 mb-2">📝 Cara Menambah Komponen:</h5>
                                        <ol class="text-sm text-yellow-700 space-y-1">
                                            <li>1. Pilih komponen dari dropdown</li>
                                            <li>2. Masukkan quantity yang dibutuhkan</li>
                                            <li>3. Klik tombol <strong>"Tambah Komponen Baru"</strong> untuk menambah komponen lain</li>
                                            <li>4. Ulangi langkah 1-3 untuk komponen selanjutnya</li>
                                            <li>💡 <strong>Tips:</strong> Tekan <kbd class="bg-gray-200 px-1 rounded">Ctrl + Enter</kbd> untuk cepat menambah komponen baru</li>
                                        </ol>
                                    </div>
                                    
                                    <!-- Debug Info -->
                                    @if(config('app.debug'))
                                    <div class="mb-2">
                                        <button 
                                            type="button" 
                                            onclick="toggleDebug()" 
                                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-3 rounded text-xs"
                                        >
                                            Toggle Debug Info
                                        </button>
                                    </div>
                                    <div id="debug-info" class="bg-gray-100 p-3 rounded text-xs hidden">
                                        <h6 class="font-bold">Debug Info:</h6>
                                        <div id="debug-content"></div>
                                    </div>
                                    @endif
                                    
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
                                </div>
                            </div>
                            @endif

                            <div class="mt-8 p-6 bg-blue-50 border border-blue-200 rounded-lg">
                                <h4 class="font-semibold text-blue-900 mb-3 flex items-center">
                                    <i class="icon ion-md-information-circle mr-2"></i>
                                    Informasi Penting
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <h5 class="font-medium text-blue-800 mb-2">Cara Penggunaan:</h5>
                                        <ul class="text-sm text-blue-700 space-y-1">
                                            <li>• Pilih produk terlebih dahulu</li>
                                            <li>• Tambahkan komponen-komponen yang dibutuhkan</li>
                                            <li>• Sistem akan otomatis menghitung total biaya</li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h5 class="font-medium text-blue-800 mb-2">Multiplier Ukuran:</h5>
                                        <ul class="text-sm text-blue-700 space-y-1">
                                            <li>• S (1.0x), M (1.3x), L (1.6x)</li>
                                            <li>• XL (1.9x), XXL (2.2x), JUMBO (2.5x)</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Preview Harga per Tipe -->
                            <div class="mt-8 p-6 bg-green-50 border border-green-200 rounded-lg" id="preview-harga" style="display:none;">
                                <h4 class="font-semibold text-green-900 mb-3 flex items-center">
                                    <i class="icon ion-md-calculator mr-2"></i>
                                    Preview Harga per Tipe (Setelah Disimpan)
                                </h4>
                                <p class="text-sm text-green-700 mb-4">Setelah data disimpan, sistem akan menghitung 4 tipe harga untuk setiap ukuran:</p>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div class="bg-white p-3 rounded border">
                                        <h6 class="font-medium text-green-800">Tipe Harga 1</h6>
                                        <p class="text-xs text-gray-600">Harga asli dari komponen</p>
                                    </div>
                                    <div class="bg-white p-3 rounded border">
                                        <h6 class="font-medium text-green-800">Tipe Harga 2</h6>
                                        <p class="text-xs text-gray-600">Harga asli + 10%</p>
                                    </div>
                                    <div class="bg-white p-3 rounded border">
                                        <h6 class="font-medium text-green-800">Tipe Harga 3</h6>
                                        <p class="text-xs text-gray-600">Harga asli + 20%</p>
                                    </div>
                                    <div class="bg-white p-3 rounded border">
                                        <h6 class="font-medium text-green-800">Tipe Harga 4</h6>
                                        <p class="text-xs text-gray-600">Harga asli + 30%</p>
                                    </div>
                                </div>
                                <div class="mt-4 text-sm text-green-600">
                                    💡 <strong>Info:</strong> Tipe harga akan otomatis dihitung untuk semua ukuran (S, M, L, XL, XXL, JUMBO) sesuai dengan multiplier masing-masing.
                                </div>
                            </div>

                            <div class="mt-10 pt-6 border-t border-gray-200">
                                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                                    <a href="{{ route('biaya-produk.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                        <i class="mr-2 icon ion-md-return-left text-gray-500"></i>
                                        Kembali
                                    </a>

                                    <button
                                        type="submit"
                                        class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out"
                                        style="background-color: #800000 !important; color: white !important; border-color: #800000 !important;"
                                    >
                                        <i class="mr-2 icon ion-md-save"></i>
                                        Simpan Biaya Produk
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </x-partials.card>
            </div>
        </div>
    </div>

    @if(isset($komponens) && count($komponens) > 0)
    <style>
        /* Custom dropdown styling */
        select[name="produk_id"] {
            background-color: #ffffff !important;
            color: #1f2937 !important;
            font-weight: 500;
        }
        
        select[name="produk_id"]:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
            border-color: #3b82f6 !important;
        }
        
        select[name="produk_id"] option {
            background-color: #ffffff !important;
            color: #1f2937 !important;
            padding: 12px 16px !important;
            font-size: 14px !important;
            border-bottom: 1px solid #f3f4f6;
        }
        
        select[name="produk_id"] option:hover {
            background-color: #eff6ff !important;
            color: #1e40af !important;
        }
        
        select[name="produk_id"] option:checked,
        select[name="produk_id"] option:selected {
            background-color: #dbeafe !important;
            color: #1e40af !important;
            font-weight: 600 !important;
        }
        
        select[name="produk_id"] option[disabled] {
            color: #9ca3af !important;
            font-style: italic;
        }
        
        /* Komponen select styling */
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
    </style>
    
    <!-- Data untuk JavaScript -->
    <script type="application/json" id="komponen-data-create">@json($komponens ?? [])</script>
    
    <script type="text/javascript">
        // Get data komponen dari script tag
        var komponenData = JSON.parse(document.getElementById('komponen-data-create').textContent);
        
        function addKomponenRow() {
            const container = document.getElementById('komponen-container');
            const firstRow = container.querySelector('.komponen-row');
            const newRow = firstRow.cloneNode(true);
            
            // Reset values
            newRow.querySelector('.komponen-select').value = '';
            newRow.querySelector('.quantity-input').value = '';
            newRow.querySelector('.subtotal').value = '';
            
            // Add event listeners to new row
            const select = newRow.querySelector('.komponen-select');
            const quantityInput = newRow.querySelector('.quantity-input');
            
            select.addEventListener('change', updateTotal);
            quantityInput.addEventListener('input', updateTotal);
            
            container.appendChild(newRow);
            
            // Scroll to new row
            newRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Focus on the new komponen select
            setTimeout(() => {
                newRow.querySelector('.komponen-select').focus();
            }, 100);
            
            // Update button text to show count
            updateAddButtonText();
            updateTotal();
            
            // Show success notification
            showNotification('Baris komponen baru telah ditambahkan!', 'success');
        }
        
        function removeKomponenRow(button) {
            const container = document.getElementById('komponen-container');
            if (container.children.length > 1) {
                button.closest('.komponen-row').remove();
                updateTotal();
                updateAddButtonText();
                showNotification('Baris komponen telah dihapus!', 'info');
            } else {
                // Reset the last remaining row instead of removing it
                const row = button.closest('.komponen-row');
                row.querySelector('.komponen-select').value = '';
                row.querySelector('.quantity-input').value = '';
                row.querySelector('.subtotal').value = '';
                updateTotal();
                showNotification('Baris komponen telah direset!', 'info');
            }
        }
        
        function updateAddButtonText() {
            const container = document.getElementById('komponen-container');
            const count = container.children.length;
            const button = document.getElementById('addKomponenBtn');
            
            if (count === 1) {
                button.innerHTML = '<i class="mr-2 icon ion-md-add"></i>Tambah Komponen Baru';
            } else {
                button.innerHTML = `<i class="mr-2 icon ion-md-add"></i>Tambah Komponen Baru (${count} komponen)`;
            }
        }
        
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transition-all duration-300 ${
                type === 'success' ? 'bg-green-500 text-white' : 
                type === 'info' ? 'bg-blue-500 text-white' : 
                'bg-gray-500 text-white'
            }`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="mr-2 icon ion-md-checkmark-circle"></i>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }
        
        function toggleDebug() {
            const debugDiv = document.getElementById('debug-info');
            if (debugDiv.classList.contains('hidden')) {
                debugDiv.classList.remove('hidden');
                updateTotal(); // Refresh debug info
            } else {
                debugDiv.classList.add('hidden');
            }
        }
        
        function updateTotal() {
            let total = 0;
            const rows = document.querySelectorAll('.komponen-row');
            
            // Debug info
            let debugInfo = `Total rows: ${rows.length}<br>`;
            
            rows.forEach((row, index) => {
                const select = row.querySelector('.komponen-select');
                const quantityInput = row.querySelector('.quantity-input');
                const subtotalInput = row.querySelector('.subtotal');
                
                debugInfo += `Row ${index}: select=${select.value}, quantity=${quantityInput.value}<br>`;
                
                if (select.value && quantityInput.value) {
                    const harga = parseFloat(select.options[select.selectedIndex].dataset.harga || 0);
                    const quantity = parseFloat(quantityInput.value || 0);
                    const subtotal = harga * quantity;
                    
                    subtotalInput.value = 'Rp ' + subtotal.toLocaleString('id-ID');
                    total += subtotal;
                    
                    debugInfo += `&nbsp;&nbsp;harga=${harga}, subtotal=${subtotal}<br>`;
                } else {
                    subtotalInput.value = '';
                }
            });
            
            document.getElementById('total-biaya').textContent = 'Rp ' + total.toLocaleString('id-ID');
            
            // Tampilkan preview harga jika ada total biaya
            const previewHarga = document.getElementById('preview-harga');
            if (total > 0) {
                previewHarga.style.display = 'block';
                updatePreviewHarga(total);
            } else {
                previewHarga.style.display = 'none';
            }
            
            // Show debug info
            const debugDiv = document.getElementById('debug-info');
            const debugContent = document.getElementById('debug-content');
            if (debugDiv && debugContent) {
                debugContent.innerHTML = debugInfo + `Total: ${total}<br><br>`;
                debugContent.innerHTML += `<strong>Form akan mengirim data:</strong><br>`;
                debugContent.innerHTML += `produk_id: ${document.querySelector('select[name="produk_id"]')?.value || 'not selected'}<br>`;
                
                const komponenIds = [];
                const quantities = [];
                rows.forEach((row, index) => {
                    const select = row.querySelector('.komponen-select');
                    const quantityInput = row.querySelector('.quantity-input');
                    if (select.value && quantityInput.value) {
                        komponenIds.push(select.value);
                        quantities.push(quantityInput.value);
                    }
                });
                
                debugContent.innerHTML += `komponen_ids: [${komponenIds.join(', ')}]<br>`;
                debugContent.innerHTML += `quantities: [${quantities.join(', ')}]<br>`;
                debugContent.innerHTML += `keterangan: ${document.querySelector('textarea[name="keterangan"]')?.value || 'empty'}<br>`;
                
                if (!debugDiv.classList.contains('hidden')) {
                    // Auto show if not hidden
                }
            }
        }
        
        function updatePreviewHarga(basePriceS) {
            // Multiplier untuk ukuran
            const multipliers = {
                'S': 1.0,
                'M': 1.3,
                'L': 1.6,
                'XL': 1.9,
                'XXL': 2.2,
                'JUMBO': 2.5
            };
            
            // Tipe harga multiplier
            const tipeMultipliers = {
                1: 1.0,
                2: 1.10,
                3: 1.20,
                4: 1.30
            };
            
            // Update preview boxes dengan contoh untuk ukuran S
            const previewBoxes = document.querySelectorAll('#preview-harga .bg-white');
            previewBoxes.forEach((box, index) => {
                const tipe = index + 1;
                const harga = basePriceS * tipeMultipliers[tipe];
                
                const existingPrice = box.querySelector('.preview-price');
                if (existingPrice) {
                    existingPrice.remove();
                }
                
                const priceElement = document.createElement('p');
                priceElement.className = 'text-sm font-medium text-green-600 mt-1 preview-price';
                priceElement.textContent = `Contoh ukuran S: Rp ${harga.toLocaleString('id-ID')}`;
                box.appendChild(priceElement);
            });
        }
        
        // Event listeners for existing elements
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listeners to initial elements
            const initialSelects = document.querySelectorAll('.komponen-select');
            const initialQuantities = document.querySelectorAll('.quantity-input');
            
            initialSelects.forEach(select => {
                select.addEventListener('change', updateTotal);
            });
            
            initialQuantities.forEach(input => {
                input.addEventListener('input', updateTotal);
            });
            
            // Add change listener to product select
            const produkSelect = document.querySelector('select[name="produk_id"]');
            if (produkSelect) {
                produkSelect.addEventListener('change', function() {
                    if (this.value) {
                        // Change visual feedback when product is selected
                        this.style.borderColor = '#10b981';
                        this.style.backgroundColor = '#f0fdf4';
                        this.style.fontWeight = '600';
                        
                        // Show success message
                        showNotification(`Produk "${this.options[this.selectedIndex].text}" telah dipilih!`, 'success');
                    } else {
                        // Reset styling when no product selected
                        this.style.borderColor = '#d1d5db';
                        this.style.backgroundColor = '#ffffff';
                        this.style.fontWeight = '500';
                    }
                });
                
                // Set initial styling if product is already selected
                if (produkSelect.value) {
                    produkSelect.style.borderColor = '#10b981';
                    produkSelect.style.backgroundColor = '#f0fdf4';
                    produkSelect.style.fontWeight = '600';
                }
            }
            
            updateAddButtonText();
            updateTotal();
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl + Enter to add new component
            if (e.ctrlKey && e.key === 'Enter') {
                e.preventDefault();
                addKomponenRow();
            }
        });

        // Form validation before submit
        document.getElementById('biayaProdukForm').addEventListener('submit', function(e) {
            console.log('=== FORM SUBMIT TRIGGERED ===');
            
            const produkSelect = document.querySelector('select[name="produk_id"]');
            console.log('Produk selected:', produkSelect ? produkSelect.value : 'not found');
            
            if (produkSelect && !produkSelect.value) {
                e.preventDefault();
                alert('Harap pilih produk terlebih dahulu!');
                return false;
            }

            // Check if at least one component is selected
            const komponenSelects = document.querySelectorAll('select[name="komponen_ids[]"]');
            const quantityInputs = document.querySelectorAll('input[name="quantities[]"]');
            let hasValidKomponen = false;
            
            console.log('Komponen selects found:', komponenSelects.length);
            console.log('Quantity inputs found:', quantityInputs.length);
            
            // Detailed logging of form data
            const formData = new FormData(this);
            console.log('=== FORM DATA ANALYSIS ===');
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }
            
            komponenSelects.forEach((select, index) => {
                const quantity = quantityInputs[index] ? quantityInputs[index].value : '';
                console.log(`Komponen ${index}: select=${select.value}, quantity=${quantity}`);
                
                if (select.value && quantity && parseFloat(quantity) > 0) {
                    hasValidKomponen = true;
                }
            });

            console.log('Has valid komponen:', hasValidKomponen);

            if (!hasValidKomponen) {
                e.preventDefault();
                alert('Harap pilih minimal satu komponen dan masukkan quantity yang valid!');
                return false;
            }
            
            // Final check before submission
            console.log('=== FINAL VALIDATION ===');
            console.log('Form action:', this.action);
            console.log('Form method:', this.method);
            console.log('CSRF token:', document.querySelector('input[name="_token"]')?.value);
            console.log('Form validation passed, submitting...');
            
            // Show loading indicator
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="mr-2 fas fa-spinner fa-spin"></i>Menyimpan...';
            submitBtn.disabled = true;
            
            // Re-enable button after 5 seconds (in case of error)
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 5000);
            
            return true;
        });
    </script>
    @endif
</x-app-layout>
