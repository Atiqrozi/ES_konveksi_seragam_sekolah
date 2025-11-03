<x-form-section submit="updatePassword" class="password-form-mobile">
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="current_password" value="{{ __('Current Password') }}" />
            <x-input id="current_password" type="password" class="block mt-1 w-full p-2 border rounded" wire:model.defer="state.current_password" autocomplete="current-password" />
            <x-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="{{ __('New Password') }}" />
            <x-input id="password" type="password" class="block mt-1 w-full p-2 border rounded" wire:model.defer="state.password" autocomplete="new-password" />
            <x-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
            <x-input id="password_confirmation" type="password" class="block mt-1 w-full p-2 border rounded" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
            <x-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button>
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>

<style>
        /* Mobile-only: stack labels above inputs and make inputs full width
           Applied only when viewport <= 768px so desktop grid/layout remains unchanged */
        @media (max-width: 768px) {
            /* Make each field wrapper take a full row and reset layout-related styles */
            .password-form-mobile .col-span-6,
            .password-form-mobile [class*="col-span-"] {
                grid-column: 1 / -1 !important; /* span all grid columns */
                width: 100% !important;
                display: block !important;
                float: none !important;
                clear: both !important;
                margin: 0 0 1rem 0 !important;
            }

            /* Ensure labels are full-width and stacked above inputs */
            .password-form-mobile label,
            .password-form-mobile .x-label {
                display: block !important;
                width: 100% !important;
                margin: 0 0 0.35rem 0 !important;
                color: #374151; /* text-gray-700 */
                font-size: 1rem !important;
                line-height: 1.2 !important;
            }

            /* Inputs should fill available width and not keep unintended margins */
            .password-form-mobile input,
            .password-form-mobile textarea,
            .password-form-mobile select,
            .password-form-mobile .block.w-full {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
                margin-left: 0 !important;
                float: none !important;
                clear: both !important;
            }

            /* Tweak small spacing classes that could push inputs */
            .password-form-mobile .mt-1 { margin-top: 0.25rem !important; }
            .password-form-mobile .mt-2 { margin-top: 0.5rem !important; }

            /* Force grid containers to a single column on small screens */
            .password-form-mobile .grid,
            .password-form-mobile [class*="grid-"] {
                grid-template-columns: 1fr !important;
                -ms-grid-columns: 1fr !important;
            }

            /* Target any Tailwind column span classes and ensure full width */
            .password-form-mobile [class*="col-span-"] {
                grid-column: 1 / -1 !important;
                width: 100% !important;
                min-width: 0 !important; /* prevent intrinsic min-width from shrinking */
            }

            /* Ensure inputs can shrink and fill the container (fixes flex/grid shrink issues) */
            .password-form-mobile input,
            .password-form-mobile textarea,
            .password-form-mobile select {
                width: 100% !important;
                min-width: 0 !important;
                flex: 0 1 100% !important;
                padding: 0.5rem 0.75rem !important;
                height: auto !important;
                font-size: 0.95rem !important;
            }

            /* Actions (buttons/messages) keep natural flow and gap */
            .password-form-mobile [wire\:click],
            .password-form-mobile button,
            .password-form-mobile .actions {
                display: inline-flex !important;
                gap: 0.5rem !important;
                margin-top: 0.25rem !important;
            }
        }
    </style>
