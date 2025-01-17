<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Vehiculo extends Model
{
    //
    public $timestamps = false;

    protected function savevehiculo(Request $request): void{
        $vehiculo = new Vehiculo;
        $vehiculo->marca_vehiculos = $request-> marca;
        $vehiculo->placa_vehiculos = $request-> placa;
        $vehiculo->tipo_vehiculos = $request-> tipo;
        $vehiculo->modelo_vehiculos = $request-> modelo;
        $vehiculo->color_vehiculos = $request-> color;
        $vehiculo->save();
    }

}
