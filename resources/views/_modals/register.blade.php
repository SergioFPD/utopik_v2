<div id="modal-register" class="modal center @if($errors->all() && $errors->has('modal-register')) show @endif">

    <div class="modal-content fondo-modal">
        <h3>{{ __('labels.form_register') }}</h3>
        <hr>
        <span class="close">&times;</span>
        <form action="{{ route('register.user') }}" method="post">
            @csrf
            <label>{{ __('labels.name') }}</label>
            <input type="text" name="nombre" required>
            @error('nombre')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <label>{{ __('labels.email') }}</label>
            <input type="email" name="email" required>
            @error('email')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <label>{{ __('labels.password') }}</label>
            <input type="password" name="password" required>
            @error('password')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <hr>
            <input class="btn-standard" type="submit" value="{{ __('buttons.register') }}">
        </form>
    </div>
</div>
