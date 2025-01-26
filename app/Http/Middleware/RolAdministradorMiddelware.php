<?php

namespace App\Http\Middleware;

use App\Models\User;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\HttpFoundation\Response;

class RolAdministradorMiddelware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        session('personal');
        session('rolusuario');
        session('subcircuito');
        // Verificar si el usuario está autenticado y rol policia
        if (session('rolusuario') === 'administrador') {
            //$rol = User::find($request->id)->rol();
            return $next($request);
        }else{
            session('personal');
            session('rolusuario');
            session('subcircuito');
            //return redirect()->route('dashboard')->with('error', 'Acceso denegado: no tienes permiso para acceder a esta ruta.');
            return response()->view('login', [
                'error' => 'Acceso Prohibido administrador'
            ], 403);
        }
    }
}
