@component('components.barra')
    @slot('color' , 'fondo-blanco')
@endcomponent
<div class="row-act-card-left fondo-blanco row">

    <div class="card-activity">

        <div class="card-act-container">

            <div class="col-left">
                <img src="{{ $imagenActividad }}" alt="">
            </div>
            <div class="col-right">
                <div class="act-info">
                    <h3>{{ $nombreActividad }}</h3>
                    <p>{!! $descripcion !!}</p>

                </div>
                <div class="day-box fondo-azul-tres texto-blanco">
                    <p>{{ __('labels.during') }}&nbsp;{{ $dias }}&nbsp;{{ __('labels.days') }}</p>
                </div>
            </div>
        </div>

    </div>
</div>
