<?php

namespace App\Http\Controllers\Auth\Solicitudes;

use App\Http\Controllers\Controller;
use App\Models\Personalpolicia;
use App\Models\Solicitudvehiculo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SolicitudvehiculoController extends Controller
{
    //
    public function guardarsolicitudvehiculo(Request $request)
    {

        $response = Solicitudvehiculo::crearsolicitudvehiculo($request);
        $data = json_decode($response->getContent(), true);
        //dd($data['idPersonal']);
        if ($data['success']) {
            $response = Solicitudvehiculo::actualizarintegridadId($request, $data['idSolicitud']);
            $data = json_decode($response->getContent(), true);
            if ($data['success']) {
                return redirect()->intended(route('dashboard', absolute: false))->with('mensaje', $data['mensaje']);
            } else {
                $ultimoRegistro = Solicitudvehiculo::latest()->first();
                $ultimoRegistro->delete();
                return redirect()->intended(route('dashboard', absolute: false))->with('error', $data['error']);
            }
        } else {
            return redirect()->intended(route('dashboard', absolute: false))->with('error', $data['error']);
        }
    }
    public function revokeSolicitudVehiculoPolicia($personalId): RedirectResponse
    {

        $personal = Personalpolicia::find($personalId);

        if ($personal) {
            // Obtener las solicitudes de vehículos del usuario dado
            $solicitudes = Solicitudvehiculo::whereHas('personal', function ($query) use ($personalId) {
                $query->where('personalpolicia_id', $personalId);
            })
                ->where('solicitudvehiculos_estado', 'Pendiente')
                ->get();

            if ($solicitudes->isEmpty()) {
                return response()->json(['error' => 'No hay solicitudes pendientes para anular.'], 404);
            }
            // Cambiar el estado a "anulada"
            foreach ($solicitudes as $solicitud) {
                $solicitud->solicitudvehiculos_estado = 'Anulada';
                $solicitud->save();
            }
            return redirect()->intended(route('dashboard', absolute: false))->with('mensaje', 'Solicitudes anuladas correctamente.');
        } else {
            return redirect()->intended(route('dashboard', absolute: false))->with('error', 'No existe el Personal Policial.');
        }
    }

}
