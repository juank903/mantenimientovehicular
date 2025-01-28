<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distritodependencia extends Model
{
    //
    use HasFactory;

    public function provincia()
    {
        return $this->belongsTo(Provinciadependencia::class, 'provinciadependencia_id');
    }

    public function circuitos()
    {
        return $this->hasMany(Circuitodependencia::class);
    }
}
