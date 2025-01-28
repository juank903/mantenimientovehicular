<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Personalpolicia;
use Illuminate\Http\Request;

class ApiPersonalpoliciaController extends Controller
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
    public function show(string $id)
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
