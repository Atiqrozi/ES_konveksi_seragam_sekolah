<x-guest-layout>
    <style>
        /* Mobile-only tweaks for login page. Desktop layout remains unchanged. */
        @media only screen and (max-width: 768px) {
            /* wrapper padding so the card doesn't touch screen edges */
            .login-custom {
                padding: 0.75rem;
                margin: 0 0.5rem;
            }

            /* make logo a bit smaller on mobile */
            .login-custom img {
                width: 70px !important;
                display: block;
                margin: 0 auto 0.5rem auto;
            }

            /* inputs: increase tap area and ensure full width */
            .login-custom input[type="email"],
            .login-custom input[type="password"] {
                padding: 0.75rem !important;
                font-size: 16px !important;
                line-height: 1.2 !important;
            }

            /* button: full width and comfortable touch size */
            .login-custom .login-action {
                width: 100% !important;
                padding: 0.85rem 1rem !important;
                font-size: 16px !important;
                justify-content: center !important;
                text-align: center !important;
            }

            /* center align labels and reduce spacing */
            .login-custom label {
                display: block;
                text-align: left;
                font-size: 14px;
                margin-bottom: 0.25rem;
            }
        }
    </style>

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
            <div class="login-custom">
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
                <x-button class="ml-4 login-action" style="background-color: #800000; color:white">
                    {{ __('Log in') }}
                </x-button>
            </div>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
