<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Vehiculo;
use Log;

class VehiculosController extends Controller
{
    /* public function guardarvehiculo(Request $request): RedirectResponse {
        $response = Vehiculo::guardarvehiculo($request);
        $data = json_decode($response->getContent(), true);
        if($data['success']){
            return redirect()->intended(route('dashboard', absolute: false))->with($data);
        }
        else {
            return redirect()->intended(route('dashboard', absolute: false))->with($data);
        }
    } */

    protected function guardarvehiculo(Request $request): JsonResponse
    {
        try {
            // Validar los datos del request aquí si es necesario
            /* $request->validate([
                'marca' => 'required|string|max:255',
                'placa' => 'required|string|max:10|unique:vehiculos,placa_vehiculos',
                'tipo' => 'required|string|max:50',
                'modelo' => 'required|string|max:50',
                'color' => 'required|string|max:30',
            ]); */

            $vehiculo = new Vehiculo;
            $vehiculo->marca_vehiculos = $request->marca;
            $vehiculo->placa_vehiculos = $request->placa;
            $vehiculo->tipo_vehiculos = $request->tipo;
            $vehiculo->modelo_vehiculos = $request->modelo;
            $vehiculo->color_vehiculos = $request->color;

            $vehiculo->save(); // Guardar el vehículo en la base de datos

            // Retornar un JSON de éxito con el campo success
            return response()->json([
                'success' => true,
                'mensaje' => 'Vehículo guardado con éxito',
                'vehiculo' => $vehiculo // Puedes incluir el objeto guardado si lo deseas
            ], 201); // Código 201 indica que se ha creado un recurso

        } catch (QueryException $e) {
            // Manejo de errores de base de datos
            Log::error('Error al guardar el vehículo: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Error en la base de datos.'], 500); // Código 500 para error de base de datos
        } catch (\Exception $e) {
            // Manejo de cualquier otra excepción
            Log::error('Error inesperado: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Error inesperado al guardar el vehículo.'], 500); // Código 500 para error inesperado
        }
    }
}
