<?php

namespace App\Http\Controllers;

use App\Models\Circuitodependencia;
use Illuminate\Http\Request;

class CircuitoController extends Controller
{
    //
    public function getCircuitoId($idcircuito) {
        $circuito = Circuitodependencia::find($idcircuito);
        return $circuito;
    }
}
