<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Quejasugerencia;
use Auth;
use Http;
use Illuminate\Http\RedirectResponse;
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

    public function getQuejasugerenciaSubcircuitoFechas(Request $request)
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
    }

    public function getSolicitudvehiculopendientePolicialogeado(){
        $response = Http::get(url('/api/personal/policia/' . auth()->id() . '/totalsolicitudesvehiculos/pendientes'));
        $data = $response->successful() ? $response->json() : [];
        if(Auth::user()->rol() == 'policia' && $data['numero_solicitudes'] == 0){
            return redirect()->route('dashboard')->with('error','Usted no tiene solicitudes pendientes');
        }else{
            $response = Http::get(url('/api/personal/policia/' . auth()->id() . '/get/solicitud-pendiente'));
            $data = $response->successful() ? $response->json() : [];

            return view('reportesViews.solicitudes.vehiculos.policia.pendientes.solicitudes-pendientes-vehiculo-index',compact('data'));
        }
    }
    public function getSolicitudvehiculopendientePoliciadministrador($id){

        $response = Http::get(url('/api/personal/policia/' . $id . '/totalsolicitudesvehiculos/pendientes'));
        $data = $response->successful() ? $response->json() : [];

        if((Auth::user()->rol() == 'administrador' || Auth::user()->rol() == 'auxiliar' || Auth::user()->rol() == 'gerencia') && $data['numero_solicitudes'] == 0){
            return redirect()->route('dashboard')->with('error','El policia no tiene solicitudes pendientes');
        }else if (Auth::user()->rol() == 'administrador' || Auth::user()->rol() == 'auxiliar' || Auth::user()->rol() == 'gerencia') {
            $response = Http::get(url('/api/personal/policia/' . $id . '/get/solicitud-pendiente'));
            $data = $response->successful() ? $response->json() : [];

            return view('reportesViews.solicitudes.vehiculos.policia.pendientes.solicitudes-pendientes-vehiculo-index',compact('data'));
        }
    }
}
