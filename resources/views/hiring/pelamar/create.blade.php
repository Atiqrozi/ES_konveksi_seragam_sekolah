<x-app-layout>
    <x-slot name="header">
        @auth
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Pelamar
        </h2>
        @endauth

        @guest
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajukan Lamaran
        </h2>
        @endguest
    </x-slot>

    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>

                    <x-form
                        method="POST"
                        action="{{ route('pelamar.store') }}"
                        has-files
                        class="mt-4"
                    >
                        @include('hiring.pelamar.form-inputs')

                        <div class="mt-10">
                            <button
                                type="submit"
                                class="button float-right"
                                style="background-color: #800000; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#700000'; this.style.color='white';" onmouseout="this.style.backgroundColor='#800000'; this.style.color='white';"
                            >
                                <i class="mr-1 icon ion-md-save"></i>
                                Ajukan
                            </button>
                        </div>
                    </x-form>
                </x-partials.card>
            </div>
        </div>
    </div>
</x-app-layout>
