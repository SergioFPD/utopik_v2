<?php

namespace App\Http\Controllers;

use App\Models\Experiencia;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pais;
use Illuminate\Support\Facades\Crypt;
use App\Mail\ContactMail;
use App\Mail\ConfirmationMail;
use Illuminate\Support\Facades\Mail;

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

    public function contact(Request $request)
    {
        $request->validate([
            'company'    => 'required|string|max:100',
            'email'   => 'required|email',
            'message' => 'required|string|min:10',
        ]);

        $details = $request->only('company', 'email', 'message');

        // Enviar al administrador (tu correo desde .env)
        Mail::to(env('MAIL_FROM_ADDRESS'))->send(new ContactMail($details));

        // Enviar una copia al visitante
        Mail::to($request->email)->send(new ConfirmationMail());

        return back()->with('success', 'Message sent successfully!');
    }
}
