<?php

namespace App\Http\Controllers;

use App\Models\Quejasugerencia;
use App\Models\Subcircuito_dependencia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use View;

class SugerenciasReclamosController extends Controller
{
    //
    public function index(){
        $arraySubcircuitos = Subcircuito_dependencia::get();
        //$arraySubcircuitos = ['sub1', 'sub2', 'sub3'];
        //$arraySubcircuitos = $arraySubcircuitos->attributes;
        return view("sugerenciasreclamos", compact("arraySubcircuitos"));
    }

    public function get(){
        $arraySubcircuitos = Subcircuito_dependencia::get();
        //$arraySubcircuitos = ['sub1', 'sub2', 'sub3'];
        //$arraySubcircuitos = $arraySubcircuitos->attributes;
        return $arraySubcircuitos;
    }

    public function save(Request $request){
        //dd($request);
        Quejasugerencia::create($request);
        return redirect()->intended(route('login', absolute: false));
    }
}
