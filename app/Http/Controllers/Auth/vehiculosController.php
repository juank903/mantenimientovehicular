<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehiculo;

class vehiculosController extends Controller
{
    public function showallvehiculos()  {
        $vehiculosjson = Vehiculo::all();
        return view('vehiculo.show', compact('vehiculosjson'));
    }

    public function create(Request $request) {
        Vehiculo::savevehiculo($request);
        return redirect(route('vehiculos.view', absolute: false));
    }
}
