<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectDashboardIfPolicia
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
        if ($user->rol() === 'policia') { // Asume que el rol está en una propiedad `rol`
            return redirect()->route('policia.dashboard');
        }

        return $next($request);

    }
}
