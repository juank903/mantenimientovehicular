<x-app-layout>
    <x-navigation.botonregresar href="{{ route('dashboard') }}" />

    <table id="solicitudesvehiculos-procesando" class="stripe hover">
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
        @vite('resources/js/tableSolicitudesVehiculosProcesando.js')
    @endpush
    {{-- <script>
        $(document).ready(function() {
            table = $('#solicitudesvehiculos').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ url('/api/listarsolicitudesvehiculos?estado=Procesando') }}',
                    type: 'GET',
                    dataSrc: function(json) {
                        return json.data || json.vehiculos; // Asegura obtener los datos correctamente
                    },
                    data: function(d) {
                        d.perPage = d.length || 10; // Captura el valor de perPage
                        d.page = d.start / d.length + 1; // Calcula la página actual
                        d.search = {
                            value: d.search.value || ''
                        };
                    }
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'created_at',
                        render: function(data, type, row) {
                            if (type === "display" || type === "filter") {
                                return new Date(data).toLocaleDateString('es-ES', {
                                    year: 'numeric',
                                    month: 'short',
                                    day: '2-digit'
                                }).replace('.', '');
                            }
                            return data;
                        }
                    },
                    {
                        data: 'updated_at',
                        render: function(data, type, row) {
                            if (type === "display" || type === "filter") {
                                return new Date(data).toLocaleDateString('es-ES', {
                                    year: 'numeric',
                                    month: 'short',
                                    day: '2-digit'
                                }).replace('.', '');
                            }
                            return data;
                        }
                    },
                    {
                        data: 'personal[0].rango_personal_policias'
                    },
                    {
                        data: 'personal[0].primerapellido_personal_policias'
                    },
                    {
                        data: 'personal[0].segundoapellido_personal_policias'
                    },
                    {
                        data: 'personal[0].primernombre_personal_policias'
                    },
                    {
                        data: 'personal[0].segundonombre_personal_policias'
                    },
                    {
                        data: 'solicitudvehiculos_tipo'
                    },
                    {
                        data: 'solicitudvehiculos_estado',
                        render: function(data, type, row) {
                            let colorClass = data === "Pendiente" ?
                                "bg-orange-300 text-orange-700" :
                                data === "Anulada" ? "bg-red-300 text-red-700" :
                                data === "Aprobada" ? "bg-green-300 text-green-700" :
                                data === "Completa" ? "bg-blue-300 text-blue-700" :
                                data === "Procesando" ? "bg-yellow-300 text-yellow-700" :
                                "";
                            return `<span class="text-center flex font-bold ${colorClass}">${data}</span>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            var id = data.personal[0].user_id;
                            var estado = data.solicitudvehiculos_estado; // Obtener el estado

                            console.log('averiguar: ' + id + ', estado: ' + estado);

                            // Mostrar el botón solo si el estado es "Pendiente"
                            if (estado === "Procesando") {
                                return `
                                <div class="flex justify-center space-x-4 align-middle cursor-pointer">
                                    <x-show-button href="{{ route('mostrarentregarecepcionvehiculo.policia.aprobada', ['id' => '__ID__']) }}" />
                                </div>`.replace('__ID__', id);
                            } else {
                                return ''; // No mostrar nada si el estado no es "Pendiente"
                            }
                        },
                        orderable: false
                    }
                ],
                order: [
                    [9, 'asc']
                ], // Asegura que se ordena por la primera columna
                layout: {
                    topStart: {
                        buttons: ['pageLength', 'copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5', 'print']
                    }
                },
                language: {
                    sProcessing: "Procesando...",
                    sLengthMenu: "Mostrar _MENU_ registros",
                    sZeroRecords: "Filtre los datos para visualizar la tabla",
                    sInfo: "Mostrando de _START_ a _END_ de _TOTAL_ registros",
                    sInfoEmpty: "Mostrando 0 a 0 de 0 registros",
                    sInfoFiltered: "(filtrado de _MAX_ registros en total)"
                },
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50, 100]
            });

            $('#nextPageButton').on('click', function() {
                let info = table.page.info();
                if (info.page < info.pages - 1) {
                    table.page(info.page + 1).draw(false);
                } else {
                    console.log("Ya estás en la última página.");
                }
            });
        });
    </script> --}}
</x-app-layout>
