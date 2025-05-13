@php

    // Genero las variables para convertir en formulario en Crear o Modificar
    // Si $country no está nulo será modificar
    $titulo = __('labels.new_country');
    $metodo = 'POST';
    $ruta = route('admin.store.country');
    $nombre = '';
    $descripcion = '';
    $imagen = asset('storage/images/no-image.jpg');
    $activo = '';
    $boton = __('buttons.add_country');

    if ($country != null) {
        $titulo = __('labels.update_country');
        $metodo = 'PUT';
        $ruta = route('admin.update.country', $country->getEncryptedId());
        $nombre = $country->pais;
        $descripcion = $country->descripcion;
        $imagen = asset('storage/' . $country->imagen);
        if ($country->activo) {
            $activo = 'checked';
        }
        $boton = __('buttons.update_country');
    }

@endphp

<div class="country-form">

    <h3 id="nombre">{{ $titulo }}</h3>
    <span class="close">&times;</span>

    <div>
        <form id="myForm" action="{{ $ruta }}" method="post" enctype="multipart/form-data">
            @csrf
            @method($metodo)
            <div>
                {{-- Image --}}
                <div class="image-preview-container">
                    <!-- Contenedor para la previsualización -->
                    <img id="image-preview" src="{{ $imagen }}" alt="country">
                </div>
                <label for="image" class="btn-standard">{{ __('buttons.charge_image') }}</label>
                <input type="file" name="image" id="image" accept="image/*">
                @error('image')
                    <p class="error-message">{{ $message }}</p>
                @enderror

            </div>
            {{-- Country name --}}
            <label for="">{{ __('labels.country_name') }}</label>
            <input type="text" id="nombreExp" name="nombre" value="{{ $nombre }}" required>
            @error('nombre')
                <p class="error-message">{{ $message }}</p>
            @enderror
            {{-- Description --}}
            <label for="">{{ __('labels.description') }}</label>
            <textarea name="descripcion" rows="5">{{ $descripcion }}</textarea>
            @error('descripcion')
                <p class="error-message">{{ $message }}</p>
            @enderror
            {{-- Activo --}}
            <div class="group-input">
                <input type="hidden" name="activo" value="0">
                <input type="checkbox" id="checkbox" name="activo" value="1" {{ $activo }} />
                <label for="">{{ __('labels.active') }}</label>

            </div>

            <input id="submitButton" class="btn-standard" type="submit" value="{{ $boton }}">
        </form>
    </div>

</div>
