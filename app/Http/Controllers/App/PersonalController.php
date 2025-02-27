<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Libraries\General;
use App\Models\Personalpolicia;
use App\Models\Subcircuitodependencia;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PersonalController extends Controller
{
    /* public static function store(Request $request)
    {
        DB::beginTransaction(); // 🔥 Inicia la transacción

        try {
            // Validación de los datos de entrada
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'provincia' => 'required|integer',
                'distrito' => 'required|integer',
                'circuito' => 'required|integer',
                'subcircuito' => 'required|integer',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required|string|min:8',
                'user_id' => 'required|integer',
                'primernombre' => 'required|string|max:255',
                'segundonombre' => 'nullable|string|max:255',
                'primerapellido' => 'required|string|max:255',
                'segundoapellido' => 'nullable|string|max:255',
                'cedula' => 'required|string|max:10|unique:personalpolicias,cedula_personal_policias',
                'sangre' => 'required|string|max:3',
                'conductor' => 'required|string|max:3',
                'rango' => 'required|string|max:50',
                'rol' => 'required|string|max:50',
                'genero' => 'required|string|max:1',
            ]);

                        // Crear el registro en la tabla personalpolicias
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

            DB::commit(); // ✅ Confirma la transacción

            // Mensaje de éxito en sesión
            session()->flash('success', 'Personal policial y usuario guardados con éxito.');
            return redirect()->route('dashboard');

        } catch (ValidationException $e) {
            DB::rollBack(); // ❌ Revierte la transacción si hay error de validación
            session()->flash('error', 'Errores de validación.');
            session()->flash('validation_errors', $e->errors());
            return redirect()->route('dashboard')->withInput();

        } catch (QueryException $e) {
            DB::rollBack(); // ❌ Revierte la transacción si hay error en la base de datos
            Log::error('Error en la base de datos: ' . $e->getMessage());
            session()->flash('error', 'Error al guardar en la base de datos.');
            return redirect()->route('dashboard');

        } catch (Exception $e) {
            DB::rollBack(); // ❌ Revierte la transacción si hay cualquier otro error
            Log::error('Error inesperado: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error inesperado.');
            return redirect()->route('dashboard');
        }
    } */

    /* protected function getId(string $nombreusuario): int
    {
        $id = Personalpolicia::where("name", $nombreusuario)->first()->id;
        return $id;
    }

    public static function getPersonalIdUsuario(string $idusuario)
    {
        //dd($idusuario);
        $personal = Personalpolicia::where("user_id", $idusuario)->first();
        return $personal->attributes;
    } */
    public function create(): View
    {
        //valores para los select
        $rangosarray = [
            'Capitan',
            'Teniente',
            'Subteniente',
            'Sargento Primero',
            'Sargento Segundo',
            'Cabo Primero',
            'Cabo Segundo',
        ];
        $rolesarray = [
            'administrador',
            'auxiliar',
            'gerencia',
            'policia'
        ];
        $conductorarray = [
            'no',
            'si'
        ];
        $generoarray = [
            'M',
            'F'
        ];
        $tiposangrearray = [
            'O+',
            'O-',
            'A+',
            'A-',
            'B+',
            'B-',
            'AB+',
            'AB-'
        ];
        return view('personalViews.create', compact('rangosarray', 'rolesarray', 'conductorarray', 'tiposangrearray', 'generoarray'));
    }
    public static function store(Request $request)
    {
        DB::beginTransaction(); // 🔥 Inicia la transacción

        try {
            // Validación de los datos de entrada
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'provincia' => 'required|integer',
                'distrito' => 'required|integer',
                'circuito' => 'required|integer',
                'subcircuito' => 'required|integer',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required|string|min:8',
                'primernombre' => 'required|string|max:255',
                'segundonombre' => 'nullable|string|max:255',
                'primerapellido' => 'required|string|max:255',
                'segundoapellido' => 'nullable|string|max:255',
                'cedula' => 'required|string|max:10|unique:personalpolicias,cedula_personal_policias',
                'sangre' => 'required|string|max:3',
                'conductor' => 'required|string|max:3',
                'rango' => 'required|string|max:50',
                'rol' => 'required|string|max:50',
                'genero' => 'required|string|max:1',
            ]);

            // Crear usuario en la tabla users
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'provincia' => $validated['provincia'],
                'distrito' => $validated['distrito'],
                'circuito' => $validated['circuito'],
                'subcircuito' => $validated['subcircuito'],
            ]);

            // Crear el registro en la tabla personalpolicias
            $policia = Personalpolicia::create([
                'user_id' => $user->id,
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

            // Generar el código usando la librería
            $codigo = General::generarCodigo($policia->id);

            // Actualizar el registro con el código generado
            $policia->personalpolicias_codigo = $codigo; // Asegúrate de que este campo exista en tu tabla
            $policia->save();

            // Obtener el subcircuito seleccionado
            $subcircuito = Subcircuitodependencia::findOrFail($validated['subcircuito']);

            // Asociar el personalpolicia con el subcircuito en la tabla pivote
            $policia->subcircuito()->attach($subcircuito->id);

            DB::commit(); // ✅ Confirma la transacción

            // Mensaje de éxito en sesión
            session(['mensaje' => 'Personal policial, usuario y subcircuito asociados con éxito.']);
            return redirect()->route('dashboard');

        } catch (ValidationException $e) {
            DB::rollBack(); // ❌ Revierte la transacción si hay error de validación
            session(['error' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors());

        } catch (QueryException $e) {
            DB::rollBack(); // ❌ Revierte la transacción si hay error en la base de datos
            Log::error('Error en la base de datos: ' . $e->getMessage());
            session(['error' => 'Error al guardar en la base de datos.' . $e->getMessage()]);
            return redirect()->route('dashboard');

        } catch (Exception $e) {
            DB::rollBack(); // ❌ Revierte la transacción si hay cualquier otro error
            Log::error('Error inesperado: ' . $e->getMessage());
            session(['error', 'Ocurrió un error inesperado.' . $e->getMessage()]);
            return redirect()->route('dashboard');
        }
    }

}
