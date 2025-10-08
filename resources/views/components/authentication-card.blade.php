<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 bg-grey">
    <div style="box-shadow: 0 0 15px rgb(185, 185, 185)">
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg" style="box-shadow: 0 0 15px rgb(185, 185, 185)">
        {{ $slot }}
    </div>
</div>
