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
        $roles = ['administrador', 'gerente'];
        if ((!auth()->check() && !in_array(User::role(), $roles))|| true) {
        //if(true){
            echo"hola";
            var_dump(User::role());
            //echo auth()->user()->role->name;
            //return redirect('/login');
        }

        return $next($request);
    }

}
