<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiUserController extends Controller
{
    //
    public function destroy($id)
    {
        try {
            // Encuentra el registro a eliminar
            $modelo = User::find($id);

            // Verifica si el registro existe
            if (!$modelo) {
                return response()->json(['mensaje' => 'Registro no encontrado'], 404);
            }

            // Inicia una transacción para asegurar la integridad de la base de datos
            DB::beginTransaction();

            // Elimina el registro y sus relaciones
            $modelo->delete();

            // Si necesitas eliminar relaciones específicas, puedes hacerlo aquí
            // Por ejemplo:
            $modelo->personalpolicia()->delete();

            // Si deseas realizar soft delete en tablas pivote, puedes hacerlo aquí
            // Por ejemplo:
            // $modelo->relacionMuchosAMuchos()->detach();

            DB::commit();

            return response()->json(['mensaje' => 'Registro eliminado correctamente'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al eliminar el registro: ' . $e->getMessage()], 500);
        }
    }
}
