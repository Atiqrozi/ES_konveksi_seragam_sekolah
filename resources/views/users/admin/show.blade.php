<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lihat Admin
        </h2>
    </x-slot>

    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('admin.index') }}" class="mr-4"
                            ><i class="mr-1 icon ion-md-arrow-back"></i
                        ></a>
                    </x-slot>

                    <div class="mt-4 px-4 row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Nama
                                </h5>
                                <span>{{ $admin->nama ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Email
                                </h5>
                                <span>{{ $admin->email ?? '-' }}</span>
                            </div>
                        
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Alamat
                                </h5>
                                <span>{{ $admin->alamat ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    No Telepon
                                </h5>
                                <span>{{ $admin->no_telepon ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Jenis Kelamin
                                </h5>
                                <span>{{ $admin->jenis_kelamin ?? '-' }}</span>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Tanggal Lahir
                                </h5>
                                <span>{{ optional($admin->tanggal_lahir)->format('Y-m-d') ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Dibuat Pada
                                </h5>
                                <span>{{ $admin->created_at ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Diperbarui Pada
                                </h5>
                                <span>{{ $admin->updated_at ?? '-' }}</span>
                            </div>
                    
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Roles
                                </h5>
                                <div>
                                    @forelse ($admin->roles as $role)
                                        @if ($role->name == 'Admin')
                                            <div
                                                style="min-width: 80px;"
                                                class="
                                                    inline-block
                                                    py-1
                                                    text-center text-sm
                                                    rounded
                                                    bg-rose-600
                                                    text-white
                                                "
                                            >
                                                <span>{{ $role->name }}</span>
                                            </div>
                                        @elseif ($role->name == 'Pegawai')
                                            <div
                                                style="min-width: 80px;"
                                                class="
                                                    inline-block
                                                    py-1
                                                    text-center text-sm
                                                    rounded
                                                    bg-lime-600
                                                    text-white
                                                "
                                            >
                                                <span>{{ $role->name }}</span>
                                            </div>
                                        @elseif ($role->name == 'Sales')
                                            <div
                                                style="min-width: 80px;"
                                                class="
                                                    inline-block
                                                    py-1
                                                    text-center text-sm
                                                    rounded
                                                    bg-slate-600
                                                    text-white
                                                "
                                            >
                                                <span>{{ $role->name }}</span>
                                            </div>
                                        @endif
                                    <br />
                                    @empty - @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <a href="{{ route('admin.index') }}" class="button">
                            <i class="mr-1 icon ion-md-return-left"></i>
                            @lang('crud.common.back')
                        </a>

                        @can('create_admin', App\Models\User::class)
                        <a href="{{ route('admin.create') }}" class="button">
                            <i class="mr-1 icon ion-md-add"></i>
                            @lang('crud.common.create')
                        </a>
                        @endcan
                    </div>
                </x-partials.card>
            </div>
        </div>
    </div>
</x-app-layout>
