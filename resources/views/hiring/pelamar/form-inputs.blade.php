@if ($auth == 'edit')
    @php $editing = isset($pelamar) @endphp
    <div class="flex flex-wrap">
        @foreach ($kriteria as $kriterium)
            <x-inputs.group class="w-1/2">
                <x-inputs.label-with-asterisk label="{{ $kriterium->nama }}"/>
                <div class="form-group">
                    <div class="justify-content-between">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="{{ strtolower(str_replace(' ', '_', $kriterium->nama)) }}" id="{{ strtolower(str_replace(' ', '_', $kriterium->nama)) }}{{ $i }}" value="{{ $i }}" {{ old(strtolower(str_replace(' ', '_', $kriterium->nama)), ($editing && optional ($pelamar->wsmPelamar->where('kriteria_id', $kriterium->id)->first())->skor == $i) ? 'checked' : '' ) }}>
                                <label class="form-check-label" for="{{ strtolower(str_replace(' ', '_', $kriterium->nama)) }}{{ $i }}">{{ $i }}</label>
                            </div>
                        @endfor
                    </div>
                    @error(strtolower(str_replace(' ', '_', $kriterium->nama)))
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </x-inputs.group>
        @endforeach
    </div>

@elseif ($auth == 'create')
    @php $editing = isset($pelamar) @endphp

    <div class="flex flex-wrap">
        <input type="hidden" name="status" value="Diajukan">

        <x-inputs.group class="w-1/2">
            <x-inputs.label-with-asterisk label="Nama Lengkap"/>
            <x-inputs.text
                name="nama"
                :value="old('nama', ($editing ? $pelamar->nama : ''))"
                maxlength="255"
                placeholder="Nama Lengkap"
                required
            ></x-inputs.text>
        </x-inputs.group>

        <x-inputs.group class="w-1/2">
            <x-inputs.label-with-asterisk label="Posisi yang Dilamar"/>
            <x-inputs.select name="posisi_id" required>
                @php $selected = old('posisi_id', ($editing ? $pelamar->posisi_id : '')) @endphp
                <option disabled {{ empty($selected) ? 'selected' : '' }}>Pilih Posisi</option>
                @foreach($posisi_lowongans as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
                @endforeach
            </x-inputs.select>
        </x-inputs.group>

        <x-inputs.group class="w-1/2">
            <x-inputs.label-with-asterisk label="Email"/>
            <x-inputs.text
                name="email"
                :value="old('email', ($editing ? $pelamar->email : ''))"
                maxlength="255"
                placeholder="Email"
                required
            ></x-inputs.text>
        </x-inputs.group>

        <x-inputs.group class="w-1/2">
            <x-inputs.label-with-asterisk label="Alamat"/>
            <x-inputs.text
                name="alamat"
                :value="old('alamat', ($editing ? $pelamar->alamat : ''))"
                maxlength="255"
                placeholder="Alamat"
                required
            ></x-inputs.text>
        </x-inputs.group>

        <x-inputs.group class="w-1/2">
            <x-inputs.label-with-asterisk label="Nomor Telepon"/>
            <x-inputs.basic 
                type="number" 
                name='no_telepon' 
                :value="old('no_telepon', ($editing ? $pelamar->no_telepon : ''))" 
                :min="0" 
                placeholder="Nomor Telepon"
            ></x-inputs.basic>
        </x-inputs.group>

        <x-inputs.group class="w-1/2">
            <x-inputs.label-with-asterisk label="Jenis Kelamin"/>
            <x-inputs.select name="jenis_kelamin">
                <option disabled selected>Pilih Jenis Kelamin</option>
                @php $selected = old('jenis_kelamin', ($editing ? $pelamar->jenis_kelamin : '')) @endphp
                <option value="Laki-Laki" {{ $selected == 'Laki-Laki' ? 'selected' : '' }} >Laki-Laki</option>
                <option value="Perempuan" {{ $selected == 'Perempuan' ? 'selected' : '' }} >Perempuan</option>
            </x-inputs.select>
        </x-inputs.group>

        <x-inputs.group class="w-1/2">
            <x-inputs.label-with-asterisk label="Tanggal Lahir"/>
            <x-inputs.date
                name="tanggal_lahir"
                value="{{ old('tanggal_lahir', ($editing ? optional($pelamar->tanggal_lahir)->format('Y-m-d') : '')) }}"
                max="255"
                required
            ></x-inputs.date>
        </x-inputs.group>

        <x-inputs.group class="w-1/2">
            <x-inputs.label-with-asterisk label="Pendidikan Terakhir"/>
            <x-inputs.text
                name="pendidikan_terakhir"
                :value="old('pendidikan_terakhir', ($editing ? $pelamar->pendidikan_terakhir : ''))"
                maxlength="255"
                placeholder="Pendidikan Terakhir"
                required
            ></x-inputs.text>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.textarea
                name="tentang_diri"
                label="Ceritakan Tentang Diri Anda Secara Singkat"
                maxlength="255"
                >{{ old('tentang_diri', ($editing ? $pelamar->tentang_diri : ''))
                }}</x-inputs.textarea
            >
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.textarea
                name="pengalaman"
                label="Pengalaman Kerja"
                maxlength="255"
                >{{ old('pengalaman', ($editing ? $pelamar->pengalaman : ''))
                }}</x-inputs.textarea
            >
        </x-inputs.group>

        <x-inputs.group class="w-1/2">
            <x-inputs.label-with-asterisk label="Pas Foto (Image)"/>
            <div
                x-data="imageViewer('{{ $editing && $pelamar->foto ? \Storage::url($pelamar->foto) : '' }}')">

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

        <x-inputs.group class="w-1/2">
            <x-inputs.label-with-asterisk label="CV (PDF)"/>
            <div
                x-data="fileViewer('{{ $editing && $pelamar->cv ? \Storage::url($pelamar->cv) : '' }}')">
        
                <template x-if="fileUrl">
                    <a
                        :href="fileUrl"
                        target="_blank"
                        class="text-blue-500 underline"
                    >
                        View Uploaded CV
                    </a>
                </template>
        
                <!-- Show the gray box when file is not available -->
                <template x-if="!fileUrl">
                    <div
                        class="border rounded border-gray-200 bg-gray-100"
                        style="width: 100px; height: 100px;"
                    ></div>
                </template>
        
                <div class="mt-2">
                    <input
                        type="file"
                        name="cv"
                        id="cv"
                        accept="application/pdf"
                        @change="fileChosen"
                    />
                </div>
        
                @error('cv') @include('components.inputs.partials.error')
                @enderror
            </div>
        </x-inputs.group>
    </div>

@elseif ($auth == 'waktu')
@php $editing = isset($pelamar) @endphp
    <div class="flex flex-wrap">
        <x-inputs.group class="w-1/2">
            <x-inputs.label-with-asterisk label="Mulai Wawancara"/>
            <x-inputs.datetime
                name="mulai_wawancara"
                value="{{ old('mulai_wawancara', $pelamar->mulai_wawancara ? $pelamar->mulai_wawancara->format('Y-m-d H:i:s') : '') }}"
                required
            ></x-inputs.datetime>
        </x-inputs.group>
    
        <x-inputs.group class="w-1/2">
            <x-inputs.label-with-asterisk label="Selesai Wawancara"/>
            <x-inputs.datetime
                name="selesai_wawancara"
                value="{{ old('selesai_wawancara', $pelamar->selesai_wawancara ? $pelamar->selesai_wawancara->format('Y-m-d H:i:s') : '') }}"
                required
            ></x-inputs.datetime>
        </x-inputs.group>
    </div>
@endif
