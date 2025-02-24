$(document).ready(function () {
    let table = $('#parteNovedades').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/api/partenovedades?personalpolicia_id=4',
            type: 'GET',
            dataSrc: function (json) {
                console.log('json:' + json);
                return json.data;
            },
            data: function (d) {
                d.perPage = d.length || 0;
                d.page = d.start / d.length + 1;
                d.search = {
                    value: d.search.value || ' '
                };
                console.log('d' + d);
            }
        },
        columns: [
            { data: 'id', title: 'Id Parte' },
            { data: 'created_at', title: 'Fecha de creación' },
            { data: 'partenovedades_tipo', title: 'Tipo' },
            // { data: 'rango_personal_policias', title: 'Rango' },
            // { data: 'primerapellido_personal_policias', title: 'Primer Apellido' },
            // { data: 'segundoapellido_personal_policias', title: 'Segundo Apellido' },
            // { data: 'primernombre_personal_policias', title: 'Primer Nombre' },
            // { data: 'segundonombre_personal_policias', title: 'Segundo Nombre' },
            { data: 'tipo_vehiculos', title: 'Tipo vehículo' },
            { data: 'placa_vehiculos', title: 'Placa vehículo' },
            {
                data: null,
                render: function (data, type, row) {
                    let userId = row.id;
                    //let estado = data.solicitudvehiculos_estado;

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

    $(document).on('click', '.show-button', function () {
        let id = $(this).data('id');
        // Puedes redirigir o usar AJAX para mostrar la información
        const url = `/mostrarsolicitudvehiculo/policia/pendiente/show/${id}`;
        // Mostrar el botón solo si el estado es "Pendiente"

        window.location.href = url;
    });

});
