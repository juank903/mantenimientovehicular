<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;

class vehiculosController extends Controller
{
    public function showallvehiculos()  {
        $vehiculosjson = Vehiculo::all();

        /* return view('personalpolicial.show', [
            'user' => "Estoy aqui"
        ]); */
        return view('vehiculo.show', compact('vehiculosjson'));
        //return gettype($personaljson);

    }
}
