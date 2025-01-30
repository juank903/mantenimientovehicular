<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Personalpolicia;
use App\Models\Solicitudvehiculo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
            ->where('solicitudvehiculos.solicitudvehiculos_estado', 'Pendiente') // Solo solicitudes pendientes
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

        if ($perPage == 0) {
            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => [],
                'currentPage' => 1,
                'lastPage' => 1,
                'perPage' => 0
            ]);
        }

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
    public function getSolicitudVehiculoPendientePolicia($personalId): JsonResponse
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
    public function getNumSolicitudesVehiculoAnuladasPolicia($personalId): JsonResponse
    {
        $personal = Personalpolicia::find($personalId);

        if ($personal) {
            $numeroSolicitudes = Solicitudvehiculo::whereHas('personal', function ($query) use ($personalId) {
                $query->where('personalpolicia_id', $personalId);
            })
                ->where('solicitudvehiculos_estado', 'Anulada')
                ->count();
        } else {
            $numeroSolicitudes = 0; // Retorna 0 si no se encontró el personal
        }

        return response()->json([
            'personal_id' => $personalId,
            'numero_solicitudes' => $numeroSolicitudes
        ]);
    }
    public function getNumSolicitudesVehiculoPendientesPolicia($personalId): JsonResponse
    {
        $personal = Personalpolicia::find($personalId);

        if ($personal) {
            $numeroSolicitudes = Solicitudvehiculo::whereHas('personal', function ($query) use ($personalId) {
                $query->where('personalpolicia_id', $personalId);
            })
                ->where('solicitudvehiculos_estado', 'Pendiente')
                ->count();
        } else {
            $numeroSolicitudes = 0; // Retorna 0 si no se encontró el personal
        }

        return response()->json([
            'personal_id' => $personalId,
            'numero_solicitudes' => $numeroSolicitudes
        ]);
    }
    public function getNumSolicitudesVehiculoAprobadasPolicia($personalId): JsonResponse
    {
        $personal = Personalpolicia::find($personalId);

        if ($personal) {
            $numeroSolicitudes = Solicitudvehiculo::whereHas('personal', function ($query) use ($personalId) {
                $query->where('personalpolicia_id', $personalId);
            })
                ->where('solicitudvehiculos_estado', 'Aprobada')
                ->count();
        } else {
            $numeroSolicitudes = 0; // Retorna 0 si no se encontró el personal
        }

        return response()->json([
            'personal_id' => $personalId,
            'numero_solicitudes' => $numeroSolicitudes
        ]);
    }
}
