$(document).ready(function () {
    let table = $('#vehiculos').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/api/vehiculos',
            type: 'GET',
            dataSrc: function (json) {
                console.log(json);
                return json.data;
            },
            data: function (d) {
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
            render: function (data, type, row) {
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
            render: function (data, type, row) {
                const userId = data.id;

                // AJAX call to get the component HTML
                $.ajax({
                    url: `/delete-button/${userId}`,
                    success: function (html) {
                        console.log(`delete button${userId}new`);
                        // Find the container and replace its content
                        $(`#delete-button-container-${userId}`).html(html);
                    }
                });
                $.ajax({
                    url: `/show-button/${userId}`, // New route for showing data
                    success: function (html) {
                        console.log(`show button${userId}new`);
                        $(`#show-button-container-${userId}`).html(html);
                    }
                });

                return `
                            <div class="flex justify-center space-x-4 align-middle cursor-pointer">
                                <div id="show-button-container-${userId}"> </div>

                                <div id="delete-button-container-${userId}"></div>
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
    $(document).on('click', '.delete-button', function (event) {
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
                    url: `/api/vehiculos/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        Swal.fire(
                            '¡Eliminado!',
                            'El registro ha sido eliminado.',
                            'success'
                        );
                        table.ajax.reload();
                    },
                    error: function (xhr) {
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

    $(document).on('click', '.show-button', function () {
        let id = $(this).data('id');
        // Puedes redirigir o usar AJAX para mostrar la información
        const url = `/vehiculo/show/${id}`; // Ajusta la URL según tu necesidad
        window.location.href = url;
    });

});
