<div class="row-provider-login">
    <div class="provider-login-image">
        <div class="fundido-dos"></div>
        <img src="{{ asset('storage/images/menu_empresa.jpg') }}" alt="">

        <div class="provider-login-container">
            <div class="left">
                <p class="text-title text-small text-shadow">{{__('descriptions.provider_text1')}}</p>
                <p class="text-shadow"><img src="{{ asset('storage/images/check-mark.svg') }}" alt="">{{__('descriptions.provider_text2')}}</p>
                <p class="text-shadow"><img src="{{ asset('storage/images/check-mark.svg') }}" alt="">{{__('descriptions.provider_text3')}}</p>
                <p class="text-shadow"><img src="{{ asset('storage/images/check-mark.svg') }}" alt="">{{__('descriptions.provider_text4')}}</p>
                <a class="btn-standard gold-button" onclick="window.location.href='mailto:empresas@utopik.com'">
                    <p>{{__('buttons.provider_access')}}</p>
                </a>

            </div>

            <div class="right">

                <div class="form">
                    <h3>{{__('labels.company_access')}}</h3>
                    <form action="{{ route('login.provider') }}" method="post">
                        @csrf
                        <div class="form-inputs">
                            <input type="email" name="email" placeholder='{{ __('labels.email') }}' required>

                            <input type="password" name="password" placeholder='{{ __('labels.password') }}' required>
                            <div class="center-content">
                                <input class="btn-standard gold-button" type="submit"
                                    value="{{ __('buttons.access') }}">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
