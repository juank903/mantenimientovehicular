<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

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
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (session('rolusuario')!== $roles) {
            // Optionally, you can redirect to a specific page or return a 403 response
            //abort(403, 'Unauthorized action.');
            return redirect('/');
        }

        return $next($request);
    }

}
