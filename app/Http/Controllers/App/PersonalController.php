<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Personalpolicia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    public function index()
    {

    }
    public static function guardarpersonal(Request $request): JsonResponse
    {
        try {
            // Validación de los datos de entrada
            /* $request->validate([
                'id' => 'required|integer',
                'primernombre' => 'required|string|max:255',
                'segundonombre' => 'nullable|string|max:255',
                'primerapellido' => 'required|string|max:255',
                'segundoapellido' => 'nullable|string|max:255',
                'cedula' => 'required|string|max:20|unique:personalpolicias,cedula_personal_policias',
                'sangre' => 'required|string|max:10',
                'conductor' => 'required|boolean',
                'rango' => 'required|string|max:50',
                'rol' => 'required|string|max:50',
            ]); */

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
        $id = Personalpolicia::where("name", $nombreusuario)->first()->id;
        return $id;
    }

    public static function getPersonalIdUsuario(string $idusuario)
    {
        //dd($idusuario);
        $personal = Personalpolicia::where("user_id", $idusuario)->first();
        return $personal->attributes;
    }

}
