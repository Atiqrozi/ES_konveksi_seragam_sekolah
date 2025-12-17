@php
    $editing = isset($pesanan);
@endphp

@php
    $sizesByProduct = [];
    $pricesByProduct = [];

    foreach ($ukuran_produks as $produkId => $sizes) {
        $sizesByProduct[$produkId] = $sizes->pluck('ukuran')->toArray();
        $pricesByProduct[$produkId] = $sizes->keyBy('ukuran')->map(function ($item) {
            return [
                'harga_produk_1' => (float) $item->harga_produk_1,
                'harga_produk_2' => (float) $item->harga_produk_2,
                'harga_produk_3' => (float) $item->harga_produk_3,
                'harga_produk_4' => (float) $item->harga_produk_4
            ];
        });
    }
    
    // Debug output
    // dd($sizesByProduct); // Uncomment untuk debug
@endphp

<style>
    .produk-group-header {
        align-items: center;
        background-color: #800000;
        color: white;
        border-radius: 5px;
        margin-bottom: 10px;
        font-weight: bold;
    }

    /* Mobile Responsive Styles */
    @media (max-width: 768px) {
        /* Stack customer name and tipe harga vertically on mobile */
        div[style*="display: flex; width: 100%"] {
            flex-direction: column !important;
        }

        div[style*="display: flex; width: 100%"] .w-1\/2 {
            width: 100% !important;
            margin-bottom: 15px;
        }

        /* Hide desktop table header on mobile */
        .produk-group-header {
            display: none !important;
        }

        /* Mobile card-style layout for products */
        .produk-group {
            display: block !important;
            border: 1px solid #e5e7eb;
            margin-bottom: 16px !important;
            padding: 12px !important;
            border-radius: 8px;
            background-color: #f9fafb;
        }

        /* All input groups inside produk-group */
        .produk-group > * {
            width: 100% !important;
            padding: 8px 0 !important;
            margin-bottom: 8px;
        }

        /* Show data-label as label on mobile */
        .produk-group > *[data-label]:not([data-label=""])::before {
            content: attr(data-label);
            display: block;
            font-weight: 600;
            color: #800000;
            margin-bottom: 4px;
            font-size: 14px;
        }

        /* Make delete button full width on mobile */
        .delete-produk {
            width: 100% !important;
            padding: 12px !important;
            margin-top: 4px;
        }

        /* Subtotal section responsive */
        div[style*="justify-content: space-between"] {
            flex-direction: column !important;
            align-items: stretch !important;
        }

        .tambah-produk-button {
            width: 100% !important;
            margin-bottom: 15px !important;
        }

        div[style*="display: flex; align-items: center"]:has(#subtotal) {
            width: 100% !important;
            flex-direction: column !important;
            align-items: stretch !important;
        }

        div[style*="display: flex; align-items: center"]:has(#subtotal) label {
            width: 100% !important;
            margin-bottom: 8px;
            text-align: left !important;
        }

        #subtotal {
            width: 100% !important;
        }
    }
</style>

<div class="flex flex-wrap">
    @if ($create == 'create')
        <!-- Row pertama dengan Nama Customer dan Pilih Tipe Harga -->
        <div style="display: flex; width: 100%; margin-bottom: 20px;">
            <x-inputs.group class="w-1/2" style="padding: 0 10px 10px 10px !important; font-size: 18px;">
                <x-inputs.label-with-asterisk label="Nama Customer"/>
                <x-inputs.select name="customer_id" required>
                    <option disabled selected>Pilih Customer</option>
                    @foreach($users as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-inputs.select>
            </x-inputs.group>

            <x-inputs.group class="w-1/2" style="padding: 0 10px 10px 10px !important; font-size: 18px;">
                <x-inputs.label-with-asterisk label="Pilih Tipe Harga"/>
                <x-inputs.select name="global_tipe_harga" id="global-tipe-harga" required>
                    <option disabled selected>Pilih Tipe Harga</option>
                    <option value="harga_produk_1">Harga 1</option>
                    <option value="harga_produk_2">Harga 2</option>
                    <option value="harga_produk_3">Harga 3</option>
                    <option value="harga_produk_4">Harga 4</option>
                </x-inputs.select>
            </x-inputs.group>
        </div>

        <!-- Header Row -->
       <div class="produk-group-header" style="display: flex; flex-wrap: wrap; padding: 10px 0;">
            <div style="width: 55px; padding: 5px 10px !important;">#</div>
            <div style="width: 275px; padding: 0 10px !important;">Pilih Produk</div>
            <div style="width: 175px; padding: 0 10px !important;">Pilih Ukuran</div>
            <div style="width: 175px; padding: 0 10px !important;">Harga</div>
            <div style="width: 175px; padding: 0 10px !important;">Jumlah Pesanan</div>
            <div style="width: 175px; padding: 0 10px !important;">Total</div>
            <div style="width: 50px; padding: 0 10px !important;"></div>
        </div>

        <div id="produk-container">
            <div class="produk-group" style="display: flex; flex-wrap: wrap; align-items: center;">

                <!-- No -->
                <x-inputs.group style="width: 55px; padding: 5px 10px !important;" data-label="No.">
                    <span class="produk-number">1</span>
                </x-inputs.group>

                <!-- Pilih Produk -->
                <x-inputs.group style="width: 275px; padding: 0 10px !important;" data-label="Produk">
                    <x-inputs.select name="produk_id[]" class="produk-select" required onchange="populateUkuran(this)">
                        <option disabled selected>Pilih Produk</option>
                        @foreach($produks as $value => $label)
                            <option value="{{ $value }}"
                                data-sizes="{{ json_encode($sizesByProduct[$value] ?? []) }}">
                                {{ $label }}
                            </option>
                        @endforeach
                    </x-inputs.select>
                </x-inputs.group>

                <!-- Pilih Ukuran -->
                <x-inputs.group style="width: 175px; padding: 0 10px !important;" data-label="Ukuran">
                    <x-inputs.select name="ukuran[]" class="ukuran-select" required onchange="populateHarga(this)">
                        <option disabled selected>Ukuran</option>
                    </x-inputs.select>
                </x-inputs.group>

                <!-- Harga -->
                <x-inputs.group style="width: 175px; padding: 0 10px !important;" data-label="Harga">
                    <x-inputs.basic name="harga[]" class="harga-input" required readonly placeholder="Pilih ukuran dan tipe harga"></x-inputs.basic>
                </x-inputs.group>

                <!-- Jumlah Pesanan -->
                <x-inputs.group style="width: 175px; padding: 0 10px !important;" data-label="Jumlah Pesanan">
                    <x-inputs.basic type="number" name="jumlah_pesanan[]" min="0" placeholder="Jumlah Pesanan" oninput="calculateTotal(this)"></x-inputs.basic>
                </x-inputs.group>

                <!-- Total -->
                <x-inputs.group style="width: 175px; padding: 0 10px !important;" data-label="Total">
                    <x-inputs.basic type="text" name="total[]" placeholder="Total" readonly></x-inputs.basic>
                </x-inputs.group>

                <!-- Delete Button -->
                <x-inputs.group style="width: 50px; padding: 0 10px !important;" data-label="">
                    <button type="button" class="delete-produk" onclick="deleteProduk(this)" style="padding: 7px 15px; background-color:rgb(221, 221, 221); border-radius: 5px;">
                        <i class="icon ion-md-trash text-red-600"></i>
                    </button>
                </x-inputs.group>

            </div>
        </div>

        <div style="width: 100%; padding: 10px; margin-top: 20px; display: flex; align-items: center; justify-content: space-between;">
            <button
                type="button"
                class="tambah-produk-button"
                onclick="addProduk()"
            >
                + Buat Baru Produk
            </button>

            <div style="display: flex; align-items: center;">
                <label for="subtotal" style="margin-right: 10px; font-weight: bold; width: 110px;">Subtotal : </label>
                <x-inputs.basic
                    type="text"
                    id="subtotal"
                    name="subtotal"
                    placeholder="Subtotal"
                    readonly
                ></x-inputs.basic>
            </div>
        </div>
    @endif
</div>

<!-- Data untuk JavaScript -->
<script id="data-script">
window.sizesByProduct = <?php echo json_encode($sizesByProduct); ?>;
window.pricesByProduct = <?php echo json_encode($pricesByProduct); ?>;
console.log('Data loaded:', window.sizesByProduct);
</script>

<script>
// JavaScript functions untuk form invoice
function populateUkuran(selectElement) {
    console.log('populateUkuran called');
    
    const produkId = selectElement.value;
    console.log('Selected product ID:', produkId);
    
    const ukuranSelect = selectElement.closest('.produk-group').querySelector('.ukuran-select');
    console.log('Ukuran select element:', ukuranSelect);
    
    // Clear existing options
    ukuranSelect.innerHTML = '<option disabled selected>Ukuran</option>';
    
    // Get sizes - try multiple sources
    let sizes = [];
    
    // Method 1: From window data
    if (window.sizesByProduct && window.sizesByProduct[produkId]) {
        sizes = window.sizesByProduct[produkId];
        console.log('Got sizes from window.sizesByProduct:', sizes);
    }
    
    // Method 2: From data attribute (fallback)
    if (sizes.length === 0) {
        const selectedOption = selectElement.querySelector('option:checked');
        if (selectedOption) {
            const dataSizes = selectedOption.getAttribute('data-sizes');
            console.log('data-sizes attribute:', dataSizes);
            try {
                sizes = JSON.parse(dataSizes || '[]');
                console.log('Got sizes from data-attribute:', sizes);
            } catch (e) {
                console.log('Error parsing data-sizes:', e);
            }
        }
    }
    
    // Method 3: Hardcoded fallback
    if (sizes.length === 0) {
        sizes = ['S', 'M', 'L', 'XL', 'XXL', 'JUMBO'];
        console.log('Using hardcoded fallback sizes:', sizes);
    }
    
    // Add options
    sizes.forEach(size => {
        const option = document.createElement('option');
        option.value = size;
        option.textContent = size;
        ukuranSelect.appendChild(option);
    });
    
    console.log('Added', sizes.length, 'size options');
    console.log('Final ukuranSelect HTML:', ukuranSelect.innerHTML);
}

function populateHarga(selectElement) {
    console.log('populateHarga called');
    
    const group = selectElement.closest('.produk-group');
    const produkSelect = group.querySelector('.produk-select');
    const hargaInput = group.querySelector('.harga-input');
    
    // Try multiple ways to find global tipe harga element
    let globalTipeHargaElement = document.getElementById('global-tipe-harga');
    
    if (!globalTipeHargaElement) {
        // Try alternative selectors
        globalTipeHargaElement = document.querySelector('select[name="global_tipe_harga"]');
        console.log('Trying alternative selector:', globalTipeHargaElement);
    }
    
    if (!globalTipeHargaElement) {
        // Try more general approach
        globalTipeHargaElement = document.querySelector('select[id*="tipe-harga"]');
        console.log('Trying general selector:', globalTipeHargaElement);
    }
    
    if (!globalTipeHargaElement) {
        console.log('ERROR: Global tipe harga element not found!');
        console.log('Available elements with IDs:');
        document.querySelectorAll('[id]').forEach(el => {
            console.log('- ID:', el.id, 'Element:', el.tagName);
        });
        
        console.log('Available select elements:');
        document.querySelectorAll('select').forEach(el => {
            console.log('- Select name:', el.name, 'ID:', el.id);
        });
        return;
    }

    const globalTipeHarga = globalTipeHargaElement.value;
    const produkId = produkSelect ? produkSelect.value : null;
    const ukuran = selectElement.value;

    console.log('Values - produkId:', produkId, 'ukuran:', ukuran, 'tipeHarga:', globalTipeHarga);

    if (!produkId || !ukuran) {
        console.log('Missing produkId or ukuran');
        if (hargaInput) hargaInput.value = '';
        return;
    }

    if (!globalTipeHarga || globalTipeHarga === 'Pilih Tipe Harga') {
        console.log('No tipe harga selected, current value:', globalTipeHarga);
        alert('Silakan pilih tipe harga terlebih dahulu!');
        if (hargaInput) hargaInput.value = '';
        return;
    }

    // Get price from data
    const prices = window.pricesByProduct || {};
    const productPrices = prices[produkId] || {};
    const sizePrice = productPrices[ukuran];
    const harga = sizePrice ? sizePrice[globalTipeHarga] : 0;

    console.log('Price calculation:');
    console.log('- productPrices:', productPrices);
    console.log('- sizePrice:', sizePrice);
    console.log('- final harga:', harga);

    if (harga && harga > 0) {
        const formattedHarga = formatCurrency(harga);
        if (hargaInput) {
            hargaInput.value = formattedHarga;
            console.log('Harga set to:', formattedHarga);
        }
    } else {
        if (hargaInput) hargaInput.value = '';
        console.log('Harga kosong atau tidak ditemukan');
    }
    
    calculateTotal(selectElement);
}

    function calculateTotal(element) {
        const group = element.closest('.produk-group');
        const hargaInput = group.querySelector('.harga-input');
        const jumlahInput = group.querySelector('input[name="jumlah_pesanan[]"]');
        const totalInput = group.querySelector('input[name="total[]"]');

        // Ambil harga dari input (hilangkan format currency)
        const hargaRaw = hargaInput.value.replace(/[^0-9]/g, '');
        const harga = parseFloat(hargaRaw) || 0;
        
        // Ambil jumlah
        const jumlah = parseFloat(jumlahInput.value) || 0;

        console.log('Calculate total - harga:', harga, 'jumlah:', jumlah);

        if (harga > 0 && jumlah > 0) {
            const total = harga * jumlah;
            totalInput.value = formatCurrency(total);
            console.log('Total calculated:', total, 'formatted:', formatCurrency(total));
        } else {
            totalInput.value = '';
            console.log('Total kosong karena harga atau jumlah 0');
        }
        
        updateSubtotal();
    }

    function updateSubtotal() {
        const totalInputs = document.querySelectorAll('input[name="total[]"]');
        let subtotal = 0;
        
        totalInputs.forEach(input => {
            const value = input.value.replace(/[^0-9]/g, '');
            const amount = parseFloat(value) || 0;
            subtotal += amount;
            console.log('Subtotal item:', amount, 'running subtotal:', subtotal);
        });
        
        const subtotalInput = document.getElementById('subtotal');
        subtotalInput.value = formatCurrency(subtotal);
        
        console.log('Final subtotal:', subtotal, 'formatted:', formatCurrency(subtotal));
    }

    function formatCurrency(value) {
        // Pastikan value adalah number
        const number = Number(value);
        if (isNaN(number)) return '';
        
        // Format dengan separator ribuan untuk rupiah Indonesia
        return number.toLocaleString('id-ID', { 
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });
    }

    function addProduk() {
        console.log('=== Adding new produk ===');
        
        const container = document.getElementById('produk-container');
        const lastGroup = container.querySelector('.produk-group:last-child');
        const newGroup = lastGroup.cloneNode(true);

        // Reset semua input dan select
        newGroup.querySelectorAll('input').forEach(input => {
            input.value = '';
        });
        
        newGroup.querySelectorAll('select').forEach(select => {
            select.selectedIndex = 0;
        });

        // Reset ukuran dropdown
        const ukuranSelect = newGroup.querySelector('.ukuran-select');
        ukuranSelect.innerHTML = '<option disabled selected>Ukuran</option>';

        // Append before attaching event listeners
        container.appendChild(newGroup);

        // Attach event listeners to new group
        attachEventListeners(newGroup);
        
        updateNumbering();
        
        console.log('New produk added and event listeners attached');
    }

    function attachEventListeners(group) {
        console.log('=== Attaching event listeners to group ===');
        
        const jumlahInput = group.querySelector('input[name="jumlah_pesanan[]"]');
        const produkSelect = group.querySelector('.produk-select');
        const ukuranSelect = group.querySelector('.ukuran-select');
        
        console.log('Found elements:');
        console.log('- jumlahInput:', jumlahInput);
        console.log('- produkSelect:', produkSelect);
        console.log('- ukuranSelect:', ukuranSelect);
        
        if (jumlahInput) {
            jumlahInput.addEventListener('input', function() {
                console.log('Jumlah changed via event listener');
                calculateTotal(this);
            });
            console.log('✓ Event listener attached to jumlahInput');
        }

        if (produkSelect) {
            produkSelect.addEventListener('change', function() {
                console.log('Produk changed via event listener to:', this.value);
                populateUkuran(this);
            });
            console.log('✓ Event listener attached to produkSelect');
        }

        if (ukuranSelect) {
            ukuranSelect.addEventListener('change', function() {
                console.log('Ukuran changed via event listener to:', this.value);
                populateHarga(this);
            });
            console.log('✓ Event listener attached to ukuranSelect');
        }
        
        console.log('=== Event listeners attachment completed ===');
    }

    function deleteProduk(button) {
        const container = document.getElementById('produk-container');
        if (container.querySelectorAll('.produk-group').length > 1) {
            button.closest('.produk-group').remove();
            updateSubtotal();
            updateNumbering();
        }
    }

    function updateNumbering() {
        document.querySelectorAll('.produk-number').forEach((num, i) => num.textContent = i + 1);
    }

    function updateAllPrices() {
        console.log('Updating all prices...');
        document.querySelectorAll('.produk-group').forEach(group => {
            const ukuranSelect = group.querySelector('.ukuran-select');
            if (ukuranSelect.value && ukuranSelect.value !== 'Ukuran') {
                populateHarga(ukuranSelect);
            }
        });
    }

// Initialize form ketika halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded - initializing form');
    
    // Event listener untuk tipe harga global
    const globalTipeHarga = document.getElementById('global-tipe-harga');
    if (globalTipeHarga) {
        globalTipeHarga.addEventListener('change', updateAllPrices);
    }

    // Attach event listeners to existing groups
    document.querySelectorAll('.produk-group').forEach(attachEventListeners);
    
    console.log('Form initialization completed');
    console.log('Available data:');
    console.log('- sizesByProduct:', window.sizesByProduct);
    console.log('- pricesByProduct keys:', Object.keys(window.pricesByProduct || {}));
});

console.log('Script loaded successfully');
</script>
