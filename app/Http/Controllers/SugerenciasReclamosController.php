<?php

namespace App\Http\Controllers;

use App\Models\Quejasugerencia;
use App\Models\Subcircuitodependencia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use View;
use Carbon\Carbon;

class SugerenciasReclamosController extends Controller
{
    //
    public function index()
    {
        $arraySubcircuitos = Subcircuitodependencia::get();
        return view("sugerenciasreclamos", compact("arraySubcircuitos"));
    }

    public function get()
    {
        $arraySubcircuitos = Subcircuitodependencia::get();
        return $arraySubcircuitos;
    }

    public function save(Request $request)
    {
        $id = Quejasugerencia::create($request);
        Quejasugerencia::find($id)->subcircuitodependencia()->attach( [ 1 => ['quejasugerencia_id'=>$id, 'subcircuitodependencia_id'=>$request->subcircuito]]);
        return redirect()->intended(route('login', absolute: false));
    }

    public function formularioquejasugerencias()
    {
        return view("reportes.quejasugerencias");
    }

    public function quejasugerenciasfechashow(Request $request)
    {
        $request->validate([
            'fechainicio' => 'required|date',
            'fechafin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $fechaInicio = $request->input('fechainicio');
        $fechaFin = $request->input('fechafin');

        $fechaInicio = Carbon::createFromFormat('Y-m-d', $fechaInicio); // Fecha de inicio
        $fechaFin = Carbon::createFromFormat('Y-m-d', $fechaFin); // Fecha de fin

        $arrayQuejasugerencias = Quejasugerencia::whereBetween('created_at', [$fechaInicio, $fechaFin])->get();
        return view("reportes.quejasugerencias", compact("arrayQuejasugerencias"));
    }
}
