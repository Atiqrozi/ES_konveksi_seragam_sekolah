@php $editing = isset($pegawai) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Nama"/>
        <x-inputs.text
            name="nama"
            :value="old('nama', ($editing ? $pegawai->nama : ''))"
            maxlength="255"
            placeholder="Nama"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Jenis Kelamin"/>
        <x-inputs.select name="jenis_kelamin">
            <option disabled selected>Pilih Jenis Kelamin</option>
            @php $selected = old('jenis_kelamin', ($editing ? $pegawai->jenis_kelamin : '')) @endphp
            <option value="Laki-Laki" {{ $selected == 'Laki-Laki' ? 'selected' : '' }} >Laki-Laki</option>
            <option value="Perempuan" {{ $selected == 'Perempuan' ? 'selected' : '' }} >Perempuan</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Email"/>
        <x-inputs.email
            name="email"
            :value="old('email', ($editing ? $pegawai->email : ''))"
            maxlength="255"
            placeholder="Email"
            required
        ></x-inputs.email>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Password"/>
        <x-inputs.password
            name="password"
            maxlength="255"
            placeholder="Password"
            :required="!$editing"
        ></x-inputs.password>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.label-with-asterisk label="Alamat"/>
        <x-inputs.text
            name="alamat"
            :value="old('alamat', ($editing ? $pegawai->alamat : ''))"
            maxlength="255"
            placeholder="Alamat"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="No Telepon"/>
        <x-inputs.text
            name="no_telepon"
            :value="old('no_telepon', ($editing ? $pegawai->no_telepon : ''))"
            maxlength="255"
            placeholder="No Telepon"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Tanggal Lahir"/>
        <x-inputs.date
            name="tanggal_lahir"
            value="{{ old('tanggal_lahir', ($editing ? optional($pegawai->tanggal_lahir)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>
</div>
