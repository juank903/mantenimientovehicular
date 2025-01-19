<?php

namespace App\Http\Controllers;

use App\Models\Subcircuito_dependencia;
use Illuminate\Http\Request;

class SugerenciasReclamosController extends Controller
{
    //
    public function index(){
        $arraySubcircuitos = Subcircuito_dependencia::get();
        //$arraySubcircuitos = ['sub1', 'sub2', 'sub3'];
        //$arraySubcircuitos = $arraySubcircuitos->attributes;
        return view("sugerenciasreclamos",compact("arraySubcircuitos"));
    }
}
