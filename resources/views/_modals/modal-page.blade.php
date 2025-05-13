{{-- Se usa para inyectar una página cargada por JS a través de una ruta --}}
<div class="loading-spinner" id="spinner">
    {{-- Spinner de espera mientras se carga --}}
    <img src="{{ asset('storage/images/loading-icon.svg') }}" alt="Loading...">
</div>
<div id="modal-page" class="modal center @if ($errors->all() && $errors->has('modal-page')) show @endif">

    <div class="modal-content fondo-modal" id="modalPageContent">

        {{-- Contenido de la página modal --}}
    </div>
</div>
