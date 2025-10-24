<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Membuat Kegiatan Baru
        </h2>
    </x-slot>

    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('kegiatan.index') }}" class="mr-4"
                            ><i class="mr-1 icon ion-md-arrow-back"></i
                        ></a>
                    </x-slot>

                    <x-form
                        method="POST"
                        action="{{ route('kegiatan.store') }}"
                        has-files
                        class="mt-4"
                    >
                        @include('transaksi.kegiatan.form-inputs')

                        <div class="mt-10">
                            <a href="{{ route('kegiatan.index') }}" class="button">
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

@push('scripts')
    <!-- Choices.js for searchable select (no jQuery) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        function initChoicesForKegiatan() {
            // The component renders the class on the actual <select>, so target select.choices-select
            const elements = document.querySelectorAll('select.choices-select, .choices-select');
            console.log('initChoicesForKegiatan: found elements count =', elements.length);
            if (typeof Choices === 'undefined') {
                console.warn('Choices.js not loaded (Choices is undefined) — attempting dynamic load fallback.');
                // Try to dynamically load Choices.js then init
                const existing = document.querySelector('script[data-choices-fallback]');
                if (!existing) {
                    const script = document.createElement('script');
                    script.src = 'https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js';
                    script.async = true;
                    script.setAttribute('data-choices-fallback', '1');
                    script.onload = function () {
                        console.log('Dynamic Choices.js loaded, running initChoicesForKegiatan again');
                        try { initChoicesForKegiatan(); } catch(e){ console.error('init after dynamic load failed', e); }
                    };
                    script.onerror = function () { console.error('Dynamic load of Choices.js failed'); };
                    document.head.appendChild(script);
                }
                // don't attempt to init until the script loads
                return;
            }
            elements.forEach(function (el) {
                // If we accidentally selected a wrapper, try to find a descendant select
                if (el.tagName !== 'SELECT') {
                    el = el.querySelector('select') || el;
                }
                if (!el || el.__choicesInitialized) return;
                try {
                    const instance = new Choices(el, {searchEnabled: true, itemSelectText: ''});
                    el.__choicesInitialized = true;
                    console.log('Choices initialized for select#' + (el.id || el.name), instance);
                } catch (e) {
                    console.warn('Choices init failed', e);
                }
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initChoicesForKegiatan);
        } else {
            // DOM already ready (script pushed late) — run immediately
            initChoicesForKegiatan();
        }
    </script>
@endpush

