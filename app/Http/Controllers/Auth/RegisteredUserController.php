<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Personal_policia;
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
        //$estados = Personal_policia::select('rango_personal_policias')->distinct();
        $rangosarray = ["Capitan", "Teniente", "Subteniente", "Sargento Primero", "Sargento Segundo", "Cabo Primero", "Cabo Segundo"];
        $rolesarray = ["administrador", "auxiliar", "gerencia", "policia"];
        $conductorarray = ["no", "si"];
        $tiposangrearray = ["O+","O-","A+","A-","B+","B-","AB+","AB-"];
        //$enumoption = General::getEnumValues('personal_policias','rango_personal_policias') ;
        return view('auth.register',  compact('rangosarray', 'rolesarray', 'conductorarray', 'tiposangrearray'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    //public function store(Request $request): RedirectResponse
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            /*'password' => ['required', 'confirmed', Rules\Password::defaults()],*/
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //event(new Registered($user));
        //Auth::login($user);


        $request["id"]=User::getId($request->name);
        Personal_policia::savepersonalpolicia($request);
        return redirect(route('dashboard', absolute: false));
    }
}
