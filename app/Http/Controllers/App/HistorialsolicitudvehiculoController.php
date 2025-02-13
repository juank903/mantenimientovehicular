<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Historialsolicitudvehiculo;
use App\Models\Solicitudvehiculo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HistorialsolicitudvehiculoController extends Controller
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
    public static function guardarHistorial($idPersonal, $idSolicitud, $motivo = 'Creada') {
        try {
            $historial = new Historialsolicitudvehiculo();
            $historial->personalpolicia_id = $idPersonal;
            $historial->solicitudvehiculo_id = $idSolicitud;

            // Si se proporciona un motivo, se guarda; si no, se guarda null
            $historial->historialsolicitudvehiculos_razoncambio = $motivo;

            $historial->save();

            return response()->json([
                'success' => true,
                'mensaje' => $motivo ? 'Cambio realizado con éxito' : 'Registro agregado con éxito',
                'historial' => $historial,
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Error al registrar la solicitud.'], 500);
        }
    }
}
