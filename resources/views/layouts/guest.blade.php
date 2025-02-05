<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $metaTitle ?? 'Control de Mantenimiento Vehicular' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>

    <body class="bg-gray-300 font-sans antialiased">
        <div class="container w-full md:w-4/5 xl:w-3/5 mx-auto px-2 mt-5 z-0 text-sm">
            <div id='recipients' class="p-5 rounded-2xl shadow bg-white">
                @if ($slot->isEmpty())
                This is default content if the slot is empty.
            @else
                {{ $slot }}
            @endif
            </div>
        </div>

    </body>

</html>
