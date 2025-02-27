<?php

namespace App\Models;

use App\Models\Solicitudvehiculo;
use App\Models\Subcircuitodependencia;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Personalpolicia extends Model
{
    use SoftDeletes;
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
    public function asignacionVehiculo()
    {
        return $this->hasMany(Asignacionvehiculo::class, 'personalpoliciasolicitante_id');
    }

    public function entregas()
    {
        return $this->hasMany(Asignacionvehiculo::class, 'personalpoliciaentrega_id');
    }

    public function recepciones()
    {
        return $this->hasMany(Asignacionvehiculo::class, 'personalpoliciarecibe_id');
    }
}
