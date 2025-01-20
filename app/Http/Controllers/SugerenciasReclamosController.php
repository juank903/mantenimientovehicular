<?php

namespace App\Http\Controllers;

use App\Models\Quejasugerencia;
use App\Models\Subcircuitodependencia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use View;

class SugerenciasReclamosController extends Controller
{
    //
    public function index(){
        $arraySubcircuitos = Subcircuitodependencia::get();
        return view("sugerenciasreclamos", compact("arraySubcircuitos"));
    }

    public function get(){
        $arraySubcircuitos = Subcircuitodependencia::get();
        return $arraySubcircuitos;
    }

    public function save(Request $request){
        Quejasugerencia::create($request);
        return redirect()->intended(route('login', absolute: false));
    }

    public function listarquejasugerencias(Request $request){
        $arrayQuejasugerencias = Subcircuitodependencia::all();
        return view("reportes.quejasugerencias", compact("arrayQuejasugerencias"));
    }
}
