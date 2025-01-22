<?php

namespace App\Models;

use Faker\Core\Number;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Personalpolicia extends Model
{
    public $timestamps = false;
    public function vehiculo(){
        return $this->hasOne(Vehiculo::class);
    }
    protected function savepersonalpolicia(Request $request): void{
        $policia = new Personalpolicia;
        $policia->iduser_personal_policias = $request-> id;
        $policia->primernombre_personal_policias = $request-> primernombre;
        $policia->segundonombre_personal_policias = $request-> segundonombre;
        $policia->primerapellido_personal_policias = $request-> primerapellido;
        $policia->segundoapellido_personal_policias = $request-> segundoapellido;
        $policia->cedula_personal_policias = $request-> cedula;
        $policia->tiposangre_personal_policias = $request-> sangre;
        $policia->conductor_personal_policias = $request-> conductor;
        $policia->rango_personal_policias = $request-> rango;
        $policia->rol_personal_policias = $request-> rol;
        $policia->save();
    }
    protected function getId(string $nombreusuario): int{
        $id = self::where("name", $nombreusuario)->first()->id;
        return $id;
    }

    protected function getPersonal(string $idusuario) {
        $personal = self::where("iduser_personal_policias", $idusuario)->first();
        return $personal->attributes;
    }
}
