<?php

// use App\Http\Controllers\Auth\ProfileController;

use App\Http\Controllers\Web\Inputs\Quejas\InputquejasviewsController;
use App\Http\Controllers\Web\QuejasugerenciasController;
use Illuminate\Support\Facades\Route;



/* Route::get('sugerenciasreclamos', function () {
    return view('sugerenciasreclamos');
})->name('sugerenciasreclamos'); */

/* Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
}); */
Route::middleware('guest')->group(function () {
    Route::get('quejasugerencias.index', [QuejasugerenciasController::class, 'index'])
    ->name('input.quejas');
    Route::post('quejasugerencias.guardar', [QuejasugerenciasController::class, 'guardarquejasugerencia'])
    ->name('guardar.quejas');
});

require __DIR__.'/auth.php';
