<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Agung's Collection</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Icons -->
        <!-- Link ke file favicon -->
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <!-- Alternatif untuk format lain -->
        <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .main {
                background-image: url('images/bg.jpg');
            }

            .bg-grey {
                background-color: rgba(243, 244, 246, 0.95);
            }
        </style>
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased main">
            {{ $slot }}
        </div>
    </body>
</html>
