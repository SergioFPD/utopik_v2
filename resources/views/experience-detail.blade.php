@extends('layouts.app')

@section('navMenu')
    @include('menus.nav-menu')
@endsection

@section('content')
    <div class="content experience-detail">
        @if ($experiencia != null)
            @component('components.row-details-head')
                @slot('imagenExperiencia')

                    {{ $experiencia->imagen->first()
                        ? asset('storage/' . $experiencia->imagen->first()->ruta)
                        : asset('storage/images/no-image.jpg') }}
                @endslot

                @slot('pais')
                    {{ __('countries.' . $experiencia->ciudad->pais->pais) }}
                @endslot
                @slot('nombre', $experiencia->nombre)
                @slot('descripcion', $experiencia->descripcion)
                @slot('precioAdulto', $experiencia->precio_adulto)
                @slot('precioMenor', $experiencia->precio_nino)
                @slot('dias', $experiencia->duracion)
                @slot('rutaReserva', $experiencia->getEncryptedId())
                @slot('esVip', $experiencia->vip)
            @endcomponent
        @endif

        @if ($experiencia->actividad)
            @php $count = 1; @endphp
            @foreach ($experiencia->actividad as $actividad)
                @if ($count % 2 !== 0)
                    @component('components.activity-card-left')
                    @else
                        @component('components.activity-card-right')
                        @endif

                        @slot('imagenActividad')
                            {{ $actividad->imagen ? asset('storage/' . $actividad->imagen) : asset('storage/images/no-image.jpg') }}
                        @endslot
                        @slot('nombreActividad', $actividad->nombre)
                        @slot('descripcion', $actividad->descripcion)
                        @slot('dias', $actividad->dia)
                    @endcomponent

                    @php $count++ @endphp
                @endforeach
            @else
                <p style="margin: 100px">SIN ACTIVIDADES</p>
            @endif

            @include('layouts.row-conditions')

            @include('layouts.row-last-experiences')

            {{-- Footer variable según la página mostrada --}}
            @component('components.footer')
                @slot('footerContent')
                    Este es el footer del detalle de experiencia
                @endslot
            @endcomponent
        </div>

    @endsection
