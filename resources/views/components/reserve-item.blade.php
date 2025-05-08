<?php
$today = new DateTime();
$today = date('Y-m-d');
?>

<div class="table-item">
    <div class="item-container">
        <table>
            <caption class="text-title-white">{{__('labels.reserve_list')}}</caption>
            <thead>
                <tr>
                    <th>{{__('labels.name')}}</th>
                    <th>{{__('labels.date')}}</th>
                    <th>{{__('labels.customer')}}</th>
                    <th>{{__('labels.email')}}</th>
                    <th>{{__('labels.adults')}}</th>
                    <th>{{__('labels.childs')}}</th>
                    <th>{{__('labels.total')}}</th>
                    <th>{{__('labels.evaluation')}}</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($experiencias as $experiencia)
                    @if ($experiencia->reserva != null)
                        @foreach ($experiencia->reserva as $reserva)
                            <tr>
                                <td>{{ $experiencia->nombre }}</td>
                                <td>{{ $reserva->exp_fecha->fecha < $today ? __('labels.date_expired') : $reserva->exp_fecha->fecha }}
                                </td>
                                <td>{{ $reserva->user->nombre }}</td>
                                <td>{{ $reserva->user->email }}</td>
                                <td>{{ $reserva->adultos }}</td>
                                <td>{{ $reserva->menores }}</td>
                                <td>{{ $reserva->dimePrecioTotal() }}€</td>
                                <td>
                                    @if ($reserva->exp_fecha->fecha >= $today)
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
