<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Personalpolicia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiPersonalpoliciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        // Establecer el valor por defecto de registros por página
        $defaultPerPage = 10;
        $perPage = $request->input('perPage', $defaultPerPage);

        // Obtener la consulta base del modelo
        $query = Personalpolicia::query();

        // Implementar la búsqueda y filtrado
        if ($request->has('search.value') && $request->search['value']) {
            $search = $request->search['value'];
            $fields = [
                'rango_personal_policias',
                'primerapellido_personal_policias',
                'segundoapellido_personal_policias',
                'primernombre_personal_policias',
                'segundonombre_personal_policias'
            ];

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
            $columns = [
                'rango_personal_policias',
                'primerapellido_personal_policias',
                'segundoapellido_personal_policias',
                'primernombre_personal_policias',
                'segundonombre_personal_policias'
            ];
            $orderColumn = $columns[$orderColumnIndex] ?? 'id';

            // Aplicar ordenación
            $query->orderBy($orderColumn, $orderDirection);
        }

        // Total de registros filtrados
        $recordsFiltered = $query->count();

        // Total de registros sin filtrar
        $recordsTotal = Personalpolicia::count();

        // Si perPage es 0, devolver un array vacío
        if ($perPage == 0) {
            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => [],
                'currentPage' => 1,
                'lastPage' => 1,
                'perPage' => 0,
            ]);
        }

        // Obtener los registros con paginación
        $personalPolicia = $query->paginate($perPage);

        // Devolver la respuesta en formato JSON
        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $personalPolicia->items(),
            'currentPage' => $personalPolicia->currentPage(),
            'lastPage' => $personalPolicia->lastPage(),
            'perPage' => $personalPolicia->perPage(),
            'order' => [
                'column' => $orderColumnIndex ?? null,
                'direction' => $orderDirection ?? null
            ],
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
    public function show(string $id): JsonResponse
    {

        // Obtener el PersonalPolicia con sus Subcircuitos y relaciones
        $personalPolicia = Personalpolicia::with('user', 'subcircuito.circuito.distrito.provincia')->find($id);

        // Verificar si el PersonalPolicia existe
        if (!$personalPolicia) {
            return response()->json(['message' => 'PersonalPolicia no encontrado'], 404);
        }

        // Devolver la información en formato JSON
        return response()->json($personalPolicia);

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
