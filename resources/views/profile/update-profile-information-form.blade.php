<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Hanya admin yang dapat melakukan update profile, hubungi admin jika ada perubahan data.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Nama') }}" />
            <x-input id="name" type="text" class="block mt-1 w-full p-2 border rounded" wire:model.defer="state.nama" required autocomplete="name" readonly/>
            <x-input-error for="name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="block mt-1 w-full p-2 border rounded" wire:model.defer="state.email" required autocomplete="username" readonly/>
            <x-input-error for="email" class="mt-2" />
        </div>
        
        <div class="col-span-6 sm:col-span-4">
            <x-label for="alamat" value="{{ __('Alamat') }}" />
            <x-input id="alamat" type="text" class="block mt-1 w-full p-2 border rounded" wire:model.defer="state.alamat" required autocomplete="alamat" readonly/>
            <x-input-error for="alamat" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="no_telepon" value="{{ __('Nomor Telepon') }}" />
            <x-input id="no_telepon" type="text" class="block mt-1 w-full p-2 border rounded" wire:model.defer="state.no_telepon" required autocomplete="no_telepon" readonly/>
            <x-input-error for="no_telepon" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="jenis_kelamin" value="{{ __('Jenis Kelamin') }}" />
            <x-input id="jenis_kelamin" type="text" class="block mt-1 w-full p-2 border rounded" wire:model.defer="state.jenis_kelamin" required autocomplete="jenis_kelamin" readonly/>
            <x-input-error for="jenis_kelamin" class="mt-2" />
        </div>       
    
        @role('Pegawai')
        @php
            $gaji_pegawai = DB::table('gaji_pegawais')->where('pegawai_id', Auth::user()->id)->first();
        @endphp
            <div class="col-span-6 sm:col-span-4">
                <x-label for="tagihan" :value="__('Tagihan')" />
                <x-input id="tagihan" type="text" class="block mt-1 w-full p-2 border rounded" value='{{ $gaji_pegawai->total_gaji_yang_bisa_diajukan }}' required autocomplete="tagihan" readonly />
                <x-input-error for="tagihan" class="mt-2" />
            </div>
        @endrole

        @role('Sales')
            <div class="col-span-6 sm:col-span-4">
                <x-label for="tagihan" :value="__('Tagihan')" />
                <x-input id="tagihan" type="text" class="block mt-1 w-full p-2 border rounded" wire:model.defer="state.tagihan" required autocomplete="tagihan" readonly />
                <x-input-error for="tagihan" class="mt-2" />
            </div>
        @endrole
    </x-slot>
</x-form-section>
