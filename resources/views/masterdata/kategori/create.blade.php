<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Baru Kategori
        </h2>
    </x-slot>

    <div class="bg">
        <style>
            @media (max-width: 768px) {
                .py-12.bg-grey.min-h-screen { padding-top: 1rem !important; padding-bottom: 1rem !important; }
                .max-w-7xl.mx-auto.sm\:px-6.lg\:px-8 { padding-left: 0.75rem !important; padding-right: 0.75rem !important; }
                .flex.flex-wrap { flex-direction: column !important; }
                .flex.flex-wrap > .w-1\/2, .flex.flex-wrap > .w-full { width: 100% !important; margin-bottom: 1rem !important; }
                .mt-4 label { font-size: 14px !important; font-weight: 500 !important; color: #374151 !important; margin-bottom: 0.5rem !important; display: block !important; }
                .mt-4 input[type="text"], .mt-4 input[type="email"], .mt-4 input[type="number"], .mt-4 input[type="date"], .mt-4 input[type="password"], .mt-4 textarea, .mt-4 select, .mt-4 input[type="file"] { width: 100% !important; padding: 0.75rem !important; font-size: 16px !important; border: 1px solid #d1d5db !important; border-radius: 0.375rem !important; box-sizing: border-box !important; }
                .mt-4 textarea { min-height: 100px !important; }
                .mt-10 { margin-top: 1.5rem !important; display: flex !important; flex-direction: column !important; gap: 10px !important; }
                .mt-10 a.button, .mt-10 button.button { width: 100% !important; float: none !important; text-align: center !important; justify-content: center !important; display: inline-flex !important; align-items: center !important; }
            }
        </style>
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('kategoris.index') }}" class="mr-4"
                            ><i class="mr-1 icon ion-md-arrow-back"></i
                        ></a>
                    </x-slot>

                    <x-form
                        method="POST"
                        action="{{ route('kategoris.store') }}"
                        has-files
                        class="mt-4"
                    >
                        @include('masterdata.kategori.form-inputs')

                        <div class="mt-10">
                            <a href="{{ route('kategoris.index') }}" class="button">
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
