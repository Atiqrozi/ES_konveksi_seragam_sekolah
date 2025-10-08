@php $editing = isset($posisi_lowongan) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.label-with-asterisk label="Nama Posisi"/>
        <x-inputs.text
            name="nama_posisi"
            :value="old('nama_posisi', ($editing ? $posisi_lowongan->nama_posisi : ''))"
            maxlength="255"
            placeholder="Nama Posisi"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.label-with-asterisk label="Deskripsi Posisi"/>
        <x-inputs.textarea
            name="deskripsi_posisi"
            maxlength="255"
            >{{ old('deskripsi_posisi', ($editing ? $posisi_lowongan->deskripsi_posisi : ''))
            }}
        </x-inputs.textarea>
    </x-inputs.group>
</div>
