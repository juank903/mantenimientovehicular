<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subcircuitodependencia;
use Illuminate\Http\Request;

class ApiSubcircuitoController extends Controller
{
    //
    public function index()
    {
        $Subcircuitos = Subcircuitodependencia::all();
        return response()->json($Subcircuitos);
    }
    public function show($id)
    {
        // Obtener el Subcircuito con su Circuito, Distrito y Provincia
        //$subcircuito = Subcircuitodependencia::with('circuito.distrito.provincia')->find($id);
        $subcircuito = Subcircuitodependencia::with('circuito.distrito.provincia')
        ->find($id);
        // Verificar si el Subcircuito existe
        if (!$subcircuito) {
            return response()->json(['message' => 'Subcircuito no encontrado'], 404);
        }

        // Devolver la provincia en formato JSON
        return response()->json($subcircuito);
    }
}
