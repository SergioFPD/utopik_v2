<div class="row-detail row">
    <div class="country-image">
        <div class="details-header-title">
            <p class="text-title text-small text-shadow texto-blanco">{{ $pais }}</p>
            <p class="text-title text-medium text-shadow texto-blanco">{{ $nombre }}</p>
            <div class="head-bottom">
                <div class="info-container">
                    <div class="book-info">
                        <p>{{ number_format($precioAdulto, 0, ',', '.') }}€&nbsp;{{ __('labels.adults') }} /
                            {{ number_format($precioMenor, 0, ',', '.') }}€&nbsp;{{ __('labels.childs') }}</p>
                    </div>
                    <div class="book-info">
                        <p>{{ $dias }}&nbsp;{{ __('labels.days') }}</p>
                    </div>
                </div>
                @if (Auth::check() && Auth::user()->rol == 'cliente')
                    <a class="btn-standard gold"
                        onclick="insertModalPage('{{ route('form.reserve', $rutaReserva) }}', true, false)">
                        <p>{{ __('buttons.make_reserve') }}</p>
                    </a>
                @endif
            </div>
        </div>
        <div class="fundido-tres"></div>
        <img src="{{ $imagenExperiencia }}" alt="">


        {{-- <div class="barra-azul"></div> --}}
    </div>

    <div class="country-description">
        @if ($esVip)
            <h3 class="text-small texto-oro text-shadow">{{ __('labels.the_vip_experience') }}</h3>
        @else
            <h3 class="text-small texto-oro text-shadow">{{ __('labels.the_experience') }}</h3>
        @endif

        <p>{!! $descripcion !!}</p>
    </div>
</div>

{{-- Donde se inyectará la página modal --}}
@include('_modals.modal-page')
