<?php
$today = new DateTime();
$today = date('Y-m-d');

$puedePuntuar = false;
?>

<div class="table-item">
    <div class="item-container">
        <table>
            <caption class="text-title-white">{{ __('labels.reserve_list') }}</caption>
            <thead>
                <tr>
                    <th>{{ __('labels.name') }}</th>
                    <th>{{ __('labels.date') }}</th>
                    <th>{{ __('labels.customer') }}</th>
                    <th>{{ __('labels.email') }}</th>
                    <th>{{ __('labels.adults') }}</th>
                    <th>{{ __('labels.childs') }}</th>
                    <th>{{ __('labels.total') }}</th>
                    <th>{{ __('labels.evaluation') }}</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($experiencias as $experiencia)
                    @if ($experiencia->reserva != null)
                        @foreach ($experiencia->reserva as $reserva)
                            <tr>
                                <td>{{ $experiencia->nombre }}</td>
                                <td>
                                    @if ($reserva->exp_fecha && $reserva->exp_fecha->fecha)
                                        @if ($reserva->exp_fecha->fecha > $today)
                                            {{ $reserva->exp_fecha->fecha }}
                                        @else
                                            {{ __('labels.date_expired') }}
                                            @php $puedePuntuar = true @endphp
                                        @endif
                                    @else
                                        {{ __('labels.date_unknown') }}
                                    @endif
                                </td>

                                <td>{{ $reserva->user->nombre }}</td>
                                <td>{{ $reserva->user->email }}</td>
                                <td>{{ $reserva->adultos }}</td>
                                <td>{{ $reserva->menores }}</td>
                                <td>{{ $reserva->dimePrecioTotal() }}€</td>
                                <td>
                                    @if (!$puedePuntuar)
                                        {{ __('labels.not_finished') }}
                                    @elseif($reserva->puntuacion == 0)
                                        <button class="btn-standard"
                                            onclick="insertModalPage('{{ route('form.evaluate', $reserva->getEncryptedId()) }}', 'modal-reserve-rate', false, false)">{{ __('buttons.evaluate') }}</button>
                                    @else
                                        {{ $reserva->puntuacion . ' ' . __('labels.points') }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach

            </tbody>
        </table>
    </div>

</div>
