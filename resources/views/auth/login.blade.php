<x-guest-layout>
    <style>
        /* Mobile-only tweaks for login page. Desktop layout remains unchanged. */
        @media only screen and (max-width: 768px) {
            /* Center and constrain the login card container */
            .min-h-screen.flex.items-center {
                padding: 1rem !important;
            }
            
            /* Login card - make it properly sized and centered */
            .sm\:max-w-md {
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 auto !important;
            }
            
            /* Card background - ensure proper sizing */
            .px-6.py-4.bg-white.shadow-md,
            .bg-white.shadow-md {
                padding: 1.5rem 1.25rem !important;
                border-radius: 0.5rem !important;
                margin: 0 auto !important;
            }
            
            /* Logo container and image */
            .mb-4.flex.justify-center img,
            img[alt=""] {
                width: 80px !important;
                height: auto !important;
                display: block !important;
                margin: 0 auto 1rem auto !important;
            }

            /* Form wrapper padding */
            .login-custom {
                padding: 0 !important;
                margin: 0 !important;
            }

            /* Labels - visible and properly styled */
            .login-custom label,
            label[for="email"],
            label[for="password"] {
                display: block !important;
                text-align: left !important;
                font-size: 14px !important;
                font-weight: 500 !important;
                color: #374151 !important;
                margin-bottom: 0.35rem !important;
            }

            /* Input fields - increase tap area and ensure full width */
            .login-custom input[type="email"],
            .login-custom input[type="password"],
            input#email,
            input#password {
                padding: 0.75rem !important;
                font-size: 16px !important;
                line-height: 1.5 !important;
                width: 100% !important;
                box-sizing: border-box !important;
                border-radius: 0.375rem !important;
            }
            
            /* Spacing between fields */
            .login-custom > div:not(:last-child) {
                margin-bottom: 1rem !important;
            }

            /* Button - full width and comfortable touch size */
            .login-custom .login-action,
            .ml-4.login-action {
                width: 100% !important;
                padding: 0.875rem 1rem !important;
                font-size: 16px !important;
                font-weight: 600 !important;
                justify-content: center !important;
                text-align: center !important;
                display: flex !important;
                align-items: center !important;
                margin-left: 0 !important;
                margin-top: 1.25rem !important;
            }
            
            /* Button container */
            .flex.items-center.justify-center {
                width: 100% !important;
                margin-top: 1.25rem !important;
                margin-bottom: 0.5rem !important;
            }
            
            /* Validation errors - better spacing on mobile */
            .mb-4 {
                margin-bottom: 1rem !important;
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
