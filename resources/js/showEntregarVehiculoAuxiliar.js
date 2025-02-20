const btnEntregarVehiculo = document.getElementById('btnEntregarVehiculo');
const modalConfirmacion = document.getElementById('modalConfirmacion');
const btnConfirmar = document.getElementById('btnConfirmar');
const btnCancelar = document.getElementById('btnCancelar');

/* btnEntregarVehiculo.addEventListener('click', () => {
    modalConfirmacion.classList.remove('hidden');
});

btnCancelar.addEventListener('click', () => {
    modalConfirmacion.classList.add('hidden');
}); */

btnEntregarVehiculo.addEventListener('click', () => {
    Swal.fire({
        title: 'Confirmar entrega de vehículo',
        text: '¿Está seguro de que desea entregar este vehículo?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, entregar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const asignacionId = document.getElementById('asignacionId').textContent;
            console.log(asignacionId);

            fetch(`/api/entregarvehiculo/policia?asignacion_id=${asignacionId}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: data.message,
                            confirmButtonText: 'OK',
                        }).then(() => {
                            window.location.href =
                                "{{ route('dashboard') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                            confirmButtonText: 'OK',
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al entregar el vehículo.',
                        confirmButtonText: 'OK',
                    });
                });
        }
    });
});


