<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\PedidoMantenimientoController;
use App\Http\Controllers\Auth\personalController;
use App\Http\Controllers\Auth\vehiculosController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\SugerenciasReclamosController;
use App\Http\Controllers\CircuitoController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('sugerenciasreclamos', [SugerenciasReclamosController::class, 'index'])->name('sugerenciasreclamos');

    Route::get('sugerenciasreclamos.get', [SugerenciasReclamosController::class, 'get'])->name('sugerenciasreclamos.get');

    Route::post('sugerenciasreclamos.post', [SugerenciasReclamosController::class, 'save'])->name('sugerenciasreclamos.post');

    Route::get('getcircuitoid/{id}', [CircuitoController::class, 'getCircuitoId'])->name('getcircuitoid');

    Route::get('/', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {

    Route::get('dashboard', function () {
        return view('dashboard');
    })
        ->name('dashboard');

    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])
        ->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::get('registrarpersonal', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('registrarpersonal', [RegisteredUserController::class, 'store']);

    Route::get('registrarvehiculo', function () {
        return view('vehiculo');
    })
        ->name('vehiculos');

    Route::get('listarvehiculos', [vehiculosController::class, 'showallvehiculos'])
        ->name('vehiculos.view');

    Route::post('ingresarvehiculos', [vehiculosController::class, 'create'])
        ->name('vehiculos.create');

    Route::get('dependencia', function () {
        return view('dependencia');
    })
        ->name('dependencia');

    //if (session('rolusuario') === 'policia') {
    Route::get('listarpersonal', [personalController::class, 'showallpersonal'])
        ->name('personal');
    //}

    Route::get('perfil', [ProfileController::class, 'edit'])
        ->name('perfil.edit');

    Route::patch('perfil', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('perfil', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::get('solicitudmantenimiento/{id}', [PedidoMantenimientoController::class, 'index'])
        ->name('pedidomantenimiento');
});
