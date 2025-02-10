<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Historialsolicitudvehiculo;
use App\Models\Solicitudvehiculo;
use Auth;
use Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SolicitudvehiculoController extends Controller
{
    //
    public function guardarsolicitudvehiculo(Request $request)
    {
        $response = Solicitudvehiculo::crearsolicitudvehiculo($request);
        $data = json_decode($response->getContent(), true);

        if ($data['success']) {
            $response = Solicitudvehiculo::actualizarintegridadId($request, $data['idSolicitud']);
            $data = json_decode($response->getContent(), true);

            if ($data['success']) {
                $response = HistorialsolicitudvehiculoController::guardarHistorialInicial($data['personalpolicia_id'], $data['solicitudvehiculo_id']);
                $data = json_decode($response->getContent(), true);
                if ($data['success']) {
                    return redirect()->intended(route('dashboard', absolute: false))->with('mensaje', $data['mensaje']);
                } else {
                    return redirect()->intended(route('dashboard', absolute: false))->with('error', $data['error']);
                }
            } else {
                $ultimoRegistro = Solicitudvehiculo::latest()->first();
                $ultimoRegistro->delete();
                return redirect()->intended(route('dashboard', absolute: false))->with('error', $data['error']);
            }
        } else {
            return redirect()->intended(route('dashboard', absolute: false))->with('error', $data['error']);
        }
    }
    public function revokeSolicitudVehiculoPolicia(Request $request): RedirectResponse|JsonResponse
    {
        // Obtener el ID del personal desde el request
        $personalId = $request->input('id');

        if ($personalId) {
            // Obtener las solicitudes de vehículos del usuario dado
            $solicitudes = Solicitudvehiculo::whereHas('personal', function ($query) use ($personalId) {
                $query->where('personalpolicia_id', $personalId);
            })
                ->where('solicitudvehiculos_estado', 'Pendiente')
                ->get();

            if ($solicitudes->isEmpty()) {
                return redirect()->route('dashboard')->with('error', 'No hay solicitudes pendientes para anular.');
            }

            // Cambiar el estado a "anulada"
            foreach ($solicitudes as $solicitud) {
                $solicitud->solicitudvehiculos_estado = 'Anulada';
                $solicitud->save();
                $motivo = $request->motivo;
                $response = HistorialsolicitudvehiculoController::guardarHistorialModificado($personalId, $solicitud->id, $motivo);
                if ($response) {
                    return redirect()->route('dashboard')->with('mensaje', 'Solicitud anulada y registrada');
                } else {
                    $solicitud->solicitudvehiculos_estado = 'Pendiente';
                    $solicitud->save();
                    return redirect()->route('dashboard')->with('error', 'No se pudo anular la solicitud.');
                }
            }
            return redirect()->route('dashboard')->with('mensaje', 'Solicitudes anuladas correctamente.');
        } else {
            return redirect()->route('dashboard')->with('error', 'No existe el Personal Policial.');
        }
    }

    /* public function solicitudVehiculoPendientePoliciaLogeado($userId = null): RedirectResponse|View
    {
        $userId ??= auth()->id();
        $user = Auth::user();

        // Verifica el rol del usuario y si tiene solicitudes pendientes antes de realizar las llamadas a la API
        if (($user->rol() !== 'policia' && $user->rol() !== 'administrador') || !$this->obtenerDetallesPolicia($userId)) {
            return redirect()->route('dashboard')->with('error', 'Acceso no autorizado.');
        }

        //$response = Http::get(url("/api/personal/policia/{$userId}/totalsolicitudesvehiculos/pendientes"));
        //$data = $response->successful() ? $response->json() : [];

        if (!$this->tieneSolicitudesPendientes($userId) && $user->rol() === 'policia') {
            $datosPolicia = $this->obtenerDetallesPolicia($userId);
            //return redirect()->route('dashboard')->with('error', 'Usted no tiene solicitudes pendientes');
            return view('solicitudesvehiculosViews.create', [
                'tipos_vehiculo' => ['Moto', 'Auto', 'Camioneta'],
                'jornadas' => ['Ordinaria', 'Extraordinaria'],
                'policia' => [
                    'id' => $datosPolicia['id'],
                    'apellido_paterno' => $datosPolicia['primerapellido_personal_policias'],
                    'apellido_materno' => $datosPolicia['segundoapellido_personal_policias'],
                    'primer_nombre' => $datosPolicia['primernombre_personal_policias'],
                    'segundo_nombre' => $datosPolicia['segundonombre_personal_policias'],
                    'circuito' => $datosPolicia['subcircuito'][0]['circuito']['nombre_circuito_dependencias'],
                    'subcircuito' => $datosPolicia['subcircuito'][0]['nombre_subcircuito_dependencias'],
                    'distrito' => $datosPolicia['subcircuito'][0]['circuito']['distrito']['nombre_distritodependencias'],
                    'provincia' => $datosPolicia['subcircuito'][0]['circuito']['distrito']['provincia']['nombre_provincia_dependencias'],
                ],
            ]);
        } else if ($this->tieneSolicitudesPendientes($userId)) {
            $datosPoliciaSolicitud = $this->obtenerDetallesPoliciaSolicitud($userId);

            return view('solicitudesvehiculosViews.index', [
                'policia' => [
                    'id' => $datosPoliciaSolicitud['personal']['id'],
                    'apellido_paterno' => $datosPoliciaSolicitud['personal']['primerapellido_personal_policias'],
                    'apellido_materno' => $datosPoliciaSolicitud['personal']['segundoapellido_personal_policias'],
                    'primer_nombre' => $datosPoliciaSolicitud['personal']['primernombre_personal_policias'],
                    'segundo_nombre' => $datosPoliciaSolicitud['personal']['segundonombre_personal_policias'],
                    'circuito' => $datosPoliciaSolicitud['personal']['subcircuito'][0]['circuito']['nombre_circuito_dependencias'],
                    'subcircuito' => $datosPoliciaSolicitud['personal']['subcircuito'][0]['nombre_subcircuito_dependencias'],
                    'id_subcircuito' => $datosPoliciaSolicitud['personal']['subcircuito'][0]['id'],
                    'distrito' => $datosPoliciaSolicitud['personal']['subcircuito'][0]['circuito']['distrito']['nombre_distritodependencias'],
                    'provincia' => $datosPoliciaSolicitud['personal']['subcircuito'][0]['circuito']['distrito']['provincia']['nombre_provincia_dependencias'],
                ],
                'solicitud' => [
                    'id' => $datosPoliciaSolicitud['solicitud_pendiente'][0]['id'] ?? 'N/A',
                    'fecha_solicitado' => $datosPoliciaSolicitud['solicitud_pendiente'][0]['created_at'] ?? '',
                    'detalle' => $datosPoliciaSolicitud['solicitud_pendiente'][0]['solicitudvehiculos_detalle'] ?? '',
                    'tipo_vehiculo' => $datosPoliciaSolicitud['solicitud_pendiente'][0]['solicitudvehiculos_tipo'] ?? '',
                    'fecha_desde' => $datosPoliciaSolicitud['solicitud_pendiente'][0]['solicitudvehiculos_fecharequerimientodesde'] ?? '',
                    'fecha_hasta' => $datosPoliciaSolicitud['solicitud_pendiente'][0]['solicitudvehiculos_fecharequerimientohasta'] ?? '',
                    'jornada' => $datosPoliciaSolicitud['solicitud_pendiente'][0]['solicitudvehiculos_jornada'] ?? '',
                    'estado_solicitud' => $datosPoliciaSolicitud['solicitud_pendiente'][0]['solicitudvehiculos_estado'] ?? '',
                ]
            ]);
        }else{
            return redirect()->route('dashboard')->with('error', 'No hay solicitudes');
        }
    } */

    /* private function obtenerDatosPolicia(int $userId): ?array
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

        return view('solicitudesvehiculosViews.create', [
            'tipos_vehiculo' => ['Moto', 'Auto', 'Camioneta'],
            'jornadas' => ['Ordinaria', 'Extraordinaria'],
            'policia' => $this->mapearDatosPolicia($datosPolicia)
        ]);
    }

    public function mostrarSolicitudVehiculoPendiente($userId = null): View | RedirectResponse {

        $userId ??= auth()->id();
        $user = Auth::user();

        $datosPoliciaSolicitud = $this->obtenerDetallesPoliciaSolicitud($userId);

        // Manejo de posibles errores al obtener los datos de la solicitud
        if (!$datosPoliciaSolicitud) {
            return redirect()->route('dashboard')->with('error', 'Error al obtener la solicitud pendiente.');
        }

        /* // Verifica si hay una solicitud pendiente antes de acceder a sus elementos
        $solicitudPendiente = $datosPoliciaSolicitud['solicitud_pendiente'][0] ?? null; */

        if ($user->rol() === 'administrador') {
            return view('solicitudesvehiculosViews.administrador.index', [
                'policia' => $this->mapearDatosPolicia($datosPoliciaSolicitud['personal']),
                'solicitud' => $this->mapearDatosSolicitud($datosPoliciaSolicitud['solicitud_pendiente'][0] ?? [])
            ]);
        }

        if ($user->rol() === 'policia') {
            return view('solicitudesvehiculosViews.policia.index', [
                'policia' => $this->mapearDatosPolicia($datosPoliciaSolicitud['personal']),
                'solicitud' => $this->mapearDatosSolicitud($datosPoliciaSolicitud['solicitud_pendiente'][0] ?? [])
            ]);
        }

        // Si el usuario no es ni administrador ni policía, redirigir con un error.
        return redirect()->route('dashboard')->with('error', 'No tienes permisos para acceder a esta sección.');
    }


    /**
     * Verifica si el usuario tiene solicitudes pendientes.
     */
    private function tieneSolicitudesPendientes($userId): bool
    {
        $response = Http::get(url("/api/personal/policia/{$userId}/totalsolicitudesvehiculos/pendientes"));

        return $response->successful() && $response->json()['numero_solicitudes'] > 0;
    }

    /**
     * Obtiene los detalles del policía logueado.
     */
    private function obtenerDetallesPolicia($userId): ?array
    {
        $response = Http::get(url("/api/personal/policia/{$userId}/detalles"));

        return $response->successful() ? $response->json() : null;
    }
    private function obtenerDetallesPoliciaSolicitud($userId): ?array
    {
        $response = Http::get(url("/api/personal/policia/{$userId}/get/solicitud-pendiente"));

        return $response->successful() ? $response->json() : null;
    }
    private function mapearDatosPolicia(array $datosPolicia): array
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

    private function mapearDatosSolicitud(array $solicitud): array
    {
        return [
            'id' => $solicitud['id'] ?? 'N/A',
            'fecha_solicitado' => $solicitud['created_at'] ?? '',
            'detalle' => $solicitud['solicitudvehiculos_detalle'] ?? '',
            'tipo_vehiculo' => $solicitud['solicitudvehiculos_tipo'] ?? '',
            'fecha_desde' => $solicitud['solicitudvehiculos_fecharequerimientodesde'] ?? '',
            'fecha_hasta' => $solicitud['solicitudvehiculos_fecharequerimientohasta'] ?? '',
            'jornada' => $solicitud['solicitudvehiculos_jornada'] ?? '',
            'estado_solicitud' => $solicitud['solicitudvehiculos_estado'] ?? '',
        ];
    }
}
