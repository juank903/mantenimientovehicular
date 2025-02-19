<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\App\HistorialsolicitudvehiculoController;
use App\Http\Controllers\Controller;
use App\Models\Asignacionvehiculo;
use App\Models\Solicitudvehiculo;
use Auth;
use Carbon\Carbon;
use Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class SolicitudvehiculoController extends Controller
{
    //
    public function guardarsolicitudvehiculo(Request $request)
    {
        try {
            DB::beginTransaction(); // Inicia la transacción

            // 1. Crear la solicitud de vehículo
            $fechaRequerimientodesde = $request->input('fecharequerimientodesde');
            $horaRequerimientodesde = $request->input('horarequerimientodesde');
            $fechaRequerimientohasta = $request->input('fecharequerimientohasta');
            $horaRequerimientohasta = $request->input('horarequerimientohasta');

            // Usando interpolación de cadenas
            $timestampDesde = Carbon::parse("{$fechaRequerimientodesde} {$horaRequerimientodesde}");
            $timestampHasta = Carbon::parse("{$fechaRequerimientohasta} {$horaRequerimientohasta}");

            $solicitudvehiculo = new Solicitudvehiculo();
            $solicitudvehiculo->solicitudvehiculos_detalle = $request->detalle;
            $solicitudvehiculo->solicitudvehiculos_tipo = $request->tipo;
            $solicitudvehiculo->solicitudvehiculos_jornada = $request->jornada;
            $solicitudvehiculo->solicitudvehiculos_fecharequerimientodesde = $timestampDesde;
            $solicitudvehiculo->solicitudvehiculos_fecharequerimientohasta = $timestampHasta;
            $solicitudvehiculo->save();

            // 2.  Guardar la relación muchos a muchos (asumiendo que tienes una tabla pivote)
            if ($request->has('id')) {
                $solicitudvehiculo->personal()->attach($request->id);
            } else {
                throw new \Exception("Debe seleccionar al menos un personal policial.");
            }
            // 3. Guardar el historial inicial
            $response = HistorialsolicitudvehiculoController::guardarHistorial($solicitudvehiculo->personal->first()->id, $solicitudvehiculo->id, ); // Usar el ID de la solicitud creada y el primer ID del personal policial relacionado.
            $data = json_decode($response->getContent(), true);

            if (!$data['success']) {
                throw new \Exception($data['error']); // Lanza una excepción si falla el guardado del historial
            }

            DB::commit(); // Confirma la transacción

            return redirect()->intended(route('dashboard', absolute: false))->with('mensaje', $data['mensaje']);

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error($e);

            return redirect()->intended(route('dashboard', absolute: false))->with('error', 'Error al guardar la solicitud: ' . $e->getMessage()); // Mensaje de error más informativo
        }
    }

    public function revokeSolicitudVehiculoPolicia(Request $request): RedirectResponse|JsonResponse
    {
        $personalId = $request->input('id');
        $motivo = $request->input('motivo');

        if (!$personalId) {
            return redirect()->route('dashboard')->with('error', 'No existe el Personal Policial.');
        }

        if (!$motivo) {
            return redirect()->route('dashboard')->with('error', 'Debe proporcionar un motivo para la anulación.');
        }

        $solicitudes = Solicitudvehiculo::whereHas('personal', function ($query) use ($personalId) {
            $query->where('personalpolicia_id', $personalId);
        })
            ->where('solicitudvehiculos_estado', 'Pendiente')
            ->get();

        if ($solicitudes->isEmpty()) {
            session(["error" => "No hay solicitudes pendientes para anular."]);
            return redirect()->route('dashboard');
            //->with('error', 'No hay solicitudes pendientes para anular.');
        }

        DB::beginTransaction(); // Inicia la transacción

        try {
            foreach ($solicitudes as $solicitud) {
                $solicitud->solicitudvehiculos_estado = 'Anulada';
                $solicitud->save();

                HistorialsolicitudvehiculoController::guardarHistorial($personalId, $solicitud->id, $motivo);
            }

            DB::commit(); // Confirma la transacción si todo fue exitoso
            session(["mensaje" => "Solicitud anulada correctamente."]);
            return redirect()->route('dashboard');
            //->with('mensaje', 'Solicitud anulada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción en caso de error

            // Opcional: Registra el error para depuración
            Log::error('Error al anular solicitudes: ' . $e->getMessage());
            session(["error" => 'No se pudo anular la solicitud: ' . $e->getMessage()]);
            return redirect()->route('dashboard');
            //->with('error', 'No se pudo anular la solicitud: ' . $e->getMessage());
        }
    }

    /* public static function obtenerDatosPolicia(int $userId): ?array
    {
        $datosPolicia = $this->obtenerDetallesPolicia($userId);
        if (!$datosPolicia) {
            abort(404, 'Datos de policía no encontrados.');
        }
        return $datosPolicia;
    } */
    public function mostrarFormularioCreacionSolicitudVehiculo($userId = null): View|RedirectResponse
    {
        $userId ??= auth()->id();
        $user = Auth::user();

        $datosPolicia = $this->obtenerDetallesPolicia($userId);

        // Manejo de posibles errores al obtener los datos del policía
        if ($user->rol() !== 'policia' || !$datosPolicia || $this->tieneSolicitudesPendientes($userId)) {
            return redirect()->route('dashboard')->with('error', 'Error al obtener los datos del policía.');
        }

        return view('solicitudesvehiculosViews.policia.create', [
            'tipos_vehiculo' => ['Moto', 'Auto', 'Camioneta'],
            'jornadas' => ['Ordinaria', 'Extraordinaria'],
            'policia' => $this->mapearDatosPolicia($datosPolicia)
        ]);
    }

    public function mostrarSolicitudVehiculoPendiente($userId = null): View|RedirectResponse
    {

        $userId ??= auth()->id();
        $user = Auth::user();

        $datosPoliciaSolicitud = $this->obtenerDetallesPoliciaSolicitudPendiente($userId);

        // Manejo de posibles errores al obtener los datos de la solicitud
        if (!$datosPoliciaSolicitud) {
            session(["error" => 'Error al obtener la solicitud pendiente.']);
            return redirect()->route('dashboard');
            //->with('error', 'Error al obtener la solicitud pendiente.');
        }

        if ($user->rol() === 'administrador') {
            return view('solicitudesvehiculosViews.administrador.show', [
                'policia' => $this->mapearDatosPolicia($datosPoliciaSolicitud['personal']),
                'solicitud' => $this->mapearDatosSolicitud($datosPoliciaSolicitud['solicitud_pendiente'][0] ?? [])
            ]);
        }

        if ($user->rol() === 'policia') {
            //echo 'aqui estoy';
            return view('solicitudesvehiculosViews.policia.show', [
                'policia' => $this->mapearDatosPolicia($datosPoliciaSolicitud['personal']),
                'solicitud' => $this->mapearDatosSolicitud($datosPoliciaSolicitud['solicitud_pendiente'][0] ?? [])
            ]);
        }

        // Si el usuario no es ni administrador ni policía, redirigir con un error.
        session(["error" => 'No tienes permisos para acceder a esta sección.']);
        return redirect()->route('dashboard');
        //->with('error', 'No tienes permisos para acceder a esta sección.');
    }




    /**
     * Verifica si el usuario tiene solicitudes pendientes.
     */
    public static function tieneSolicitudesPendientes($userId): bool
    {
        $response = Http::get(url("/api/personal/policia/{$userId}/totalsolicitudesvehiculos/pendientes"));

        return $response->successful() && $response->json()['numero_solicitudes'] > 0;
    }

    /**
     * Obtiene los detalles del policía logueado.
     */
    public static function obtenerDetallesPolicia($userId): ?array
    {
        $response = Http::get(url("/api/personal/policia/{$userId}/detalles"));

        return $response->successful() ? $response->json() : null;
    }
    public static function obtenerDetallesPoliciaSolicitudPendiente($userId): ?array
    {
        $response = Http::get(url("/api/personal/policia/{$userId}/get/solicitud-pendiente"));

        return $response->successful() ? $response->json() : null;
    }
    public static function obtenerDetallesPoliciaSolicitudAprobada($userId): ?array
    {
        $response = Http::get(url("/api/personal/policia/{$userId}/get/solicitud-aprobada"));

        return $response->successful() ? $response->json() : null;
    }
    public static function mapearDatosPolicia(array $datosPolicia): array
    {
        return [
            'id' => $datosPolicia['id'],
            'apellido_paterno' => $datosPolicia['primerapellido_personal_policias'],
            'apellido_materno' => $datosPolicia['segundoapellido_personal_policias'],
            'primer_nombre' => $datosPolicia['primernombre_personal_policias'],
            'segundo_nombre' => $datosPolicia['segundonombre_personal_policias'],
            'circuito' => $datosPolicia['subcircuito'][0]['circuito']['nombre_circuito_dependencias'] ?? '',
            'subcircuito' => $datosPolicia['subcircuito'][0]['nombre_subcircuito_dependencias'] ?? '',
            'id_subcircuito' => $datosPolicia['subcircuito'][0]['id'] ?? '',
            'distrito' => $datosPolicia['subcircuito'][0]['circuito']['distrito']['nombre_distritodependencias'] ?? '',
            'provincia' => $datosPolicia['subcircuito'][0]['circuito']['distrito']['provincia']['nombre_provincia_dependencias'] ?? '',
        ];
    }

    public static function mapearDatosSolicitud(array $solicitud): array
    {
        return [
            'id' => $solicitud['id'] ?? 'N/A',
            'fecha_solicitado' => Carbon::parse($solicitud['created_at'])->toDateTimeString() ?? '',
            'detalle' => $solicitud['solicitudvehiculos_detalle'] ?? '',
            'tipo_vehiculo' => $solicitud['solicitudvehiculos_tipo'] ?? '',
            'fecha_desde' => $solicitud['solicitudvehiculos_fecharequerimientodesde'] ?? '',
            'fecha_hasta' => $solicitud['solicitudvehiculos_fecharequerimientohasta'] ?? '',
            'jornada' => $solicitud['solicitudvehiculos_jornada'] ?? '',
            'estado_solicitud' => $solicitud['solicitudvehiculos_estado'] ?? '',
        ];
    }

}
