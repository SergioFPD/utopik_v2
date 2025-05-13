@php

    // Genero las variables para convertir en formulario en Crear o Modificar
    // Si $country no está nulo será modificar
    $titulo = __('labels.new_provider');
    $metodo = 'POST';
    $ruta = route('admin.store.provider');
    $nombre = '';
    $email = '';
    $telefono = '';
    $password = 'required';
    $bloqueado = '';
    $boton = __('buttons.add_provider');

    if ($provider != null) {
        $titulo = __('labels.update_provider');
        $metodo = 'PUT';
        $ruta = route('admin.update.provider', $provider->getEncryptedId());
        $nombre = $provider->nombre;
        $email = $provider->email;
        $telefono = $provider->telefono;
        $password = '';
        if ($provider->bloqueado) {
            $bloqueado = 'checked';
        }
        $boton = __('buttons.update_provider');
    }

@endphp

<div>
    <h3>{{ $titulo }}</h3>
    <span class="close">&times;</span>
    <form id="myForm" action="{{ $ruta }}" method="post">
        @method($metodo)
        @csrf
        {{-- Name --}}
        <label for="">{{ __('labels.name') }}</label>
        <input type="text" name="nombre" value="{{ $nombre }}" required>
        @error('nombre')
            <p class="error-message">{{ $message }}</p>
        @enderror
        {{-- email --}}
        <label for="">{{ __('labels.email') }}</label>
        <input type="email" name="email" value="{{ $email }}" required>
        @error('email')
            <p class="error-message">{{ $message }}</p>
        @enderror
        {{-- phone --}}
        <label for="">{{ __('labels.phone') }}</label>
        <input type="phone" name="telefono" value="{{ $telefono }}">
        @error('telefono')
            <p class="error-message">{{ $message }}</p>
        @enderror
        {{-- password --}}
        <label for="">{{ __('labels.password') }}</label>
        <input type="password" name="password" {{ $password }}>
        @error('password')
            <p class="error-message">{{ $message }}</p>
        @enderror
        {{-- estate --}}
        <div class="group-input">

            <input type="hidden" name="bloqueado" value="0">
            <input type="checkbox" name="bloqueado" value="1" {{ $bloqueado }} />
            <label for="">{{ __('labels.blocked') }}</label>
        </div>

        <input id="submitButton" class="btn-standard" type="submit" value="{{ $boton }}">
    </form>
</div>
