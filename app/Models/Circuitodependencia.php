<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circuitodependencia extends Model
{
    //
    use HasFactory;

    public function distrito()
    {
        return $this->belongsTo(Distritodependencia::class, 'distritodependencia_id');
    }

    public function subcircuitos()
    {
        return $this->hasMany(Subcircuitodependencia::class);
    }
}
