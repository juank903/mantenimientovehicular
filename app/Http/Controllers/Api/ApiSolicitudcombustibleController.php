<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiSolicitudcombustibleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    public function conteo(Request $request, $userId = null)
    {
        $estado = $request->query('estado');
        //dd($estado);

        // Si no se proporciona userId, usa el usuario autenticado
        $userId = $userId ?? auth()->id();

        $query = DB::table('solicitudcombustibles');

        if ($estado) {
            $query->where('solicitudcombustible_estado', $estado);
        }

        // Filtra por userId si se proporciona
        if ($userId) {
            $query->where('solicitudcombustibles.personalpolicia_id', $userId); // Ajusta el nombre de la columna según tu esquema
        }

        $cantidad = $query->count();

        // Verifica si no se encontraron solicitudes
        if ($cantidad === 0) {
            return response()->json(['estado' => $estado, 'cantidad' => 0]);
        }

        return response()->json(['estado' => $estado, 'cantidad' => $cantidad]);
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
