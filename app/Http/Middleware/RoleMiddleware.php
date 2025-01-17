<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    /* public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    } */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!auth()->check() || !in_array(auth()->user()->role->name, $roles)) {
            return redirect('/'); // O a donde desees redirigir
        }

        return $next($request);
    }

}
