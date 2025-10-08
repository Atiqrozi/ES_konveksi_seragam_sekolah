@php $editing = isset($artikel) @endphp

<div class="flex flex-wrap">

    <input type="hidden" name="penulis" value="{{ Auth::user()->id }}">

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Judul"/>
        <x-inputs.text
            name="judul"
            :value="old('judul', ($editing ? $artikel->judul : ''))"
            maxlength="255"
            placeholder="Judul"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Slug"/>
        <x-inputs.text
            id="slug"
            name="slug"
            :value="old('slug', ($editing ? $artikel->slug : ''))"
            maxlength="255"
            placeholder="Slug"
            required
            readonly
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.label-with-asterisk label="Cover Artikel"/>
        <div
            x-data="imageViewer('{{ $editing && $artikel->cover ? \Storage::url($artikel->cover) : '' }}')"
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
                    name="cover"
                    id="cover"
                    @change="fileChosen"
                />
            </div>

            @error('cover') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.label-with-asterisk label="Konten"/>
        <textarea
            id="summernote"
            name="konten"
            maxlength="255"
            >{{ old('konten', ($editing ? $artikel->konten : ''))
            }}</textarea
        >
    </x-inputs.group>

    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview']],
                ]
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const judulInput = document.getElementById('judul');
            const slugInput = document.getElementById('slug');
    
            judulInput.addEventListener('input', function() {
                const slug = judulInput.value
                    .toLowerCase()
                    .replace(/[^a-z0-9 -]/g, '') // Menghapus karakter spesial
                    .replace(/\s+/g, '-')        // Mengganti spasi dengan tanda hubung
                    .replace(/-+/g, '-');        // Mengganti beberapa tanda hubung dengan satu tanda hubung
                slugInput.value = slug;
            });
        });
    </script>
    
</div>
