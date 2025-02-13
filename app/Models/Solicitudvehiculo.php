<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class Solicitudvehiculo extends Model
{
    protected $fillable = [
        'solicitudvehiculos_detalle',
        'solicitudvehiculos_tipo',
        'solicitudvehiculos_fecharequerimientodesde',
        'solicitudvehiculos_fecharequerimientohasta',
        'solicitudvehiculos_jornada',
        'solicitudvehiculos_estado'
    ];
    public function personal()
    {
        return $this->belongsToMany(Personalpolicia::class);
    }
    public function historialsolicitudvehiculo()
    {
        return $this->hasOne(HistorialSolicitudVehiculo::class);
    }
}
