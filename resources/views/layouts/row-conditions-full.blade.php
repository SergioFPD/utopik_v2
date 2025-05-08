@component('components.barra')
    @slot('color', 'fondo-claro')
@endcomponent
<div class="row-terms row">
    <div class="terms-container">

        <h3>{{__('descriptions.reserve_conditions_title')}}</h3>
        <p>{!! __('descriptions.reserve_terms')!!}</p>
        <hr>
        <h3>{{__('descriptions.reserve_refund_title')}}</h3>
        <p>{!! __('descriptions.reserve_refund')!!}</p>
    </div>
</div>

