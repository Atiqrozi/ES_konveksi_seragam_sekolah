@php $editing = isset($jenis_pengeluaran) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.label-with-asterisk label="Nama Jenis Pengeluaran"/>
        <x-inputs.text
            name="nama_pengeluaran"
            :value="old('nama_pengeluaran', ($editing ? $jenis_pengeluaran->nama_pengeluaran : ''))"
            maxlength="255"
            placeholder="Nama Jenis Pengeluaran"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="keterangan"
            label="Keterangan"
            maxlength="255"
            >{{ old('keterangan', ($editing ? $jenis_pengeluaran->keterangan : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
