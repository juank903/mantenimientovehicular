<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Personalpolicia;
use App\Models\Solicitudvehiculo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiSolicitudvehiculoController extends Controller
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
        $Solicitudvehiculo = Solicitudvehiculo::findOrFail($id);
        return response()->json($Solicitudvehiculo);
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
    public function obtenerSolicitudPendiente($personalId): JsonResponse
    {
        // Buscar el PersonalPolicias por ID
        $personalPolicia = Personalpolicia::findOrFail($personalId);

        // Recuperar las solicitudes de vehículos donde el estado es "pendiente"
        $solicitudesPendientes = $personalPolicia->solicitudVehiculo()
            ->where('solicitudvehiculos_estado', 'pendiente')
            ->with('personal')
            ->get();

        // Devolver las solicitudes pendientes como JSON
        return response()->json($solicitudesPendientes);
    }
    public function getNumeroSolicitudes($personalId): JsonResponse
    {
        $personal = Personalpolicia::find($personalId);

        if ($personal) {
            $numeroSolicitudes = $personal->solicitudVehiculo()->count();
        } else {
            $numeroSolicitudes = 0; // Retorna 0 si no se encontró el personal
        }

        return response()->json([
            'personal_id' => $personalId,
            'numero_solicitudes' => $numeroSolicitudes
        ]);
    }
    public function getNumeroSolicitudesAnuladas($personalId): JsonResponse
    {
        $personal = Personalpolicia::find($personalId);

        if ($personal) {
            $numeroSolicitudes = Solicitudvehiculo::whereHas('personal', function ($query) use ($personalId) {
                $query->where('personalpolicia_id', $personalId);
            })
                ->where('solicitudvehiculos_estado', 'Anulada')
                ->count();
        } else {
            $numeroSolicitudes = 0; // Retorna 0 si no se encontró el personal
        }

        return response()->json([
            'personal_id' => $personalId,
            'numero_solicitudes' => $numeroSolicitudes
        ]);
    }
    public function getNumeroSolicitudesPendientes($personalId): JsonResponse
    {
        $personal = Personalpolicia::find($personalId);

        if ($personal) {
            $numeroSolicitudes = Solicitudvehiculo::whereHas('personal', function ($query) use ($personalId) {
                $query->where('personalpolicia_id', $personalId);
            })
                ->where('solicitudvehiculos_estado', 'Pendiente')
                ->count();
        } else {
            $numeroSolicitudes = 0; // Retorna 0 si no se encontró el personal
        }

        return response()->json([
            'personal_id' => $personalId,
            'numero_solicitudes' => $numeroSolicitudes
        ]);
    }
    public function getNumeroSolicitudesAprobadas($personalId): JsonResponse
    {
        $personal = Personalpolicia::find($personalId);

        if ($personal) {
            $numeroSolicitudes = Solicitudvehiculo::whereHas('personal', function ($query) use ($personalId) {
                $query->where('personalpolicia_id', $personalId);
            })
                ->where('solicitudvehiculos_estado', 'Aprobada')
                ->count();
        } else {
            $numeroSolicitudes = 0; // Retorna 0 si no se encontró el personal
        }

        return response()->json([
            'personal_id' => $personalId,
            'numero_solicitudes' => $numeroSolicitudes
        ]);
    }
    public function anularSolicitudVehiculo($personalId)
    {

        $personal = Personalpolicia::find($personalId);

        if ($personal) {
            // Obtener las solicitudes de vehículos del usuario dado
            $solicitudes = Solicitudvehiculo::whereHas('personal', function ($query) use ($personalId) {
                $query->where('personalpolicia_id', $personalId);
            })
                ->where('solicitudvehiculos_estado', 'Pendiente')
                ->get();

            if ($solicitudes->isEmpty()) {
                return response()->json(['error' => 'No hay solicitudes pendientes para anular.'], 404);
            }
            // Cambiar el estado a "anulada"
            foreach ($solicitudes as $solicitud) {
                $solicitud->solicitudvehiculos_estado = 'Anulada';
                $solicitud->save();
            }
            return response()->json(['mensaje' => 'Solicitudes anuladas correctamente.']);
        } else {
            return response()->json(['error' => 'No existe el Personal Policial.'], 404);
        }
    }
}
