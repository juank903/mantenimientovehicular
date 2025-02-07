<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public static function eliminarUltimoUsuarioAgregado(): JsonResponse
    {
        try {
            $ultimoRegistro = User::latest()->first();

            if ($ultimoRegistro) {
                $ultimoRegistro->delete();
                return response()->json([
                    'success' => true,
                    'mensaje' => 'Eliminado usuario creado para mantener la integridad',
                    'error' => 'Tuvo problemas al ingresar Personal Policial',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'No hay usuarios para eliminar',
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al eliminar el usuario agregado: ' . $e->getMessage(),
            ], 500);
        }
    }
}
