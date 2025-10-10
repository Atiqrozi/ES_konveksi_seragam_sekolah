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
                'harga_produk_1' => $item->harga_produk_1,
                'harga_produk_2' => $item->harga_produk_2,
                'harga_produk_3' => $item->harga_produk_3,
                'harga_produk_4' => $item->harga_produk_4
            ];
        });
    }
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
                <x-inputs.select name="global_tipe_harga" id="global-tipe-harga" required onchange="updateAllPrices()">
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
                <x-inputs.group style="width: 55px; padding: 5px 10px !important;">
                    <span class="produk-number">1</span>
                </x-inputs.group>

                <!-- Pilih Produk -->
                <x-inputs.group style="width: 275px; padding: 0 10px !important;">
                    <x-inputs.select name="produk_id[]" required onchange="populateUkuran(this)">
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
                <x-inputs.group style="width: 175px; padding: 0 10px !important;">
                    <x-inputs.select name="ukuran[]" class="ukuran-select" required onchange="populateHarga(this)">
                        <option disabled selected>Ukuran</option>
                    </x-inputs.select>
                </x-inputs.group>

                <!-- Harga -->
                <x-inputs.group style="width: 175px; padding: 0 10px !important;">
                    <x-inputs.basic name="harga[]" class="harga-input" required readonly></x-inputs.basic>
                </x-inputs.group>

                <!-- Jumlah Pesanan -->
                <x-inputs.group style="width: 175px; padding: 0 10px !important;">
                    <x-inputs.basic type="number" name="jumlah_pesanan[]" min="0" placeholder="Jumlah Pesanan" oninput="calculateTotal(this)"></x-inputs.basic>
                </x-inputs.group>

                <!-- Total -->
                <x-inputs.group style="width: 175px; padding: 0 10px !important;">
                    <x-inputs.basic type="text" name="total[]" placeholder="Total" readonly></x-inputs.basic>
                </x-inputs.group>

                <!-- Delete Button -->
                <x-inputs.group style="width: 50px; padding: 0 10px !important;">
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
                + Tambah Produk
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

<script>
    function populateUkuran(selectElement) {
        const selectedOption = selectElement.querySelector('option:checked');
        const ukuranSelect = selectElement.closest('.produk-group').querySelector('.ukuran-select');

        ukuranSelect.innerHTML = '<option disabled selected>Ukuran</option>';
        const sizes = JSON.parse(selectedOption.getAttribute('data-sizes') || '[]');
        sizes.forEach(size => {
            const option = document.createElement('option');
            option.value = size;
            option.textContent = size;
            ukuranSelect.appendChild(option);
        });

        selectElement.closest('.produk-group').querySelector('.harga-input').value = '';
    }

    function populateHarga(selectElement) {
        const group = selectElement.closest('.produk-group');
        const globalTipeHarga = document.getElementById('global-tipe-harga').value;
        const produkSelect = group.querySelector('select[name="produk_id[]"]');
        const hargaInput = group.querySelector('.harga-input');

        const produkId = produkSelect.value;
        const ukuran = group.querySelector('.ukuran-select').value;

        console.log('Populate harga - produkId:', produkId, 'ukuran:', ukuran, 'tipeHarga:', globalTipeHarga);

        if (!produkId || !ukuran || !globalTipeHarga) {
            hargaInput.value = '';
            console.log('Salah satu parameter kosong, mengosongkan harga');
            return;
        }

        const prices = @json($pricesByProduct);
        console.log('Prices data:', prices);
        
        const productPrices = prices[produkId] || {};
        console.log('Product prices for produkId', produkId, ':', productPrices);
        
        const sizePrice = productPrices[ukuran];
        console.log('Size price for ukuran', ukuran, ':', sizePrice);
        
        const harga = sizePrice ? sizePrice[globalTipeHarga] : 0;
        console.log('Final harga:', harga);

        if (harga && harga > 0) {
            hargaInput.value = formatCurrency(harga);
            console.log('Harga formatted:', formatCurrency(harga));
        } else {
            hargaInput.value = '';
            console.log('Harga kosong atau 0');
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

        // Tambahkan event listener untuk elemen baru
        const jumlahInput = newGroup.querySelector('input[name="jumlah_pesanan[]"]');
        if (jumlahInput) {
            jumlahInput.addEventListener('input', function() {
                calculateTotal(this);
            });
        }

        const produkSelect = newGroup.querySelector('select[name="produk_id[]"]');
        if (produkSelect) {
            produkSelect.addEventListener('change', function() {
                populateUkuran(this);
            });
        }

        const ukuranSelectNew = newGroup.querySelector('.ukuran-select');
        if (ukuranSelectNew) {
            ukuranSelectNew.addEventListener('change', function() {
                populateHarga(this);
            });
        }

        container.appendChild(newGroup);
        updateNumbering();
        
        console.log('Produk baru ditambahkan');
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
        console.log('Form initialized');
        
        // Event listener untuk tipe harga global
        const globalTipeHarga = document.getElementById('global-tipe-harga');
        if (globalTipeHarga) {
            globalTipeHarga.addEventListener('change', function() {
                console.log('Global tipe harga changed to:', this.value);
                updateAllPrices();
            });
        }

        // Event listener untuk produk grup yang sudah ada
        document.querySelectorAll('.produk-group').forEach(group => {
            const jumlahInput = group.querySelector('input[name="jumlah_pesanan[]"]');
            if (jumlahInput) {
                jumlahInput.addEventListener('input', function() {
                    calculateTotal(this);
                });
            }
        });

        console.log('Event listeners initialized');
    });
</script>
