@php $editing = isset($riwayat_stok_produk) @endphp

@php
    $sizesByProduct = [];

    foreach ($ukuranProduks as $produkId => $sizes) {
        $sizesByProduct[$produkId] = $sizes->pluck('ukuran')->toArray();
    }
@endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Nama Produk"/>
        <x-inputs.select name="id_produk" id="id_produk" required onchange="populateUkuran(this)">
            @php 
                $selected = old('id_produk', ($editing ? $riwayat_stok_produk->id_produk : '')) 
            @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Pilih produk</option>
            @foreach($produks as $value => $label)
                @php
                    // Retrieve sizes for the current product
                    $sizes = isset($sizesByProduct[$value]) ? $sizesByProduct[$value] : [];
                @endphp
                <option value="{{ $value }}" 
                    @foreach($sizes as $index => $size)
                        data-ukuran{{ $index + 1 }}="{{ $size }}"
                    @endforeach
                    {{ $selected == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Ukuran Produk"/>
        <x-inputs.select name="ukuran_produk" id="ukuran_produk" required>
            <option disabled selected>Pilih ukuran produk</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.label-with-asterisk label="Stok Masuk"/>
        <x-inputs.basic 
            type="number" 
            name='stok_masuk' 
            :value="old('stok_masuk', ($editing ? $riwayat_stok_produk->stok_masuk : ''))" 
            :min="0"
            placeholder="Stok Masuk"
        ></x-inputs.basic>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="catatan"
            label="Catatan"
            maxlength="255"
        >{{ old('catatan', ($editing ? $riwayat_stok_produk->catatan : '')) }}</x-inputs.textarea>
    </x-inputs.group>
</div>

<script>
    function populateUkuran(select) {
        var selectedOption = select.options[select.selectedIndex];
        var ukuranOptions = [];
        
        // Collect all ukuran data attributes
        for (var i = 1; i <= 30; i++) { // Assuming a maximum of 10 sizes
            var ukuran = selectedOption.getAttribute('data-ukuran' + i);
            if (ukuran) {
                ukuranOptions.push(ukuran);
            } else {
                break;
            }
        }
        
        var ukuranSelect = document.getElementById('ukuran_produk');
        ukuranSelect.innerHTML = '<option disabled selected>Pilih ukuran produk</option>';
        
        // Populate the ukuran select element
        ukuranOptions.forEach(function(size) {
            var option = document.createElement('option');
            option.value = size;
            option.text = size;
            ukuranSelect.appendChild(option);
        });
    }
</script>
