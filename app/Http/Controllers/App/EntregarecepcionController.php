<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\App\SolicitudvehiculoController;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;

class EntregarecepcionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function mostrarEntregaRecepcionVehiculoAprobada($userId = null): View|RedirectResponse
    {

        $userId ??= auth()->id();
        $user = Auth::user();

        $datosPoliciaSolicitud = SolicitudvehiculoController::obtenerDetallesPoliciaSolicitudAprobada($userId);
         // Manejo de posibles errores al obtener los datos de la solicitud
        if (!$datosPoliciaSolicitud) {
            return redirect()->route('dashboard')->with('error', 'Error al obtener la solicitud aprobada.');
        }

        if ($user->rol() === 'auxiliar') {
            return view('solicitudesvehiculosViews.administrador.index', [
                'policia' => SolicitudvehiculoController::mapearDatosPolicia($datosPoliciaSolicitud['personal']),
                'solicitud' => SolicitudvehiculoController::mapearDatosSolicitud($datosPoliciaSolicitud['solicitud_aprobada'][0] ?? [])
            ]);
        }

        if ($user->rol() === 'policia') {
            return view('solicitudesvehiculosViews.policia.index', [
                'policia' => SolicitudvehiculoController::mapearDatosPolicia($datosPoliciaSolicitud['personal']),
                'solicitud' => SolicitudvehiculoController::mapearDatosSolicitud($datosPoliciaSolicitud['solicitud_aprobada'][0] ?? [])
            ]);
        }

        // Si el usuario no es ni administrador ni policía, redirigir con un error.
        return redirect()->route('dashboard')->with('error', 'No tienes permisos para acceder a esta sección.');
    }
}
