<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehiculo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request)
{
    // Establecer el valor por defecto
    $defaultPerPage = 10; // Número de registros por página

    // Obtener el valor de perPage o usar el valor por defecto
    $perPage = $request->input('perPage', $defaultPerPage);

    // Obtener todos los registros
    $query = Vehiculo::query();

    // Implementar la búsqueda y filtrado
    if ($request->has('search.value') && $request->search['value']) {
        $search = $request->search['value'];
        $query->where(function ($q) use ($search) {
            $q->where('marca_vehiculos', 'like', "%{$search}%")
                ->orWhere('modelo_vehiculos', 'like', "%{$search}%")
                ->orWhere('color_vehiculos', 'like', "%{$search}%")
                ->orWhere('placa_vehiculos', 'like', "%{$search}%");
        });
    }

    // Total de registros filtrados
    $recordsFiltered = $query->count();

    // Si perPage es 0, devolver un array vacío
    if ($perPage == 0) {
        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $recordsFiltered, // Total después de filtrar
            'recordsFiltered' => $recordsFiltered,
            'data' => [], // Array vacío cuando perPage es 0
            'currentPage' => 1, // Página actual
            'lastPage' => 1, // Última página
            'perPage' => 0, // Registros por página
        ]);
    }

    // Manejar la ordenación
    if ($request->has('order')) {
        $orderColumnIndex = $request->input('order.0.column');
        $orderDirection = $request->input('order.0.dir');

        // Mapea el índice de columna a su nombre en la base de datos
        $columns = ['marca_vehiculos', 'modelo_vehiculos', 'color_vehiculos', 'placa_vehiculos'];
        $orderColumn = $columns[$orderColumnIndex];

        // Aplicar ordenación
        $query->orderBy($orderColumn, $orderDirection);
    }

    // Obtener los registros con paginación usando el nuevo parámetro
    $vehiculos = $query->paginate($perPage);

    // Total de registros sin filtrar
    $recordsTotal = Vehiculo::count();

    // Devolver la respuesta en formato JSON
    return response()->json([
        'draw' => intval($request->draw),
        'recordsTotal' => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data' => $vehiculos->items(), // Obtener solo los elementos
        'currentPage' => $vehiculos->currentPage(), // Página actual
        'lastPage' => $vehiculos->lastPage(), // Última página
        'perPage' => $vehiculos->perPage(), // Registros por página
        'order' => [
            'column' => $orderColumn ?? null, // Columna ordenada
            'direction' => $orderDirection ?? null // Dirección de la ordenación
        ],
    ]);
}




    /* public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 10); // Número de registros por página (por defecto 10)
        $vehiculos = Vehiculo::paginate($perPage); // Paginación de vehículos

        return response()->json($vehiculos); // Devuelve la respuesta en formato JSON
    } */


    /* public function index(Request $request): JsonResponse
    {
        // Obtiene todos los vehículos sin paginación
        $vehiculos = Vehiculo::all(); // Devuelve todos los registros

        return response()->json($vehiculos); // Devuelve la respuesta en formato JSON
    } */

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
    public function show(string $id)
    {
        //
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
