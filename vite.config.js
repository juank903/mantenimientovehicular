import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/script.js',
                'resources/js/tablePersonal.js',
                'resources/js/tableVehiculos.js',
                'resources/js/tableSolicitudesVehiculosPendientes.js',
                'resources/js/tableSolicitudesVehiculosAprobadas.js',
                'resources/js/tableSolicitudesVehiculosProcesando.js',
                'resources/js/tableSolicitudesVehiculosCompletas.js',
                'resources/js/datetimeSelects.js',
                'resources/js/showAprobarSolicitudVehiculoAdministrador.js',
                'resources/js/modalAprobarSolicitudVehiculoAdministrador.js',
                'resources/js/showEntregarVehiculoAuxiliar.js',
                'resources/js/editProfile.js',
                'resources/js/createSolicitudCombustible.js',
                'resources/js/tablePartesNovedades.js',
                'resources/js/tableAsistencia.js'
            ],
            refresh: true,
        }),
    ],
});
