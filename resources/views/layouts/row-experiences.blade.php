@php
    $esVip = Auth::check() && (Auth::user()->vip || Auth::user()->rol == 'admin');
    $esCliente = Auth::check() && Auth::user()->rol == 'cliente';
@endphp
@component('components.barra')
    @slot('color', 'fondo-blanco')
@endcomponent
<div class="content-margin row">

    @if ($experienciasPais->isEmpty())
        {{-- @if ($experienciasPais->count() == 0) --}}
        <h1>{{ __('labels.no_experience_list') }}</h1>
    @elseif ($experienciasPais->every(fn($exp) => $exp->vip) && !$esVip)
        <h1>{{ __('labels.no_experience_standard') }}</h1>
    @else
        <h1>{{ __('labels.experience_list') }}</h1>
        @foreach ($experienciasPais as $experiencia)
            @if (!$experiencia->vip || ($experiencia->vip && $esVip))
                @component('components.experience-card')
                    @slot('ciudad', $experiencia->ciudad->ciudad)
                    @slot('pais')
                        {{ __('countries.' . $experiencia->ciudad->pais->pais) }}
                    @endslot
                    @slot('nombreExperiencia', $experiencia->nombre)
                    @slot('rutaImagen')

                        {{ $experiencia->imagen->first()
                            ? asset('storage/' . $experiencia->imagen->first()->ruta)
                            : asset('storage/images/no-image.jpg') }}

                    @endslot
                    @slot('fechas')
                        @foreach ($experiencia->exp_fecha as $fecha)
                            <p>{{ $fecha->fecha }}</p>
                        @endforeach
                    @endslot
                    @slot('esVip', $experiencia->vip)
                    @slot('descripcion', $experiencia->descripcion)
                    @slot('precio_adulto', $experiencia->getFormatedPrice())
                    @slot('dias', $experiencia->duracion)

                    @slot('esCliente', $esCliente)
                    {{-- Datos para abrir el formulario modal de reservas --}}
                    @slot('ruta', route('form.reserve', $experiencia->getEncryptedId()))
                    @slot('modal', 'modal-new-reserve')

                    @slot('rutaDetalle', route('experience.detail', $experiencia->nombre))

                    @slot('actividades')
                        @foreach ($experiencia->actividad as $actividad)
                            <li>{{ $actividad->nombre }}: {{ $actividad->descripcion }}</li>
                        @endforeach
                    @endslot
                @endcomponent
            @endif
        @endforeach
    @endif

</div>



{{-- Donde se inyectará la página modal --}}
@include('_partials.page-content')
