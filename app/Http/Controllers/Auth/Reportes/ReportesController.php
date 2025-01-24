<?php

namespace App\Http\Controllers\Auth\Reportes;

use App\Http\Controllers\Controller;
use App\Models\Quejasugerencia;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportesController extends Controller
{
    //
    /* public function quejasugerenciasfechashow(Request $request)
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
    } */

    public function getQuejasugerenciassubcircuitoFechas(Request $request)
    {
        $request->validate([
            'fechainicio' => 'required|date',
            'fechafin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $fechaInicio = $request->input('fechainicio');
        $fechaFin = $request->input('fechafin');

        $fechaInicio = Carbon::createFromFormat('Y-m-d', $fechaInicio); // Fecha de inicio
        $fechaFin = Carbon::createFromFormat('Y-m-d', $fechaFin); // Fecha de fin

        $arrayQuejasugerencias = Quejasugerencia::selectRaw('DATE(quejasugerencias.created_at) AS fecha, quejasugerencias.tipo_quejasugerencias, c.subcircuitodependencia_id,
        b.nombre_subcircuito_dependencias AS nombre_subcircuito, COUNT(*) AS total')
        ->join('quejasugerencia_subcircuitodependencia AS c', 'quejasugerencias.id', '=', 'c.quejasugerencia_id')
        ->join('subcircuitodependencias AS b', 'c.subcircuitodependencia_id', '=', 'b.id')
        ->whereBetween('quejasugerencias.created_at', [$fechaInicio, $fechaFin])
        ->groupBy('c.subcircuitodependencia_id', 'fecha', 'quejasugerencias.tipo_quejasugerencias', 'b.nombre_subcircuito_dependencias')
        ->get();

        return response()->json($arrayQuejasugerencias);

        //return view("reportes.quejasugerencias", compact("arrayQuejasugerencias"));
    }
}
