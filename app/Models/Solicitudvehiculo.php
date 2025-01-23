<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class Solicitudvehiculo extends Model
{

    public function personal()
    {
        return $this->belongsToMany(Personalpolicia::class);
    }

    protected function crearsolicitudvehiculo($request): JsonResponse
    {

        try {
            $fechaRequerimiento = $request->input('fecharequerimiento');
            $fechaRequerimiento = Carbon::createFromFormat('Y-m-d', $fechaRequerimiento); // Fecha de inicio
            $solicitudvehiculo = new Solicitudvehiculo();
            $solicitudvehiculo->solicitudvehiculos_detalle = $request->detalle;
            $solicitudvehiculo->solicitudvehiculos_tipo = $request->tipo;
            $solicitudvehiculo->solicitudvehiculos_prioridad = $request->prioridad;
            $solicitudvehiculo->solicitudvehiculos_fecharequerimiento = $fechaRequerimiento;
            $solicitudvehiculo->save();

            return response()->json([
                'success' => true,
                'mensaje' => 'Solicitud de vehículo registrada con éxito',
                'solicitudvehiculo' => $solicitudvehiculo,
                'idSolicitud' => $solicitudvehiculo->id  // Retornando el ID de la solicitud de vehiculo
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Error al registrar la solicitud.'], 500);
        }
    }

    protected function actualizarintegridadId($request, $idSolicitud): JsonResponse
    {
        try {
            // Buscar la queja por ID
            $solicitudVehiculo = Solicitudvehiculo::find($idSolicitud);

            if (!$solicitudVehiculo) {
                return response()->json(['success' => false, 'error' => 'Solicitud vehículo no encontrada.'], 404);
            }

            // Adjuntar la subdependencia
            $solicitudVehiculo->personal()->attach([
                1 => [
                    'personalpolicia_id' => $request->id,
                    'solicitudvehiculo_id' => $solicitudVehiculo->id,
                ]
            ]);

            return response()->json([
                'success' => true,
                'mensaje' => 'Solicitud de vehículo añadida con éxito',
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Es posible que haya problemas de integridad referencial entre una queja y subcircuito'], 500);
        }
    }
}
