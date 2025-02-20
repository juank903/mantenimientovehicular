<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehiculo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ApiVehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request): JsonResponse
    {
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
            $columns = ['id', 'marca_vehiculos', 'tipo_vehiculos', 'modelo_vehiculos', 'placa_vehiculos', 'estado_vehiculos'];
            $orderColumn = $columns[$orderColumnIndex] ?? 'id';

            $query->orderBy($orderColumn, $orderDirection);
        }

        // Total de registros filtrados y sin filtrar
        $recordsFiltered = $query->count();
        $recordsTotal = Vehiculo::count();

        // Si perPage es 0 o -1, obtener todos los registros sin paginar
        if ($perPage == 0 || $perPage == -1) {
            $vehiculos = $query->get();

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
                        'estado' => $vehiculo->estado_vehiculos,
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
                'currentPage' => 1,
                'lastPage' => 1,
                'perPage' => $vehiculos->count(),
            ]);
        }

        // Aplicar paginación normal
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
                    'estado' => $vehiculo->estado_vehiculos,
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
        // 1. Validar los datos del formulario (incluyendo los IDs de subcircuitos)
        $request->validate([
            'marca_vehiculos' => 'required|string|max:255',
            'tipo_vehiculos' => 'required|string|max:255',
            // ... otras validaciones
            'subcircuito_dependencia_ids' => 'required|array', // Asegúrate de que es un array
            'subcircuito_dependencia_ids.*' => 'exists:subcircuito_dependencias,id', // Valida que los IDs existen
        ]);

        // 2. Crear una nueva instancia del modelo Vehiculo
        $vehiculo = new Vehiculo();

        // 3. Asignar los valores del request a los atributos del modelo (excepto los IDs de subcircuitos)
        $vehiculo->marca_vehiculos = $request->input('marca_vehiculos');
        $vehiculo->tipo_vehiculos = $request->input('tipo_vehiculos');
        // ... asignar los demás campos

        // 4. Guardar el modelo en la base de datos
        $vehiculo->save();

        // 5. Sincronizar la tabla pivote con los IDs de subcircuitos
        $vehiculo->subcircuitoDependencias()->sync($request->input('subcircuito_dependencia_ids'));

        // 6. Redireccionar o retornar una respuesta
        return redirect()->route('ruta.a.la.que.quieras.redireccionar')
            ->with('success', 'Vehículo registrado exitosamente.');
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
    public function destroy($id)
    {
        try {
            // Encuentra el registro a eliminar
            $modelo = Vehiculo::find($id);

            // Verifica si el registro existe
            if (!$modelo) {
                return response()->json(['mensaje' => 'Registro no encontrado'], 404);
            }

            // Inicia una transacción para asegurar la integridad de la base de datos
            DB::beginTransaction();

            // Elimina el registro y sus relaciones
            $modelo->delete();

            DB::commit();

            return response()->json(['mensaje' => 'Registro eliminado correctamente '], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al eliminar el registro: ' . $e->getMessage()], 500);
        }
    }

    public function getVehiculoParqueaderoSubcircuito($subcircuito_id, $tipo_vehiculo)
    {
        $vehiculos = Vehiculo::with(['parqueaderos', 'espacio'])
            ->whereHas('subcircuito', function ($query) use ($subcircuito_id) {
                $query->where('subcircuitodependencia_id', $subcircuito_id);
            })
            ->when($tipo_vehiculo, function ($query) use ($tipo_vehiculo) {
                $query->where('tipo_vehiculos', $tipo_vehiculo);
            })
            ->where('estado_vehiculos', 'no asignado')
            ->get();

        return response()->json($vehiculos);
    }
}
