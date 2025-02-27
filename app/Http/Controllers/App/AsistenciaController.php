<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use App\Models\Personalpolicia;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AsistenciaController extends Controller
{
    //
    public function create($userId = null)
    {
        $userId ??= auth()->id();
        $user = Auth::user();

        return view('asistenciaViews.create', ['userId' => $userId]);
    }
    public function store(Request $request)
    {
        // Iniciar la transacción
        //dd($request);
        DB::beginTransaction();

        try {
            // Validación de los datos
            $validator = Validator::make($request->all(), [
                'personalpolicia_codigo' => 'required|exists:personalpolicias,personalpolicias_codigo',
                'tipoInput' => 'required|in:ingreso,salida', // Añadimos la validación para tipoInput
                'personapolicia_id' => 'required',
            ]);

            // Si la validación falla, lanzar ValidationException
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            // Buscar el personal de policía por el código único
            $personalpolicia = Personalpolicia::where('personalpolicias_codigo', $request->personalpolicia_codigo)->first();


            // Validar que se encontró el personal de policía
            if (!$personalpolicia) {
                throw new \Exception('No se encontró personal de policía con el código único proporcionado.');
            }

            if ($request->tipoInput === 'ingreso') {
                dd($request);
                // Crear la asistencia con la fecha de ingreso
                Asistencia::create([
                    'personalpolicia_id' => $personalpolicia->id,
                    'asistencias_ingreso' => now(), // Usamos now() para la fecha actual
                ]);
            } elseif ($request->tipoInput === 'salida') {
                // Buscar la asistencia existente para el personal de policía
                $asistencia = Asistencia::where('personalpolicia_id', $personalpolicia->id)
                    ->whereNull('asistencias_salida') // Aseguramos que no tenga salida registrada
                    ->latest()
                    ->first();

                if ($asistencia) {
                    // Actualizar la asistencia con la fecha de salida
                    $asistencia->update([
                        'asistencias_salida' => now(), // Usamos now() para la fecha actual
                    ]);
                } else {
                    // Si no se encuentra una asistencia de ingreso, lanzar una excepción
                    throw new \Exception('No se encontró una asistencia de ingreso para registrar la salida.');
                }
            }

            // Confirmar la transacción
            DB::commit();
            session(['mensaje' => 'Asistencia registrada con éxito']);
            // Redirigir en caso de éxito (solo para ValidationException)
            return redirect()->route('dashboard');
            //->with('success', 'Asistencia registrada con éxito');

        } catch (ValidationException $e) {
            // En caso de ValidationException, hacer rollback y redirigir con errores
            DB::rollback();
            return redirect()->back()->withErrors($e->errors())->withInput();

        } catch (QueryException $e) {
            // En caso de QueryException, hacer rollback y redirigir al dashboard
            DB::rollback();
            session(['error' => 'Ocurrió un error en la base de datos.' . $e->getMessage()]);
            return redirect()->route('dashboard');
            //->with('error', 'Ocurrió un error en la base de datos.');

        } catch (\Exception $e) {
            // En caso de cualquier otra excepción, hacer rollback y redirigir al dashboard
            DB::rollback();
            session(['error' => $e->getMessage()]);
            return redirect()->route('dashboard');
            //->with('error', $e->getMessage()); // Mostramos el mensaje de la excepción
        }
    }
}
