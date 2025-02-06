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

    public function solicitudVehiculoPendientePoliciaLogeado(): RedirectResponse|View
    {
        $userId = auth()->id();
        $user = Auth::user();

        if ($user->rol() !== 'policia') {
            return redirect()->route('dashboard')->with('error', 'Acceso no autorizado.');
        }

        if ($this->tieneSolicitudesPendientes($userId)) {
            return redirect()->route('dashboard')->with('error', 'Usted tiene solicitudes pendientes.');
        }

        $datosPolicia = $this->obtenerDetallesPolicia($userId);
        if (!$datosPolicia) {
            return redirect()->route('dashboard')->with('error', 'No existen datos.');
        }

        return view('solicitudesvehiculosViews.index', [
            'datosTipoVehiculo' => ['Moto', 'Auto', 'Camioneta'],
            'datosJornada' => ['Ordinaria', 'Extraordinaria'],
            'id' => $datosPolicia['id'],
            'apellidoPaterno' => $datosPolicia['primerapellido_personal_policias'],
            'apellidoMaterno' => $datosPolicia['segundoapellido_personal_policias'],
            'primerNombre' => $datosPolicia['primernombre_personal_policias'],
            'segundoNombre' => $datosPolicia['segundonombre_personal_policias'],
            'circuito' => $datosPolicia['subcircuito'][0]['circuito']['nombre_circuito_dependencias'],
            'subcircuito' => $datosPolicia['subcircuito'][0]['nombre_subcircuito_dependencias'],
            'distrito' => $datosPolicia['subcircuito'][0]['circuito']['distrito']['nombre_distritodependencias'],
            'provincia' => $datosPolicia['subcircuito'][0]['circuito']['distrito']['provincia']['nombre_provincia_dependencias'],
        ]);
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
}
