<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignacionvehiculo extends Model
{
    protected $fillable = [
        'personalpolicias_id',
        'vehiculos_id',
        'asignacionvehiculos_estado',
        'asignacionvehiculos_kmrecibido',
        'asignacionvehiculos_kmentregado',
        'asignacionvehiculos_combustible',
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
