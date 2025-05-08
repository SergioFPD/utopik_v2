@php
    use Carbon\Carbon;

    $languages = Config::get('languages');

    // Obtener el idioma actual
    $currentLang = App::getLocale();

    // Convertir la fecha a Carbon
    $date = Carbon::parse($fecha);

    // Establecer el idioma en Carbon
    Carbon::setLocale($currentLang);

    // Formato de fecha según el idioma
    if ($currentLang === 'es') {
        $fechaLarga = $date->isoFormat('dddd, D [de] MMMM [de] YYYY');
    } else {
        $fechaLarga = $date->isoFormat('dddd, MMMM D, YYYY');
    }

    echo ucfirst($fechaLarga); // Primera letra en mayúscula
@endphp

