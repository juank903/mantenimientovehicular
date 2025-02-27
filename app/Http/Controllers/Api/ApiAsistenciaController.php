<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiAsistenciaController extends Controller
{
    //
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('length', 10); // DataTables usa "length" en vez de "perPage"
        $start = $request->input('start', 0);
        $draw = intval($request->input('draw', 1));

        $query = Asistencia::with([
            'personalpolicia:id,user_id,primernombre_personal_policias,segundonombre_personal_policias,primerapellido_personal_policias,segundoapellido_personal_policias,rango_personal_policias'
        ])->select([
                    'id',
                    'personalpolicia_id',
                    'asistencias_ingreso',
                    'asistencias_salida'
                ]);

        // Filtrar por ID de personalpolicia si se proporciona
        if ($request->filled('personalpolicia_id')) {
            $query->where('personalpolicia_id', $request->input('personalpolicia_id'));
        }

        // Ordenación dinámica basada en las columnas enviadas por DataTables
        $columns = ['id', 'asistencias_ingreso', 'asistencias_salida', 'personalpolicia.rango_personal_policias', 'personalpolicia.primerapellido_personal_policias', 'personalpolicia.segundoapellido_personal_policias', 'personalpolicia.primernombre_personal_policias', 'personalpolicia.segundonombre_personal_policias'];

        if ($request->has('order')) {
            $orderColumnIndex = $request->input('order.0.column', 0);
            $orderDirection = $request->input('order.0.dir', 'asc');
            $orderColumn = $columns[$orderColumnIndex] ?? 'id';

            if (strpos($orderColumn, 'personalpolicia.') !== false) {
                $query->join('personalpolicias', 'asistencias.personalpolicia_id', '=', 'personalpolicias.id')
                    ->orderBy($orderColumn, $orderDirection);
            } else {
                $query->orderBy($orderColumn, $orderDirection);
            }
        }

        // Contar total de registros
        $recordsTotal = Asistencia::count();

        // Obtener total después de filtros
        $recordsFiltered = $query->count();

        // Aplicar paginación
        $asistencias = $query->skip($start)->take($perPage)->get();

        // Formatear la salida
        $data = $asistencias->map(function ($asistencia) {
            return [
                'id' => $asistencia->id,
                'asistencias_ingreso' => Carbon::parse($asistencia->asistencias_ingreso)->toDateTimeString(),
                'asistencias_salida' => Carbon::parse($asistencia->asistencias_salida)->toDateTimeString(),
                'rango_personal_policias' => $asistencia->personalpolicia->rango_personal_policias ?? '',
                'primerapellido' => $asistencia->personalpolicia->primerapellido_personal_policias ?? '',
                'segundoapellido' => $asistencia->personalpolicia->segundoapellido_personal_policias ?? '',
                'primernombre' => $asistencia->personalpolicia->primernombre_personal_policias ?? '',
                'segundonombre' => $asistencia->personalpolicia->segundonombre_personal_policias ?? ''
            ];
        });

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data
        ]);
    }

    public function show($id)
    {
        $asistencia = Asistencia::with('personalpolicial')->find($id);

        if (!$asistencia) {
            return response()->json(['message' => 'Asistencia no encontrada'], 404);
        }

        return response()->json($asistencia);
    }
}
