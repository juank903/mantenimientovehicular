$(document).ready(function () {
    let table = $('#asistencias').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/api/asistencias',
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
        columns: [
            { data: 'id' },
            { data: 'asistencias_ingreso' },
            { data: 'asistencias_salida' },
            { data: 'rango_personal_policias' },
            { data: 'primerapellido' },
            { data: 'segundoapellido' },
            { data: 'primernombre' },
            { data: 'segundonombre' },
            {
                data: null,
                render: function (data, type, row) {
                    const id = data.id;
                    // Aquí puedes agregar botones de acción, como ver detalles o eliminar
                    return `
                        <div class="flex justify-center space-x-4 align-middle cursor-pointer">
                            <button class="show-button bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" data-id="${id}">Ver</button>
                            <button class="delete-button bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" data-id="${id}">Eliminar</button>
                        </div>
                    `;
                },
                orderable: false
            }
        ],
        dom: 'Bfrtip', // Añade 'B' para habilitar los botones
        buttons: [
            'pageLength',
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
            'print'
        ],
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
                    url: `/api/asistencias/${id}`, // Ajusta la URL de tu API
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Asegúrate de tener el token CSRF
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
        const url = `/asistencia/show/${id}`; // Ajusta la URL según tu necesidad
        window.location.href = url;
    });
});
