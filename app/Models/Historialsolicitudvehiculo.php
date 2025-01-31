<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historialsolicitudvehiculo extends Model
{
    //
    public function personal()
    {
        return $this->belongsTo(Personalpolicia::class);
    }

    public function solicitudvehiculo()
    {
        return $this->belongsTo(Solicitudvehiculo::class);
    }

    protected function guardarHistorialInicial($idPersonal, $idSolicitud){
        try {
            //dd($idPersonal);
            $historial = new Historialsolicitudvehiculo();
            $historial->personalpolicia_id = $idPersonal;
            $historial->solicitudvehiculo_id = $idSolicitud;
            $historial->save();

            return response()->json([
                'success' => true,
                'mensaje' => 'Registro agregado con éxito',
                'historial' => $historial,
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Error al registrar la solicitud.'], 500);
        }

    }
    protected function guardarHistorialModificado($idPersonal, $idSolicitud, $motivo){
        try {
            //dd($idSolicitud);
            $historial = new Historialsolicitudvehiculo();
            $historial->personalpolicia_id = $idPersonal;
            $historial->solicitudvehiculo_id = $idSolicitud;
            $historial->historialsolicitudvehiculos_razoncambio = $motivo;
            $historial->save();

            return response()->json([
                'success' => true,
                'mensaje' => 'Cambio realizado con éxito',
                'historial' => $historial,
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Error al registrar la solicitud.'], 500);
        }

    }
}
