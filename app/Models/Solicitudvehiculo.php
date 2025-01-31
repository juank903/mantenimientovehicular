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
    public function historialsolicitudvehiculo()
    {
        return $this->hasOne(HistorialSolicitudVehiculo::class);
    }

    protected function crearsolicitudvehiculo($request): JsonResponse
    {

        try {

            $fechaRequerimientodesde = $request->input('fecharequerimientodesde');
            $horaRequerimientodesde = $request->input('horarequerimientodesde');
            $fechaRequerimientohasta = $request->input('fecharequerimientohasta');
            $horaRequerimientohasta = $request->input('horarequerimientohasta');
            //dd($fechaRequerimientodesde);
            // Combinar fecha y hora para formar un timestamp
            /* $fechahoraDesde = $fechaRequerimientodesde . ' ' . $horaRequerimientodesde;
            $fechahoraHasta = $fechaRequerimientohasta . ' ' . $horaRequerimientohasta; */
            // Crear los timestamps usando Carbon
            $timestampDesde = Carbon::createFromFormat('Y-m-d', $fechaRequerimientodesde);
            $timestampHasta = Carbon::createFromFormat('Y-m-d', $fechaRequerimientohasta);


            $solicitudvehiculo = new Solicitudvehiculo();
            $solicitudvehiculo->solicitudvehiculos_detalle = $request->detalle;
            $solicitudvehiculo->solicitudvehiculos_tipo = $request->tipo;
            $solicitudvehiculo->solicitudvehiculos_jornada = $request->jornada;
            $solicitudvehiculo->solicitudvehiculos_fecharequerimientodesde = $timestampDesde;
            $solicitudvehiculo->solicitudvehiculos_fecharequerimientohasta = $timestampHasta;
            $solicitudvehiculo->save();

            return response()->json([
                'success' => true,
                'mensaje' => 'Solicitud de vehículo registrada con éxito',
                'solicitudvehiculo' => $solicitudvehiculo,
                'idSolicitud' => $solicitudvehiculo->id  // Retornando el ID de la solicitud de vehiculo
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Error 1 al registrar la solicitud.'], 500);
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
                'personalpolicia_id' => $request->id,
                'solicitudvehiculo_id' => $solicitudVehiculo->id,
                'mensaje' => 'Solicitud de vehículo añadida con éxito',
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Es posible que haya problemas de integridad referencial entre una queja y subcircuito'], 500);
        }
    }
}
