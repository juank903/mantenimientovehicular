<x-app-layout>
    <div class="container w-full md:w-4/5 xl:w-3/5 mx-auto px-2 mt-10 z-0 text-sm">
        <div id='recipients' class="p-8 mt-6 rounded shadow bg-white">
            <table id="vehiculos" class="stripe hover w-full">
                <thead>
                    <tr>
                        <th>Marca Vehículo</th>
                        <th>Tipo Vehículo</th>
                        <th>Modelo Vehículo</th>
                        <th>Placa Vehículo</th>
                        <th>Parqueaderos y Subcircuitos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let table = $('#vehiculos').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ url('/api/vehiculos') }}',
                    type: 'GET',
                    dataSrc: function(json) {
                        console.log(json); // Ver la estructura de los datos
                        return json.data;
                    },
                    data: function(d) {
                        d.perPage = d.length || 0;
                        d.page = d.start / d.length + 1;
                        d.search = {
                            value: d.search.value || ' '
                        };
                        console.log(d);
                    }
                },
                columns: [{
                        data: 'marca'
                    },
                    {
                        data: 'tipo'
                    },
                    {
                        data: 'modelo'
                    },
                    {
                        data: 'placa'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            if (!row.parqueaderos.length) return "Sin parqueadero";
                            let content = '<ul>';
                            row.parqueaderos.forEach(parqueadero => {
                                content += `<li><strong>${parqueadero.direccion}</strong>`;
                                if (parqueadero.subcircuitos.length) {
                                    content += `<ul>`;
                                    parqueadero.subcircuitos.forEach(sub => {
                                        content += `<li>${sub.nombre}</li>`;
                                    });
                                    content += `</ul>`;
                                }
                                content += `</li>`;
                            });
                            content += '</ul>';
                            return content;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <div class="flex justify-center space-x-4 align-middle cursor-pointer">
                                    <x-show-button data-id="${row.id}" />
                                    <x-edit-button data-id="${row.id}" />
                                    <x-delete-button data-id="${row.id}" />
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
                    "sZeroRecords": "No se encontraron datos",
                    "sInfo": "Mostrando de _START_ a _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "sInfoFiltered": "(filtrado de _MAX_ registros en total)",
                },
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50, 100],
                order: [
                    [0, 'asc']
                ]
            });

            // Cargar siguiente página
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
