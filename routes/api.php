<?php

use App\Http\Controllers\Api\ApiCircuitoController;
use App\Http\Controllers\Api\ApiPersonalpoliciaController;
use App\Http\Controllers\Api\ApiProvinciaController;
use App\Http\Controllers\Api\ApiSolicitudvehiculoController;
use App\Http\Controllers\Api\ApiSubcircuitoController;
use App\Http\Controllers\Api\ApiVehiculoController;
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
Route::get('/quejasugerenciasubcircuitofechas', [ReportesController::class, 'getQuejasugerenciaSubcircuitoFechas']);
Route::resource('/vehiculos', ApiVehiculoController::class);
Route::resource('/circuito', ApiCircuitoController::class);

/*Api Solicitudes hechas por usuario policia*/
Route::get('/personal/policia/{id}/totalsolicitudesvehiculos', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoPolicia']);
Route::get('/personal/policia/{id}/totalsolicitudesvehiculos/anuladas', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoAnuladasPolicia']);
Route::get('/personal/policia/{id}/totalsolicitudesvehiculos/pendientes', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoPendientesPolicia']);
Route::get('/personal/policia/{id}/totalsolicitudesvehiculos/aprobadas', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoAprobadasPolicia']);
Route::get('/personal/policia/{id}/get/solicitud-pendiente', [ApiSolicitudvehiculoController::class, 'getSolicitudVehiculoPendientePolicia']);
Route::resource('/solicitudesvehiculos', ApiSolicitudvehiculoController::class);

/*Api Información personal policia*/
Route::get('/provincias/{id}', [ApiProvinciaController::class, 'show']);
Route::get('/personal/policia/{id}/detalles', [ApiPersonalpoliciaController::class, 'show']);
Route::get('/subcircuito/{id}/provincia', [ApiSubcircuitoController::class, 'show']);
Route::resource('/personal', ApiPersonalpoliciaController::class);
