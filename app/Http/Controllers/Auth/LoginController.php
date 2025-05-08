<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginUser(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password')) && Auth::user()->rol != 'proveedor') {
            // Redirigir al inicio si la autenticación es exitosa
            return redirect()->back();
        }

        Auth::logout();
        // Redirigir de vuelta con un mensaje de error si falla
        return redirect()->back()->with('error', 'Parece que tus credenciales no son válidas');
    }

    public function loginProvider(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);


        if (Auth::attempt($request->only('email', 'password')) && Auth::user()->rol === 'proveedor') {
            // Redirigir al inicio si la autenticación es exitosa
            return redirect()->back();
        }

        Auth::logout();
        // Redirigir de vuelta con un mensaje de error si falla
        return redirect()->back()->with('error', 'Parece que tus credenciales no son válidas');
    }
    

    public function logout()
    {
        Auth::logout(); // Cerrar sesión
        return redirect('/'); // Redirigir al inicio
    }
}
