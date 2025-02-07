<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Personalpolicia;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    public function index()
    {

    }
    public static function guardarpersonal(Request $request): JsonResponse
    {
        //dd($request);
        try {
            // Validación de los datos de entrada
            $validated = $request->validate([
                'user_id' => 'required|integer',
                'primernombre' => 'required|string|max:255',
                'segundonombre' => 'nullable|string|max:255',
                'primerapellido' => 'required|string|max:255',
                'segundoapellido' => 'nullable|string|max:255',
                'cedula' => 'required|string|max:10|unique:personalpolicias,cedula_personal_policias',
                //'cedula' => 'required|string|max:10',
                'sangre' => 'required|string|max:3',
                'conductor' => 'required|string|max:3',
                'rango' => 'required|string|max:50',
                'rol' => 'required|string|max:50',
                'genero' => 'required|string|max:1',
            ]);

            $policia = Personalpolicia::create([
                'user_id' => $validated['user_id'],
                'primernombre_personal_policias' => $validated['primernombre'],
                'segundonombre_personal_policias' => $validated['segundonombre'],
                'primerapellido_personal_policias' => $validated['primerapellido'],
                'segundoapellido_personal_policias' => $validated['segundoapellido'],
                'cedula_personal_policias' => $validated['cedula'],
                'tiposangre_personal_policias' => $validated['sangre'],
                'conductor_personal_policias' => $validated['conductor'],
                'rango_personal_policias' => $validated['rango'],
                'rol_personal_policias' => $validated['rol'],
                'personalpolicias_genero' => $validated['genero'],
            ]);

            return response()->json([
                'success' => true,
                'mensaje' => 'Personal policial guardado con éxito',
                'personal' => $policia,
            ], 201);

        } catch (Exception $e) {
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
