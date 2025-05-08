<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Experiencia;
use App\Models\Ciudad;
use App\Models\Imagen;
use App\Models\User;
use App\Models\Actividad;
use App\Models\Exp_fecha;
use App\Models\Reserva;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;


class ProviderController extends Controller
{
    public function viewProviderProfile($menu)
    {
        $user = Auth::user();

        $experiencias = $user->experiencia;
        return view('profiles.prov-profile', compact('experiencias', 'menu'));
    }

    // Formularios de experiencias ---------------------------
    public function experienceCreateForm()
    {
        $mode = 'create';
        return view('experience-form', compact('mode'));
    }

    public function experienceModifyForm($experiencia_id)
    {
        $experiencia = Experiencia::find(Crypt::decryptString($experiencia_id));
        $mode = 'modify';
        return view('experience-form', compact('experiencia', 'mode'));
    }

    public function storeExperience3(Request $request)
    {

        return back();
    }

    public function storeExperience(Request $request)
    {
        if (Experiencia::where('nombre', $request->nombre)->exists()) {
            return redirect()->back()->with('error', 'Ya existe una experiencia con ese nombre, cámbialo');
        }

        // $validator = Validator::make($request->all(), [
        //     'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validar el tipo y tamaño de la imagen
        //     'fechas' => 'required|array|different:null',
        //     'fechas.*' => 'required|string'
        // ]);

        // if ($validator->fails()) {
        //     // Especifica un nombre de error para abrir el formulario modal correspondiente
        //     $validator->errors()->add('error', 'Error saving experience');
        //     // Llamamos a la excepción de validación para que Laravel maneje el error
        //     throw new ValidationException($validator);
        // }

        // Verifico si ya existe una ciudad en ese pais en la BD
        $ciudad = Ciudad::firstOrCreate(
            ['ciudad' => $request->ciudad, 'pais_id' => $request->pais_id],
            ['ciudad' => $request->ciudad, 'pais_id' => $request->pais_id]
        );

        $user = Auth::user();

        $experiencia = Experiencia::create([

            'nombre' => $request->nombre,
            'descripcion_corta' => $request->descripcionCorta,
            'descripcion' => $request->descripcion,
            'vip' => $request->vip,
            'activa' => $request->activa,
            'duracion' => $request->duracion,
            'precio_adulto' => $request->precio_adulto,
            'precio_nino' => $request->precio_nino,
            'ciudad_id' => $ciudad->id,
            'user_id' => $user->id,
        ]);

        // Si hay imagen, la guarda y la crea en la tabla imagenes
        if ($request->image != null) {
            // Crear el nombre único para la imagen
            $imageName = time() . '.' . $request->image->extension();

            // Crear una carpeta con el ID del usuario autenticado
            $folderPath = public_path("images/providers/" . $user->id);
            $folderUri = "images/providers/" . $user->id; // Se guardará como ruta de la imagen

            $request->image->storeAs($folderPath, $imageName);

            Imagen::create([
                'ruta' => $folderUri . "/" . $imageName,
                'experiencia_id' => $experiencia->id,

            ]);
        }

        // Guardar las fechas asociadas, primero pasamos el string recibido, que 
        // por alguna cosa no es un array de php
        $arrayFechas = json_decode($request->fechas[0], true);
        foreach ($arrayFechas as $fecha) {
            Exp_fecha::create([
                'experiencia_id' => $experiencia->id,
                'fecha' => $fecha,
            ]);
        }

        return redirect()->route('provider.profile', 'experiences')->with('success', 'Experiencia creada');
    }



    public function updateExperience(Request $request, $experience_id)
    {

        $experienceId = Crypt::decryptString($experience_id);
        $experience = Experiencia::find($experienceId);
        $expHasImage = Imagen::where('experiencia_id', $experienceId)->exists();
        if ($expHasImage) {

            $imagenExp = Imagen::where('experiencia_id', $experienceId)->first();
        }

        $user = Auth::user();

        // Borrar imagen anterior y guardar la nueva
        if ($request->image != null) {
            // Crear el nombre único para la imagen
            $imageName = time() . '.' . $request->image->extension();

            // Crear una carpeta con el ID del usuario autenticado
            $folderPath = "public/images/providers/" . $user->id;
            $folderUri = "images/providers/" . $user->id; // Se guardará como ruta de la imagen

            $request->image->storeAs($folderPath, $imageName);

            // Eliminar la imagen anterior si existe
            if ($expHasImage) {
                Storage::delete('public/' . $imagenExp->ruta);
            }
        }

        // Verifico si ya existe una ciudad en ese pais en la BD y guardo la nueva si no existe
        $ciudad = Ciudad::firstOrCreate(
            ['ciudad' => $request->ciudad, 'pais_id' => $request->pais_id],
            ['ciudad' => $request->ciudad, 'pais_id' => $request->pais_id]
        );

        $experience->nombre = $request->nombre;
        $experience->descripcion_corta = $request->descripcionCorta;
        $experience->descripcion = $request->descripcion;
        $experience->vip = $request->vip;
        $experience->activa = $request->activa;
        $experience->duracion = $request->duracion;
        $experience->precio_adulto = $request->precio_adulto;
        $experience->precio_nino = $request->precio_nino;
        $experience->ciudad_id = $ciudad->id;

        // 1️⃣ Eliminar las fechas anteriores de la experiencia
        Exp_fecha::where('experiencia_id', $experienceId)->delete();

        // Guardar las fechas asociadas, primero pasamos el string recibido, que 
        // por alguna cosa no es un array de php
        $arrayFechas = json_decode($request->fechas[0], true);
        foreach ($arrayFechas as $fecha) {
            Exp_fecha::create([
                'experiencia_id' => $experienceId,
                'fecha' => $fecha,
            ]);
        }

        // Si existe la imagen asociada a la experiencia, modificamos su ruta
        if ($expHasImage) {
            if ($request->image != null) {
                $imagenExp->ruta = $folderUri . "/" . $imageName;
                $imagenExp->save();
            }
            // Si no existe imagen asociada a la experiencia, la creamos
        } else {
            if ($request->image != null) {
                Imagen::create([
                    'ruta' => $folderUri . "/" . $imageName,
                    'experiencia_id' => $experienceId,
                ]);
            }
        }

        $experience->save();
        return redirect()->route('provider.profile', 'experiences')->with('success', __('alerts.experience_updated'));
    }

    // Formularios de actividades ---------------------------
    public function activityListForm($experience_id, $activity_id, $mode)
    {
        $experiencia = Experiencia::find(Crypt::decryptString($experience_id));
        if ($mode == 'modify') {
            $actividad = Actividad::find(Crypt::decryptString($activity_id));
            return view('activity-form', compact('experiencia', 'actividad', 'mode'));
        } else {
            $actividad = '';
            return view('activity-form', compact('experiencia', 'actividad', 'mode'));
        }
    }

    public function updateActivity(Request $request, $activity_id)
    {

        $user = User::find(Auth::user()->id);
        $actividad = Actividad::find(Crypt::decryptString($activity_id));

        if ($request->image != null) {
            // Crear el nombre único para la imagen
            $imageName = time() . '.' . $request->image->extension();

            // Crear una carpeta con el ID del usuario autenticado
            $folderPath = "public/images/providers/" . $user->id . '/activities';
            $folderUri = "images/providers/" . $user->id . '/activities'; // Se guardará como ruta de la imagen

            $request->image->storeAs($folderPath, $imageName);

            // Eliminar la imagen anterior si existe
            if ($actividad->imagen) {
                Storage::delete('public/' . $actividad->imagen);
            }
        }

        $actividad->nombre = $request->nombre;
        $actividad->descripcion = $request->descripcion;
        if ($request->image != null) {
            $actividad->imagen = $folderUri . "/" . $imageName;
        }

        $actividad->dia = $request->dia;
        $actividad->save();

        return redirect()->route('provider.profile', 'experiences')->with('success', __('alerts.activity_updated'));
    }

    public function deleteActivity($activity_id)
    {

        $actividad = Actividad::find(Crypt::decryptString($activity_id));

        // Eliminar la imagen si existe
        if ($actividad->imagen) {
            Storage::delete('public/' . $actividad->imagen);
        }

        $actividad->delete();
        return redirect()->route('provider.profile', 'experiences')->with('success', __('alerts.activity_deleted'));
    }


    public function storeActivity(Request $request)
    {

        // Validaciones de campos, si alguno falla se muestra en formulario
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|min:5',
            'descripcion' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            // Especifica un nombre de error para abrir el formulario modal correspondiente
            $validator->errors()->add('modal-new-activity', 'Error in this modal form');
            // Llamamos a la excepción de validación para que Laravel maneje el error
            throw new ValidationException($validator);
        }

        $user = Auth::user();
        $rutaImagen = "";

        // Si hay imagen
        if ($request->image != null) {
            // Crear el nombre único para la imagen
            $imageName = time() . '.' . $request->image->extension();

            // Crear una carpeta con el ID del usuario autenticado
            $folderPath = "public/images/providers/" . $user->id . '/activities';
            $folderUri = "images/providers/" . $user->id . '/activities'; // Se guardará como ruta de la imagen

            $request->image->storeAs($folderPath, $imageName);
            $rutaImagen = $folderUri . "/" . $imageName;
        }

        $experiencia = Experiencia::find(Crypt::decryptString($request->experience_id));

        $experiencia->actividad()->create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'dia' => $request->dia,
            'imagen' => $rutaImagen,

        ]);

        return redirect()->route('provider.profile', 'experiences')->with('success', __('alerts.activity_created'));
    }

    // Comprueba si ya existe el nombre introducido en el formulario
    public function checkName($nombre)
    {
        $exists = Experiencia::where('nombre', $nombre)->exists();
        return response()->json(['exists' => $exists]);
    }

    // For open modal form evaluation
    public function formEvaluate($reserve_id)
    {
        $reservation = Reserva::find(Crypt::decryptString($reserve_id));

        $usuario = User::findOrFail($reservation->user_id);
        $customer = $usuario->nombre;


        return View('_modals.reserve-rate', compact('reservation', 'customer'));
    }

    public function rateCustomer(Request $request, $reservation_id)
    {

        // Media de puntuación 
        $points = round(($request->one +
            $request->two +
            $request->three +
            $request->four +
            $request->five +
            $request->six +
            $request->seven
        ) / 7);

        // Compruebo que la nota no sea mayor de 10
        if ($points > 10) {
            return back()->with('error', __('alerts.invalid_rate'));
        }

        try {
            // Obtener la reserva por su ID
            $reservation = Reserva::findOrFail(Crypt::decryptString($reservation_id));

            // Obtener el usuario por su ID en la reserva
            $usuario = User::findOrFail($reservation->user_id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', __('alerts.invalid_rate'.$e));
        }


        // Sumar la nueva puntuación a la actual
        $usuario->puntos += $points;

        // Actualizar puntos de la reserva
        $reservation->puntuacion = $points;

        // Si el usuario supera los 30 puntos, se establece como VIP
        if ($usuario->puntos >= 30) {
            $usuario->vip = true;
        }

        // Guardar cambios en la base de datos
        $usuario->save();
        $reservation->save();

        return back()->with('success', __('alerts.reserve_evaluated'));
    }
}
