document.addEventListener("DOMContentLoaded", function () {

    const btnConsultarVehiculos = document.getElementById("btnConsultarVehiculos");

    if (btnConsultarVehiculos) { // Check if the element exists
        btnConsultarVehiculos.addEventListener("click", function () {
            // Obtener los valores de las variables (asegúrate de que estas variables estén disponibles en este contexto)

            let idSubcircuito = document.getElementById('idSubcircuito').textContent;
            let tipoVehiculo = document.getElementById('tipoVehiculo').textContent;

            // Construir la URL completa
            let urlCompleta = `/api/vehiculos/subcircuito/${idSubcircuito}/tipo/${tipoVehiculo}`;
            console.log('esta es la URL api: ' + urlCompleta);

            // Realizar la solicitud AJAX
            fetch(urlCompleta)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`); // Mejor manejo de errores
                    }
                    return response.json(); // Retorna la promesa del JSON
                })
                .then(data => {
                    console.log("Datos como JSON:", JSON.stringify(data, null, 2)); // Imprime JSON formateado

                    let select = document.getElementById("selectMarca");
                    if (select) {
                        select.innerHTML = '<option value="">Seleccione una marca</option>';

                        data.forEach(vehiculo => {
                            let option = document.createElement("option");
                            option.value = vehiculo.id;
                            option.textContent = vehiculo.marca_vehiculos;

                            //  Almacenar el objeto completo en un atributo data.
                            option.dataset.vehiculo = JSON.stringify(vehiculo); // Almacena el objeto vehiculo como JSON stringificado.

                            select.appendChild(option);
                        });

                        document.getElementById("vehiculoContainer").classList.remove("hidden");
                    }
                })
                .catch(error => console.error("Error en la petición:", error));
        });
    }

    const selectMarca = document.getElementById("selectMarca");

    if (selectMarca) { // Check if the element exists
        selectMarca.addEventListener("change", function () {
            let selectedOption = this.options[this.selectedIndex];
            let vehiculo = selectedOption.dataset.vehiculo ? JSON.parse(selectedOption.dataset.vehiculo) : null;

            const detalleVehiculo = document.getElementById("detalleVehiculo");
            const btnAprobarSolicitud = document.getElementById("btnAprobarSolicitud");

            if (vehiculo && detalleVehiculo && btnAprobarSolicitud) { // Check if elements exist
                document.getElementById("placa").textContent = vehiculo.placa_vehiculos;
                document.getElementById("parqueadero").textContent = vehiculo.parqueaderos && vehiculo.parqueaderos.length > 0 ? vehiculo.parqueaderos[0].parqueaderos_nombre : "No disponible";
                document.getElementById("espacio").textContent = vehiculo.espacio && vehiculo.espacio.length > 0 ? vehiculo.espacio[0].espacioparqueaderos_nombre : "No disponible";
                document.getElementById("observaciones").textContent = vehiculo.espacio && vehiculo.espacio.length > 0 ? vehiculo.espacio[0].espacioparqueaderos_observacion : "No disponible";
                document.getElementById("responsable").textContent = vehiculo.parqueaderos && vehiculo.parqueaderos.length > 0 ? vehiculo.parqueaderos[0].parqueaderos_responsable : "No disponible";

                detalleVehiculo.classList.remove("hidden");
                btnAprobarSolicitud.classList.remove("hidden");
            } else {
                if (detalleVehiculo) detalleVehiculo.classList.add("hidden");
                if (btnAprobarSolicitud) btnAprobarSolicitud.classList.add("hidden");
            }
        });
    }

    const btnAprobarSolicitud = document.getElementById("btnAprobarSolicitud");

    if (btnAprobarSolicitud) {
        btnAprobarSolicitud.addEventListener("click", function () {
            let selectedOption = document.getElementById("selectMarca").options[document.getElementById("selectMarca").selectedIndex];
            let vehiculo = selectedOption.dataset.vehiculo ? JSON.parse(selectedOption.dataset.vehiculo) : null;

            if (!vehiculo) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor, seleccione un vehículo.'
                });
                return;
            }

            const data = {
                solicitud_id: document.getElementById('solicitudId').textContent,
                vehiculo_id: vehiculo.id,
                personalpolicia_id: document.getElementById('policiaId').textContent,
                kilometraje: parseInt(vehiculo.kmactual_vehiculos),
                combustible: vehiculo.combustibleactual_vehiculos,
            };

            console.log("Datos a enviar:", data);

            fetch('/api/solicitudvehiculo/aprobar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(responseData => {
                    if (responseData.status === 'error') {
                        console.error("Error al aprobar la solicitud:", responseData.message); // Muestra el mensaje de error del servidor
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: responseData.message || 'Error al aprobar la solicitud. Por favor, intente nuevamente.' // Muestra el mensaje del servidor o uno genérico
                        });
                    } else {
                        console.log("Solicitud aprobada:", responseData);
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'Solicitud aprobada exitosamente.'
                        }).then(() => {
                            window.location.href = "{{ route('dashboard') }}";
                        }); // Redirige después de la aprobación exitosa
                    }
                })
                .catch(error => {
                    console.error("Error al aprobar la solicitud:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al aprobar la solicitud. Por favor, intente nuevamente.'
                    });
                });
        });
    }

});
