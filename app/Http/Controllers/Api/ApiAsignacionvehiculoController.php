<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asignacionvehiculo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    /* public function getAsignacionesEsperaVehiculos(Request $request, $idSolicitante = null)
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
    } */
    public function getAsignacionesPorEstadoSolicitud(Request $request, $estado_solicitud, $estado_asignacion, $idSolicitante = null)
    {
        $query = Asignacionvehiculo::with([
            'vehiculo',
            'solicitante',
            'vehiculo.parqueaderos',
            'vehiculo.espacio',
            'solicitante.subcircuito',
            'solicitante.subcircuito.circuito',
            'solicitante.subcircuito.circuito.distrito',
            'solicitante.subcircuito.circuito.distrito.provincia',
        ])
        ->select('asignacionvehiculos.*', 'solicitudvehiculos.*', 'asignacionvehiculos.id as asignacion_id' )
            ->join('personalpolicia_solicitudvehiculo', 'asignacionvehiculos.personalpoliciasolicitante_id', '=', 'personalpolicia_solicitudvehiculo.personalpolicia_id')
            ->join('solicitudvehiculos', 'personalpolicia_solicitudvehiculo.solicitudvehiculo_id', '=', 'solicitudvehiculos.id')
            ->where('solicitudvehiculos_estado', $estado_solicitud)
            ->where('asignacionvehiculos_estado', $estado_asignacion);

        if ($idSolicitante) {
            $query->where('asignacionvehiculos.personalpoliciasolicitante_id', $idSolicitante);
        }

        $asignaciones = $query->get();

        return response()->json($asignaciones);
    }
    public function entregarVehiculoAPolicia(Request $request)
    {
        try {
            DB::beginTransaction();

            $asignacion_id = $request->asignacion_id;

            $asignacion = Asignacionvehiculo::findOrFail($asignacion_id);

            $vehiculo = $asignacion->vehiculo;

            if ($asignacion->asignacionvehiculos_estado === 'entregado') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Esta asignación ya fue entregada.'
                ], 400);
            }

            $vehiculo->estado_vehiculos = 'asignado';
            $vehiculo->save();

            $asignacion->asignacionvehiculos_estado = 'entregado';
            $asignacion->personalpoliciaentrega_id = auth()->id();
            $asignacion->save();

            // Filtrar la solicitud por estado "Aprobada"
            $solicitud = $asignacion->solicitante->solicitudVehiculo()->where('solicitudvehiculos_estado', 'Aprobada')->first();

            // Manejar el caso de que no se encuentre la solicitud aprobada
            if ($solicitud) {
                $solicitud->solicitudvehiculos_estado = 'Procesando';
                $solicitud->save();
            } else {
                DB::rollBack(); // Revertir la transacción si no se encuentra la solicitud
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se encontró ninguna solicitud aprobada para esta asignación.'
                ], 400);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Vehículo entregado a la policía con éxito.',
                'data' => [
                    'asignacion_id' => $asignacion->id,
                    'vehiculo_id' => $vehiculo->id,
                    'estado_vehiculo' => $vehiculo->estado_vehiculos,
                    'personal_policia_id' => $asignacion->personalpoliciasolicitante_id,
                    'asignacion_fecha' => $asignacion->created_at,
                    'km_actual' => $asignacion->asignacionvehiculos_kmrecibido,
                    'combustible_actual' => $asignacion->asignacionvehiculos_combustiblerecibido,
                ]
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                $message = 'No se encontró la asignación.';
            } else {
                $message = 'Error al entregar el vehículo a la policía: ' . $e->getMessage();
            }

            return response()->json([
                'status' => 'error',
                'message' => $message,
            ], 500);
        }
    }
}
