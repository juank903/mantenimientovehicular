<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{$metaTitle ?? 'Control de Mantenimiento Vehicular'}}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-gray-300 font-sans antialiased">
        <main class="container mx-auto flex md:px-5 md:py-24 sm:py-0 md:flex-row flex-col items-center">
            @if ($slot->isEmpty())
                This is default content if the slot is empty.
            @else
                {{ $slot }}
            @endif
        </main>
    </body>
</html>
