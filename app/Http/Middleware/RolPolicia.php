<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolPolicia
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // Obtener el rol del usuario
            $rolUsuario = Auth::user()->rol();
            // Si el rol es 'policia', denegar el acceso
            if ($rolUsuario === 'policia') {
                //return response()->json(['mensaje' => 'Acceso denegado: no tienes permiso para acceder a esta ruta.'], 403);
                return redirect()->route('dashboard')->with('error', 'Acceso denegado: no tienes permiso para acceder a esta ruta.');
            }
        }

        // Si el rol no es 'policia', continuar con la siguiente solicitud
        return $next($request);
    }
}
