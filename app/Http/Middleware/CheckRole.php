<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {

        if (auth()->check() && auth()->user()->bloqueado) {
            return redirect('/')->with('error', 'Tu cuenta está bloqueada.');
        }

        if (auth()->check() && auth()->user()->rol === $role) {
            return $next($request);
        }

        // Redirige si el usuario no tiene el rol requerido
        return redirect('/')->with('error', 'No tienes permiso para acceder a esta página.');
  
    }
}
