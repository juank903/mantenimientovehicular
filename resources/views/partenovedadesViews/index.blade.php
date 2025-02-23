<x-app-layout>

    <table id="vehiculos" class="stripe hover w-full">
        <thead>
            <tr>
                <th>Id</th>
                <th>Marca Vehículo</th>
                <th>Tipo Vehículo</th>
                <th>Modelo Vehículo</th>
                <th>Placa Vehículo</th>
                <th>Estado</th>
                <th>Parqueaderos y Subcircuitos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    @push('scripts')
        @vite('resources/js/tableVehiculos.js')
    @endpush

</x-app-layout>
