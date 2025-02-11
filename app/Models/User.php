<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function personalpolicia(): HasOne
    {
        return $this->hasOne(Personalpolicia::class);
    }

    public function rol()
    {
        // Devuelve el rol o un valor predeterminado
        return $this->personalpolicia ? $this->personalpolicia->rol_personal_policias : 'Rol no asignado'; // Cambia 'Rol no asignado' por lo que desees
    }

    protected function getId(string $nombreusuario): int
    {
        $id = self::where("name", $nombreusuario)->first()->id;
        return $id;
    }

}
