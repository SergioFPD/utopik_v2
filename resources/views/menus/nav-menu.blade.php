@php

    if (Auth::user()) {
        $rol = Auth::user()->rol;
        $logeado = true;
    } else {
        $rol = 'guest';
        $logeado = false;
    }

    if ($rol == 'admin') {
        $nomBoton = __('buttons.admin_profile');
        $rutaPerfil = route('admin.profile', 'users');
    } elseif ($rol == 'proveedor') {
        $nomBoton = __('buttons.provider_profile');
        $rutaPerfil = route('provider.profile', 'experiences');
    } else {
        $nomBoton = __('buttons.business_area');
        $rutaPerfil = route('provider.login');
    }

@endphp
{{-- Modales ocultos --}}
@include('_modals.register')

<div class="navmenu">
    <div class="container">
        <div class="left">
            <div class="img-logo">
                <div class="img-logo full">
                    <a href="{{ route('home') }}"><img class="logo"
                            src="{{ asset('storage/images/utopik_logo_alpha.png') }}" alt=""></a>
                </div>
                <div class="img-logo small">
                    <a href="{{ route('home') }}"><img class="logo"
                            src="{{ asset('storage/images/utopik_circle2_alpha.png') }}" alt=""></a>
                </div>
            </div>
        </div>

        <div class="middle">
            @component('menus.country-select')
                @slot('listaPaises')
                    @if ($paises != null)
                        @foreach ($paises as $pais)
                            {{-- El pais ha de estar activo --}}
                            @if ($pais->activo)
                                <a class="country-select-item" href="{{ route('country', $pais->pais) }}">
                                    <p>{{ __('countries.' . $pais->pais) }}</p>
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endslot

            @endcomponent
        </div>

        <!-- Lado derecho del menú -->
        <div class="right">

            <div class="right-up">
                <div class="botonera">
                    @if (($logeado && $rol != 'cliente') || !$logeado)
                        <a class="btn-standard gold-button" href="{{ $rutaPerfil }}">
                            <p>{{ $nomBoton }}</p>
                        </a>
                    @endif
                    @if (!$logeado)
                        <a class="btn-standard" onclick="openModal('modal-register')">
                            <p>{{ __('buttons.register') }}</p>
                        </a>
                    @endif
                    @if ($logeado && $rol != 'cliente')
                        <a class="btn-standard alpha2" href="{{ route('logout') }}">
                            <p>{{ __('buttons.logout') }}</p>
                        </a>
                    @endif
                </div>
                @include('_partials.lang')
            </div>

            <div class="right-down">
                @if ($rol == 'cliente')
                    @include('menus.user-menu')
                @endif
                @if (!$logeado)
                    @include('_modals.login')
                @endif
                @if (!$logeado || ($logeado && $rol != 'cliente'))
                    @include('_modals.menu-responsive')
                @endif

            </div>

        </div>
    </div>
</div>
