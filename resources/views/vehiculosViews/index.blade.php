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
    {{-- <script>
        $(document).ready(function() {
            let table = $('#vehiculos').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ url('/api/vehiculos') }}',
                    type: 'GET',
                    dataSrc: function(json) {
                        console.log(json);
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
                        data: 'id'
                    },
                    {
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
                        data: 'estado'
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
                        },
                        orderable: false
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                            <div class="flex justify-center space-x-4 align-middle cursor-pointer">
                                <button class="show-button" data-id="${row.id}"><x-show-button /></button>
                                <button class="edit-button" data-id="${row.id}"><x-edit-button /></button>
                                <button class="delete-button" data-id="${row.id}"><x-delete-button /></button>
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
                order: {
                    idx: 0,
                    dir: 'asc'
                }
            });

            // Evento para eliminar un registro (CON CONFIRMACIÓN)
            $(document).on('click', '.delete-button', function(event) {
                event.preventDefault();

                let id = $(this).data('id');

                Swal.fire({
                    title: '¿Estás seguro de que deseas eliminar este registro?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ url('/api/vehiculos') }}/${id}`, // URL correcta para vehiculos
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    '¡Eliminado!',
                                    'El registro ha sido eliminado.',
                                    'success'
                                );
                                table.ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    '¡Error!',
                                    'Error al eliminar el registro.',
                                    'error'
                                );
                                console.log(xhr.responseText);
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.show-button', function() {
                let id = $(this).data('id');
                // Puedes redirigir o usar AJAX para mostrar la información
                // Ejemplo de redirección:
                const url = `/vehiculos/${id}`; // Ajusta la URL según tu necesidad
                window.location.href = url;

                // Ejemplo usando AJAX (si necesitas cargar contenido en la misma página):
                /*
                $.ajax({
                    url: `/vehiculos/${id}`,
                    type: 'GET',
                    success: function(response) {
                        // Muestra la información en un modal, div, etc.
                        $('#modal-content').html(response);
                        $('#myModal').modal('show'); // Ejemplo con Bootstrap modal
                    },
                    error: function(error) {
                        console.error("Error al cargar datos:", error);
                    }
                });
                */
            });


            // ... (código para next page si lo necesitas)
        });
    </script> --}}
</x-app-layout>
