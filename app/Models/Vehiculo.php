<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Log;

class Vehiculo extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'marca_vehiculos',
        'tipo_vehiculos',
        'modelo_vehiculos',
        'color_vehiculos',
        'placa_vehiculos',
        'estado_vehiculos',
        'kmactual_vehiculos',
        'combustibleactual_vehiculos'
    ];

    public function personalpolicia(){
        return $this->belongsTo(PersonalPolicia::class);
    }

    public function parqueaderos() {
        return $this->belongsToMany(Parqueadero::class);
    }
    public function subcircuito()
    {
        return $this->belongsToMany(Subcircuitodependencia::class);
    }
    public function espacio()
    {
        return $this->belongsToMany(Espacioparqueadero::class);
    }
    public function asignaciones() {
        return $this->hasMany(Asignacionvehiculo::class);
    }

}
