<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcircuitodependencia extends Model
{
    //
    use HasFactory;
    public function quejasugerencia()
    {
        return $this->belongsToMany(Quejasugerencia::class);
    }
    public function personal()
    {
        return $this->belongsToMany(Personalpolicia::class);
    }

    public function circuito()
    {
        return $this->belongsTo(Circuitodependencia::class, 'circuitodependencia_id');
    }
}
