<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Pais;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use NunoMaduro\Collision\Provider;

class AdminController extends Controller
{

    public function viewProfile($menu)
    {
        $usuarios = User::all();
        return view('profiles.admin-profile', compact('usuarios', 'menu'));
    }

    // For open modal form
    public function formCustomer($customer_id)
    {
        $customer = User::find(Crypt::decryptString($customer_id));

        return View('_modals.customer-modify', compact('customer'));
    }

    public function updateCustomer(Request $request, $customer_id)
    {
        $customer = User::find(Crypt::decryptString($customer_id));

        $customer->bloqueado = $request->bloqueado;
        $customer->rol = $request->rol;
        $customer->save();
        return redirect()->route('admin.profile', 'users')->with('success', __('alerts.user_updated', ['name' => $customer->nombre]));
    }

    public function deleteCustomer($customer_id)
    {
        $customer = User::find(Crypt::decryptString($customer_id));

        $customer->delete();
        return redirect()->back()->with('success', __('alerts.user_deleted', ['name' => $customer->nombre]));
    }

    public function storeCountry(Request $request)
    {
        $rutaImagen = "";

        // Si hay imagen, la guarda y la crea en la tabla imagenes
        if ($request->image != null) {
            // Crear el nombre único para la imagen
            $imageName = time() . '.' . $request->image->extension();

            // Crear una carpeta con el ID del usuario autenticado
            $folderPath = "public/images/countries";
            $folderUri = "images/countries"; // Se guardará como ruta de la imagen

            $request->image->storeAs($folderPath, $imageName);

            $rutaImagen = $folderUri . "/" . $imageName;
        }

        Pais::create([
            'pais' => $request->nombre,
            'descripcion' => $request->descripcion,
            'activo' => $request->activo,
            'imagen' => $rutaImagen,
        ]);

        return redirect()->back()->with('success', __('alerts.country_created'));
    }

    public function updateCountry(Request $request, $country_id)
    {

        $pais = Pais::find(Crypt::decryptString($country_id));

        if ($request->image != null) {
            // Crear el nombre único para la imagen
            $imageName = time() . '.' . $request->image->extension();

            // Crear una carpeta para la imagen
            $folderPath = "public/images/countries";
            $folderUri = "images/countries"; // Se guardará como ruta de la imagen

            $request->image->storeAs($folderPath, $imageName);

            // Eliminar la imagen anterior si existe
            if ($pais->imagen) {
                Storage::delete('public/' . $pais->imagen);
            }
        }

        $pais->pais = $request->nombre;
        $pais->descripcion = $request->descripcion;
        if ($request->image != null) {
            $pais->imagen = $folderUri . "/" . $imageName;
        }

        $pais->activo = $request->activo;
        $pais->save();

        return redirect()->route('admin.profile', 'countries')->with('success', __('alerts.country_updated'));
    }

    // For open modal form
    public function formCountry($country_id)
    {
        if ($country_id != "new") {
            $country = Pais::find(Crypt::decryptString($country_id));
        } else {
            $country = null;
        }

        return View('_modals.country-form', compact('country'));
    }

    // For open modal form
    public function formProvider($provider_id)
    {
        if ($provider_id != "new") {
            $provider = User::find(Crypt::decryptString($provider_id));
        } else {
            $provider = null;
        }

        return View('_modals.provider-form', compact('provider'));
    }

    public function storeProvider(Request $request)
    {
        User::create($request->all());

        return redirect()->back()->with('success', __('alerts.provider_created', ['name' => $request->nombre]));
    }

    public function updateProvider(Request $request, $provider_id)
    {
        $provider = User::find(Crypt::decryptString($provider_id));

        $provider->bloqueado = $request->bloqueado;
        $provider->email = $request->email;
        $provider->nombre = $request->nombre;
        $provider->telefono = $request->telefono;
        if ($request->bloqueado != null) {
            $provider->password = $request->password;
        }
        $provider->save();
        return redirect()->route('admin.profile', 'providers')->with('success', __('alerts.user_updated', ['name' => $provider->nombre]));
    }
}
