<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'personalpolicia_id',
        'asistencias_ingreso',
        'asistencias_salida',
        'asistencias_tipo',
        'asistencias_modificadopor',
        'asistencias_razon',
    ];

    public function personalpolicia()
    {
        return $this->belongsTo(Personalpolicia::class, 'personalpolicia_id');
    }
}
