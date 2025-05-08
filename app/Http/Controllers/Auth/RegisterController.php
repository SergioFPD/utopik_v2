<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{

    public function registerUser(Request $request)
    {

        // Validaciones de campos, si alguno falla se muestra en formulario
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',  // Verifica si ya existe el email
            'nombre' => 'required|string|max:255|min:4',
            'password' => 'required|string|min:4',
        ]);

        if ($validator->fails()) {
            // Especifica un nombre de error para abrir el formulario modal correspondiente
            $validator->errors()->add('modal-register', 'Error in this modal form');
            // Llamamos a la excepción de validación para que Laravel maneje el error
            throw new ValidationException($validator);
        }

        $user = User::create($request->all());
        // Iniciar sesión automáticamente después del registro
        auth()->login($user);
        return redirect()->back()->with('success', 'Registro realizado');
    }
}
