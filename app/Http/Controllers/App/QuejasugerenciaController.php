<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Quejasugerencia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuejasugerenciaController extends Controller
{
    //
    protected function crearquejasugerencia($request): JsonResponse
    {

        try {
            // Validación de los datos de entrada
            /* $request->validate([
                'detalle' => 'required|string|max:1000',
                'tipoqueja' => 'required|string|max:100',
                'apellidos' => 'required|string|max:255',
                'nombres' => 'required|string|max:255',
            ]); */

            $queja = new Quejasugerencia();
            $queja->detalle_quejasugerencias = $request->detalle;
            $queja->tipo_quejasugerencias = $request->tipoqueja;
            $queja->apellidos_quejasugerencias = $request->apellidos;
            $queja->nombres_quejasugerencias = $request->nombres;
            $queja->save();

            return response()->json([
                'success' => true,
                'mensaje' => 'Queja registrada con éxito',
                'queja' => $queja,
                'id' => $queja->id  // Retornando el ID de la queja
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Error al registrar la queja.'], 500);
        }
    }

    protected function actualizarintegridadId($request, $quejaId): JsonResponse
    {
        try {
            // Validación de los datos de entrada
            /* $request->validate([
                'subcircuito' => 'required|integer|exists:subcircuitodependencias,id', // Asegúrate de que el ID exista
            ]); */

            // Buscar la queja por ID
            $queja = Quejasugerencia::find($quejaId);

            if (!$queja) {
                return response()->json(['success' => false, 'error' => 'Queja no encontrada.'], 404);
            }

            // Adjuntar la subdependencia
            $queja->subcircuitodependencia()->attach([
                1 => [
                    'quejasugerencia_id' => $quejaId,
                    'subcircuitodependencia_id' => $request->subcircuito,
                ]
            ]);

            return response()->json([
                'success' => true,
                'mensaje' => 'Queja añadida con éxito',
                'queja_id' => $quejaId,
                'subcircuito_id' => $request->subcircuito
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Es posible que haya problemas de integridad referencial entre una queja y subcircuito'], 500);
        }
    }
}
