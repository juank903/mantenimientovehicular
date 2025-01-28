<?php

use App\Http\Controllers\Api\ApiPersonalpoliciaController;
use App\Http\Controllers\Api\ApiProvinciaController;
use App\Http\Controllers\Api\ApiSolicitudvehiculoController;
use App\Http\Controllers\Api\CircuitoController;
use App\Http\Controllers\Api\SolicitudvehiculoController;
use App\Http\Controllers\Api\SubcircuitoController;
use App\Http\Controllers\Api\VehiculoController;
use App\Http\Controllers\Auth\Reportes\ReportesController;
use App\Http\Controllers\Web\Quejas\QuejasugerenciasController;
use App\Models\Personalpolicia;
use App\Models\Quejasubcircuito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
});
Route::get('quejasugerenciasubcircuitofechas', [ReportesController::class, 'getQuejasugerenciaSubcircuitoFechas']);
Route::resource('vehiculos', VehiculoController::class);
Route::resource('circuito', CircuitoController::class);
Route::get('personal/{id}/solicitudes', [ApiSolicitudvehiculoController::class, 'getNumeroSolicitudes']);
Route::get('/personal/{id}/solicitudes/anuladas', [ApiSolicitudvehiculoController::class, 'getNumeroSolicitudesAnuladas']);
Route::get('/personal/{id}/solicitudes/pendientes', [ApiSolicitudvehiculoController::class, 'getNumeroSolicitudesPendientes']);
Route::get('/personal/{id}/solicitudes/aprobadas', [ApiSolicitudvehiculoController::class, 'getNumeroSolicitudesAprobadas']);
Route::get('/solicitudvehiculo-pendiente/{id}', [ApiSolicitudvehiculoController::class, 'obtenerSolicitudPendiente']);
Route::put('/solicitud-vehiculo/anular/{id}', [ApiSolicitudvehiculoController::class, 'anularSolicitudVehiculo']);
Route::get('/provincias/{id}', [ApiProvinciaController::class, 'show']);
Route::get('/personalpolicia/{id}/detalles', [ApiPersonalpoliciaController::class, 'show']);
//este es de prueba para tener todo el detalle de un subcircuito a provincia
Route::get('/subcircuito/{id}/provincia', [SubcircuitoController::class, 'show']);
