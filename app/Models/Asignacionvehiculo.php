<?php

namespace App\Models;

use App\Models\Partenovedad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    public function personalpolicia(): BelongsTo
    {
        return $this->belongsTo(Personalpolicia::class);
    }

    public function vehiculo(): BelongsTo
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculos_id');
    }
    public function solicitante(): BelongsTo
    {
        return $this->belongsTo(Personalpolicia::class, 'personalpoliciasolicitante_id');
    }

    public function entrega(): BelongsTo
    {
        return $this->belongsTo(Personalpolicia::class, 'personalpoliciaentrega_id');
    }

    public function recibe(): BelongsTo
    {
        return $this->belongsTo(Personalpolicia::class, 'personalpoliciarecibe_id');
    }

    public function partenovedades()
    {
        return $this->hasMany(Partenovedad::class, 'asignacionvehiculo_id');
    }

    public function combustible()
    {
        return $this->belongsTo(Solicitudcombustible::class, 'asignacionvehiculo_id');
    }
}
