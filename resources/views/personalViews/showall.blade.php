<x-app-layout>

    <!--Container-->
    <div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2 mt-10 z-0 text-sm">

        <!--Card-->
        <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">

            <table id="personal" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                <thead>
                    <tr>
                        <th class="w-1/6" >Rango</th>
                        <th class="w-1/6" >Apellido Paterno</th>
                        <th class="w-1/6" >Apellido Materno</th>
                        <th class="w-1/6" >Primer Nombre</th>
                        <th class="w-1/6" >Segundo Nombre</th>
                        <th class="w-1/6">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <!--/Card-->
    </div>
    <!--/container-->

    <script>
        $(document).ready(function() {
            table = $('#personal').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ url('/api/personal') }}',
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
                            value: d.search.value || ' '
                        };
                        console.log(d); // Ver los parámetros enviados
                    }
                },
                columns: [{
                        data: 'rango_personal_policias'
                    },
                    {
                        data: 'primerapellido_personal_policias'
                    },
                    {
                        data: 'segundoapellido_personal_policias'
                    },
                    {
                        data: 'primernombre_personal_policias'
                    },
                    {
                        data: 'segundonombre_personal_policias'
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
                pageLength: 10, // Establece el valor por defecto
                lengthMenu: [0, 5, 10, 25, 50, 100], // Opciones de longitud de página
                order: {
                    idx: 0,
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
/*             table.columns().every(function(index) {
                console.log('Índice de columna: ' + index + ' - Nombre: ' + this.header().innerHTML);
            }); */
        });
    </script>
</x-app-layout>
