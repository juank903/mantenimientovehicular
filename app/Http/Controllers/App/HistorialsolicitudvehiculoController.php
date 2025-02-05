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
    public function crearsolicitudvehiculo($request): JsonResponse
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

    public function actualizarintegridadId($request, $idSolicitud): JsonResponse
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
    public static function guardarHistorialInicial($idPersonal, $idSolicitud){
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
    public static function guardarHistorialModificado($idPersonal, $idSolicitud, $motivo){
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
