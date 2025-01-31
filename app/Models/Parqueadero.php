<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parqueadero extends Model
{
    //
    use HasFactory;

    public function vehiculos() {
        return $this->belongsToMany(Vehiculo::class);
    }
    public function subcircuitos() {
        return $this->belongsToMany(Subcircuitodependencia::class);
    }
}
