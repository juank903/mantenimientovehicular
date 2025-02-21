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
    /* public function mostrarEntregaRecepcionVehiculoAprobada(Request $request, $userId = null): View|RedirectResponse
    {
        $userId ??= auth()->id();
        $user = Auth::user();

        $response = Http::get(url("/api/mostrarasignaciones/Aprobada/espera/vehiculos/policia/{$userId}"));

        // Manejo de errores en la respuesta de la API
        if (!$response->successful()) {
            $errorMessage = $response->status() . ' - ' . $response->reason();
            return redirect()->route('dashboard')->with('error', 'Error al obtener datos de la API: ' . $errorMessage);
        }

        $datosApi = $response->json(); // Utiliza json() para simplificar el decodificado

        // Verifica si la respuesta de la API contiene datos
        if (empty($datosApi)) {
            return redirect()->route('dashboard')->with('error', 'No se encontraron datos.');
        }

        // Extrae el primer elemento del array (asumiendo que solo hay un resultado)
        $datos = $datosApi[0];

        $solicitante = $this->mapearDatosSolicitante($datos['solicitante']);
        $vehiculo = $this->mapearDatosVehiculo($datos['vehiculo']);
        $asignacion_solicitudvehiculo = $this->mapearDatosAsignacion_Solicitudvehiculo($datos);
        $asignacion = $this->mapearDatosAsignacion($datos);

        // Simplifica la lógica de roles con un array y un operador ternario
        $vista = [
            'auxiliar' => 'entregarecepcionViews.auxiliar.show',
            'policia' => 'entregarecepcionViews.policia.show',
        ];

        $rol = $user->rol();

        if (isset($vista[$rol])) {
            return view($vista[$rol], [
                'asignacion_solicitudvehiculo' => $asignacion_solicitudvehiculo,
                'asignacion' => $asignacion,
                'solicitante' => $solicitante,
                'vehiculo' => $vehiculo,
            ]);
        }

        return redirect()->route('dashboard')->with('error', 'No tienes permisos para acceder.');
    } */

    public function show(Request $request, string $estadoAsignacion, $userId = null): View|RedirectResponse
    {
        $userId ??= auth()->id();
        $user = Auth::user();

        $response = Http::get(url("/api/mostrarasignaciones/{$estadoAsignacion}/vehiculos/policia/{$userId}"));

        // Manejo de errores en la respuesta de la API
        if (!$response->successful()) {
            $errorMessage = $response->status() . ' - ' . $response->reason();
            return redirect()->route('dashboard')->with('error', 'Error al obtener datos de la API: ' . $errorMessage);
        }

        $datosApi = $response->json(); // Utiliza json() para simplificar el decodificado

        // Verifica si la respuesta de la API contiene datos
        if (empty($datosApi)) {
            return redirect()->route('dashboard')->with('error', 'No se encontraron datos.');
        }

        // Extrae el primer elemento del array (asumiendo que solo hay un resultado)
        $datos = $datosApi[0];

        $solicitante = $this->mapearDatosSolicitante($datos['solicitante']);
        $vehiculo = $this->mapearDatosVehiculo($datos['vehiculo']);
        $asignacion_solicitudvehiculo = $this->mapearDatosAsignacion_Solicitudvehiculo($datos);
        $asignacion = $this->mapearDatosAsignacion($datos);

        // Simplifica la lógica de roles con un array y un operador ternario
        if ($estadoAsignacion == 'Aprobada/espera') {
            $vista = [
                'auxiliar' => 'entregarecepcionViews.auxiliar.aprobada_show',
                'policia' => 'entregarecepcionViews.policia.show',
            ];
        }
        if ($estadoAsignacion == 'Procesando/entregado') {
            $vista = [
                'auxiliar' => 'entregarecepcionViews.auxiliar.procesando_show',
                'policia' => 'entregarecepcionViews.policia.show',
            ];
        }

        $rol = $user->rol();

        if (isset($vista[$rol])) {
            return view($vista[$rol], [
                'asignacion_solicitudvehiculo' => $asignacion_solicitudvehiculo,
                'asignacion' => $asignacion,
                'solicitante' => $solicitante,
                'vehiculo' => $vehiculo,
            ]);
        }
        session(['error' => 'No tienes permisos para acceder']);
        return redirect()->route('dashboard');
        //->with('error', 'No tienes permisos para acceder.');
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
            ];
        }

        return [
            'id_solicitante' => $datos['id'],
            'user_id' => $datos['user_id'],
            'nombre_completo' => $datos['primernombre_personal_policias'] . ' ' . $datos['segundonombre_personal_policias'] . ' ' . $datos['primerapellido_personal_policias'] . ' ' . $datos['segundoapellido_personal_policias'],
            'cedula' => $datos['cedula_personal_policias'],
            'tipoSangre' => $datos['tiposangre_personal_policias'],
            'conductor' => $datos['conductor_personal_policias'],
            'rango' => $datos['rango_personal_policias'],
            'rol' => $datos['rol_personal_policias'], // Añadido el rol
            'genero' => $datos['personalpolicias_genero'], // Añadido el género
            'subcircuitos' => $subcircuitosMapeados,
        ];
    }

    private function mapearDatosVehiculo(array $datos): array
    {
        $parqueaderosMapeados = [];
        foreach ($datos['parqueaderos'] as $parqueadero) {
            $parqueaderosMapeados[] = [
                'id_parqueadero' => $parqueadero['id'],
                'nombre' => $parqueadero['parqueaderos_nombre'],
                'direccion' => $parqueadero['parqueaderos_direccion'],
                'responsable' => $parqueadero['parqueaderos_responsable'],
            ];
        }

        $espaciosMapeados = [];
        foreach ($datos['espacio'] as $espacio) {
            $espaciosMapeados[] = [
                'id_espacio' => $espacio['id'],
                'nombre' => $espacio['espacioparqueaderos_nombre'],
                'observacion' => $espacio['espacioparqueaderos_observacion'],
                'estado' => $espacio['espacioparqueadero_estado'], // Añadido el estado del espacio
            ];
        }

        return [
            'id_vehiculo' => $datos['id'],
            'marca' => $datos['marca_vehiculos'],
            'modelo' => $datos['modelo_vehiculos'],
            'tipo' => $datos['tipo_vehiculos'],
            'placa' => $datos['placa_vehiculos'],
            'color' => $datos['color_vehiculos'],
            'estado' => $datos['estado_vehiculos'],
            'kmActual' => $datos['kmactual_vehiculos'],
            'combustibleActual' => $datos['combustibleactual_vehiculos'],
            'parqueadero' => $parqueaderosMapeados,
            'espacio' => $espaciosMapeados,
        ];
    }

    private function mapearDatosAsignacion_Solicitudvehiculo(array $datos): array
    {
        return [
            'fecha_elaboracion' => Carbon::parse($datos['created_at'])->toDateTimeString(),
            'fecha_aprobacion' => Carbon::parse($datos['updated_at'])->toDateTimeString(),
            'id' => $datos['id'], // Añadido el ID de la solicitud
            'detalle' => $datos['solicitudvehiculos_detalle'], // Añadido el detalle de la solicitud
            'tipo' => $datos['solicitudvehiculos_tipo'], // Añadido el tipo de solicitud
            'fecharequerimientodesde' => $datos['solicitudvehiculos_fecharequerimientodesde'], // Añadida la fecha de requerimiento desde
            'fecharequerimientohasta' => $datos['solicitudvehiculos_fecharequerimientohasta'], // Añadida la fecha de requerimiento hasta
            'estado' => $datos['solicitudvehiculos_estado'], // Añadido el estado de la solicitud
        ];
    }

    private function mapearDatosAsignacion(array $datos): array
    {
        return [
            'id' => $datos['asignacion_id'],
            'estado' => $datos['asignacionvehiculos_estado'],
        ];
    }

}
