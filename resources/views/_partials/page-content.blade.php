{{-- Se usa para inyectar una página cargada por JS a través de una ruta --}}
<div class="loading-spinner" id="spinner">
    {{-- Spinner de espera mientras se carga --}}
    <img src="{{ asset('storage/images/loading-icon.svg') }}" alt="Loading...">
</div>
<div class="modal-body" id="modalPageContent">
    <!-- Aquí se cargará dinámicamente el contenido -->

</div>
