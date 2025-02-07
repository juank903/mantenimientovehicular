<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\App\PersonalController;
use App\Http\Controllers\Controller;
use App\Models\Personalpolicia;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Libraries\General;

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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //$request["id"] = User::getId($request->name);
        $request->merge(['id' => $user->id]);
        $response = PersonalController::guardarpersonal($request);
        $data = json_decode($response->getContent(), true);
        if ($data['success']) {
            return redirect()->intended(route('dashboard', absolute: false))->with('mensaje', $data['mensaje']);
        } else {
            $response = User::eliminarultimousuarioagreado();
            $data = json_decode($response->getContent(), true);
            if ($data['success']) {
                return redirect()->intended(route('dashboard', absolute: false))->with('error', $data['mensaje']);
            } else {
                return redirect()->intended(route('dashboard', absolute: false))->with('error', $data['mensaje']);
            }
        }
    } */
    public function store(Request $request): RedirectResponse
{
    // Validación de los datos del formulario
    $validatedData = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    // Creación del usuario
    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
    ]);

    // Asignar el ID del usuario al request
    $request->merge(['user_id' => $user->id]);

    // Llamar al controlador PersonalController para guardar información adicional
    $response = PersonalController::guardarpersonal($request);
    $data = json_decode($response->getContent(), true);

    // Manejo de la respuesta
    if ($data['success']) {
        return redirect()->intended(route('dashboard'))->with('mensaje', $data['mensaje']);
    } else {
        // Si falla, eliminar el usuario recién creado
        $deleteResponse = User::eliminarultimousuarioagreado();
        $deleteData = json_decode($deleteResponse->getContent(), true);

        $message = $deleteData['success'] ? $deleteData['mensaje'] : 'Error al eliminar el usuario.';
        return redirect()->intended(route('dashboard'))->with('error', $message);
    }
}
}
