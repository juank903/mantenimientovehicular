<x-app-layout>
    <x-navigation.botonregresar href="{{ route('dashboard') }}" />

    <table id="solicitudesvehiculos-aprobadas" class="stripe hover">
        <thead>
            <tr>
                <th rowspan="2">Solicitud No.</th>
                <th rowspan="2">Fecha de creación</th>
                <th rowspan="2">Fecha de aprobacion</th>
                <th colspan="5">Usuario</th>
                <th rowspan="2">Vehículo solicitado</th>
                <th rowspan="2">Tipo solicitud</th>
                <th rowspan="2">Acciones</th>
            </tr>
            <tr>
                <th>Grado</th>
                <th>Apellido paterno</th>
                <th>Apellido materno</th>
                <th>Primer nombre</th>
                <th>Segundo nombre</th>
            </tr>
        </thead>
        <tbody> </tbody>
    </table>

    @push('scripts')
        @vite('resources/js/tableSolicitudesVehiculosAprobadas.js')
    @endpush

</x-app-layout>
