{{-- <div id="modal-new-reserve" class="modal center @if ($errors->all() && $errors->has('modal-new-reserve')) show @endif">
    <div class="modal-content"> --}}
{{-- Se recibe variable "experiencia" --}}
<div class="new-reserve">
    <span class="close">&times;</span>

    <div class="res-image-container">
        <div class="fundido-down"></div>
        <img src="{{ $experiencia->imagen->first()
            ? asset('storage/' . $experiencia->imagen->first()->ruta)
            : asset('storage/images/no-image.jpg') }}"
            alt="">
        <div class="res-title">

            <p>{{ __('labels.new_reserve') }}</p>
            <p class="text-nomal">{{ $experiencia->nombre }}</p>

        </div>
    </div>
    <div>
        <form action="{{ route('reserve.store') }}" method="post">
            @csrf
            <input type="hidden" value="{{ $experiencia->getEncryptedId() }}" name="experiencia_id">
            {{-- date --}}
            <label for="">{{ __('labels.departure_date') }}</label>
            <select id="data_options" name="exp_fecha_id" required>
                <option value="" selected disabled>{{ __('labels.select_date') }}</option>
                @foreach ($experiencia->exp_fecha as $fecha)
                    <option value="{{ $fecha->id }}">

                        @component('components.fecha')
                            @slot('fecha', $fecha->fecha)
                        @endcomponent
                    </option>
                @endforeach

            </select>
            {{-- adults --}}
            <div class="data-enter">
                <div class="values">
                    <div class="left">
                        <label for="slider">{{ __('labels.num_adult') }}</label>
                        <p class="price">{{ number_format($experiencia->precio_adulto, 0, ',', '.') }}€</p>
                    </div>
                    <div class="right">
                        <div class="slider-value"><span id="slider-value-adults">1</span></div>
                    </div>

                </div>
                <input type="range" id="value-adults" name="adultos" min="1" max="10" step="1"
                    value="1"
                    oninput="updateSliderValue(this.value, 'slider-value-adults', {{ $experiencia->precio_adulto }}, {{ $experiencia->precio_nino }})">
            </div>
            <hr>

            {{-- childs --}}
            <div class="data-enter">
                <div class="values">
                    <div class="left">
                        <label for="slider">{{ __('labels.num_child') }}</label>
                        <p class="price">{{ number_format($experiencia->precio_nino, 0, ',', '.') }}€</p>
                    </div>
                    <div class="right">
                        <div class="slider-value"><span id="slider-value-child">0</span></div>
                    </div>

                </div>
                <input type="range" id="value-child" name="menores" min="0" max="10" step="1"
                    value="0"
                    oninput="updateSliderValue(this.value, 'slider-value-child', {{ $experiencia->precio_adulto }}, {{ $experiencia->precio_nino }})">
            </div>
            <hr>

            {{-- total price --}}
            <div class="amount">
                <p>{{ __('labels.amount') }}</p>
                <p id="total-price">{{ number_format($experiencia->precio_adulto, 0, ',', '.') }}€</p>
            </div>
            <div class="amount">
                <p>{{ __('labels.reservation') }}</p>
                <p id="total-booking">395€</p>
            </div>
            <hr>


            <input class="btn-standard" type="submit" value="{{ __('buttons.pay_reserve') }}">
        </form>
    </div>
</div>
{{-- </div>
</div> --}}
