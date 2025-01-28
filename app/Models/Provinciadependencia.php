<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinciadependencia extends Model
{
    //
    use HasFactory;

    public function distritos()
    {
        return $this->hasMany(Distritodependencia::class);
    }
}
