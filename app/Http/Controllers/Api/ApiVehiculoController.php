<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehiculo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ApiVehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /* public function index(Request $request): JsonResponse
    {
        // Establecer el valor por defecto
        $defaultPerPage = 10; // Número de registros por página

        // Obtener el valor de perPage o usar el valor por defecto
        $perPage = $request->input('perPage', $defaultPerPage);

        // Obtener todos los registros
        $query = Vehiculo::query();
        //dd($request);

        // Implementar la búsqueda y filtrado
        if ($request->has('search.value') && $request->search['value']) {
            $search = $request->search['value'];
            $fields = ['marca_vehiculos', 'modelo_vehiculos', 'color_vehiculos', 'placa_vehiculos'];

            $query->where(function ($q) use ($search, $fields) {
                foreach ($fields as $field) {
                    $q->orWhere($field, 'like', "%{$search}%");
                }
            });
        }
        // Manejar la ordenación
        if ($request->has('order')) {
            $orderColumnIndex = $request->input('order.0.column');
            $orderDirection = $request->input('order.0.dir');

            // Mapea el índice de columna a su nombre en la base de datos
            $columns = ['marca_vehiculos', 'tipo_vehiculos', 'modelo_vehiculos', 'color_vehiculos', 'placa_vehiculos'];
            $orderColumn = $columns[$orderColumnIndex];

            // Aplicar ordenación
            $query->orderBy($orderColumn, $orderDirection);
        }

        // Total de registros filtrados
        $recordsFiltered = $query->count();

        // Total de registros sin filtrar
        $recordsTotal = Vehiculo::count();

        // Si perPage es 0, devolver un array vacío
        if ($perPage == 0) {
            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => $recordsTotal, // Total después de filtrar
                'recordsFiltered' => $recordsFiltered,
                'data' => [], // Array vacío cuando perPage es 0
                'currentPage' => 1, // Página actual
                'lastPage' => 1, // Última página
                'perPage' => 0, // Registros por página
            ]);
        }

        // Obtener los registros con paginación usando el nuevo parámetro
        $vehiculos = $query->paginate($perPage);
        // Definir las columnas
        $columns = [];
        $fields = ['marca_vehiculos', 'modelo_vehiculos', 'color_vehiculos', 'placa_vehiculos'];

        foreach ($fields as $field) {
            $columns[] = [
                "data" => $field, // Utilizamos el nombre de la columna
                "name" => "",
                "searchable" => true,
                "orderable" => true,
                "search" => [
                    "value" => "",
                    "regex" => false,
                    "fixed" => []
                ]
            ];
        }
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
                'column' => $orderColumnIndex ?? null, // Columna ordenada
                'direction' => $orderDirection ?? null // Dirección de la ordenación
            ],
            'columns' => $columns // Agregar aquí la clave "columns"
        ]);
    } */

    public function index(Request $request): JsonResponse {
        // Valor por defecto para la paginación
        $defaultPerPage = 10;
        $perPage = $request->input('perPage', $defaultPerPage);

        // Consulta base con relaciones cargadas
        $query = Vehiculo::with(['parqueaderos.subcircuitos']);

        // Implementar búsqueda y filtrado
        if ($request->has('search.value') && $request->search['value']) {
            $search = $request->search['value'];
            $fields = ['marca_vehiculos', 'tipo_vehiculos', 'modelo_vehiculos', 'placa_vehiculos'];

            $query->where(function ($q) use ($search, $fields) {
                foreach ($fields as $field) {
                    $q->orWhere($field, 'like', "%{$search}%");
                }
            });
        }

        // Ordenación
        if ($request->has('order')) {
            $orderColumnIndex = $request->input('order.0.column');
            $orderDirection = $request->input('order.0.dir');

            // Mapea el índice de columna a su nombre
            $columns = ['marca_vehiculos', 'tipo_vehiculos', 'modelo_vehiculos', 'placa_vehiculos'];
            $orderColumn = $columns[$orderColumnIndex] ?? 'id';

            $query->orderBy($orderColumn, $orderDirection);
        }

        // Total de registros filtrados y sin filtrar
        $recordsFiltered = $query->count();
        $recordsTotal = Vehiculo::count();

        // Manejar la paginación
        if ($perPage == 0) {
            return response()->json([
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => [],
                'currentPage' => 1,
                'lastPage' => 1,
                'perPage' => 0,
            ]);
        }

        $vehiculos = $query->paginate($perPage);

        return response()->json([
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $vehiculos->map(function ($vehiculo) {
                return [
                    'id' => $vehiculo->id,
                    'marca' => $vehiculo->marca_vehiculos,
                    'tipo' => $vehiculo->tipo_vehiculos,
                    'modelo' => $vehiculo->modelo_vehiculos,
                    'placa' => $vehiculo->placa_vehiculos,
                    'parqueaderos' => $vehiculo->parqueaderos->map(function ($parqueadero) {
                        return [
                            'id' => $parqueadero->id,
                            'direccion' => $parqueadero->parqueaderos_direccion,
                            'subcircuitos' => $parqueadero->subcircuitos->map(function ($subcircuito) {
                                return [
                                    'id' => $subcircuito->id,
                                    'nombre' => $subcircuito->nombre_subcircuito_dependencias,
                                ];
                            }),
                        ];
                    }),
                ];
            }),
            'currentPage' => $vehiculos->currentPage(),
            'lastPage' => $vehiculos->lastPage(),
            'perPage' => $vehiculos->perPage(),
        ]);
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
