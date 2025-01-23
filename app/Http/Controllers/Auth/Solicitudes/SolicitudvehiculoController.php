<?php

namespace App\Http\Controllers\Auth\Solicitudes;

use App\Http\Controllers\Controller;
use App\Models\Solicitudvehiculo;
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
}
