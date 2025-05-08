<div class="modal-menu-responsive">
    <p>☰</p>
    <div class="modal responsive">
        <div class="responsive-content">
            <div class="botonera-responsive">
                @if (!$logeado)
                    <a class="btn-standard" onclick="openModal('modal-register')">
                        <p>{{ __('buttons.register') }}</p>
                    </a>
                @endif

                @if (($logeado && $rol != 'cliente') || !$logeado)
                    <a class="btn-standard gold-button" href="{{ $rutaPerfil }}">
                        <p>{{ $nomBoton }}</p>
                    </a>
                @endif
                @if ($logeado && $rol != 'cliente')
                <a class="btn-standard alpha2" href="{{ route('logout') }}">
                    <p>{{ __('buttons.logout') }}</p>
                </a>
            @endif
            </div>
        </div>

    </div>
</div>
