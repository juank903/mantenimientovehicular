<?php

namespace App\Http\Controllers\Auth\Solicitudes;

use App\Http\Controllers\Controller;
use App\Models\Historialsolicitudvehiculo;
use App\Models\Personalpolicia;
use App\Models\Solicitudvehiculo;
use Auth;
use Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SolicitudvehiculoController extends Controller
{
    //
    public function guardarsolicitudvehiculo(Request $request)
    {
        //dd($request);
        $response = Solicitudvehiculo::crearsolicitudvehiculo($request);
        $data = json_decode($response->getContent(), true);

        if ($data['success']) {
            $response = Solicitudvehiculo::actualizarintegridadId($request, $data['idSolicitud']);
            $data = json_decode($response->getContent(), true);
            if ($data['success']) {
                //dd($data);
                $response = Historialsolicitudvehiculo::guardarHistorialInicial($data['personalpolicia_id'], $data['solicitudvehiculo_id']);
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
        //dd($request->all()); // Verifica qué datos están llegando realmente

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
                //dd($request->all());
                $response = Historialsolicitudvehiculo::guardarHistorialModificado($personalId, $solicitud->id, $motivo);
                if($response){
                    return redirect()->route('dashboard')->with('mensaje', 'Solicitud anulada y registrada');
                }
                else{
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

    public function solicitudvehiculopendientePolicialogeado()
    {
        $response = Http::get(url('/api/personal/policia/' . auth()->id() . '/totalsolicitudesvehiculos/pendientes'));
        $data = $response->successful() ? $response->json() : [];
        if (Auth::user()->rol() == 'policia' && $data['numero_solicitudes'] == 0) {
            $response = Http::get(url('/api/personal/policia/' . auth()->id() . '/detalles'));
            if ($response->successful()) {
                $data = $response->json();
                return view('inputsViews.solicitudes.vehiculos.policia.solicitudvehiculopolicia-index', compact('data'));
            } else {
                return redirect()->route('dashboard')->with('error', 'No existen datos');
            }
        } else {
            return redirect()->route('dashboard')->with('error', 'Usted tiene solicitudes pendientes');
        }
    }
}
