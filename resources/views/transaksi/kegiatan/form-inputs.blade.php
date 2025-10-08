@php $editing = isset($kegiatan) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Nama Pekerjaan"/>
        <x-inputs.select name="pekerjaan_id" required>
            @php $selected = old('pekerjaan_id', ($editing ? $kegiatan->pekerjaan_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Pilih Kegiatan</option>
            @foreach($pekerjaans as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Jumlah"/>
        <x-inputs.basic
            type="number"
            name='jumlah_kegiatan'
            :value="old('jumlah_kegiatan', ($editing ? $kegiatan->jumlah_kegiatan : ''))"
            :min="0"
            placeholder="Jumlah"
        ></x-inputs.basic>
    </x-inputs.group>

    {{-- Cek apakah user adalah admin --}}
    @if(Auth::user()->hasRole('Admin'))
        <x-inputs.group class="w-full">
            <x-inputs.label-with-asterisk label="Nama Pegawai"/>
            <x-inputs.select name="user_id" required>
                <option disabled selected>Pilih Pegawai</option>
                @foreach ($nama_pegawai as $pegawai)
                    <option value="{{ $pegawai->id }}"
                        {{ old('user_id', ($editing ? $kegiatan->user_id : '')) == $pegawai->id ? 'selected' : '' }}>
                        {{ $pegawai->nama }}
                    </option>
                @endforeach
            </x-inputs.select>
        </x-inputs.group>
    @else
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <x-inputs.group class="w-full">
            <x-inputs.label-with-asterisk label="Nama Pegawai"/>
            <x-inputs.select name="user_id" required readonly id="user_id">
                <option value="{{ Auth::user()->id }}" selected>{{ Auth::user()->nama }}</option>
            </x-inputs.select>
        </x-inputs.group>
    @endif

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="catatan"
            label="Catatan"
            maxlength="255"
            >{{ old('catatan', ($editing ? $kegiatan->catatan : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <input type="hidden" name="status_kegiatan" value="Belum Ditarik">
    <input type="hidden" name="kegiatan_dibuat" value='{{ now() }}'>
</div>

@if(!Auth::user()->hasRole('Admin'))
<script>
    document.getElementById("user_id").addEventListener("mousedown", function(event){
        event.preventDefault();
    });

    document.getElementById("user_id").addEventListener("keydown", function(event){
        event.preventDefault();
    });
</script>
@endif
