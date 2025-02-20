/* window.addEventListener('load', function () {
    // floating Type
    const fpDesde = flatpickr('#fecharequerimientodesde', {
        monthSelectorType: 'static',
        minDate: 'today',
        onChange: function (selectedDates, dateStr, instance) {
            fpHasta.set('minDate', selectedDates); // Actualiza la fecha mínima en fpHasta
            validarHoras(); // Llama a la función para validar las horas
        }
    });

    const fpHasta = flatpickr('#fecharequerimientohasta', {
        monthSelectorType: 'static',
        minDate: 'today',
        onChange: function (selectedDates, dateStr, instance) {
            validarHoras(); // Llama a la función para validar las horas
        }
    });

    // Time
    const tpDesde = flatpickr('#horarequerimientodesde', {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'H:i',
        minuteIncrement: 30,
        defaultDate: 'now',
        onChange: function (selectedDates, dateStr, instance) {
            validarHoras(); // Llama a la función para validar las horas
        }
    });

    const tpHasta = flatpickr('#horarequerimientohasta', {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'H:i',
        minuteIncrement: 30,
        defaultDate: 'now',
        onChange: function (selectedDates, dateStr, instance) {
            validarHoras(); // Llama a la función para validar las horas
        }
    });

    function validarHoras() {
        const fechaDesde = fpDesde.selectedDates[0];
        const fechaHasta = fpHasta.selectedDates[0];
        const horaDesde = tpDesde.selectedDates[0];
        const horaHasta = tpHasta.selectedDates[0];

        if (fechaDesde && fechaHasta && horaDesde && horaHasta) {
            if (fechaDesde.getTime() === fechaHasta.getTime()) {
                if (horaHasta.getTime() <= horaDesde.getTime()) {
                    tpHasta.set('minTime', horaDesde.getTime() + 30 * 60 * 1000); // Establece la hora mínima en tpHasta
                    // Puedes mostrar un mensaje de error si lo deseas:
                    // alert('La hora de finalización debe ser posterior a la hora de inicio.');
                } else {
                    tpHasta.set('minTime', null); // Restablece la hora mínima si la condición no se cumple
                }
            } else {
                tpHasta.set('minTime', null); // Restablece la hora mínima si las fechas son diferentes
            }
        }
    }

    function validarHoras() {
        const fechaDesde = fpDesde.selectedDates[0];
        const fechaHasta = fpHasta.selectedDates[0];
        const horaDesde = tpDesde.selectedDates[0];
        const horaHasta = tpHasta.selectedDates[0];
        const ahora = new Date(); // Obtiene la fecha y hora actual

        if (fechaDesde && fechaHasta && horaDesde && horaHasta) {
            // Validación de fechas y horas contra la hora actual
            if (fechaDesde.getTime() < ahora.getTime() || (fechaDesde.getTime() === ahora.getTime() && horaDesde.getTime() < ahora.getTime())) {
                tpDesde.set('minTime', ahora.getTime()); // Establece la hora mínima en tpDesde
                // Puedes mostrar un mensaje de error si lo deseas:
                // alert('La hora de inicio debe ser posterior a la hora actual.');
            } else {
                tpDesde.set('minTime', null); // Restablece la hora mínima si la condición no se cumple
            }

            if (fechaHasta.getTime() < ahora.getTime() || (fechaHasta.getTime() === ahora.getTime() && horaHasta.getTime() < ahora.getTime())) {
                tpHasta.set('minTime', ahora.getTime()); // Establece la hora mínima en tpHasta
                // Puedes mostrar un mensaje de error si lo deseas:
                // alert('La hora de finalización debe ser posterior a la hora actual.');
            } else {
                tpHasta.set('minTime', null); // Restablece la hora mínima si la condición no se cumple
            }

            // Validación de horas si las fechas son iguales
            if (fechaDesde.getTime() === fechaHasta.getTime()) {
                if (horaHasta.getTime() <= horaDesde.getTime()) {
                    tpHasta.set('minTime', horaDesde.getTime() + 30 * 60 * 1000); // Establece la hora mínima en tpHasta
                    // Puedes mostrar un mensaje de error si lo deseas:
                    // alert('La hora de finalización debe ser posterior a la hora de inicio.');
                }
            }
        }
    }
});
 */
window.addEventListener('load', function () {
    // Floating Type
    const fpDesde = flatpickr('#fecharequerimientodesde', {
        monthSelectorType: 'static',
        minDate: 'today',
        onChange: function (selectedDates, dateStr, instance) {
            if (fpHasta.selectedDates[0] && selectedDates[0] > fpHasta.selectedDates[0]) {
                alert('La fecha de inicio no puede ser mayor que la fecha de finalización.');
                fpDesde.setDate(fpHasta.selectedDates[0]); // Restablece la fecha
                return;
            }
            fpHasta.set('minDate', selectedDates[0]); // Actualiza la fecha mínima en fpHasta
            validarHoras();
        }
    });

    const fpHasta = flatpickr('#fecharequerimientohasta', {
        monthSelectorType: 'static',
        minDate: 'today',
        onChange: function (selectedDates, dateStr, instance) {
            if (fpDesde.selectedDates[0] && selectedDates[0] < fpDesde.selectedDates[0]) {
                alert('La fecha de finalización no puede ser menor que la fecha de inicio.');
                fpHasta.setDate(fpDesde.selectedDates[0]); // Restablece la fecha
                return;
            }
            validarHoras();
        }
    });

    // Time Pickers
    const tpDesde = flatpickr('#horarequerimientodesde', {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'H:i',
        minuteIncrement: 30,
        defaultDate: 'now',
        onChange: validarHoras
    });

    const tpHasta = flatpickr('#horarequerimientohasta', {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'H:i',
        minuteIncrement: 30,
        defaultDate: 'now',
        onChange: validarHoras
    });

    function validarHoras() {
        const fechaDesde = fpDesde.selectedDates[0];
        const fechaHasta = fpHasta.selectedDates[0];
        const horaDesde = tpDesde.selectedDates[0];
        const horaHasta = tpHasta.selectedDates[0];
        const ahora = new Date(); // Fecha y hora actual

        if (fechaDesde && fechaHasta && horaDesde && horaHasta) {
            // Validación de fechas y horas contra la hora actual
            if (fechaDesde.getTime() < ahora.getTime()) {
                alert('La fecha de inicio no puede estar en el pasado.');
                fpDesde.setDate(ahora);
            }

            if (fechaHasta.getTime() < fechaDesde.getTime()) {
                alert('La fecha de finalización no puede ser menor que la fecha de inicio.');
                fpHasta.setDate(fechaDesde);
            }

            // Validación de horas si las fechas son iguales
            if (fechaDesde.getTime() === fechaHasta.getTime() && horaHasta.getTime() <= horaDesde.getTime()) {
                alert('La hora de finalización debe ser posterior a la hora de inicio.');
                tpHasta.setDate(new Date(horaDesde.getTime() + 30 * 60 * 1000)); // Ajusta la hora mínima
            }
        }
    }
});
