<?php

namespace App\Models;

use Faker\Core\Number;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Solicitudvehiculo;
use App\Models\Subcircuitodependencia;

class Personalpolicia extends Model
{
    public $timestamps = false;
    public function vehiculo()
    {
        return $this->hasOne(Vehiculo::class);
    }

    public function subcircuito()
    {
        return $this->belongsToMany(Subcircuitodependencia::class);
    }

    public function solicitudVehiculo()
    {
        return $this->belongsToMany(SolicitudVehiculo::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
/*     protected function guardarpersonal(Request $request): JsonResponse
    {
        try {
            // Validación de los datos de entrada
            $policia = new Personalpolicia;
            $policia->user_id = $request->id;
            $policia->primernombre_personal_policias = $request->primernombre;
            $policia->segundonombre_personal_policias = $request->segundonombre;
            $policia->primerapellido_personal_policias = $request->primerapellido;
            $policia->segundoapellido_personal_policias = $request->segundoapellido;
            $policia->cedula_personal_policias = $request->cedula;
            $policia->tiposangre_personal_policias = $request->sangre;
            $policia->conductor_personal_policias = $request->conductor;
            $policia->rango_personal_policias = $request->rango;
            $policia->rol_personal_policias = $request->rol;

            $policia->save();

            return response()->json([
                'success' => true,
                'mensaje' => 'Personal policial guardado con éxito',
                'personal' => $policia
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Error al guardar el personal policial.'], 500);
        }
    }
    protected function getId(string $nombreusuario): int
    {
        $id = self::where("name", $nombreusuario)->first()->id;
        return $id;
    }

    public function getPersonalIdUsuario(string $idusuario)
    {
        $personal = self::where("user_id", $idusuario)->first();
        return $personal->attributes;
    } */
}
