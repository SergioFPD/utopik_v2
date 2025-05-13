<div class="table-item">
    <div class="item-container">
        <table>
            <caption class="texto-oscuro">{{__('labels.customer_list')}}</caption>
            <thead>
                <tr>
                    <th>{{__('labels.name')}}</th>
                    <th>{{__('labels.email')}}</th>
                    <th>{{__('labels.rol')}}</th>
                    <th>{{__('labels.blocked')}}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if ($usuarios != null)
                    @foreach ($usuarios as $usuario)
                        @if ($usuario->rol != 'proveedor' && $usuario->email != Auth::user()->email)
                            <tr>
                                <td>{{ $usuario->nombre }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->rol }}</td>
                                <td>{{ ($usuario->bloqueado) ? __('labels.yes') : __('labels.no')}}</td>
                                <td>
                                    <button class="btn-standard"
                                        onclick="insertModalPage('{{ route('form.customer', $usuario->getEncryptedId()) }}', false, true)">{{ __('buttons.modify') }}</button>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

</div>
