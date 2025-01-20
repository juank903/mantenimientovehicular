<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Quejasugerencia extends Model
{
    //
    public $timestamps = false;
    protected function create($request){
        $queja = new Quejasugerencia();
        $queja->id_subcircuito = $request->subcircuito;
        $queja->detalle_quejasugerencias = $request->detalle;
        $queja->tipo_quejasugerencias = $request->tipoqueja;
        $queja->apellidos_quejasugerencias = $request->apellidos;
        $queja->nombres_quejasugerencias = $request->nombres;
        $queja->save();
    }
}
