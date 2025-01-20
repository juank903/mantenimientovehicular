<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcircuitodependencia extends Model
{
    //
    public function quejasugerencia()
    {
        return $this->belongsToMany(Quejasugerencia::class);
    }
}
