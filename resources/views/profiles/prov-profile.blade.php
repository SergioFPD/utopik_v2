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





                    {{-- 
                                <div class="reserve-content">
                                    <h3> Nombre de experiencia: {{ $experiencia->nombre }}</h3>
                                    <p>Adultos: {{ $reserva->adultos }}</p>
                                    <p>Cliente: {{ $reserva->user->nombre }}</p>
                                    <p>Email del cliente: {{ $reserva->user->email }}</p>
                                    <p>Precio total de la reserva: {{ $reserva->dimePrecioTotal() }}€</p>
              
                                    @if ($reserva->puntuacion == 0)
                                        <button class="btn-standard"
                                            onclick="insertModalPage('{{ route('form.evaluate', $reserva->getEncryptedId()) }}', 'modal-reserve-rate', false, false)">{{ __('buttons.evaluate') }}</button>
                                    @else
                                        <p>Se ha evaluado con: {{ $reserva->puntuacion }} puntos</p>
                                    @endif


                                </div> --}}




                </div>
            @endif

        </div>

        {{-- Donde se inyectará la página modal --}}
        @include('_partials.page-content')

        {{-- Footer variable según la página mostrada --}}
        @component('components.footer')
            @slot('footerContent')
                Este es el footer del perfil proveedor
            @endslot
        @endcomponent
    </div>
@endsection
