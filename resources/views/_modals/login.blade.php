<div class="modal-login-row">
    <p>{{ __('buttons.login') }}</p>
    <div class="modal login">
        <div class="login-content">
            <h3>{{ __('labels.hello_traveler') }}</h3>
            <form action="{{ route('login.user') }}" method="post">
                @csrf

                <div class="form-inputs">
                    <input type="email" name="email" placeholder='{{ __('labels.email') }}' required>

                    <input type="password" name="password" placeholder='{{ __('labels.password') }}' required>
                    <div class="center-content">
                        <input class="btn-standard" type="submit" value="{{ __('buttons.access') }}">
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
