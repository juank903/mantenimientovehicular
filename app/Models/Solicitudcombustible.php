<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitudcombustible extends Model
{
    use HasFactory;

    protected $fillable = [
        'asignacionvehiculo_id',
        'personalpolicia_id',
        'solicitudcombustible_cantidad',
        'solicitudcombustible_motivo',
        'solicitudcombustible_estado',
        'solicitudcombustible_km',
        'solicitudcombustible_tipo',
    ];
}
