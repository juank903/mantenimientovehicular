<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use App\Models\User;
//use Illuminate\Support\Facades\Auth;

use Symfony\Component\HttpFoundation\Response;

class RolPoliciaMiddelware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado y rol policia

        if ($request->id && User::find($request->id)->rol() === 'policia') {
            //$rol = User::find($request->id)->rol();
            return $next($request);
        }else{
            session('personal');
            session('rolusuario');
            session('subcircuito');
            //return redirect()->route('dashboard')->with('error', 'Acceso denegado: no tienes permiso para acceder a esta ruta.');
            return response()->view('auth.dashboard', [
                'error' => 'Acceso Prohibido'
            ], 403);
        }

        /* if (isset($rol) && $rol === 'policia') {
            //return response()->json(['mensaje' => 'estas logueado como: '. User::find($request->id)->rol() .' pasa dato'], 400);
            return $next($request);
        } else {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado: no tienes permiso para acceder a esta ruta.');
        } */
    }
}
