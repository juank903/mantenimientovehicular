    <x-app-layout>

        <!--Container-->
        <div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2 mt-10 z-0 text-sm">


            <!-- Card -->
            <div id='recipients' class="p-8 mt-6 rounded shadow bg-white">

                <table id="vehiculos" class="stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th data-priority="2">Marca Vehículo</th>
                            <th data-priority="3">Tipo Vehículo</th>
                            <th data-priority="4">Modelo Vehículo</th>
                            <th data-priority="5">Color Vehículo</th>
                            <th data-priority="1">Placa Vehículo</th>
                            <th class="flex justify-center space-x-4 align-middle cursor-pointer">Acciones</th>
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
        <!-- CSS de DataTables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- JS de DataTables -->
        <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

        <style>
            #vehiculos {
                background-color: #f9f9f9;
            }

            #vehiculos thead th {
                background-color: #ffffff;

            }

            #vehiculos tbody tr:hover {
                background-color: #f1f1f1;
            }
        </style>
        <script>
            $(document).ready(function() {
                $('#vehiculos').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ url('api/vehiculos') }}',
                        type: 'GET',
                        dataSrc: function(json) {
                            console.log(json); // Ver la estructura de los datos
                            return json.data; // Retornar solo los datos de los vehículos
                        },
                        data: function(d) {
                            // Aquí puedes agregar cualquier dato adicional que necesites enviar
                            d.perPage = d.length ||
                                10; // Captura el valor seleccionado de perPage
                            d.page = d.start / d.length + 1; // Calcula la página actual
                            // Si tienes un campo de búsqueda
                            d.search = {
                                value: $('#searchInput').val()
                            };
                            console.log(d); // Ver los parámetros enviados
                        }
                    },
                    columns: [{
                            data: 'marca_vehiculos'
                        },
                        {
                            data: 'tipo_vehiculos'
                        },
                        {
                            data: 'modelo_vehiculos'
                        },
                        {
                            data: 'color_vehiculos'
                        },
                        {
                            data: 'placa_vehiculos'
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
                    language: {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "No se encontraron resultados",
                        "sInfo": "Mostrando de _START_ a _END_ de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
                        "sInfoFiltered": "(filtrado de _MAX_ registros en total)",
                        "sInfoPostFix": "",
                        // Otros mensajes de idioma
                    },
                    // Configura la paginación para que use los valores de `currentPage` y `perPage` de la API
                    pageLength: 10, // Establece el valor por defecto
                    lengthMenu: [5, 10, 25, 50, 100], // Opciones de longitud de página

                });

                // Función para cargar la siguiente página
                function loadNextPage() {
                    var info = table.page.info(); // Obtiene información sobre la página actual
                    if (info.page < info.pages - 1) { // Verifica si no es la última página
                        table.page(info.page + 1).draw(false); // Cambia a la siguiente página
                    } else {
                        console.log("Ya estás en la última página.");
                    }
                }

                // Llama a la función cuando necesites cargar la siguiente página
                $('#nextPageButton').on('click', function() {
                    loadNextPage(); // Llama a la función para cargar la siguiente página
                });
            });
        </script>
    </x-app-layout>
