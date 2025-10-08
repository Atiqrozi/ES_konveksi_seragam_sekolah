@php $editing = isset($kategori) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.label-with-asterisk label="Nama Kategori"/>
        <x-inputs.text
            name="nama"
            :value="old('nama', ($editing ? $kategori->nama : ''))"
            maxlength="255"
            placeholder="Nama Kategori"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="keterangan"
            label="Keterangan"
            maxlength="255"
            >{{ old('keterangan', ($editing ? $kategori->keterangan : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.label-with-asterisk label="Gambar Kategori (ukuran 1:1 atau kotak)"/>
        <div
            x-data="imageViewer('{{ $editing && $kategori->foto ? \Storage::url($kategori->foto) : '' }}')"
        >

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input
                    type="file"
                    name="foto"
                    id="foto"
                    @change="fileChosen"
                />
            </div>

            @error('foto') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>
</div>
