<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subcircuitodependencia;
use Illuminate\Http\Request;

class SubcircuitoController extends Controller
{
    //
    public function index()
    {
        $Subcircuitos = Subcircuitodependencia::all();
        return response()->json($Subcircuitos);
    }
}
