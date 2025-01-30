<x-app-layout>

    <!--Container-->
    <div class="container flex w-full md:w-4/5 xl:w-3/5  mx-auto px-2 mt-10 z-0 text-sm">

        <!-- Card -->
        <div id='recipients' class="p-8 mt-6 rounded shadow bg-white">
            <table id="solicitudesvehiculos" class="stripe hover"
                style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                <thead>
                    <tr>
                        <th rowspan="2">Solicitud No.</th>
                        <th rowspan="2">Fecha de creación</th>
                        <th rowspan="2">Fecha para requerimiento</th>
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
                <tbody>
                    <!-- Data will be populated dynamically here -->
                </tbody>
            </table>
        </div>
        <!-- /Card -->

    </div>
    <!-- /Container -->

    <script>
        $(document).ready(function() {
            table = $('#solicitudesvehiculos').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ url('/api/solicitudesvehiculos') }}',
                    type: 'GET',
                    dataSrc: function(json) {
                        return json.data || json.vehiculos; // Asegura obtener los datos correctamente
                    },
                    data: function(d) {
                        d.perPage = d.length || 10; // Captura el valor de perPage
                        d.page = d.start / d.length + 1; // Calcula la página actual
                        d.search = { value: d.search.value || '' };
                    }
                },
                columns: [
                    { data: 'id' },
                    {
                        data: 'created_at',
                        render: function(data, type, row) {
                            if (type === "display" || type === "filter") {
                                return new Date(data).toLocaleDateString('es-ES', { year: 'numeric', month: 'short', day: '2-digit' }).replace('.', '');
                            }
                            return data;
                        }
                    },
                    {
                        data: 'solicitudvehiculos_fecharequerimiento',
                        render: function(data, type, row) {
                            if (type === "display" || type === "filter") {
                                return new Date(data).toLocaleDateString('es-ES', { year: 'numeric', month: 'short', day: '2-digit' }).replace('.', '');
                            }
                            return data;
                        }
                    },
                    { data: 'personal[0].rango_personal_policias' },
                    { data: 'personal[0].primerapellido_personal_policias' },
                    { data: 'personal[0].segundoapellido_personal_policias' },
                    { data: 'personal[0].primernombre_personal_policias' },
                    { data: 'personal[0].segundonombre_personal_policias' },
                    { data: 'solicitudvehiculos_tipo' },
                    {
                        data: 'solicitudvehiculos_estado',
                        render: function(data, type, row) {
                            let colorClass = data === "Pendiente" ? "bg-orange-300 text-orange-700" :
                                             data === "Anulada" ? "bg-red-300 text-red-700" :
                                             "bg-green-300 text-green-700";
                            return `<span class="text-center flex font-bold ${colorClass}">${data}</span>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <div class="flex justify-center space-x-4 align-middle cursor-pointer">
                                    <x-show-button />
                                    <x-edit-button />
                                    <x-delete-button />
                                </div>`;
                        },
                        orderable: false
                    }
                ],
                order: [[9, 'asc']], // Asegura que se ordena por la primera columna
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
    </script>
</x-app-layout>
