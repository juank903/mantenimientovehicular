<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partenovedad;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiPartenovedadController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('perPage', 10);
        $personalPoliciaId = $request->input('personalpolicia_id'); // ID opcional

        $query = Partenovedad::with([
            'personalpolicia:id,primernombre_personal_policias,segundonombre_personal_policias,primerapellido_personal_policias,segundoapellido_personal_policias,rango_personal_policias',
            'vehiculo:id,tipo_vehiculos,placa_vehiculos'
        ])->select(['id', 'created_at', 'partenovedades_tipo', 'personalpolicia_id', 'vehiculo_id']);

        // Si se pasa un ID, filtrar por personalpolicia_id
        if (!empty($personalPoliciaId)) {
            $query->where('personalpolicia_id', $personalPoliciaId);
        }

        // Ordenación
        if ($request->has('order')) {
            $orderColumnIndex = $request->input('order.0.column');
            $orderDirection = $request->input('order.0.dir');

            // Mapea el índice de columna a su nombre
            $columns = ['id', 'created_at', 'partenovedades_tipo', 'tipo_vehiculos', 'placa_vehiculos']; // Columnas disponibles para ordenar
            $orderColumn = $columns[$orderColumnIndex] ?? 'id'; // Valor por defecto: 'id'

            $query->orderBy($orderColumn, $orderDirection);
        }

        // Contar registros (después de la ordenación para obtener el conteo correcto)
        $recordsTotal = Partenovedad::count();
        $recordsFiltered = $query->count();

        // Obtener los registros con paginación o sin ella
        if ($perPage == 0 || $perPage == -1) {
            $partesNovedad = $query->get();
        } else {
            $partesNovedad = $query->paginate($perPage);
        }

        // Formatear la salida con solo las columnas requeridas
        $data = $partesNovedad->map(function ($parte) {
            return [
                'id' => $parte->id,
                'created_at' => Carbon::parse($parte->created_at)->setTimezone('America/Guayaquil')->toDateTimeString(),
                'partenovedades_tipo' => $parte->partenovedades_tipo,
                'tipo_vehiculos' => $parte->vehiculo->tipo_vehiculos ?? null,
                'placa_vehiculos' => $parte->vehiculo->placa_vehiculos ?? null,
            ];
        });

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
            'currentPage' => $partesNovedad instanceof \Illuminate\Pagination\LengthAwarePaginator ? $partesNovedad->currentPage() : 1,
            'lastPage' => $partesNovedad instanceof \Illuminate\Pagination\LengthAwarePaginator ? $partesNovedad->lastPage() : 1,
            'perPage' => $perPage,
        ]);
    }


    /* public function show($id)
    {
        try {
            // Obtener la partenovedad basada en el id de personalpolicia con sus relaciones
            $partenovedad = Partenovedad::with(['personalpolicia', 'vehiculo', 'asignacionVehiculo'])
                ->whereHas('personalpolicia', function ($query) use ($id) {
                    $query->where('id', $id);
                })
                ->first();

            // Verificar si la partenovedad existe
            if (!$partenovedad) {
                return response()->json([], 404); // 404 Not Found
            }

            // Retornar la partenovedad con sus relaciones
            return response()->json($partenovedad, 200); // 200 OK

        } catch (\Exception $e) {
            // Manejo de errores inesperados
            return response()->json([
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage()
            ], 500); // 500 Internal Server Error
        }
    } */
    public function show($id)
    {
        try {
            // Obtener la partenovedad basada en el id de personalpolicia con sus relaciones
            $partenovedad = Partenovedad::with(['personalpolicia', 'vehiculo', 'asignacionVehiculo'])
                ->find($id); // Buscar por el ID de la clave primaria

            // Verificar si la partenovedad existe
            if (!$partenovedad) {
                return response()->json([], 404); // 404 Not Found
            }

            // Retornar la partenovedad con sus relaciones
            return response()->json($partenovedad, 200); // 200 OK

        } catch (\Exception $e) {
            // Manejo de errores inesperados
            return response()->json([
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage()
            ], 500); // 500 Internal Server Error
        }
    }
}
