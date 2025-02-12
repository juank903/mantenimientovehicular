<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Log;

class Vehiculo extends Model
{
    //
    use HasFactory;
    public $timestamps = false;

    public function personalpolicia(){
        return $this->belongsTo(PersonalPolicia::class);
    }

    public function parqueaderos() {
        return $this->belongsToMany(Parqueadero::class);
    }
    public function subcircuito()
    {
        return $this->belongsToMany(Subcircuitodependencia::class);
    }
    public function espacio()
    {
        return $this->belongsToMany(Espacioparqueadero::class);
    }

}
