<?php

namespace App\Http\Controllers;

use App\Models\Experiencia;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pais;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class NavController extends Controller
{

    // Todas las vistas tendrán la variable paises para el menu
    // a traves del AppServiceProvider de Providers
    public function home()
    {

        $ultimasExperiencias = Experiencia::where('activa', true)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        return View('home', compact('ultimasExperiencias'));
    }

    public function providerLogin()
    {
        return View('provider-login');
    }

    public function country($country)
    {
        $ultimasExperiencias = Experiencia::where('activa', true)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $paisElegido = Pais::firstWhere('pais', $country);
        if ($country == 'World') {
            $experienciasPais = Experiencia::where('activa', true)->get();
        } else {

            $experienciasPais = Experiencia::where('activa', true)
                ->whereHas('ciudad.pais', function ($query) use ($country) {
                    $query->where('pais', $country); // Filtrar por el país
                })
                ->get();
        }

        return View('experiences-by-country', compact('ultimasExperiencias', 'experienciasPais', 'paisElegido'));
    }

    public function viewDetail($nombre)
    {
        $ultimasExperiencias = Experiencia::where('activa', true)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        $experiencia = Experiencia::firstWhere('nombre', $nombre);

        if ($experiencia == null || ($experiencia->vip && ((Auth::check() && (!Auth::user()->vip && Auth::user()->rol != 'admin')) || !Auth::check()))) {
            return redirect()->route('home');
        } else {
            return View('experience-detail', compact('experiencia', 'ultimasExperiencias'));
        }
    }

    public function formReserve($experiencia_id)
    {

        $experiencia = Experiencia::find(Crypt::decryptString($experiencia_id));

        if (!$experiencia) {
            $experiencia = "error";
        }

        return View('_modals.reserve-form', compact('experiencia'));
    }
}
