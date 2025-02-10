<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Personalpolicia;
use App\Models\Subcircuitodependencia;
use Illuminate\Http\Request;

class PersonalpoliciaSubcircuitodependenciaController extends Controller
{
    //
    public static function create(Request $request)
    {
        $personalpoliciaId = $request->input('id');
        $subcircuitodependenciaId = $request->input('subcircuito');

        // Validar los datos recibidos (opcional)

        $personalpolicia = Personalpolicia::findOrFail($personalpoliciaId);
        $subcircuitodependencia = Subcircuitodependencia::findOrFail($subcircuitodependenciaId);

        $personalpolicia->subcircuito()->attach($subcircuitodependencia);

        // Puedes agregar lógica adicional aquí, como devolver una respuesta al cliente.

        return response()->json([
            'success' => true,
            'mensaje' => 'Relación creada. Proceso ejecutado correctamente',
        ], 201);
    }
}
