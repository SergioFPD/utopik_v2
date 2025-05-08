@component('components.barra')
    @slot('color', 'fondo-azul-dos')
@endcomponent
<div class="row-conditions row">
    <div class="conditions-container">

        <h3>{{__('descriptions.reserve_conditions_title')}}</h3>
        <p>{!! __('descriptions.reserve_conditions')!!}</p>
    </div>
</div>

