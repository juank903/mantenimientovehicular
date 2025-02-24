<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Control Mantenimiento Vehicular') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    @if (Request::is('mostrartodopersonal') ||
            Request::is('mostrartodovehiculos') ||
            Request::is('mostrartodasolicitudesvehiculos/pendientes') ||
            Route::is('mostrartodasolicitudesvehiculos.aprobadas') ||
            Route::is('mostrartodasolicitudesvehiculos.procesando'))
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css">
        <!-- DataTables Buttons CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.0/css/buttons.dataTables.css">
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
        <!-- DataTables Buttons JS -->
        <script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.dataTables.js"></script>
        <!-- JSZip for Excel export -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <!-- pdfmake for PDF export -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.print.min.js"></script>
    @endif

    @if (Route::is('gerencia.dashboard'))
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endif

    @if (Route::is('mostrarsolicitudvehiculo.policia.pendiente'))
        @vite(['resources/js/modalAprobarSolicitudVehiculoAdministrador.js'])
    @endif

    @if (Route::is('mostrarsolicitudvehiculo.policia.pendiente') ||
            Route::is('mostrarentregarecepcionvehiculo.policia.aprobada') ||
            Route::is('mostrarentregarecepcionvehiculo.estado') ||
            Route::is('solicitudcombustible.policia.create'))
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endif

    @if (Route::is('solicitarvehiculo.policia.create'))
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @endif

</head>

<body class="font-sans antialiased bg-gray-300">
    <x-navigation.navegacion :menuItems="$menuItems" />
    <div class="header hidden">
        <img src="{{ asset('img/logoPolicia.png') }}" alt="Logo">
    </div>
    <div class="container w-full mx-auto px-10 mt-5 z-0 text-sm mb-10">
        <div id='recipients' class="p-5 rounded-2xl shadow bg-white">
            {{ $slot }}
        </div>
    </div>
    @stack('scripts')
</body>

</html>
