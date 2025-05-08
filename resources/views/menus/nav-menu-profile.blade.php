@php

    if (Auth::user()) {
        $rol = Auth::user()->rol;
        $logeado = true;
    } else {
        $rol = 'guest';
        $logeado = false;
    }

    if ($rol == 'cliente') {
        $nomBoton1 = __('buttons.reserves');
        $rutaBoton1 = route('client.profile', 'reserves');
        $nomBoton2 = __('buttons.user_data');
        $rutaBoton2 = route('client.profile', 'user_data');
    } elseif ($rol == 'proveedor') {
        $nomBoton1 = __('buttons.my_experiences');
        $rutaBoton1 = route('provider.profile', 'experiences');
        $nomBoton2 = __('buttons.my_reservations');
        $rutaBoton2 = route('provider.profile', 'reserves');
    } else {
        $nomBoton1 = __('buttons.users');
        $rutaBoton1 = route('admin.profile', 'users');
        $nomBoton2 = __('buttons.providers');
        $rutaBoton2 = route('admin.profile', 'providers');
        $nomBoton3 = __('buttons.countries');
        $rutaBoton3 = route('admin.profile', 'countries');
    }

@endphp
{{-- Modales ocultos --}}
@include('_modals.register')

<div class="navmenu menu-profile">
    <div class="container">
        <div class="left">
            <div class="img-logo">
                <a href="{{ route('home') }}"><img class="logo"
                        src="{{ asset('storage/images/utopik_circle_alpha.png') }}" alt=""></a>
            </div>
        </div>

        <div class="middle">
            @if ($logeado)
                <a class="btn-standard alpha" href="{{ $rutaBoton1 }}">
                    <p>{{ $nomBoton1 }}</p>
                </a>

                <a class="btn-standard alpha" href="{{ $rutaBoton2 }}">
                    <p>{{ $nomBoton2 }}</p>
                </a>

                @if ($rol == 'admin')
                    <a class="btn-standard alpha" href="{{ $rutaBoton3 }}">
                        <p>{{ $nomBoton3 }}</p>
                    </a>
                @endif
            @else
                <p class="texto-blanco text-small text-shadow">{{__('buttons.business_area')}}</p>
            @endif
        </div>

        <!-- Lado derecho del menú -->
        <div class="right">

            <div class="right-up">
                @include('_partials.lang')
            </div>

            <div class="right-down">
                {{-- <a class="btn-standard gold-button" href="{{ route('home') }}">
                    <p>{{ __('buttons.go_home') }}</p>
                </a> --}}
            </div>

        </div>
    </div>
</div>
