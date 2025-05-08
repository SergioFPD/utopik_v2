<div class="table-item">
    <div class="item-container">
        <table>
            <caption class="texto-oscuro">{{__('labels.provider_list')}}</caption>
            <thead>
                <tr>
                    <th>{{__('labels.name')}}</th>
                    <th>{{__('labels.email')}}</th>
                    <th>{{__('labels.experiences')}}</th>
                    <th>{{__('labels.reservations')}}</th>
                    <th>{{__('labels.blocked')}}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if ($providers != null)
                    @foreach ($providers as $provider)
                        @if ($provider->rol == 'proveedor')
                            <tr>
                                <td>{{ $provider->nombre }}</td>
                                <td>{{ $provider->email }}</td>
                                <td>{{ $provider->experienceCount() }}</td>
                                <td>{{ $provider->reserveCount() }}</td>
                                <td>{{ ($provider->bloqueado) ? __('labels.yes') : __('labels.no')}}</td>
                                <td>
                                    <button class="btn-standard"
                                    onclick="insertModalPage('{{ route('form.provider', $provider->getEncryptedId()) }}', 'modal-provider', false, true)">{{ __('buttons.modify') }}</button>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

</div>
