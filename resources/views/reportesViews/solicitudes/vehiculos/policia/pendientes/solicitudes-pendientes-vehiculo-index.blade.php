<x-app-layout>

    <!--Container-->
    <div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2 mt-10 z-0 text-sm">

        <div class="bg-white overflow-hidden shadow rounded-lg border">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    User Profile
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    This is some information about the user.
                </p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Full name
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            John Doe
                        </dd>
                    </div>
                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Email address
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            johndoe@example.com
                        </dd>
                    </div>
                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Phone number
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            (123) 456-7890
                        </dd>
                    </div>
                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Address
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            123 Main St<br>
                             Anytown, USA 12345
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

    </div>
    <!-- /Container -->

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.0/css/buttons.dataTables.css">

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
                /*                     layout: {
                                        topStart: {
                                            buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
                                        }
                                    }, */
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
                            0; // Captura el valor seleccionado de perPage
                        d.page = d.start / d.length + 1; // Calcula la página actual
                        // Si tienes un campo de búsqueda
                        d.search = {
                            value: d.search.value || ' '
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
                layout: {
                    topStart: {
                        buttons: ['pageLength', 'copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5', 'print']
                    }
                },
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "Filtre los datos para visualizar la tabla",
                    "sInfo": "Mostrando de _START_ a _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "sInfoFiltered": "(filtrado de _MAX_ registros en total)",
                    "sInfoPostFix": "",
                    // Otros mensajes de idioma
                },
                // Configura la paginación para que use los valores de `currentPage` y `perPage` de la API
                pageLength: 0, // Establece el valor por defecto
                lengthMenu: [0, 5, 10, 25, 50, 100], // Opciones de longitud de página
                order: {
                    idx: 1,
                    dir: 'asc'
                }
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
