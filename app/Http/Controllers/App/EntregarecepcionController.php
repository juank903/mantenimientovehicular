<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\App\SolicitudvehiculoController;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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
    public function mostrarEntregaRecepcionVehiculoAprobada(Request $request, $userId = null): View|RedirectResponse
    {
        $userId ??= auth()->id();
        $user = Auth::user();


        $response = Http::get(url("/api/mostrarasignaciones/espera/vehiculos/policia/ {$userId}"));
        $datosApi = json_decode($response, true);

        if (empty($datosApi)) {
            return redirect()->route('dashboard')->with('error', 'Error al obtener datos de la API.');
        }

        $solicitante = $this->mapearDatosSolicitante($datosApi[0]['solicitante']);
        $vehiculo = $this->mapearDatosVehiculo($datosApi[0]['vehiculo']);
        //$policia = $this->mapearDatosPolicia($datosApi[0]['solicitante']); // Mapeo de datos del policía (usando 'solicitante' como ejemplo, ajusta si es diferente)
        $asignacion = $this->mapearDatosAsignacion($datosApi[0]); // Mapeo de datos de la solicitud

        if ($user->rol() === 'auxiliar') {
            return view('entregarecepcionViews.auxiliar.show', [
                //'policia' => $policia,
                'asignacion' => $asignacion,
                'solicitante' => $solicitante,
                'vehiculo' => $vehiculo,
            ]);
        }

        if ($user->rol() === 'policia') {
            return view('entregarecepcionViews.policia.show', [
                //'policia' => $policia,
                'asignacion' => $asignacion,
                'solicitante' => $solicitante,
                'vehiculo' => $vehiculo,
            ]);
        }

        return redirect()->route('dashboard')->with('error', 'No tienes permisos para acceder.');
    }

    // Funciones de mapeo de datos

    private function mapearDatosSolicitante(array $datos): array
    {
        $subcircuitosMapeados = [];
        foreach ($datos['subcircuito'] as $subcircuito) {
            $subcircuitosMapeados[] = [
                'id' => $subcircuito['id'],
                'nombre' => $subcircuito['nombre_subcircuito_dependencias'],
                'circuito' => [
                    'id' => $subcircuito['circuito']['id'],
                    'nombre' => $subcircuito['circuito']['nombre_circuito_dependencias'],
                    'distrito' => [
                        'id' => $subcircuito['circuito']['distrito']['id'],
                        'nombre' => $subcircuito['circuito']['distrito']['nombre_distritodependencias'],
                        'provincia' => [
                            'id' => $subcircuito['circuito']['distrito']['provincia']['id'],
                            'nombre' => $subcircuito['circuito']['distrito']['provincia']['nombre_provincia_dependencias'],
                        ],
                    ],
                ],
                // ... otros campos de subcircuito
            ];
        }

        $solicitudesMapeadas = [];
        foreach ($datos['solicitud_vehiculo'] as $solicitud) {
            $solicitudesMapeadas[] = [
                'id' => $solicitud['id'],
                'fecha_solicitado' => Carbon::parse($solicitud['created_at'])->toDateTimeString(),
                'detalle' => $solicitud['solicitudvehiculos_detalle'],
                'fecha_requerimiento_desde' => $solicitud['solicitudvehiculos_fecharequerimientodesde'],
                'fecha_requerimiento_hasta' => $solicitud['solicitudvehiculos_fecharequerimientohasta'],
                'jornada' => $solicitud['solicitudvehiculos_jornada'],
            ];
        }

        return [
            'id' => $datos['id'],
            'nombre_completo' => $datos['primernombre_personal_policias'] . ' ' . $datos['segundonombre_personal_policias'] . ' ' . $datos['primerapellido_personal_policias'] . ' ' . $datos['segundoapellido_personal_policias'],
            'cedula' => $datos['cedula_personal_policias'],
            'tipoSangre' => $datos['tiposangre_personal_policias'],
            'conductor' => $datos['conductor_personal_policias'],
            'rango' => $datos['rango_personal_policias'],
            'subcircuitos' => $subcircuitosMapeados, // Añade los subcircuitos mapeados
            'solicitudes' => $solicitudesMapeadas, // Añade las solicitudes mapeadas
        ];
    }

    private function mapearDatosVehiculo(array $datos): array
    {
        $parqueaderosMapeados = [];
        foreach ($datos['parqueaderos'] as $parqueadero) {
            $parqueaderosMapeados[] = [
                'id' => $parqueadero['id'],
                'nombre' => $parqueadero['parqueaderos_nombre'],
                'direccion' => $parqueadero['parqueaderos_direccion'],
                'responsable' => $parqueadero['parqueaderos_responsable'],

            ];
        }

        $espaciosMapeados = [];
        foreach ($datos['espacio'] as $espacio) {
            $espaciosMapeados[] = [
                'id' => $espacio['id'],
                'nombre' => $espacio['espacioparqueaderos_nombre'],
                'observacion' => $espacio['espacioparqueaderos_observacion'],
            ];
        }

        return [
            'id' => $datos['id'],
            'marca' => $datos['marca_vehiculos'],
            'modelo' => $datos['modelo_vehiculos'],
            'tipo' => $datos['tipo_vehiculos'],
            'placa' => $datos['placa_vehiculos'],
            'color' => $datos['color_vehiculos'],
            'estado' => $datos['estado_vehiculos'],
            'kmActual' => $datos['kmactual_vehiculos'],
            'combustibleActual' => $datos['combustibleactual_vehiculos'],
            'parqueaderos' => $parqueaderosMapeados, // Añade los parqueaderos mapeados
            'espacios' => $espaciosMapeados, // Añade los espacios mapeados
        ];
    }

    /* private function mapearDatosPolicia(array $datos): array
    {
        return [
            'id' => $datos['id'],
            'nombre_completo' => $datos['primernombre_personal_policias'] . ' ' . $datos['segundonombre_personal_policias'] . ' ' . $datos['primerapellido_personal_policias'] . ' ' . $datos['segundoapellido_personal_policias'],
            'cedula' => $datos['cedula_personal_policias'],
            'rango' => $datos['rango_personal_policias'],
            'rol' => $datos['rol_personal_policias'],
            // ... otros campos que necesites
        ];
    } */

    private function mapearDatosAsignacion(array $datos): array
    {
        return [
            'id' => $datos['id'],
            'estado' => $datos['asignacionvehiculos_estado'],
            'kmRecibido' => $datos['asignacionvehiculos_kmrecibido'],
            'combustibleRecibido' => $datos['asignacionvehiculos_combustiblerecibido'],
            // ... otros campos que necesites
        ];
    }
}
