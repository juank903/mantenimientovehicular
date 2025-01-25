<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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

    protected function eliminarultimousuarioagreado(): JsonResponse
    {
        try {
            $ultimoRegistro = User::latest()->first();
            $ultimoRegistro->delete();
            return response()->json([
                'success' => true,
                'mensaje' => 'Eliminado usuario creado para mantener la integridad',
                'error' => 'Tuvo problemas al ingresar Personal Policial',
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Error al eliminar el usuario agregado'], 500);
        }
    }
}
