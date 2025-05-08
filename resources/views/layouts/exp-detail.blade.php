<div class="content detail">
    <h3>Detalle de experiencia</h3>
    @if ($experiencia == null)
        <p>Experiencia no encontrada</p>
    @else
        <p>{{ $experiencia->nombre }}</p>
        <img style="width: 100%; height: 100%; object-fit: cover;"
            src="{{ $experiencia->imagen->first() ? asset('storage/' . $experiencia->imagen->first()->ruta) : asset('storage/images/no-image.jpg') }}"
            alt="">
        @if ($experiencia->vip)
            <p>Es una experiencia VIP</p>
        @endif

        @if (Auth::check() && Auth::user()->rol == 'cliente')
            <a class="btn-standard"
                onclick="insertModalPage('{{ route('form.reserve', $experiencia->getEncryptedId()) }}', 'modal-new-reserve', false)">
                <p>{{ __('buttons.make_reserve') }}</p>
            </a>
        @endif

    @endif
    {{-- Donde se inyectará la página modal --}}
    @include('_partials.page-content')
</div>
