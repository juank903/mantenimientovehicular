<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Personalpolicia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    /* public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    } */

    public function edit(Request $request, $user_id = null): View
{
    // Obtén el userId del parámetro o del usuario autenticado
    $user_id = $request->input('user_id') ?? Auth::id();

    $personalpolicia = Personalpolicia::select([
        'id',
        'user_id',
        'primernombre_personal_policias',
        'segundonombre_personal_policias',
        'primerapellido_personal_policias',
        'segundoapellido_personal_policias',
        'cedula_personal_policias',
        'tiposangre_personal_policias',
        'conductor_personal_policias',
        'rango_personal_policias',
        'rol_personal_policias',
        'personalpolicias_genero',
        'deleted_at'
    ])->where('id', $user_id)->first(); // Usa where para buscar por user_id

    return view('profile.edit', [
        'user' => $request->user(),
        'personalpolicia' => $personalpolicia,
        'user_d' => $user_id
    ]);
}


    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
