@extends('layouts.app')

@section('navMenu')
    @include('menus.nav-menu-profile')
@endsection
@section('content')

    <div class="content admin-menu">
        @component('components.row-profile')
            @slot('menuTitulo', __('labels.profile_admin'))
            @slot('menuNombre')
                {{ Auth::user()->nombre }}
            @endslot
        @endcomponent
        <div class="row">
            {{-- USERS --------------------------------- --}}
            @if ($menu == 'users')
                <div class="user-list menu">
                    @if ($usuarios != null)
                        @component('components.item-user', ['usuarios' => $usuarios])
                        @endcomponent
                    @else
                        <div>
                            <p>{{ __('labels.no_users') }}</p>
                        </div>
                    @endif
                </div>
            @endif
            {{-- PROVIDERS --------------------------------- --}}
            @if ($menu == 'providers')
                <div class="user-list menu">
                    @if ($usuarios != null)
                        @component('components.item-provider', ['providers' => $usuarios])
                        @endcomponent
                    @else
                        <div>
                            <p>{{ __('labels.no_providers') }}</p>
                        </div>
                    @endif
                    <div class="button-container">
                        <button class="btn-standard"
                            onclick="insertModalPage('{{ route('form.provider', 'new') }}', 'modal-provider', false, true)">{{ __('buttons.new_provider') }}</button>
                    </div>
                </div>
            @endif

            {{-- CONTRIES ------------------------- --}}
            @if ($menu == 'countries')
                <div class="country-list menu">

                    @if ($paises != null)
                        @component('components.item-country', ['paises' => $paises])
                        @endcomponent
                    @else
                        <div>
                            <p>{{ __('labels.no_countries') }}</p>
                        </div>
                    @endif
                    <div class="button-container">
                        <button
                            class="btn-standard"onclick="insertModalPage('{{ route('form.country', 'new') }}', 'modal-country-form', true, true)">{{ __('buttons.new_country') }}</button>
                    </div>
                </div>
            @endif


        </div>

        {{-- Donde se inyectará la página modal --}}
        @include('_partials.page-content')

        {{-- Footer variable según la página mostrada --}}
        @component('components.footer')
            @slot('footerContent')
                Este es el footer del perfil administrador
            @endslot
        @endcomponent

    </div>


@endsection
