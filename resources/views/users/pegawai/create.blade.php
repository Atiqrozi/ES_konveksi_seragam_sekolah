<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Baru Pegawai
        </h2>
    </x-slot>

    <style>
        /* Mobile-only CSS for Buat Baru Pegawai form (max-width: 768px) */
        @media (max-width: 768px) {
            /* Reduce page padding on mobile */
            .py-12.bg-grey.min-h-screen { 
                padding-top: 1rem !important; 
                padding-bottom: 1rem !important; 
            }
            
            /* Container padding */
            .max-w-7xl.mx-auto.sm\:px-6.lg\:px-8 { 
                padding-left: 0.75rem !important; 
                padding-right: 0.75rem !important; 
            }
            
            /* Make all form fields full width on mobile */
            .flex.flex-wrap > .w-1\/2,
            .flex.flex-wrap > .w-full {
                width: 100% !important;
                max-width: 100% !important;
            }
            
            /* Field groups - proper spacing */
            .flex.flex-wrap > div {
                margin-bottom: 1rem !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            
            /* Labels - visible and properly styled */
            .flex.flex-wrap label,
            .flex.flex-wrap .label-with-asterisk {
                display: block !important;
                font-size: 14px !important;
                font-weight: 500 !important;
                color: #374151 !important;
                margin-bottom: 0.35rem !important;
            }
            
            /* Input fields - full width and comfortable sizing */
            .flex.flex-wrap input[type="text"],
            .flex.flex-wrap input[type="email"],
            .flex.flex-wrap input[type="password"],
            .flex.flex-wrap input[type="date"],
            .flex.flex-wrap select {
                width: 100% !important;
                padding: 0.75rem !important;
                font-size: 16px !important;
                box-sizing: border-box !important;
                border: 1px solid #d1d5db !important;
                border-radius: 0.375rem !important;
            }
            
            /* Select dropdown - ensure proper styling */
            .flex.flex-wrap select {
                appearance: none !important;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e") !important;
                background-position: right 0.5rem center !important;
                background-repeat: no-repeat !important;
                background-size: 1.5em 1.5em !important;
                padding-right: 2.5rem !important;
            }
            
            /* Button container - stack buttons vertically */
            .mt-10 {
                margin-top: 1.5rem !important;
                display: flex !important;
                flex-direction: column !important;
                gap: 0.75rem !important;
            }
            
            /* Buttons - full width and centered */
            .mt-10 a.button,
            .mt-10 button.button {
                width: 100% !important;
                text-align: center !important;
                justify-content: center !important;
                padding: 0.875rem 1rem !important;
                font-size: 16px !important;
                float: none !important;
            }
            
            /* Remove float from submit button */
            .mt-10 button.float-right {
                float: none !important;
            }
            
            /* Card padding adjustment */
            .bg-white.shadow-md {
                padding: 1rem !important;
            }
        }
    </style>
    
    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('pegawai.index') }}" class="mr-4"
                            ><i class="mr-1 icon ion-md-arrow-back"></i
                        ></a>
                    </x-slot>

                    <x-form
                        method="POST"
                        action="{{ route('pegawai.store') }}"
                        class="mt-4"
                    >
                        @include('users.pegawai.form-inputs')

                        <div class="mt-10">
                            <a href="{{ route('pegawai.index') }}" class="button">
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
