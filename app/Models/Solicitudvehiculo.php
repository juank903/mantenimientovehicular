<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class Solicitudvehiculo extends Model
{
    public function personal()
    {
        return $this->belongsToMany(Personalpolicia::class);
    }
    public function historialsolicitudvehiculo()
    {
        return $this->hasOne(HistorialSolicitudVehiculo::class);
    }
}
