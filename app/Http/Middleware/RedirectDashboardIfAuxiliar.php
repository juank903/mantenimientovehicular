<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectDashboardIfAuxiliar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = auth()->user();

        // Verificar si el usuario tiene el rol de "policia"
        if ($user->rol() === 'auxiliar') { // Asume que el rol está en una propiedad `rol`
            return redirect()->route('auxiliar.dashboard');
        }

        return $next($request);

    }
}
