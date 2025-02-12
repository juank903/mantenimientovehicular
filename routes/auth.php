<?php

use App\Http\Controllers\App\DashboardAdministradorController;
use App\Http\Controllers\App\DashboardAuxiliarController;
use App\Http\Controllers\App\DashboardGerenciaController;
use App\Http\Controllers\App\DashboardPoliciaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\App\SolicitudvehiculoController;
use App\Http\Controllers\App\VehiculosController;
use App\Http\Controllers\Auth\VerifyEmailController;
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
        })
        ->name('dashboard')
        ->middleware(
            'redirectDashboardAdministrador',
                        'redirectDashboardGerencia',
                        'redirectDashboardAuxiliar',
                        'redirectDashboardPolicia');

        /*Rutas dashboards*/
        Route::get('/policia/dashboard', [DashboardPoliciaController::class, 'index'])
            ->name('policia.dashboard');
        Route::get('/administrador/dashboard', [DashboardAdministradorController::class, 'index'])
            ->name('administrador.dashboard');
        Route::get('/auxiliar/dashboard', [DashboardAuxiliarController::class, 'index'])
            ->name('auxiliar.dashboard');
        Route::get('/gerencia/dashboard', [DashboardGerenciaController::class, 'index'])
            ->name('gerencia.dashboard');

        /*Verificación email*/
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

        /* Personal */
        Route::get('registrarpersonal', [RegisteredUserController::class, 'create'])
            ->name('register');
        Route::post('registrarpersonal', [RegisteredUserController::class, 'store']);
        Route::get('perfil', [ProfileController::class, 'edit'])
            ->name('profile.edit');
        Route::patch('perfil', [ProfileController::class, 'update'])
            ->name('profile.update');
        Route::delete('perfil', [ProfileController::class, 'destroy'])
            ->name('profile.destroy');
    /* fin rutas por defecto*/

    /*Rutas personal policial */
        /* Route::get('mostrartodopersonal', [PersonalController::class, 'mostrartodopersonal'])
            ->name('mostrartodopersonal'); */
        Route::get('mostrartodopersonal', function () {
            return view('personalViews.index');
        })->name('mostrartodopersonal');


    /*Rutas Vehículos*/
        Route::post('vehiculos', [VehiculosController::class, 'guardarvehiculo'])
            ->name('guardarvehiculo');

        Route::get('mostrartodovehiculos', function () {
            return view('vehiculosViews.index');
        })->name('mostrartodovehiculos');

    /*Rutas Mantenimientos*/


    /*Rutas Reportes*/



    /*Rutas Solicitudes*/
        Route::get('mostrartodasolicitudesvehiculos/pendientes', function () {
            return view('solicitudesvehiculosViews.show');
        })->name('mostrartodasolicitudesvehiculos.pendientes');

        Route::get('solicitarvehiculo/policia/create', [SolicitudvehiculoController::class, 'mostrarFormularioCreacionSolicitudVehiculo'])
            ->name('solicitarvehiculo.policia');
        /* Route::get('mostrarsolicitudvehiculo/policia/pendiente/index', [SolicitudvehiculoController::class, 'mostrarSolicitudVehiculoPendiente'])
            ->name('mostrarsolicitudvehiculo.policia.pendiente'); */
        Route::get('mostrarsolicitudvehiculo/policia/pendiente/index/{id?}', [SolicitudvehiculoController::class, 'mostrarSolicitudVehiculoPendiente'])
            ->name('mostrarsolicitudvehiculo.policia.pendiente');

    /*Solicitudes acciones solicitudes */
        Route::post('/personal/policia/revoke', [SolicitudvehiculoController::class, 'revokeSolicitudVehiculoPolicia'])
            ->name('anularsolicitudvehiculopolicia-pendiente');

        Route::post('solicitarvehiculo.guardar', [SolicitudvehiculoController::class, 'guardarsolicitudvehiculo'])
            ->name('guardarsolicitudvehiculo');

    /*Componentes bonotes dinámicos */
        Route::get('/delete-button/{userId}', function ($userId) {
            return view('components.delete-button', ['userId' => $userId]);
        });

});
