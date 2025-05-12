<div id="modal-contact" class="modal center @if($errors->all() && $errors->has('modal-contact')) show @endif">

    <div class="modal-content fondo-modal">
        <h3>{{ __('labels.form_contact') }}</h3>
        <hr>
        <span class="close">&times;</span>
        <form action="{{ route('contact') }}" method="post">
            @csrf
            <label>{{ __('labels.company') }}</label>
            <input type="text" name="company" required>
            @error('company')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <label>{{ __('labels.email') }}</label>
            <input type="email" name="email" required>
            @error('email')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <label>{{ __('labels.message') }}</label>
            <textarea name="message" rows="4" placeholder="{{ __('labels.your_message') }}" required></textarea>
            @error('message')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <hr>
            <input class="btn-standard" type="submit" value="{{ __('buttons.send') }}">
        </form>
    </div>
</div>
