<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Espacioparqueadero extends Model
{
    //
    public function parqueadero()
    {
        return $this->belongsToMany(Parqueadero::class);
    }
    public function espacioparqueadero()
    {
        return $this->belongsToMany(Espacioparqueadero::class)
            ->withTimestamps();
    }
}
