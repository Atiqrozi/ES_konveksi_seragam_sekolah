@php $editing = isset($absensi) @endphp

<div class="flex flex-wrap">
    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Nama Pegawai"/>
        <x-inputs.select name="user_id" id="user_id" disabled>
            <option value="{{ Auth::user()->id }}" selected>{{ Auth::user()->nama }}</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Bidang Pekerjaan"/>
        <x-inputs.text
            name="bidang_pekerjaan"
            :value="old('bidang_pekerjaan', ($editing ? $absensi->bidang_pekerjaan : ''))"
            maxlength="255"
            placeholder="Bidang Pekerjaan"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="keterangan"
            label="Keterangan"
            maxlength="255"
            >{{ old('keterangan', ($editing ? $absensi->keterangan : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.label-with-asterisk label="Gambar Absensi"/>
        <div
            x-data="imageViewer('{{ $editing && $absensi->foto ? \Storage::url($absensi->foto) : '' }}')"
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
                    required
                />
            </div>

            @error('foto') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>
</div>
