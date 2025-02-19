$(document).ready(function () {
    let table = $('#solicitudesvehiculos-aprobadas').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: `/api/listarsolicitudesvehiculos?estado=Aprobada`,
            type: 'GET',
            dataSrc: function (json) {
                return json.data || json.vehiculos; // Asegura obtener los datos correctamente
            },
            data: function (d) {
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
            render: function (data, type, row) {
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
            render: function (data, type, row) {
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
            render: function (data, type, row) {
                let colorClass = data === "Pendiente" ?
                    "bg-orange-300 text-orange-700" :
                    data === "Anulada" ? "bg-red-300 text-red-700" :
                        data === "Aprobada" ? "bg-green-300 text-green-700" :
                            data === "Completa" ? "bg-blue-300 text-blue-700" :
                                "";
                return `<span class="text-center flex font-bold ${colorClass}">${data}</span>`;
            }
        },
        {
            data: null,
            render: function (data, type, row) {
                let userId = data.personal[0].user_id;
                let estado = data.solicitudvehiculos_estado;
                console.log('averiguar: ' + userId + ', estado: ' + estado);
                $.ajax({
                    url: `/show-button/${userId}`, // New route for showing data
                    success: function (html) {
                        console.log(`show button${userId}new`);
                        $(`#show-button-container-${userId}`).html(html);
                    }
                });

                if (estado === "Aprobada") {
                    return `
                            <div class="flex justify-center space-x-4 align-middle cursor-pointer">
                                <div id="show-button-container-${userId}"> </div>
                            </div>`;
                } else {
                    return '';
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

    /* $('#nextPageButton').on('click', function () {
        let info = table.page.info();
        if (info.page < info.pages - 1) {
            table.page(info.page + 1).draw(false);
        } else {
            console.log("Ya estás en la última página.");
        }
    }); */
    $(document).on('click', '.show-button', function () {
        let id = $(this).data('id');
        // Puedes redirigir o usar AJAX para mostrar la información
        const url = `/mostrarsolicitudvehiculo/policia/aprobada/show/${id}`;
        // Mostrar el botón solo si el estado es "Pendiente"

        window.location.href = url;
    });
});
