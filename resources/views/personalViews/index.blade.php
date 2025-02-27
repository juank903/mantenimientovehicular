<x-app-layout>

    <table id="personal" class="stripe hover">
        <thead>
            <tr>
                <th class="w-1/6">Id</th>
                <th class="w-1/6">Rango</th>
                <th class="w-1/6">Apellido Paterno</th>
                <th class="w-1/6">Apellido Materno</th>
                <th class="w-1/6">Primer Nombre</th>
                <th class="w-1/6">Segundo Nombre</th>
                <th class="w-1/6">Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    @push('scripts')
        @vite('resources/js/tablePersonal.js')
    @endpush

</x-app-layout>
