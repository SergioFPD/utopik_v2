<?php

namespace App\Http\Middleware;

use App\Models\Experiencia;
use Closure;
use Illuminate\Http\Request;
use App\Models\Pais;
use Symfony\Component\HttpFoundation\Response;

class CheckCountry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Verificar cuando se pasa el nombre del país
        if ($request->route('country')) {
            // Obtener el nombre del país
            $countryName = $request->route('country');
            // Buscar el país en la base de datos
            $country = Pais::where('pais', $countryName)->first();

            // Verificar si el país existe y está activado
            if (!$country || !$country->activo) {
                return redirect('/');
            }
        }

        // Verificar cuando se pasa el nombre de la experiencia
        if ($request->route('experience')) {
            // Obtener el nombre de la experiencia
            $experienceName = $request->route('experience');
            // Buscar el país en la base de datos
            $experience = Experiencia::where('nombre', $experienceName)->first();

            // Verificar si el país existe y está activado
            if (!$experience || !$experience->ciudad->pais->activo) {
                return redirect('/');
            }
        }

        return $next($request);
    }
}
