<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckBloqued
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::attempt($request->only('email', 'password'))) {
            if (auth()->check() && auth()->user()->bloqueado) {

                $user = Auth::user()->nombre;
                Auth::logout();
                return redirect('/')->with('error', __('alerts.user_blocked', ['name' => $user]));
            }
        }

        return $next($request);
    }
}
