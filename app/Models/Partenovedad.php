<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partenovedad extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si sigue la convención de nombres de Laravel)
    protected $table = 'partenovedades';

    // Campos asignables masivamente
    protected $fillable = [
        'personalpolicia_id',
        'vehiculo_id',
        'asignacionvehiculo_id',
        'partenovedades_detalle',
        'partenovedades_tipo',
        'partenovedades_kilometraje',
        'partenovedades_combustible',
    ];

    // Relaciones (si es necesario)
    public function personalpolicia()
    {
        return $this->belongsTo(Personalpolicia::class, 'personalpolicia_id');
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }

    public function asignacionVehiculo()
    {
        return $this->belongsTo(Asignacionvehiculo::class, 'asignacionvehiculo_id');
    }
}
