<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <img src="{{ asset('images/AC Icon.png') }}" alt="" style="width: 90px;">
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email"
                    class="block mt-1 w-full p-2 bg-transparent text-white placeholder-white border-0 border-b-2 border-white focus:outline-none focus:ring-0 focus:border-white"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" 
                    class="block mt-1 w-full p-2 bg-transparent text-white placeholder-white border-0 border-b-2 border-white focus:outline-none focus:ring-0 focus:border-white"
                    type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="flex items-center justify-center mt-6 mb-3">
                <x-button class="ml-4" style="background-color: #800000; color:white">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
