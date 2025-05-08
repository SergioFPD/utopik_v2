@component('components.barra')
    @slot('color', 'fondo-azul-tres')
@endcomponent
<div class="row-act-card-right row fondo-azul-tres">

    <div class="card-activity">

        <div class="card-act-container">

            <div class="col-left">
                <div class="act-info">
                    <h3>{{ $nombreActividad }}</h3>
                    <p>{!! $descripcion !!}</p>

                </div>
                <div class="day-box fondo-blanco texto-azul-tres">
                    <p>{{ __('labels.during') }}&nbsp;{{ $dias }}&nbsp;{{ __('labels.days') }}</p>
                </div>

            </div>
            <div class="col-right">
                <img src="{{ $imagenActividad }}" alt="">
            </div>
        </div>

    </div>
</div>
