@component('components.barra')
    @slot('color', 'fondo-blanco')
@endcomponent
@php
    $esVip = Auth::check() && (Auth::user()->vip || Auth::user()->rol == 'admin');
@endphp
<div class="carousel-container row">
    @if ($ultimasExperiencias == null || $ultimasExperiencias->count() == 0)
        <p class="text-title text-small texto-azul-dos">{{ __('labels.no_experience') }}</p>
    @else
        <p class="text-title text-small texto-azul-dos">{{ __('labels.discover-last') }}</p>
        <div class="owl-carousel">
            @foreach ($ultimasExperiencias as $experiencia)
                @if (!$experiencia->vip || ($experiencia->vip && $esVip))
                    @component('components.card1')
                        @slot('rutaImagen')

                            {{ $experiencia->imagen->first()
                                ? asset('storage/' . $experiencia->imagen->first()->ruta)
                                : asset('storage/images/no-image.jpg') }}

                        @endslot
                        @slot('nombreExperiencia', $experiencia->nombre)
                        @slot('esVip', $experiencia->vip)
                        @slot('descripcion', $experiencia->descripcion_corta)
                        @slot('ciudad', $experiencia->ciudad->ciudad)
                        @slot('pais', __('countries.' . $experiencia->ciudad->pais->pais))
                        @slot('rutaDetalle', route('experience.detail', $experiencia->nombre))
                        @slot('precio', $experiencia->getFormatedPrice())
                        {{-- @slot('dias', $experiencia->duracion)

                    @slot('esCliente', $esCliente) --}}
                    @endcomponent
                @endif
            @endforeach
        </div>
    @endif
</div>
