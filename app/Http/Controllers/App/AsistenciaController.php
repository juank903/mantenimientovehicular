<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use App\Models\Personalpolicia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AsistenciaController extends Controller
{
    //
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo_unico' => 'required|exists:personalpolicia,codigo_unico',
            'asistencias_ingreso' => 'required',
            'asistencias_salida' => 'required',
            'asistencias_tipo' => 'required',
            'asistencias_modificadopor' => 'required',
            'asistencias_razon' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $personalpolicia = Personalpolicia::where('codigo_unico', $request->codigo_unico)->first();

        Asistencia::create([
            'personalpolicia_id' => $personalpolicia->id,
            'asistencias_ingreso' => $request->asistencias_ingreso,
            'asistencias_salida' => $request->asistencias_salida,
            'asistencias_tipo' => $request->asistencias_tipo,
            'asistencias_modificadopor' => $request->asistencias_modificadopor,
            'asistencias_razon' => $request->asistencias_razon,
        ]);

        return response()->json(['mensaje' => 'Asistencia registrada con éxito'], 201);
    }
}
