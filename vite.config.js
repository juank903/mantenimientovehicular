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
            ],
            refresh: true,
        }),
    ],
});
