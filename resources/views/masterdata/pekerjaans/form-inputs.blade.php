@php $editing = isset($pekerjaan) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Nama Pekerjaan"/>
        <x-inputs.text
            name="nama_pekerjaan"
            :value="old('nama_pekerjaan', ($editing ? $pekerjaan->nama_pekerjaan : ''))"
            maxlength="255"
            placeholder="Nama Pekerjaan"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Gaji Per Pekerjaan"/>
        <x-inputs.basic 
            type="number" 
            name='gaji_per_pekerjaan' 
            :value="old('gaji_per_pekerjaan', ($editing ? $pekerjaan->gaji_per_pekerjaan : ''))" 
            :min="0" 
            placeholder="Harga Pekerjaan"
        ></x-inputs.basic>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="deskripsi_pekerjaan"
            label="Deskripsi Pekerjaan"
            maxlength="255"
            >{{ old('deskripsi_pekerjaan', ($editing ? $pekerjaan->deskripsi_pekerjaan : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
