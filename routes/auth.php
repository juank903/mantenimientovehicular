<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\Inputs\Vehiculos\InputvehiculosviewsController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\Solicitudes\SolicitudvehiculoController;
use App\Http\Controllers\Auth\Vehiculos\VehiculosController;
use App\Http\Controllers\Auth\VerifyEmailController;

use App\Http\Controllers\Auth\Personal\PersonalController;

use App\Http\Controllers\Auth\ProfileController;

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
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

    /*Rutas por defecto*/
    Route::get('dashboard', function () {
        return view('auth.dashboard');
    })->name('dashboard');
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
        ->name('register')->middleware('rolpolicia');
    Route::post('registrarpersonal', [RegisteredUserController::class, 'store']);
    Route::get('perfil', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('perfil', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('perfil', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    /* fin rutas por defecto*/

    /*Rutas personal policial */
    Route::get('mostrartodopersonal', [PersonalController::class, 'mostrartodopersonal'])
        ->name('mostrartodopersonal');
    /*Fin Rutas personal policial*/

    /*Rutas Vehículos*/
    Route::get('vehiculos.policia.index', [InputvehiculosviewsController::class, 'policiaIndex'])
    ->name('vehiculos.policia');

    Route::post('vehiculos', [VehiculosController::class, 'guardarvehiculo'])
    ->name('guardarvehiculo');

    Route::get('mostrartodovehiculos', function () {
        return view('vehiculosViews.showall');
    })->name('mostrartodovehiculos');
    /*Fin Rutas Vehículos*/

    /*Rutas Mantenimientos*/

    /*Fin Rutas Mantenimientos*/

    /*Rutas Reportes*/


    /*Fin Rutas Reportes*/

    /*Rutas Solicitudes*/
    Route::get('solicitarvehiculo.index', function () {
        return view('inputsViews.vehiculos.policia.index-vehiculo');
    })->name('solicitudvehiculo.index');

    Route::post('solicitarvehiculo.guardar', [SolicitudvehiculoController::class, 'guardarsolicitudvehiculo'])
    ->name('guardarsolicitudvehiculo');
    /*Fin Rutas Solicitudes*/

});
