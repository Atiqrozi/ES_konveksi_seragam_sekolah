@php $editing = isset($kriterium) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Nama Kriteria"/>
        <x-inputs.text
            name="nama"
            :value="old('nama', ($editing ? $kriterium->nama : ''))"
            maxlength="255"
            placeholder="Nama Kriteria"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Bobot (Total bobot semua kriteria harus 1 agar optimal)"/>
        <x-inputs.basic 
            type="number" 
            name='bobot' 
            :value="old('bobot', ($editing ? $kriterium->bobot : ''))" 
            :min="0"
            :max="1"
            step="0.01"
            placeholder="Bobot"
        ></x-inputs.basic>
    </x-inputs.group>
</div>
