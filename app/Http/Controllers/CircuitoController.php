<?php

namespace App\Http\Controllers;

use App\Models\Circuito_dependencia;
use Illuminate\Http\Request;

class CircuitoController extends Controller
{
    //
    //public function getCircuito(string $idcircuito) {
    public function getCircuitoId($idcircuito) {
        $circuito = Circuito_dependencia::find($idcircuito);
        return $circuito;
    }
}
