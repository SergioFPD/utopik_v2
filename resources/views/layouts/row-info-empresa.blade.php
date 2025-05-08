@component('components.barra')
    @slot('color', 'fondo-azul-dos')
@endcomponent
<div class="carousel-container fondo-azul-dos row">
    <p class="text-title text-small texto-blanco">{{ __('descriptions.we_offer') }}</p>
    <div class="owl-carousel">
        @component('components.card2')
            @slot('rutaImagen')
                {{ asset('storage/images/icon1.svg') }}
            @endslot
            @slot('titulo')
                {{ __('descriptions.company_info1_title') }}
            @endslot
            @slot('descripcion')
                {{ __('descriptions.company_info1_description') }}
            @endslot
        @endcomponent

        @component('components.card2')
            @slot('rutaImagen')
                {{ asset('storage/images/icon2.svg') }}
            @endslot
            @slot('titulo')
                {{ __('descriptions.company_info2_title') }}
            @endslot
            @slot('descripcion')
                {{ __('descriptions.company_info2_description') }}
            @endslot
        @endcomponent

        @component('components.card2')
            @slot('rutaImagen')
                {{ asset('storage/images/icon3.svg') }}
            @endslot
            @slot('titulo')
                {{ __('descriptions.company_info3_title') }}
            @endslot
            @slot('descripcion')
                {{ __('descriptions.company_info3_description') }}
            @endslot
        @endcomponent
    </div>
</div>
