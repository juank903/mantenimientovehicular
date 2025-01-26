<?php

use App\Http\Controllers\Api\CircuitoController;
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
Route::get('personal/{id}/solicitudes', [Personalpolicia::class, 'getNumeroSolicitudes']);
Route::resource('circuito', CircuitoController::class);
Route::get('/personal/{id}/solicitudes/anuladas', [Personalpolicia::class, 'getNumeroSolicitudesAnuladas']);
Route::get('/personal/{id}/solicitudes/pendientes', [Personalpolicia::class, 'getNumeroSolicitudesPendientes']);
Route::get('/personal/{id}/solicitudes/aprobadas', [Personalpolicia::class, 'getNumeroSolicitudesAprobadas']);
