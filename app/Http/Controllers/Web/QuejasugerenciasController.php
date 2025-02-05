<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Quejasugerencia;
use Illuminate\Http\Request;
use View;


class QuejasugerenciasController extends Controller
{
    public function index()
    {
        $datosTipo = ['Reclamo', 'Sugerencia'];
        return view("quejasViews.index", compact('datosTipo'));
    }
    public function guardarquejasugerencia(Request $request)
    {
        $response = Quejasugerencia::crearquejasugerencia($request);
        $data = json_decode($response->getContent(), true);
        if ($data['success']) {
            $response = Quejasugerencia::actualizarintegridadId($request, $data['id']);
            $data = json_decode($response->getContent(), true);
            if ($data['success']) {
                return redirect()->intended(route('login', absolute: false))->with('mensaje', $data['mensaje']);
            } else {
                $ultimoRegistro = Quejasugerencia::latest()->first();
                $ultimoRegistro->delete();
                return redirect()->intended(route('login', absolute: false))->with('error', $data['error']);
            }
        } else {
            return redirect()->intended(route('login', absolute: false))->with('error', $data['error']);
        }
    }

}
