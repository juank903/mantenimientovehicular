<?php

// use App\Http\Controllers\Auth\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SugerenciasReclamosController;

/* Route::get('sugerenciasreclamos', function () {
    return view('sugerenciasreclamos');
})->name('sugerenciasreclamos'); */
Route::get('sugerenciasreclamos', [SugerenciasReclamosController::class, 'index'])->name('sugerenciasreclamos');

/* Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); */

/* Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
}); */

require __DIR__.'/auth.php';
