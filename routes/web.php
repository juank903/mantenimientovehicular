<?php

// use App\Http\Controllers\Auth\ProfileController;

use App\Http\Controllers\Web\Inputs\Quejas\InputquejasviewsController;
use App\Http\Controllers\Web\Quejas\QuejasugerenciasController;
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

    Route::get('quejas.index', [InputquejasviewsController::class, 'index'])
    ->name('quejas');
    Route::post('quejasugerencias.guardar', [QuejasugerenciasController::class, 'guardarquejasugerencia'])
    ->name('guardarquejasugerencia');
});

require __DIR__.'/auth.php';
