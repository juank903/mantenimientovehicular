<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asignacionvehiculo;
use App\Models\Personalpolicia;
use App\Models\Solicitudvehiculo;
use App\Models\Vehiculo;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Clock\now;

class ApiSolicitudvehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $defaultPerPage = 10;
        $perPage = $request->input('perPage', $defaultPerPage);

        // Asegurar el JOIN siempre
        $query = Solicitudvehiculo::query()
            ->leftJoin('personalpolicia_solicitudvehiculo', 'solicitudvehiculos.id', '=', 'personalpolicia_solicitudvehiculo.solicitudvehiculo_id')
            ->leftJoin('personalpolicias', 'personalpolicia_solicitudvehiculo.personalpolicia_id', '=', 'personalpolicias.id')
            ->select([
                'solicitudvehiculos.*',
                'personalpolicias.rango_personal_policias',
                'personalpolicias.primerapellido_personal_policias',
                'personalpolicias.segundoapellido_personal_policias',
                'personalpolicias.primernombre_personal_policias',
                'personalpolicias.segundonombre_personal_policias'
            ])
            ->where('personalpolicias.rol_personal_policias', 'policia'); // Solo personal con rol "policia"

        // Aplicar búsqueda
        if ($request->has('search.value') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search) {
                $q->where('solicitudvehiculos.id', 'like', "%{$search}%")
                    ->orWhere('solicitudvehiculos.created_at', 'like', "%{$search}%")
                    ->orWhere('solicitudvehiculos.solicitudvehiculos_fecharequerimiento', 'like', "%{$search}%")
                    ->orWhere('solicitudvehiculos.solicitudvehiculos_tipo', 'like', "%{$search}%")
                    ->orWhere('solicitudvehiculos.solicitudvehiculos_estado', 'like', "%{$search}%")
                    ->orWhere('personalpolicias.rango_personal_policias', 'like', "%{$search}%")
                    ->orWhere('personalpolicias.primerapellido_personal_policias', 'like', "%{$search}%")
                    ->orWhere('personalpolicias.segundoapellido_personal_policias', 'like', "%{$search}%")
                    ->orWhere('personalpolicias.primernombre_personal_policias', 'like', "%{$search}%")
                    ->orWhere('personalpolicias.segundonombre_personal_policias', 'like', "%{$search}%");
            });
        }

        // Aplicar ordenación
        $columns = [
            'solicitudvehiculos.id',
            'solicitudvehiculos.created_at',
            'solicitudvehiculos.solicitudvehiculos_fecharequerimiento',
            'personalpolicias.rango_personal_policias',
            'personalpolicias.primerapellido_personal_policias',
            'personalpolicias.segundoapellido_personal_policias',
            'personalpolicias.primernombre_personal_policias',
            'personalpolicias.segundonombre_personal_policias',
            'solicitudvehiculos.solicitudvehiculos_tipo',
            'solicitudvehiculos.solicitudvehiculos_estado'
        ];

        if ($request->has('order')) {
            $orderColumnIndex = intval($request->input('order.0.column', 0));
            $orderDirection = $request->input('order.0.dir', 'asc');

            if (isset($columns[$orderColumnIndex])) {
                $query->orderBy($columns[$orderColumnIndex], $orderDirection);
            }
        }

        // Total de registros
        $recordsFiltered = $query->count();
        $recordsTotal = Solicitudvehiculo::count();

        // Si perPage es 0 o -1, devolver todos los registros sin paginación
        if ($perPage == 0 || $perPage == -1) {
            $vehiculos = $query->with('personal')->get();

            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $vehiculos,
                'currentPage' => 1,
                'lastPage' => 1,
                'perPage' => $vehiculos->count()
            ]);
        }

        // Obtener los registros con paginación
        $vehiculos = $query->with('personal')->paginate($perPage);

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $vehiculos->items(),
            'currentPage' => $vehiculos->currentPage(),
            'lastPage' => $vehiculos->lastPage(),
            'perPage' => $vehiculos->perPage()
        ]);
    }

    public function listarSolicitudesVehiculos(Request $request)
    {
        $defaultPerPage = 10;
        $perPage = $request->input('perPage', $defaultPerPage);
        $estado = $request->input('estado', 'Pendiente');

        $estadosValidos = ['Pendiente', 'Aprobada', 'Anulada', 'Completa', 'Procesando'];
        if (!in_array($estado, $estadosValidos)) {
            $estado = 'Pendiente';
        }

        $query = Solicitudvehiculo::query()
            ->leftJoin('personalpolicia_solicitudvehiculo', 'solicitudvehiculos.id', '=', 'personalpolicia_solicitudvehiculo.solicitudvehiculo_id')
            ->leftJoin('personalpolicias', 'personalpolicia_solicitudvehiculo.personalpolicia_id', '=', 'personalpolicias.id')
            ->select([
                'solicitudvehiculos.*',
                'personalpolicias.rango_personal_policias',
                'personalpolicias.primerapellido_personal_policias',
                'personalpolicias.segundoapellido_personal_policias',
                'personalpolicias.primernombre_personal_policias',
                'personalpolicias.segundonombre_personal_policias'
            ])
            ->where('solicitudvehiculos.solicitudvehiculos_estado', $estado)
            ->where('personalpolicias.rol_personal_policias', 'policia');

        if ($request->has('search.value') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search) {
                $q->where('solicitudvehiculos.id', 'like', "%{$search}%")
                    ->orWhere('solicitudvehiculos.created_at', 'like', "%{$search}%")
                    ->orWhere('solicitudvehiculos.solicitudvehiculos_fecharequerimientodesde', 'like', "%{$search}%")
                    ->orWhere('solicitudvehiculos.solicitudvehiculos_tipo', 'like', "%{$search}%")
                    ->orWhere('solicitudvehiculos.solicitudvehiculos_estado', 'like', "%{$search}%")
                    ->orWhere('personalpolicias.rango_personal_policias', 'like', "%{$search}%")
                    ->orWhere('personalpolicias.primerapellido_personal_policias', 'like', "%{$search}%")
                    ->orWhere('personalpolicias.segundoapellido_personal_policias', 'like', "%{$search}%")
                    ->orWhere('personalpolicias.primernombre_personal_policias', 'like', "%{$search}%")
                    ->orWhere('personalpolicias.segundonombre_personal_policias', 'like', "%{$search}%");
            });
        }

        $columns = [
            'solicitudvehiculos.id',
            'solicitudvehiculos.created_at',
            'solicitudvehiculos.solicitudvehiculos_fecharequerimientodesde',
            'personalpolicias.rango_personal_policias',
            'personalpolicias.primerapellido_personal_policias',
            'personalpolicias.segundoapellido_personal_policias',
            'personalpolicias.primernombre_personal_policias',
            'personalpolicias.segundonombre_personal_policias',
            'solicitudvehiculos.solicitudvehiculos_tipo',
            'solicitudvehiculos.solicitudvehiculos_estado'
        ];

        if ($request->has('order')) {
            $orderColumnIndex = intval($request->input('order.0.column', 0));
            $orderDirection = $request->input('order.0.dir', 'asc');

            if (isset($columns[$orderColumnIndex])) {
                $query->orderBy($columns[$orderColumnIndex], $orderDirection);
            }
        }

        if ($perPage == 0 || $perPage == -1) {
            $vehiculos = $query->with('personal')->get();
            $total = $vehiculos->count();

            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => $total,
                'recordsFiltered' => $total,
                'data' => $vehiculos,
                'currentPage' => 1,
                'lastPage' => 1,
                'perPage' => $total
            ]);
        } else {
            $vehiculos = $query->with('personal')->paginate($perPage);

            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => Solicitudvehiculo::where('solicitudvehiculos_estado', $estado)->count(),
                'recordsFiltered' => $query->count(),
                'data' => $vehiculos->items(),
                'currentPage' => $vehiculos->currentPage(),
                'lastPage' => $vehiculos->lastPage(),
                'perPage' => $vehiculos->perPage()
            ]);
        }
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
        /* $Solicitudvehiculo = Solicitudvehiculo::findOrFail($id);
        return response()->json($Solicitudvehiculo); */
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
    /* public function getSolicitudVehiculoPendientePolicia($personalId): JsonResponse
    {
        // Buscar el PersonalPolicia por ID
        $personalPolicia = Personalpolicia::with('subcircuito.circuito.distrito.provincia')->findOrFail($personalId);

        // Recuperar las solicitudes de vehículos donde el estado es "pendiente"
        $solicitudesPendientes = $personalPolicia->solicitudVehiculo()
            ->where('solicitudvehiculos_estado', 'pendiente')
            //->with('personal') // Si personal tiene relaciones, puedes incluirlas aquí también
            ->get();

        // Agregar información del subcircuito al resultado
        return response()->json([
            'personal' => $personalPolicia,
            'solicitud_pendiente' => $solicitudesPendientes
        ]);
    }
    public function getSolicitudVehiculoAprobadaPolicia($personalId): JsonResponse
    {
        // Buscar el PersonalPolicia por ID
        $personalPolicia = Personalpolicia::with('subcircuito.circuito.distrito.provincia')->findOrFail($personalId);

        // Recuperar las solicitudes de vehículos donde el estado es "pendiente"
        $solicitudesAprobadas = $personalPolicia->solicitudVehiculo()
            ->where('solicitudvehiculos_estado', 'aprobada')
            //->with('personal') // Si personal tiene relaciones, puedes incluirlas aquí también
            ->get();

        // Agregar información del subcircuito al resultado
        return response()->json([
            'personal' => $personalPolicia,
            'solicitud_aprobada' => $solicitudesAprobadas
        ]);
    }
    public function getSolicitudVehiculoCompletaPolicia($personalId): JsonResponse
    {
        // Buscar el PersonalPolicia por ID
        $personalPolicia = Personalpolicia::with('subcircuito.circuito.distrito.provincia')->findOrFail($personalId);

        // Recuperar las solicitudes de vehículos donde el estado es "pendiente"
        $solicitudesCompletas = $personalPolicia->solicitudVehiculo()
            ->where('solicitudvehiculos_estado', 'completa')
            //->with('personal') // Si personal tiene relaciones, puedes incluirlas aquí también
            ->get();

        // Agregar información del subcircuito al resultado
        return response()->json([
            'personal' => $personalPolicia,
            'solicitud_completa' => $solicitudesCompletas
        ]);
    } */

    public function getSolicitudVehiculoPorEstado($personalId, $estado): JsonResponse
    {
        // Validar que el estado sea uno de los permitidos
        $estadosPermitidos = ['pendiente', 'aprobada', 'completa', 'procesando', 'anulada'];
        if (!in_array($estado, $estadosPermitidos)) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => 'Estado no válido. Use: pendiente, aprobada, anulada, procesando o completa.',
            ], 400);
        }

        // Buscar el PersonalPolicia por ID con relaciones
        $personalPolicia = Personalpolicia::with('subcircuito.circuito.distrito.provincia')->find($personalId);

        if (!$personalPolicia) {
            return response()->json([
                'success' => false,
                'status' => 404,
                'message' => 'PersonalPolicia no encontrado.',
            ], 404);
        }

        // Recuperar las solicitudes de vehículos con el estado solicitado
        $solicitudes = $personalPolicia->solicitudVehiculo()
            ->where('solicitudvehiculos_estado', $estado)
            ->get();

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Solicitudes recuperadas exitosamente.',
            'personal' => $personalPolicia,
            'solicitudes' => $solicitudes
        ], 200);
    }


    public function getNumSolicitudesVehiculoPolicia($personalId): JsonResponse
    {
        $personal = Personalpolicia::find($personalId);

        if ($personal) {
            $numeroSolicitudes = $personal->solicitudVehiculo()->count();
        } else {
            $numeroSolicitudes = 0; // Retorna 0 si no se encontró el personal
        }

        return response()->json([
            'personal_id' => $personalId,
            'numero_solicitudes' => $numeroSolicitudes
        ]);
    }

    public function getNumSolicitudesVehiculoPendientesTotal(): JsonResponse
    {
        // Contar todas las solicitudes en estado 'Pendiente'
        $numeroSolicitudes = Solicitudvehiculo::where('solicitudvehiculos_estado', 'Pendiente')->count();

        return response()->json([
            'numero_solicitudes' => $numeroSolicitudes
        ]);
    }
    public function getNumSolicitudesVehiculoAnuladasTotal(): JsonResponse
    {
        // Contar todas las solicitudes en estado 'Pendiente'
        $numeroSolicitudes = Solicitudvehiculo::where('solicitudvehiculos_estado', 'Anulada')->count();

        return response()->json([
            'numero_solicitudes' => $numeroSolicitudes
        ]);
    }
    public function getNumSolicitudesVehiculoAprobadasTotal(): JsonResponse
    {
        // Contar todas las solicitudes en estado 'Pendiente'
        $numeroSolicitudes = Solicitudvehiculo::where('solicitudvehiculos_estado', 'Aprobada')->count();

        return response()->json([
            'numero_solicitudes' => $numeroSolicitudes
        ]);
    }
    public function getNumSolicitudesVehiculoCompletasTotal(): JsonResponse
    {
        // Contar todas las solicitudes en estado 'Pendiente'
        $numeroSolicitudes = Solicitudvehiculo::where('solicitudvehiculos_estado', 'Completa')->count();

        return response()->json([
            'numero_solicitudes' => $numeroSolicitudes
        ]);
    }
    public function getNumSolicitudesVehiculoProcesandoTotal(): JsonResponse
    {
        // Contar todas las solicitudes en estado 'Pendiente'
        $numeroSolicitudes = Solicitudvehiculo::where('solicitudvehiculos_estado', 'Procesando')->count();

        return response()->json([
            'numero_solicitudes' => $numeroSolicitudes
        ]);
    }
    public function aprobarSolicitud(Request $request)
    {
        try {
            DB::beginTransaction(); // Iniciar la transacción

            // Buscar la solicitud por ID
            $solicitud = SolicitudVehiculo::findOrFail($request->solicitud_id);

            // Verificar si la solicitud ya fue aprobada
            if ($solicitud->solicitudvehiculos_estado === 'Aprobada') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Esta solicitud ya fue aprobada.'
                ], 400);
            }

            // Cambiar el estado de la solicitud a 'Aprobada'
            $solicitud->solicitudvehiculos_estado = 'Aprobada';
            $solicitud->save();

            // Buscar el vehículo correspondiente
            $vehiculo = Vehiculo::findOrFail($request->vehiculo_id);

            // Cambiar el estado del vehículo a 'Espera'
            $vehiculo->estado_vehiculos = 'espera';
            $vehiculo->save();

            // Registrar la asignación del vehículo
            $asignacion = Asignacionvehiculo::create([
                'personalpoliciasolicitante_id' => $request->personalpolicia_id,
                'vehiculos_id' => $request->vehiculo_id,
                'asignacionvehiculos_kmrecibido' => $request->kilometraje,
                'asignacionvehiculos_combustiblerecibido' => $request->combustible,
            ]);

            DB::commit(); // Confirmar la transacción

            return response()->json([
                'status' => 'success',
                'message' => 'Solicitud aprobada, vehículo en espera y asignación registrada con éxito.',
                'data' => [
                    'solicitud_id' => $solicitud->id,
                    'asignacion_id' => $asignacion->id,
                    'vehiculo_id' => $vehiculo->id,
                    'estado_vehiculo' => $vehiculo->vehiculos_estado,
                    'personal_policia_id' => $asignacion->personalpolicias_id,
                    'asignacion_fecha' => $asignacion->created_at,
                    'km_actual' => $asignacion->asignacionvehiculos_kmrecibido,
                    'combustible_actual' => $asignacion->asignacionvehiculos_combustible,
                ]
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack(); // Revertir la transacción en caso de error

            return response()->json([
                'status' => 'error',
                'message' => 'Error al procesar la solicitud.',
                'error' => $e->getMessage() // Devuelve el mensaje de error para debugging
            ], 500);
        }
    }
    public function getNumSolicitudesVehiculoPorEstado($personalId, $estado): JsonResponse
    {
        $personal = Personalpolicia::find($personalId);

        if (!$personal) {
            return response()->json([
                'personal_id' => $personalId,
                'numero_solicitudes' => 0
            ]);
        }

        $numeroSolicitudes = Solicitudvehiculo::whereHas('personal', function ($query) use ($personalId) {
            $query->where('personalpolicia_id', $personalId);
        })
            ->where('solicitudvehiculos_estado', $estado)
            ->count();

        return response()->json([
            'personal_id' => $personalId,
            'estado' => $estado,
            'numero_solicitudes' => $numeroSolicitudes
        ]);
    }


}
