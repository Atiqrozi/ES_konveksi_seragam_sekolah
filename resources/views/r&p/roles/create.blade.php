<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.roles.create_title')
        </h2>
    </x-slot>

    <div class="bg">
        <style>
            @media (max-width: 768px) {
                .mt-10 {
                    display: flex;
                    flex-direction: column;
                    gap: 10px;
                }
                .mt-10 a,
                .mt-10 button {
                    width: 100%;
                    text-align: center;
                }
                .mt-10 .float-right {
                    float: none !important;
                }
            }
        </style>
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('roles.index') }}" class="mr-4"
                            ><i class="mr-1 icon ion-md-arrow-back"></i
                        ></a>
                    </x-slot>

                    <x-form
                        method="POST"
                        action="{{ route('roles.store') }}"
                        class="mt-4"
                    >
                        @include('r&p.roles.form-inputs')

                        <div class="mt-10">
                            <a href="{{ route('roles.index') }}" class="button">
                                <i
                                    class="
                                        mr-1
                                        icon
                                        ion-md-return-left
                                        text-primary
                                    "
                                ></i>
                                @lang('crud.common.back')
                            </a>

                            <button
                                type="submit"
                                class="button float-right"
                                style="background-color: #800000; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#700000'; this.style.color='white';" onmouseout="this.style.backgroundColor='#800000'; this.style.color='white';"
                            >
                                <i class="mr-1 icon ion-md-save"></i>
                                @lang('crud.common.create')
                            </button>
                        </div>
                    </x-form>
                </x-partials.card>
            </div>
        </div>
    </div>
</x-app-layout>
