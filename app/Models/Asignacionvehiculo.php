<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignacionvehiculo extends Model
{
    protected $fillable = [
        'vehiculos_id',
        'personalpoliciasolicitante_id',
        'personalpoliciaentrega_id',
        'personalpoliciarecibe_id',
        'asignacionvehiculos_estado',
        'asignacionvehiculos_kmrecibido',
        'asignacionvehiculos_kmentregado',
        'asignacionvehiculos_combustiblerecibido',
        'asignacionvehiculos_combustiblentregado'
    ];
    //
    public function personalpolicia()
    {
        return $this->belongsTo(Personalpolicia::class);
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
}
