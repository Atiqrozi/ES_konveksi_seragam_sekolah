@php $editing = isset($pengeluaran) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Jenis Pengeluaran"/>
        <x-inputs.select name="jenis_pengeluaran_id" required>
            <option disabled selected>Pilih Jenis Pengeluaran</option>
            @foreach ($jenis_pengeluarans as $jenis_pengeluaran)
                <option value="{{ $jenis_pengeluaran->id }}"
                    {{ old('jenis_pengeluaran_id', ($editing ? $pengeluaran->jenis_pengeluaran_id : '')) == $jenis_pengeluaran->id ? 'selected' : '' }}>
                    {{ $jenis_pengeluaran->nama_pengeluaran }}
                </option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Rincian"/>
        <x-inputs.text
            name="keterangan"
            :value="old('keterangan', ($editing ? $pengeluaran->keterangan : ''))"
            maxlength="255"
            placeholder="Rincian"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Jumlah"/>
        <x-inputs.basic
            type="number"
            name='jumlah'
            :value="old('jumlah', ($editing ? $pengeluaran->jumlah : ''))"
            :min="0"
            placeholder="Jumlah"
        ></x-inputs.basic>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Tanggal"/>
        <x-inputs.date
            name="tanggal"
            value="{{ old('tanggal', ($editing ? $pengeluaran->tanggal : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>
</div>
