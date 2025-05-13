<div class="card-booking">
    <div class="left">
        <p class="book-description text-shadow">{{ $descripcionCorta }}</p>
        <div class="fundido-down"></div>
        <img src="{{ $rutaImagen }}" alt="">
    </div>
    <div class="right">
        @if ($esVip)
        <div class="exp-vip-card1">
            <p class="vip-rotate-card1">VIP</p>
        </div>
    @endif

        <p class="book-title">{{ $titulo }}</p>

        <div class="book-info">
            <p class="box1">{{ $dias }}&nbsp;{{ __('labels.days') }}</p>
            <p class="box1">{{ $adultos }}&nbsp;{{ __('labels.adults') }}</p>
            @if ($menores > 0)
                <p class="box1">{{ $menores }}&nbsp;{{ __('labels.childs') }}</p>
            @endif
        </div>
        <div class="price-box">
            <p>{{ __('labels.total_price') }}</p>
            <p>{{ number_format($precioTotal, 0, ',', '.') }}€</p>
        </div>
        <div class="price-box">
            <p>{{ __('labels.reservation_of') }}</p>
            <p>{{ number_format($pagoReserva, 0, ',', '.')}}€</p>
        </div>
        <div class="price-box">
            <p>{{ __('labels.rest_to_pay') }}</p>
            <p>{{ number_format($restoPagar, 0, ',', '.') }}€</p>
        </div>

        <p class="text-bold">{{ __('labels.departure_on') }}
            @component('components.fecha')
                @slot('fecha')
                    {{ $fecha }}
                @endslot
            @endcomponent
        </p>

        <div class="button-box">
            <a class="btn-standard" href="{{ route('experience.detail', $experienciaNombre) }}">
                <p>{{ __('buttons.view_experience') }}</p>
            </a>
            @if($restoPagar>0)
            <a class="btn-standard"  onclick="insertModalPage('{{ route('payment', $reservaId) }}', 'modal-pay-rest', false, false)">
                <p>{{ __('buttons.pay_all') }}</p>
            </a>
            @endif
        </div>
    </div>
</div>

{{-- Donde se inyectará la página modal --}}
{{-- @include('_partials.page-content') --}}
@include('_modals.modal-page')