@php $editing = isset($ukuran_produk) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.label-with-asterisk label="Nama Produk"/>
        <x-inputs.select name="produk_id" required>
            @php $selected = old('produk_id', ($editing ? $ukuran_produk->produk_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Pilih Produk</option>
            @foreach($produks as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Ukuran"/>
        <x-inputs.text
            name="ukuran"
            :value="old('ukuran', ($editing ? $ukuran_produk->ukuran : ''))"
            maxlength="255"
            placeholder="Ukuran"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Stok"/>
        <x-inputs.basic 
            type="number" 
            name='stok' 
            :value="old('stok', ($editing ? $ukuran_produk->stok : ''))" 
            :min="0" 
            placeholder="Stok"
        ></x-inputs.basic>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Harga 1"/>
        <x-inputs.basic 
            type="number" 
            name='harga_produk_1' 
            :value="old('harga_produk_1', ($editing ? $ukuran_produk->harga_produk_1 : ''))" 
            :min="0" 
            placeholder="Harga 1"
        ></x-inputs.basic>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Harga 2"/>
        <x-inputs.basic 
            type="number" 
            name='harga_produk_2' 
            :value="old('harga_produk_2', ($editing ? $ukuran_produk->harga_produk_2 : ''))" 
            :min="0" 
            placeholder="Harga 2"
        ></x-inputs.basic>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Harga 3"/>
        <x-inputs.basic 
            type="number" 
            name='harga_produk_3'  
            :value="old('harga_produk_3', ($editing ? $ukuran_produk->harga_produk_3 : ''))" 
            :min="0" 
            placeholder="Harga 3"
        ></x-inputs.basic>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Harga 4"/>
        <x-inputs.basic 
            type="number" 
            name='harga_produk_4' 
            :value="old('harga_produk_4', ($editing ? $ukuran_produk->harga_produk_4 : ''))" 
            :min="0" 
            placeholder="Harga 4"
        ></x-inputs.basic>
    </x-inputs.group>
</div>
