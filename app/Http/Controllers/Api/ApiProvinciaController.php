<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Provinciadependencia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiProvinciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(): JsonResponse
    {
        $query = Provinciadependencia::with('distritos.circuitos.subcircuitos.parqueaderos.espacios');

        // Obtener el estado de los espacios desde los parámetros de la solicitud
        $estado = request('estado');

        // Filtrar por estado si se proporciona
        if ($estado) {
            $query->whereHas('distritos.circuitos.subcircuitos.parqueaderos.espacios', function ($q) use ($estado) {
                $q->where('espacioparqueadero_estado', $estado);
            });
        }

        $provincias = $query->get();
        return response()->json($provincias);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        // Obtener la provincia con sus distritos, circuitos y subcircuitos
        $provincia = Provinciadependencia::with('distritos.circuitos.subcircuitos.parqueaderos.espacios')->find($id);

        // Verificar si la provincia existe
        if (!$provincia) {
            return response()->json(['error' => 'Provincia no encontrada'], 404);
        }

        // Devolver la provincia y sus relaciones en formato JSON
        return response()->json($provincia);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
