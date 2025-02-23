<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Espacioparqueadero;
use App\Models\Parqueadero;
use App\Models\Partenovedad;
use App\Models\Vehiculo;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PartenovedadesController extends Controller
{
    //
    public function create(Request $request, $userId = null): View|RedirectResponse
    {
        $userId ??= auth()->id();
        $user = Auth::user();

        $response = Http::get(url("/api/mostrarasignaciones/Procesando/entregado/vehiculos/policia/{$userId}"));

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
            'policia' => 'partenovedadesViews.create',
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
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'personalpolicia_id' => 'required|exists:personalpolicias,id',
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'asignacionvehiculo_id' => 'nullable|exists:asignacionvehiculos,id',
            'partenovedades_detalle' => 'nullable|string',
            'partenovedades_tipo' => 'nullable|string',
            'partenovedades_kilometraje' => 'nullable|integer',
            'partenovedades_combustible' => 'nullable|string',
        ]);

        // Si la validación falla, lanzar ValidationException
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Iniciar una transacción de base de datos
        DB::beginTransaction();

        try {
            // Crear y guardar el registro en una sola línea
            Partenovedad::create([
                'personalpolicia_id' => $request->input('personalpolicia_id'),
                'vehiculo_id' => $request->input('vehiculo_id'),
                'asignacionvehiculo_id' => $request->input('asignacionvehiculo_id'),
                'partenovedades_detalle' => $request->input('partenovedades_detalle'),
                'partenovedades_tipo' => $request->input('partenovedades_tipo'),
                'partenovedades_kilometraje' => $request->input('partenovedades_kilometraje'),
                'partenovedades_combustible' => $request->input('partenovedades_combustible'),
            ]);

            // Confirmar la transacción
            DB::commit();

            // Mensaje de éxito en la sesión
            session(['mensaje' => 'Parte guardado con éxito']);

            // Redireccionar al dashboard
            return redirect()->route('dashboard');

        } catch (ValidationException $e) {
            DB::rollBack();
            session(['error' => 'Error de validación: ' . $e->getMessage()]);
            return redirect()->route('dashboard')->withErrors($e->errors())->withInput();

        } catch (QueryException $e) {
            DB::rollBack();
            session(['error' => 'Error al guardar el parte en la base de datos.' . $e->getMessage()]);
            return redirect()->route('dashboard')->withInput();

        } catch (\Exception $e) {
            DB::rollBack();
            session(['error' => 'Error al guardar el parte.' . $e->getMessage()]);
            return redirect()->route('dashboard')->withInput();
        }
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
