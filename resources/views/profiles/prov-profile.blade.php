@extends('layouts.app')

@section('navMenu')
    @include('menus.nav-menu-profile')
@endsection
@section('content')

    <div class="content provider-menu">
        @component('components.row-profile')
            @slot('menuTitulo', __('labels.profile_provider'))
            @slot('menuNombre')
            {{ Auth::user()->nombre }}
            @endslot
        @endcomponent
        <div class="row menu-content">

            @if ($menu == 'experiences')
                <div class="experience-list menu">

                    <div class="button-container">
                        <a class="btn-standard gold" href="{{ route('experience.form') }}">
                            <p>{{ __('buttons.add_experience') }}</p>
                        </a>
                    </div>

                    @foreach ($experiencias as $experiencia)
                        @component('components.experience-item', ['experiencia' => $experiencia])
                        @endcomponent
                    @endforeach

                </div>
            @endif
            @if ($menu == 'reserves')
                <div class="reserve-list menu">

                    @if ($experiencias != null)
                        @component('components.reserve-item', ['experiencias' => $experiencias])
                        @endcomponent
                    @else
                        <div>
                            <p>{{ __('labels.no_reservations') }}</p>
                        </div>
                    @endif

                </div>
            @endif

        </div>

        {{-- Donde se inyectará la página modal --}}
        @include('_modals.modal-page')

        {{-- Footer variable según la página mostrada --}}
        @component('components.footer')
            @slot('footerContent')
                Este es el footer del perfil proveedor
            @endslot
        @endcomponent
    </div>
@endsection
