document.addEventListener('DOMContentLoaded', function () {
    // Datos Personales
    const switchDatosPersonales = document.getElementById('switch-datosPersonales');
    const datosPersonalesH1 = document.getElementById('datosPersonales');
    const formDatosPersonales = document.getElementById('formDatosPersonales');

    // Datos Usuario
    const switchDatosUsuario = document.getElementById('switch-datosUsuario');
    const datosUsuarioH1 = document.getElementById('datosUsuario');
    const formDatosUsuario = document.getElementById('formDatosUsuario');

    // Verificar que los elementos existen antes de manipularlos
    if (formDatosPersonales) formDatosPersonales.style.display = 'none';
    if (formDatosUsuario) formDatosUsuario.style.display = 'none';

    if (switchDatosPersonales) {

        switchDatosPersonales.addEventListener('change', function () {
            //console.log('presionando switch datosPersonales')
            if (datosPersonalesH1) datosPersonalesH1.style.display = this.checked ? 'none' : 'block';
            if (formDatosPersonales) formDatosPersonales.style.display = this.checked ? '' : 'none';
        });
    }

    if (switchDatosUsuario) {

        switchDatosUsuario.addEventListener('change', function () {
            //console.log('presionando switch datosUsuario')
            if (datosUsuarioH1) datosUsuarioH1.style.display = this.checked ? 'none' : '';
            if (formDatosUsuario) formDatosUsuario.style.display = this.checked ? '' : 'none';
        });
    }
});
