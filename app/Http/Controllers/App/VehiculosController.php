<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Vehiculo;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Log;

class VehiculosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        //valores para los select
        $tipovehiculoarray = [
            'Moto',
            'Camioneta',
            'Vehiculo',
        ];
        $combustiblearray = [
            'cuarto',
            'medio',
            'tres cuartos',
            'full',
        ];
        return view('vehiculosViews.create', compact('tipovehiculoarray', 'combustiblearray'));
    }

    public function store(Request $request): RedirectResponse // Cambia el tipo de retorno a RedirectResponse
    {
        try {
            // Validación de datos
            $request->validate([
                'marca_vehiculos' => 'required|string|max:255',
                'tipo_vehiculos' => 'required|string|max:50|in:Camioneta,Auto,Moto',
                'modelo_vehiculos' => 'required|string|max:50',
                'color_vehiculos' => 'required|string|max:30',
                'placa_vehiculos' => 'required|string|max:10|unique:vehiculos,placa_vehiculos',
                'kmactual_vehiculos' => 'required|integer|min:0',
                'combustibleactual_vehiculos' => 'required|string|max:20|in:cuarto,medio,tres cuartos,full',
                'subcircuito' => 'required|integer',
                'subcircuito.*' => 'exists:subcircuitos,id',
            ]);

            DB::beginTransaction();

            $vehiculo = new Vehiculo;
            $vehiculo->fill($request->all());
            $vehiculo->save();

            $subcircuitoIds = $request->input('subcircuito');
            $vehiculo->subcircuito()->attach($subcircuitoIds);

            DB::commit();

            // Redirección con mensaje en la sesión
            session(['mensaje' => 'Vehículo guardado con éxito']);
            return redirect()->route('dashboard'); // Redirecciona a la ruta 'dashboard'

        } catch (ValidationException $e) {
            DB::rollBack();
            // Redirección con errores de validación en la sesión
            return back()->withErrors($e->errors())->withInput(); // Redirecciona a la página anterior con errores
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Error al guardar el vehículo: ' . $e->getMessage());
            // Redirección con mensaje de error en la sesión
            session(['error' => 'Error en la base de datos']);
            return back()->withInput(); // Redirecciona a la página anterior
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error inesperado: ' . $e->getMessage());
            // Redirección con mensaje de error en la sesión
            session(['error' => 'Error inesperado']);
            return back()->withInput(); // Redirecciona a la página anterior
        }
    }
}
