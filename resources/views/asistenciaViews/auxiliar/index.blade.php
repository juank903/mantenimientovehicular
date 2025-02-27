<x-app-layout>

    <table id="asistencias" class="stripe hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ingreso</th>
                <th>Salida</th>
                <th>Rango Personal Policial</th>
                <th>Primer Apellido</th>
                <th>Segundo Apellido</th>
                <th>Primer Nombre</th>
                <th>Segundo Nombre</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    @push('scripts')
        @vite('resources/js/tableAsistencia.js')
    @endpush

</x-app-layout>
