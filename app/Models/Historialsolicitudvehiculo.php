<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historialsolicitudvehiculo extends Model
{
    //
    public function personal()
    {
        return $this->belongsTo(Personalpolicia::class);
    }

    public function solicitudvehiculo()
    {
        return $this->belongsTo(Solicitudvehiculo::class);
    }
}
