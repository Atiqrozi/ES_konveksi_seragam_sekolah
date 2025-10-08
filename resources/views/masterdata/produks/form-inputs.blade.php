@php
    $editing = isset($produk);
    $fields = [
        ['label' => 'Foto Sampul', 'name' => 'foto_sampul', 'required' => false, 'value' => $editing && $produk->foto_sampul ? \Storage::url($produk->foto_sampul) : ''],
        ['label' => 'Foto Lain 1', 'name' => 'foto_lain_1', 'required' => false, 'value' => $editing && $produk->foto_lain_1 ? \Storage::url($produk->foto_lain_1) : ''],
        ['label' => 'Foto Lain 2', 'name' => 'foto_lain_2', 'required' => false, 'value' => $editing && $produk->foto_lain_2 ? \Storage::url($produk->foto_lain_2) : ''],
        ['label' => 'Foto Lain 3', 'name' => 'foto_lain_3', 'required' => false, 'value' => $editing && $produk->foto_lain_3 ? \Storage::url($produk->foto_lain_3) : ''],
    ];
@endphp

<div class="flex flex-wrap">
    {{-- Nama Produk --}}
    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Nama Produk"/>
        <x-inputs.text
            name="nama_produk"
            :value="old('nama_produk', ($editing ? $produk->nama_produk : ''))"
            maxlength="255"
            placeholder="Nama Produk"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Kategori"/>
        <x-inputs.select name="kategori_id" required>
            @php $selected = old('kategori_id', ($editing ? $produk->kategori_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Pilih Kategori</option>
            @foreach($kategoris as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    {{-- Deskripsi Produk --}}
    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="deskripsi_produk"
            label="Deskripsi Produk"
            maxlength="255"
        >{{ old('deskripsi_produk', ($editing ? $produk->deskripsi_produk : '')) }}</x-inputs.textarea>
    </x-inputs.group>

    {{-- Media Upload Table --}}
    <x-inputs.group class="w-full">
        <table class="border-collapse border border-gray-300 w-full text-sm">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 p-2 w-40">Label</th>
                    <th class="border border-gray-300 p-2 w-40">Preview</th>
                    <th class="border border-gray-300 p-2">Upload</th>
                    <th class="border border-gray-300 p-2 w-20">Reset</th>
                </tr>
            </thead>
            <tbody>
                {{-- Gambar --}}
                @foreach ($fields as $field)
                <tr x-data="{ imageUrl: '{{ $field['value'] }}' }">
                    <td class="border border-gray-300 p-2 font-medium">
                        {{ $field['label'] }} @if($field['required'])<span class="text-red-500">*</span>@endif
                    </td>
                    <td class="border border-gray-300 p-2 text-center">
                        <template x-if="imageUrl">
                            <img :src="imageUrl"
                                 @click="window.open(imageUrl, '_blank')"
                                 class="object-cover rounded border border-gray-200 cursor-pointer hover:opacity-80"
                                 style="width: 100px; height: 100px;" />
                        </template>
                        <template x-if="!imageUrl">
                            <div class="border rounded border-gray-200 bg-gray-100 flex items-center justify-center text-gray-400"
                                 style="width: 100px; height: 100px;">No Image</div>
                        </template>
                    </td>
                    <td class="border border-gray-300 p-2">
                        <input type="file" name="{{ $field['name'] }}"
                               @change="imageUrl = URL.createObjectURL($event.target.files[0])">
                        @error($field['name']) @include('components.inputs.partials.error') @enderror
                    </td>
                    <td class="border border-gray-300 p-2 text-center">
                        <button type="button" class="px-2 py-1 bg-red-500 text-white rounded text-xs"
                                @click="imageUrl=''; $el.closest('tr').querySelector('input[type=file]').value=''">
                            Reset
                        </button>
                    </td>
                </tr>
                @endforeach

                {{-- Video --}}
                <tr x-data="{ videoUrl: '{{ $editing && $produk->video ? \Storage::url($produk->video) : '' }}' }">
                    <td class="border border-gray-300 p-2 font-medium">Video</td>
                    <td class="border border-gray-300 p-2 text-center">
                        <template x-if="videoUrl">
                            <video :src="videoUrl" controls class="rounded border border-gray-200 cursor-pointer"
                                   @click="window.open(videoUrl, '_blank')"
                                   style="width: 150px; height: 100px;"></video>
                        </template>
                        <template x-if="!videoUrl">
                            <div class="border rounded border-gray-200 bg-gray-100 flex items-center justify-center text-gray-400"
                                style="width: 150px; height: 100px;">No Video</div>
                        </template>
                    </td>
                    <td class="border border-gray-300 p-2">
                        <input type="file" name="video" accept="video/*"
                            @change="videoUrl = URL.createObjectURL($event.target.files[0])">
                        @error('video') @include('components.inputs.partials.error') @enderror
                    </td>
                    <td class="border border-gray-300 p-2 text-center">
                        <button type="button" class="px-2 py-1 bg-red-500 text-white rounded text-xs"
                                @click="videoUrl=''; $el.closest('tr').querySelector('input[type=file]').value=''">
                            Reset
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </x-inputs.group>
</div>


{{-- AlpineJS Component --}}
<script>
function filePreview(initialUrl) {
    return {
        fileUrl: initialUrl || '',
        updateFile(event, type) {
            const file = event.target.files[0];
            if (file) {
                this.fileUrl = URL.createObjectURL(file);
            }
        },
        resetFile() {
            this.fileUrl = '';
            const input = event.target.closest('div').querySelector('input[type="file"]');
            input.value = '';
        }
    }
}
</script>
