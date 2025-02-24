/* document.addEventListener('DOMContentLoaded', function () {
    const fechaAsignacionInput = document.getElementById('fechaAsignacion');
    const combustibleActualInput = document.getElementById('combustibleActual');
    const kilometrajeInput = document.querySelector('input[name="solicitudcombustible_km"]');
    const btnEnviarSolicitud = document.getElementById('btnEnviarSolicitud'); // Asegúrate de que este ID existe en tu HTML

    let kilometrajeInicial = kilometrajeInput.value;

    console.log('fechaAsignacion: ' + fechaAsignacionInput.value);
    console.log('combustibleActual: ' + combustibleActualInput.value);
    console.log('kilometrajeInicial: ' + kilometrajeInicial);

    kilometrajeInput.addEventListener('input', function () {
        const kilometrajeSolicitud = kilometrajeInput.value;
        console.log('kilometrajeSolicitud: ' + kilometrajeSolicitud);

        if (kilometrajeSolicitud !== kilometrajeInicial) {
            console.log('El kilometraje ha cambiado.');
            // Aquí puedes realizar las acciones que necesites cuando el valor cambia.
        }
    });

    function validarFormulario() {
        const fechaAsignacion = new Date(fechaAsignacionInput.value);
        const fechaActual = new Date();
        const combustibleActual = combustibleActualInput.value;
        const kilometrajeSolicitud = parseInt(kilometrajeInput.value, 10);

        console.log('fecha asignacion: ' + fechaAsignacion);
        console.log('fecha actual: ' + fechaActual);

        // Calcular la diferencia en milisegundos entre la fecha actual y la fecha de asignación
        const diferenciaTiempo = fechaActual - fechaAsignacion;
        const horasDiferencia = diferenciaTiempo / (1000 * 60 * 60); // Convertir a horas

        if (combustibleActual === 'full') {
            // Si el combustible está lleno, la fecha de asignación debe ser al menos 24 horas antes
            if (horasDiferencia > 24) {
                btnEnviarSolicitud.disabled = false;
            } else {
                btnEnviarSolicitud.disabled = true;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se puede enviar la solicitud porque el combustible está lleno y no han pasado más de 24 horas desde la fecha de asignación.',
                });
            }
        } else if (fechaActual >= fechaAsignacion) {
            // Si el combustible no está lleno y la fecha es válida, habilitar el botón
            btnEnviarSolicitud.disabled = false;
        } else {
            btnEnviarSolicitud.disabled = true;
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'La fecha de asignación debe ser mayor o igual a la fecha actual.',
            });
        }
    }

    kilometrajeInput.addEventListener('input', validarFormulario);
    fechaAsignacionInput.addEventListener('change', validarFormulario);
    combustibleActualInput.addEventListener('change', validarFormulario);

    validarFormulario(); // Validar el formulario al cargar la página
});
 */
document.addEventListener('DOMContentLoaded', function () {
    const fechaAsignacionInput = document.getElementById('fechaAsignacion');
    const combustibleActualInput = document.getElementById('combustibleActual');
    const kilometrajeInput = document.querySelector('input[name="solicitudcombustible_km"]');
    const btnEnviarSolicitud = document.getElementById('btnEnviarSolicitud'); // Asegúrate de que este ID existe en tu HTML

    let kilometrajeInicial = parseInt(kilometrajeInput.value, 10); // Convertir a número

    console.log('fechaAsignacion: ' + fechaAsignacionInput.value);
    console.log('combustibleActual: ' + combustibleActualInput.value);
    console.log('kilometrajeInicial: ' + kilometrajeInicial);

    // Validar el kilometraje cuando el input pierde el foco
    kilometrajeInput.addEventListener('blur', function () {
        const kilometrajeSolicitud = parseInt(kilometrajeInput.value, 10);
        console.log('kilometrajeSolicitud: ' + kilometrajeSolicitud);

        if (combustibleActualInput.value === 'full' && kilometrajeSolicitud <= kilometrajeInicial) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El kilometraje solicitado debe ser mayor al kilometraje actual.',
            });
        }
        validarFormulario(); // Llamar a la validación general después de perder el foco
    });

    function validarFormulario() {
        const fechaAsignacion = new Date(fechaAsignacionInput.value);
        const fechaActual = new Date();
        const combustibleActual = combustibleActualInput.value;
        const kilometrajeSolicitud = parseInt(kilometrajeInput.value, 10);

        console.log('fecha asignacion: ' + fechaAsignacion);
        console.log('fecha actual: ' + fechaActual);

        // Calcular la diferencia en milisegundos entre la fecha actual y la fecha de asignación
        const diferenciaTiempo = fechaActual - fechaAsignacion;
        const horasDiferencia = diferenciaTiempo / (1000 * 60 * 60); // Convertir a horas

        if (combustibleActual === 'full') {
            // Si el combustible está lleno, validar que hayan pasado más de 24 horas y que el kilometraje solicitado sea mayor
            if (horasDiferencia > 24 && kilometrajeSolicitud > kilometrajeInicial) {
                btnEnviarSolicitud.disabled = false;
            } else {
                btnEnviarSolicitud.disabled = true;

                if (horasDiferencia <= 24) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se puede enviar la solicitud porque el combustible está lleno y no han pasado más de 24 horas desde la fecha de asignación.',
                    });
                } else if (kilometrajeSolicitud <= kilometrajeInicial) {
                    // Este mensaje ya se muestra en el evento 'blur', por lo que no es necesario repetirlo aquí
                }
            }
        } else if (fechaActual >= fechaAsignacion) {
            // Si el combustible no está lleno y la fecha es válida, habilitar el botón
            btnEnviarSolicitud.disabled = false;
        } else {
            btnEnviarSolicitud.disabled = true;
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'La fecha de asignación debe ser mayor o igual a la fecha actual.',
            });
        }
    }

    // Validar el formulario cuando cambian otros campos
    fechaAsignacionInput.addEventListener('change', validarFormulario);
    combustibleActualInput.addEventListener('change', validarFormulario);

    validarFormulario(); // Validar el formulario al cargar la página
});
