<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignacionvehiculo extends Model
{
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
