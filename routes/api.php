<?php

use App\Http\Controllers\Api\ApiAsignacionvehiculoController;
use App\Http\Controllers\Api\ApiAsistenciaController;
use App\Http\Controllers\Api\ApiCircuitoController;
use App\Http\Controllers\Api\ApiPartenovedadController;
use App\Http\Controllers\Api\ApiPersonalpoliciaController;
use App\Http\Controllers\Api\ApiProvinciaController;
use App\Http\Controllers\Api\ApiSolicitudcombustibleController;
use App\Http\Controllers\Api\ApiSolicitudvehiculoController;
use App\Http\Controllers\Api\ApiSubcircuitoController;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\ApiVehiculoController;
use App\Http\Controllers\App\ReportesController;
use Illuminate\Support\Facades\Route;





Route::get('/quejasugerenciasubcircuitofechas', [ReportesController::class, 'getQuejasugerenciaSubcircuitoFechas']);
Route::resource('/vehiculos', ApiVehiculoController::class);
Route::resource('/circuito', ApiCircuitoController::class);

/*Api Solicitudes hechas por usuario policia*/
Route::get('/personal/policia/{id}/totalsolicitudesvehiculos', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoPolicia']);
// Route::get('/personal/policia/{id}/totalsolicitudesvehiculos/anuladas', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoAnuladasPolicia']);
// Route::get('/personal/policia/{id}/totalsolicitudesvehiculos/pendientes', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoPendientesPolicia'])->name('policia.solicitudes.pendientes');
// Route::get('/personal/policia/{id}/totalsolicitudesvehiculos/aprobadas', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoAprobadasPolicia']);
// Route::get('/personal/policia/{id}/totalsolicitudesvehiculos/completas', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoCompletasPolicia']);
// Route::get('/personal/policia/{id}/totalsolicitudesvehiculos/procesando', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoProcesandoPolicia']);
Route::get('/totalsolicitudes-vehiculo/policia/{id}/{estado}', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoPorEstado'])->name('totalsolicitudes.vehiculo.policia');

//Route::get('/personal/policia/{id}/get/solicitud-pendiente', [ApiSolicitudvehiculoController::class, 'getSolicitudVehiculoPendientePolicia']);
//Route::get('/personal/policia/{id}/get/solicitud-aprobada', [ApiSolicitudvehiculoController::class, 'getSolicitudVehiculoAprobadaPolicia']);
//Route::get('/personal/policia/{id}/get/solicitud-completa', [ApiSolicitudvehiculoController::class, 'getSolicitudVehiculoCompletaPolicia']);

Route::get('/policia/{id}/get/solicitud/vehiculo/{estado}', [ApiSolicitudvehiculoController::class, 'getSolicitudVehiculoPorEstado']);


Route::get('/totalsolicitudesvehiculos/pendientes', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoPendientesTotal']);
Route::get('/totalsolicitudesvehiculos/anuladas', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoAnuladasTotal']);
Route::get('/totalsolicitudesvehiculos/aprobadas', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoAprobadasTotal']);
Route::get('/totalsolicitudesvehiculos/completas', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoCompletasTotal']);
Route::get('/totalsolicitudesvehiculos/procesando', [ApiSolicitudvehiculoController::class, 'getNumSolicitudesVehiculoProcesandoTotal']);
Route::get('/listarsolicitudesvehiculos', [ApiSolicitudvehiculoController::class, 'listarSolicitudesVehiculos']);
Route::post('/solicitudvehiculo/aprobar', [ApiSolicitudvehiculoController::class, 'aprobarSolicitud']);
Route::resource('/solicitudesvehiculos', ApiSolicitudvehiculoController::class);

/*Api Información personal policia*/
Route::get('/provincias/{id}', [ApiProvinciaController::class, 'show']);
Route::get('/provincias', [ApiProvinciaController::class, 'index']);
Route::get('/personal/policia/{id}/detalles', [ApiPersonalpoliciaController::class, 'show']);
Route::get('/subcircuito/{id}/provincia', [ApiSubcircuitoController::class, 'show']);
Route::resource('/personal', ApiPersonalpoliciaController::class);
Route::resource('/user', ApiUserController::class);
Route::resource('/partenovedades', ApiPartenovedadController::class);

/*Api Dependencias*/
Route::get('/vehiculos/subcircuito/{id}/tipo/{tipo}', [ApiVehiculoController::class, 'getVehiculoParqueaderoSubcircuito']);

/*Api Solicitud Combustible*/
Route::get('/solicitudcombustible/conteo/{userId?}', [ApiSolicitudcombustibleController::class, 'conteo']);

/*Api Asignaciones*/
Route::get('/listarasignaciones/vehiculos', [ApiAsignacionvehiculoController::class, 'listarAsignacionesVehiculos']);
Route::get('/entregarvehiculo/policia', [ApiAsignacionvehiculoController::class, 'entregarVehiculoAPolicia']);
Route::get('/listarasignaciones/vehiculos/policia/{idSolicitante}', [ApiAsignacionvehiculoController::class, 'listarAsignacionesVehiculos']);
//Route::get('/mostrarasignaciones/espera/vehiculos', [ApiAsignacionvehiculoController::class, 'getAsignacionesPorEstadoSolicitud']);
//Route::get('/mostrarasignaciones/espera/vehiculos/policia/{idSolicitante}', [ApiAsignacionvehiculoController::class, 'getAsignacionesPorEstadoSolicitud']);
Route::get('/mostrarasignaciones/{estado_solicitud}/{estado_asignacion}/vehiculos/policia/{idSolicitante?}', [ApiAsignacionvehiculoController::class, 'getAsignacionesPorEstadoSolicitud']);


Route::get('/asistencias', [ApiAsistenciaController::class, 'index']);
Route::get('/asistencias/{id}', [ApiAsistenciaController::class, 'show']);
