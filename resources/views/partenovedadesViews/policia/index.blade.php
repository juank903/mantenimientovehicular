<x-app-layout>

    <table id="parteNovedades" class="stripe hover w-full">
        <thead>
            <tr>
                <th>Id Parte</th>
                <th>Fecha de creación</th>
                <th>Tipo</th>
                {{-- <th>Rango</th> --}}
                {{-- <th>Primer Apellido</th> --}}
                {{-- <th>Segundo Apellido</th> --}}
                {{-- <th>Primer Nombre</th> --}}
                {{-- <th>Segundo Nombre</th> --}}
                <th>Tipo vehículo</th>
                <th>Placa vehículo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    @push('scripts')
        @vite('resources/js/tablePartesNovedades.js')
    @endpush

</x-app-layout>
