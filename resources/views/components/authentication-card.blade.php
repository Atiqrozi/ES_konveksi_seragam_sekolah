<style>
    .logoLogin {
        margin: 30px 0 40px 0;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
    }

    .auth-card {
        background: rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(4px);
    }
    /* Mobile: make the auth card narrower so it doesn't fill entire screen */
    @media only screen and (max-width: 768px) {
        .auth-card {
            width: calc(100% - 48px) !important; /* leave side gutters */
            max-width: 420px !important;
            margin: 24px auto !important;
            padding: 1rem !important;
            border-radius: 10px !important;
        }

        .logoLogin {
            width: 40% !important;
            margin: 18px auto !important;
        }
    }
</style>

<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-grey">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 border-2 border-white shadow-md overflow-hidden sm:rounded-lg auth-card">
        <img src="{{ asset('images/logo.png') }}" class="logoLogin" alt="" srcset="">
        {{ $slot }}
    </div>
</div>
