<?php

use App\Http\Controllers\Api\CircuitoController;
use App\Http\Controllers\Api\SubcircuitoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Route::resource('quejasugerencia', QuejasugerenciaController::class);

Route::resource('subcircuitos', SubcircuitoController::class);
Route::resource('circuito', CircuitoController::class);
