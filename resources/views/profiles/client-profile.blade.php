@extends('layouts.app')

@section('navMenu')
    @include('menus.nav-menu-profile')
@endsection
@section('content')

    <div class="content user-profile">
        @component('components.row-profile')
            @slot('menuTitulo', __('labels.profile_user'))
            @slot('menuNombre')
                {{ Auth::user()->nombre }}
            @endslot
        @endcomponent

        @if ($menu == 'user_data')
            <div class="userdata-list menu row">

                <div class="top">
                    <div class="left">

                        <form id="myForm" action="{{ route('client.update.user') }}" method="post"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <div class="form-inputs-user">
                                {{-- name --}}
                                <div class="form-group">
                                    <label for="name">{{ __('labels.name') }}</label>
                                    <input type="text" name="name" value="{{ Auth::user()->nombre }}" required>
                                </div>
                                {{-- email --}}
                                <div class="form-group">

                                    <label for="email">{{ __('labels.email') }}</label>
                                    <input type="text" name="email" value="{{ Auth::user()->email }}" disabled>
                                </div>
                                {{-- phone --}}
                                <div class="form-group">

                                    <label for="phone">{{ __('labels.phone') }}</label>
                                    <input type="text" name="phone" value="{{ Auth::user()->telefono }}" required>
                                </div>
                                {{-- city --}}
                                <div class="form-group">

                                    <label for="city">{{ __('labels.city') }}</label>
                                    <input type="text" name="city" value="{{ Auth::user()->ciudad }}" required>
                                </div>
                                {{-- image --}}
                                <div class="form-group">
                                    <label for="image">{{ __('labels.user_image') }}</label>
                                    <input type="file" name="image" id="image" accept="image/*">
                                </div>
                                {{-- send --}}
                                <input id="submitButton" class="btn-standard disabled" type="submit"
                                    value="{{ __('buttons.update_profile') }}">
                            </div>
                        </form>
                    </div>

                    <div class="right">
                        <div class="user-image">

                            <img id="image-preview"
                                src="{{ Auth::user()->imagen ? asset('storage/' . Auth::user()->imagen) : asset('storage/images/user-img.png') }}"
                                alt="user-image">
                        </div>
                        <div class="points">
                            <p class="text-small">{{ Auth::user()->puntos }}</p>
                            <p class="text-very-small">{{ __('labels.vip_points') }}</p>
                        </div>

                        @if (Auth::user()->puntos >= 30)
                            <div class="imvip yesvip">
                                <p>{{ __('labels.you_are_vip') }}</p>
                            </div>
                        @else
                            <div class="imvip notvip">
                                <p>{{ __('labels.you_are_not_vip') }}</p>
                            </div>
                        @endif


                    </div>
                </div>
            </div>
            <hr>
        @endif
        @if ($menu == 'reserves')
            <div class="reserve-list menu row">
                @foreach ($reservas as $reserva)
                    @if ($reserva->experiencia != null)
                        @component('components.bookings')
                            @slot('rutaImagen')
                                {{ $reserva->experiencia->imagen->first()
                                    ? asset('storage/' . $reserva->experiencia->imagen->first()->ruta)
                                    : asset('storage/images/no-image.jpg') }}

                            @endslot
                            @slot('reservaId', $reserva->getEncryptedId())
                            @slot('esVip', $reserva->experiencia->vip)
                            @slot('titulo', $reserva->experiencia->nombre)
                            @slot('descripcionCorta', $reserva->experiencia->descripcion_corta)
                            @slot('dias', $reserva->experiencia->duracion)
                            @slot('adultos', $reserva->adultos)
                            @slot('menores', $reserva->menores)
                            @slot('precioTotal', $reserva->dimePrecioTotal())
                            @slot('pagoReserva', $reserva->dimePrecioReserva())

                            @slot('fecha', $reserva->exp_fecha->fecha)
                            @slot('restoPagar', $reserva->dimePorPagar())
                            @slot('experienciaNombre', $reserva->experiencia->nombre)
                            
                        @endcomponent
                    @endif
                @endforeach
            </div>

            @include('layouts.row-conditions-full')
        @endif


        @include('layouts.row-last-experiences')
        {{-- Footer variable según la página mostrada --}}
        @component('components.footer')
            @slot('footerContent')
                Este es el footer de perfil cliente
            @endslot
        @endcomponent
    </div>


@endsection
