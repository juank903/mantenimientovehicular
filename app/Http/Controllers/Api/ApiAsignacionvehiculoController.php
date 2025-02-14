<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asignacionvehiculo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ApiAsignacionvehiculoController extends Controller
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
    public function listarAsignacionesVehiculos(Request $request, $idSolicitante = null)
    {
        $query = Asignacionvehiculo::with(['vehiculo', 'solicitante', 'vehiculo.parqueaderos', 'vehiculo.espacio']);

        if ($idSolicitante) {
            $query->where('personalpoliciasolicitante_id', $idSolicitante);
        }

        $asignaciones = $query->get();

        return response()->json($asignaciones);
    }
    public function getAsignacionesEsperaVehiculos(Request $request, $idSolicitante = null)
    {
        $query = Asignacionvehiculo::with([
            'vehiculo',
            'solicitante',
            'vehiculo.parqueaderos',
            'vehiculo.espacio',
            'solicitante.subcircuito', // Incluye la relación con Subcircuito
            'solicitante.subcircuito.circuito', // Incluye la relación con Circuito a través de Subcircuito
            'solicitante.subcircuito.circuito.distrito', // Incluye la relación con Distrito a través de Circuito
            'solicitante.subcircuito.circuito.distrito.provincia', // Incluye la relación con Provincia a través de Distrito
            'solicitante.solicitudVehiculo' => function ($query) { // Incluye la relación con SolicitudVehiculo y la función de callback
                $query->where('solicitudvehiculos_estado', 'Aprobada'); // Filtra las solicitudes aprobadas
            }
        ])
            ->where('asignacionvehiculos_estado', 'espera'); // Filtra por estado "espera"

        if ($idSolicitante) {
            $query->where('personalpoliciasolicitante_id', $idSolicitante);
        }

        $asignaciones = $query->get();

        return response()->json($asignaciones);
    }
}
