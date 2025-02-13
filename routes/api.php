<?php

use App\Http\Controllers\Api\ApiCircuitoController;
use App\Http\Controllers\Api\ApiPersonalpoliciaController;
use App\Http\Controllers\Api\ApiProvinciaController;
use App\Http\Controllers\Api\ApiSolicitudvehiculoController;
use App\Http\Controllers\Api\ApiSubcircuitoController;
use App\Http\Controllers\Api\ApiVehiculoController;
use App\Http\Controllers\App\ReportesController;
use App\Http\Controllers\App\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/quejasugerenciasubcircuitofechas', [ReportesController::class, 'getQuejasugerenciaSubcircuitoFechas']);
Route::resource('/vehiculos', ApiVehiculoController::class);
Route::resource('/circuito', ApiCircuitoController::class);

/*Api Solicitudes hechas por usuario policia*/
Route::get('/personal/policia/{id}/totalsolicitudesvehiculos', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoPolicia']);
Route::get('/personal/policia/{id}/totalsolicitudesvehiculos/anuladas', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoAnuladasPolicia']);
Route::get('/personal/policia/{id}/totalsolicitudesvehiculos/pendientes', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoPendientesPolicia']);
Route::get('/personal/policia/{id}/totalsolicitudesvehiculos/aprobadas', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoAprobadasPolicia']);
Route::get('/personal/policia/{id}/totalsolicitudesvehiculos/completas', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoCompletasPolicia']);
Route::get('/personal/policia/{id}/get/solicitud-pendiente', [ApiSolicitudvehiculoController::class, 'getSolicitudVehiculoPendientePolicia']);
Route::get('/personal/policia/{id}/get/solicitud-aprobada', [ApiSolicitudvehiculoController::class, 'getSolicitudVehiculoAprobadaPolicia']);
Route::get('/personal/policia/{id}/get/solicitud-completa', [ApiSolicitudvehiculoController::class, 'getSolicitudVehiculoCompletaPolicia']);
Route::get('/totalsolicitudesvehiculos/pendientes', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoPendientesTotal']);
Route::get('/totalsolicitudesvehiculos/anuladas', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoAnuladasTotal']);
Route::get('/totalsolicitudesvehiculos/aprobadas', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoAprobadasTotal']);
Route::get('/totalsolicitudesvehiculos/completas', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoCompletasTotal']);
Route::get('/listarsolicitudesvehiculos/pendientes', [ApiSolicitudvehiculoController::class, 'listarSolicitudesVehiculosPendientes']);
Route::post('/solicitudvehiculo/aprobar', [ApiSolicitudvehiculoController::class, 'aprobarSolicitud']);
Route::resource('/solicitudesvehiculos', ApiSolicitudvehiculoController::class);

/*Api Información personal policia*/
Route::get('/provincias/{id}', [ApiProvinciaController::class, 'show']);
Route::get('/provincias', [ApiProvinciaController::class, 'index']);
Route::get('/personal/policia/{id}/detalles', [ApiPersonalpoliciaController::class, 'show']);
Route::get('/subcircuito/{id}/provincia', [ApiSubcircuitoController::class, 'show']);
Route::resource('/personal', ApiPersonalpoliciaController::class);
Route::resource('/user', UserController::class);

/*Api Dependencias*/
Route::get('/vehiculos/subcircuito/{id}/tipo/{tipo}', [ApiVehiculoController::class, 'getVehiculoParqueaderoSubcircuito']);
