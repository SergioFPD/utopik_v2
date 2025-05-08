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
            $reservas = Reserva::join('exp_fechas', 'exp_fechas.id', '=', 'reservas.exp_fecha_id') // unir tabla exp_fechas y reservas por id
                ->where('reservas.user_id', $user->id)  // Filtrar por el cliente
                ->orderBy('exp_fechas.fecha', 'asc')  // Ordenar por la fecha de la tabla 'exp_fechas'
                ->get();
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
}
