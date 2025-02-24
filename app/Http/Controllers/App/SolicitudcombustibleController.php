<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Solicitudcombustible;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SolicitudcombustibleController extends Controller
{
    public function create(Request $request, $userId = null): View|RedirectResponse
    {
        $userId ??= auth()->id();
        $user = Auth::user();

        $response = Http::get(url("/api/mostrarasignaciones/Procesando/entregado/vehiculos/policia/{$userId}"));

        if (!$response->successful()) {
            $errorMessage = $response->status() . ' - ' . $response->reason();
            session(['error' => "Error al obtener datos de la API: {$errorMessage}"]);
            return redirect()->route('dashboard');
            //->with('error', "Error al obtener datos de la API: {$errorMessage}");
        }

        $datosApi = $response->json();

        if (empty($datosApi)) {
            return redirect()->route('dashboard')->with('error', 'No se encontraron datos.');
        }

        $datos = $datosApi[0];

        $solicitante = $this->mapearDatosSolicitante($datos['solicitante']);
        $vehiculo = $this->mapearDatosVehiculo($datos['vehiculo']);
        $asignacion_solicitudvehiculo = $this->mapearDatosAsignacion_Solicitudvehiculo($datos);
        $asignacion = $this->mapearDatosAsignacion($datos);

        $vista = [
            'policia' => 'solicitudcombustibleViews.policia.create',
        ];

        $rol = $user->rol();

        if (isset($vista[$rol])) {
            return view($vista[$rol], [
                'asignacion_solicitudvehiculo' => $asignacion_solicitudvehiculo,
                'asignacion' => $asignacion,
                'solicitante' => $solicitante,
                'vehiculo' => $vehiculo,
                'novedadArray' => ['reporte', 'accidente', 'siniestro', 'anulación'],
                'combustibleArray' => ['cuarto', 'medio', 'tres cuartos', 'full'],
            ]);
        }

        return redirect()->route('dashboard')->with('error', 'No tienes permisos para acceder.');
    }
    public function store(Request $request)
    {
        // Define las reglas de validación
        //dd($request);
        $rules = [
            'asignacionvehiculo_id' => 'required|integer|exists:asignacionvehiculos,id',
            'solicitudcombustible_motivo' => 'required|string|max:255',
            'solicitudcombustible_km' => 'required|integer',
            'solicitudcombustible_tipo' => 'required|string|max:255',
        ];

        // Ejecuta la validación
        $validator = Validator::make($request->all(), $rules);

        // Si la validación falla, regresa con los errores
        if ($validator->fails()) {
            session(['error' => 'validaciones']);
            return redirect()->route('dashboard');
            //->withErrors($validator)->withInput();
        }


        try {
            DB::beginTransaction();

            SolicitudCombustible::create([
                'asignacionvehiculo_id' => $request->input('asignacionvehiculo_id'),
                'solicitudcombustible_motivo' => $request->input('solicitudcombustible_motivo'),
                'solicitudcombustible_km' => $request->input('solicitudcombustible_km'),
                'solicitudcombustible_tipo' => $request->input('solicitudcombustible_tipo'),
            ]);

            DB::commit();
            session(['mensaje' => 'Solicitud de combustible creada exitosamente.']);
            return redirect()->route('dashboard')->with('success', 'Solicitud de combustible creada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            session(['error' => 'Error al crear la solicitud de combustible: ' . $e->getMessage()]);
            return redirect()->route('dashboard');
            //->with('error', 'Error al crear la solicitud de combustible: ' . $e->getMessage());
        }
    }
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
            'tipoCombustible' => $datos['tipocombustible_vehiculos'],
            'combustibleActual' => $datos['combustibleactual_vehiculos'],
            'parqueadero' => $parqueaderosMapeados,
            'espacio' => $espaciosMapeados,
        ];
    }

    private function mapearDatosAsignacion_Solicitudvehiculo(array $datos): array
    {
        return [
            'fecha_elaboracion' => Carbon::parse($datos['created_at'])->setTimezone('America/Guayaquil')->toDateTimeString(),
            'fecha_aprobacion' => Carbon::parse($datos['updated_at'])->setTimezone('America/Guayaquil')->toDateTimeString(),
            'id' => $datos['id'],
            'detalle' => $datos['solicitudvehiculos_detalle'],
            'tipo' => $datos['solicitudvehiculos_tipo'],
            'fecharequerimientodesde' => $datos['solicitudvehiculos_fecharequerimientodesde'],
            'fecharequerimientohasta' => $datos['solicitudvehiculos_fecharequerimientohasta'],
            'estado' => $datos['solicitudvehiculos_estado'],
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
