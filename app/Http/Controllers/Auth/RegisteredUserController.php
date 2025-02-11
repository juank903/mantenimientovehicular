<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\App\PersonalController;
use App\Http\Controllers\App\PersonalpoliciaSubcircuitodependenciaController;
use App\Http\Controllers\App\UserController;
use App\Http\Controllers\Controller;
use App\Libraries\General;
use App\Models\Personalpolicia;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
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

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    /* public function store(Request $request): RedirectResponse
    {
        try {
            // Validación de datos
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            // Crear usuario
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);
            // Llamar al controlador PersonalController para guardar información adicional
            $request->merge(['user_id' => $user->id]);
            $response = PersonalController::guardarpersonal($request);
            $data = json_decode($response->getContent(), true);

            if (!$data['success']) {
                throw new \Exception('Error al guardar información personal.');
            }
            // Actualizar integridad de datos en PersonalpoliciaSubcircuitodependenciaController
            $request->merge(['id' => User::latest()->first()->personalpolicia->id]);
            $response = PersonalpoliciaSubcircuitodependenciaController::actualizarIntegridadId($request);
            $data = json_decode($response->getContent(), true);

            if (!$data['success']) {
                throw new \Exception('Problemas actualizando la integridad.');
            }

            session(['mensaje' => $data['mensaje']]);
            return redirect()->route('dashboard');
            //->with('mensaje', $data['mensaje']);

        } catch (\Exception $e) {
            // Eliminar usuario en caso de error
            $deleteResponse = UserController::eliminarUltimoUsuarioAgregado();
            $deleteData = json_decode($deleteResponse->getContent(), true);

            $errorMessage = $deleteData['success'] ? $deleteData['mensaje'] : 'Error al eliminar el usuario.';
            session(['error' => $e->getMessage() . ' - ' . $errorMessage]);
            return redirect()->route('dashboard');
            //->with('error', $e->getMessage() . ' ' . $errorMessage);
        }
    } */


    public function store(Request $request): RedirectResponse
    {
        DB::beginTransaction(); // Inicia la transacción

        try {
            // Validación de datos (sin cambios)
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', 'min:8', Rules\Password::defaults()],
            ]);

            // Crear usuario
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            // Llamar al controlador PersonalController para guardar información adicional
            $request->merge(['user_id' => $user->id]);
            $response = PersonalController::guardarpersonal($request);
            $data = json_decode($response->getContent(), true);

            if (!$data['success']) {
                throw new \Exception('Error al guardar información personal: ' . $data['error']); // Incluye el mensaje de error del controlador
            }

            // Actualizar integridad de datos en PersonalpoliciaSubcircuitodependenciaController
            $request->merge(['id' => $user->personalpolicia->id]); // Usa la relación directamente
            $response = PersonalpoliciaSubcircuitodependenciaController::create($request);
            $data = json_decode($response->getContent(), true);

            if (!$data['success']) {
                throw new \Exception('Problemas actualizando la integridad: ' . $data['error']); // Incluye el mensaje de error del controlador
            }

            DB::commit(); // Confirma la transacción si todo va bien

            session(['mensaje' => $data['mensaje']]);
            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción en caso de error

            // Log del error para depuración
            Log::error($e);

            // Mensaje de error para el usuario (puedes personalizarlo)
            $errorMessage = 'Ocurrió un error al crear el usuario. Intente nuevamente.';
            if (config('app.debug')) { // Solo mostrar el mensaje real en desarrollo.
                $errorMessage = $e->getMessage();
            }

            session(['error' => $errorMessage]);
            return redirect()->route('dashboard');
        }
    }
}
