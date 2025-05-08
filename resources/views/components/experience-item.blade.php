<h3 class="text-title-white">ID {{ $experiencia->id }} - {{ $experiencia->nombre }}</h3>
<div class="experience-item">
    <div class="item-container">
        <div class="up">
            <div class="left">

                <img src=" {{ $experiencia->imagen->first()
                    ? asset('storage/' . $experiencia->imagen->first()->ruta)
                    : asset('storage/images/no-image.jpg') }}"
                    alt="">


            </div>
            <div class="middle">
                @if ($experiencia->reserva->count() > 0)
                    <div class="destacado">
                        <p><b>{{ $experiencia->reserva->count() }} {{ __('labels.reservations') }}</b></p>
                    </div>
                @endif
                <p><b>{{ __('labels.name') }}: </b>{{ $experiencia->nombre }}</p>
                <p><b>{{ __('labels.location') }}: </b>{{ $experiencia->ciudad->ciudad }}
                    ({{ $experiencia->ciudad->pais->pais }})</p>
                <p><b>{{ __('labels.description') }}: </b>{{Str::limit($experiencia->descripcion_corta, 150, '...')}}</p>
                <p><b>{{ __('labels.price_adult') }}: </b> {{ $experiencia->getFormatedPrice() }}€</p>
                <p><b>{{ __('labels.price_child') }}: </b> {{ $experiencia->getFormatedPriceChild() }}€</p>
                <p><b>{{ __('labels.duration') }}: </b> {{ $experiencia->duracion }} días</p>

            </div>
            <div class="right">

                <div class="exp-fechas">
                    @foreach ($experiencia->exp_fecha as $fecha)
                        <p>{{ $fecha->fecha }}</p>
                    @endforeach

                </div>
            </div>

            <div class="button-container">
                <a class="btn-standard" href="{{ route('experience.modify', $experiencia->getEncryptedId()) }}">
                    <p>{{ __('buttons.modify_experience') }}</p>
                </a>

                <a class="btn-standard"
                    href="{{ route('activity.form', ['exp_id' => $experiencia->getEncryptedId(), 'act_id' => $experiencia->getEncryptedId(), 'mode' => 'create']) }}">
                    <p>{{ __('buttons.add_activity') }}</p>
                </a>

            </div>
        </div>
        <div class="down">

            @if ($experiencia->actividad->count() == 0)
                <p class="text-bold">{{ __('labels.no_activities') }}</p>
            @else
                <p class="text-bold">{{ __('labels.activities') }}</p>
                @foreach ($experiencia->actividad as $actividad)
                    <div class="activity-item">
                        <div class="left">
                            <a class="btn-standard"
                                href="{{ route('activity.form', ['exp_id' => $experiencia->getEncryptedId(), 'act_id' => $actividad->getEncryptedId(), 'mode' => 'modify']) }}">
                                <p>{{ __('buttons.edit') }}</p>
                            </a>
                        </div>

                        <div class="middle">
                            <img src="{{ $actividad->imagen ? asset('storage/' . $actividad->imagen) : asset('storage/images/no-image.jpg') }}"
                                alt="">
                        </div>

                        <div class="right">
                            <p><b>{{ __('labels.name') }}: </b>{{ $actividad->nombre }}</p>
                            <p><b>{{ __('labels.description') }}: </b>{!!Str::limit($actividad->descripcion, 150, '...')!!}</p>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>

</div>
