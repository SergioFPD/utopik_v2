{{-- <div id="modal-pay-rest" class="modal center @if ($errors->all() && $errors->has('modal-pay-rest')) show @endif">

    <div class="modal-content fondo-modal"> --}}
        <h3>{{ __('labels.pay_rest') }}</h3>
        <hr>
        @if ($reserva != 'error')
            <p>{{__('labels.rest_to_pay')}}: {{ number_format($reserva->dimePorPagar(), 0, ',', '.')}}€</p>
        @endif
        <br><br>
        <hr>
        <span class="close">&times;</span>
        <form action="" method="post">
            @csrf
            <label>{{ __('labels.name') }}</label>
            <input type="text" name="name">
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <label>{{ __('labels.cardid') }}</label>
            <input type="number" name="cardid" required>
            @error('cardid')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <hr>
            <p style="color: red">SISTEMA DE PAGO SIN IMPLEMENTAR</p>
            {{-- <input class="btn-standard" type="submit" value="{{ __('buttons.pay') }}"> --}}
        </form>
    {{-- </div> --}}
{{-- </div> --}}
