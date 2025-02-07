<?php

namespace App\Models;

use Faker\Core\Number;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Solicitudvehiculo;
use App\Models\Subcircuitodependencia;

class Personalpolicia extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'primernombre_personal_policias',
        'segundonombre_personal_policias',
        'primerapellido_personal_policias',
        'segundoapellido_personal_policias',
        'cedula_personal_policias',
        'tiposangre_personal_policias',
        'conductor_personal_policias',
        'rango_personal_policias',
        'rol_personal_policias',
        'personalpolicias_genero',
    ];
    public function vehiculo()
    {
        return $this->hasOne(Vehiculo::class);
    }

    public function subcircuito()
    {
        return $this->belongsToMany(Subcircuitodependencia::class);
    }

    public function solicitudVehiculo()
    {
        return $this->belongsToMany(SolicitudVehiculo::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
