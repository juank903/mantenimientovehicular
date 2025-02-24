<?php

use App\Http\Controllers\App\DashboardAdministradorController;
use App\Http\Controllers\App\DashboardAuxiliarController;
use App\Http\Controllers\App\DashboardGerenciaController;
use App\Http\Controllers\App\DashboardPoliciaController;
use App\Http\Controllers\App\EntregarecepcionController;
use App\Http\Controllers\App\PartenovedadesController;
use App\Http\Controllers\App\SolicitudcombustibleController;
use App\Http\Controllers\App\SolicitudmantenimientoController;
use App\Http\Controllers\App\SolicitudvehiculoController;
use App\Http\Controllers\App\VehiculosController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
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
            'redirectDashboardPolicia'
        );

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

    Route::get('/profile/edit/{user_id?}', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('perfil', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('perfil', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    /* fin rutas por defecto*/

    /*Rutas personal policial */
    Route::get('mostrartodopersonal', function () {
        return view('personalViews.index');
    })->name('mostrartodopersonal');


    /*Rutas Vehículos*/
    Route::post('vehiculo/store', [VehiculosController::class, 'store'])
        ->name('vehiculo.store');

    Route::get('vehiculos/create', [VehiculosController::class, 'create'])
        ->name('vehiculos.create');

    Route::get('mostrartodovehiculos', function () {
        return view('vehiculosViews.index');
    })->name('mostrartodovehiculos');


    /*Rutas Partes Novedades*/
    Route::get('mostrartodopartesnovedades', function () {
        return view('partenovedadesViews.policia.index');
    })->name('mostrartodopartesnovedades.index');

    /*Rutas Mantenimientos*/


    /*Rutas Reportes*/



    /*Rutas Solicitudes*/
    Route::get('mostrartodasolicitudesvehiculos/pendientes', function () {
        return view('solicitudesvehiculosViews.administrador.index');
    })->name('mostrartodasolicitudesvehiculos.pendientes');

    Route::get('mostrartodasolicitudesvehiculos/aprobadas', function () {
        return view('solicitudesvehiculosViews.auxiliar.aprobadas_index');
    })->name('mostrartodasolicitudesvehiculos.aprobadas');

    Route::get('mostrartodasolicitudesvehiculos/procesando', function () {
        return view('solicitudesvehiculosViews.auxiliar.procesando_index');
    })->name('mostrartodasolicitudesvehiculos.procesando');

    Route::get('mostrarentregarecepcionvehiculo/{estadoAsignacion}/show/{id?}', [EntregarecepcionController::class, 'show'])
        ->where('estadoAsignacion', 'Aprobada\/espera|Procesando\/entregado|Completa\/recibido')
        ->name('mostrarentregarecepcionvehiculo.estado');

    Route::get('solicitarvehiculo/policia/create', [SolicitudvehiculoController::class, 'create'])
        ->name('solicitarvehiculo.policia.create');

    Route::get('mostrarsolicitudvehiculo/policia/pendiente/show/{id?}', [SolicitudvehiculoController::class, 'show'])
        ->name('mostrarsolicitudvehiculo.policia.pendiente');

    Route::get('partenovedades/policia/create', [PartenovedadesController::class, 'create'])
        ->name('partenovedades.policia.create');

    Route::get('partenovedades/policia/show/{id?}', [PartenovedadesController::class, 'show'])
        ->name('partenovedades.policia.show');

    Route::post('guardarpartenovedades', [PartenovedadesController::class, 'store'])
        ->name('partenovedades.store');

    Route::get('solicitarcombustible/policia/create', [SolicitudcombustibleController::class, 'create'])
        ->name('solicitudcombustible.policia.create');

    Route::post('guardarsolicitudcombustible', [SolicitudcombustibleController::class, 'store'])
        ->name('solicitudcombustible.store');

    Route::get('mostrarsolicitudcombustible/{id?}', [SolicitudcombustibleController::class, 'show'])
        ->name('solicitudcombustible.show');

    Route::get('solicitarmantenimiento/policia/create', [SolicitudmantenimientoController::class, 'create'])
        ->name('solicitudmantenimiento.policia.create');

    /*Solicitudes acciones solicitudes */
    Route::post('/personal/policia/revoke', [SolicitudvehiculoController::class, 'revoke'])
        ->name('anularsolicitudvehiculopolicia-pendiente');

    Route::post('guardarsolicitarvehiculo', [SolicitudvehiculoController::class, 'store'])
        ->name('solicitudvehiculo.store');

    /*Componentes bonotes dinámicos */
    Route::get('/delete-button/{userId}', function ($userId) {
        return view('components.delete-button', ['userId' => $userId]);
    });
    Route::get('/show-button/{user_id}', function ($userId) {
        return view('components.show-button', ['userId' => $userId]);
    });

});
