<?php

namespace App\Http\Controllers;

use App\Models\Experiencia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function viewClientProfile($menu)
    {
        $ultimasExperiencias = Experiencia::orderBy('created_at', 'desc')->take(5)->get();
        if ($menu == 'reserves') {
            $user = Auth::user();
            // $reservas = Reserva::join('exp_fechas', 'exp_fechas.id', '=', 'reservas.exp_fecha_id')
            //     ->where('reservas.user_id', $user->id)
            //     ->orderBy('exp_fechas.fecha', 'asc')
            //     ->select('reservas.*', 'reservas.id as reserva_id') // ← importante: usar alias
            //     ->get();
            $reservas = Reserva::where('user_id', $user->id)
                ->with('exp_fecha')
                ->get()
                ->sortBy(function ($reserva) {
                    return $reserva->exp_fecha->fecha;
                })
                ->values();
        } else {
            $reservas = null;
        }



        return view('profiles.client-profile', compact('ultimasExperiencias', 'reservas', 'menu'));
    }

    public function storeReserve(Request $request)
    {
        $user = Auth::user();

        Reserva::create([

            'adultos' => $request->adultos,
            'menores' => $request->menores,
            'experiencia_id' => Crypt::decryptString($request->experiencia_id),
            'exp_fecha_id' => $request->exp_fecha_id,
            'user_id' => $user->id,
        ]);

        return redirect()->route('client.profile', 'reserves');
    }

    public function updateUser(Request $request)
    {

        $user = User::find(Auth::user()->id);

        if ($request->image != null) {
            // Crear el nombre único para la imagen
            $imageName = time() . '.' . $request->image->extension();

            // Crear una carpeta con el ID del usuario autenticado
            $folderPath = "public/images/users/" . $user->id;
            $folderUri = "images/users/" . $user->id; // Se guardará como ruta de la imagen

            $request->image->storeAs($folderPath, $imageName);

            // Eliminar la imagen anterior si existe
            if ($user->imagen) {
                Storage::delete('public/' . $user->imagen);
            }
        }

        $user->nombre = $request->name;
        $user->telefono = $request->phone;
        $user->ciudad = $request->city;
        if ($request->image != null) {
            $user->imagen = $folderUri . "/" . $imageName;
        }
        $user->save();
        return redirect()->back()->with('success', __('alerts.user_updated', ['name' => $user->nombre]));
    }

    public function formReserve($experiencia_id)
    {

        $experiencia = Experiencia::find(Crypt::decryptString($experiencia_id));

        if (!$experiencia) {
            $experiencia = "error";
        }

        return View('_partials.reserve-form', compact('experiencia'));
    }

    public function payment($reserve_id)
    {

        $reserva = Reserva::find(Crypt::decryptString($reserve_id));

        if (!$reserva) {
            $reserva = "error";
        }

        return View('_partials.pay-rest', compact('reserva'));
    }
}
