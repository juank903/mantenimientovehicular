<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;



class Quejasugerencia extends Model
{
    //
    //public $timestamps = false;

    public function subcircuitodependencia()
    {
        return $this->belongsToMany(Subcircuitodependencia::class);
    }
}
