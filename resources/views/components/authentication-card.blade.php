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
</style>

<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-grey">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 border-2 border-white shadow-md overflow-hidden sm:rounded-lg auth-card">
        <img src="{{ asset('images/logo.png') }}" class="logoLogin" alt="" srcset="">
        {{ $slot }}
    </div>
</div>
