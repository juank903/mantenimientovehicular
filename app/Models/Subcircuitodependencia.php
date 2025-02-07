<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subcircuitodependencia extends Model
{
    //
    use HasFactory;
    public function quejasugerencia(): BelongsToMany
    {
        return $this->belongsToMany(Quejasugerencia::class);
    }
    public function personal(): BelongsToMany
    {
        return $this->belongsToMany(Personalpolicia::class);
    }

    public function circuito(): BelongsTo
    {
        return $this->belongsTo(Circuitodependencia::class, 'circuitodependencia_id');
    }
    public function parqueaderos(): BelongsToMany
    {
        return $this->belongsToMany(Parqueadero::class);
    }
}
