<div class="table-item">
    <div class="item-container">
        <table>
            <caption class="texto-oscuro">{{ __('labels.country_list') }}</caption>
            <thead>
                <tr>
                    <th>{{ __('labels.image') }}</th>
                    <th>{{ __('labels.name') }}</th>
                    <th>{{ __('labels.description') }}</th>
                    <th>{{ __('labels.visible') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if ($paises != null)
                    @foreach ($paises as $pais)
                        <tr>
                            <td><img src="{{ $pais->imagen
                                ? asset('storage/' . $pais->imagen)
                                : asset('storage/images/no-image.jpg') }}" alt=""></td>
                            <td>{{ $pais->pais }}</td>
                            <td ><div class="description">{{ $pais->descripcion }}</div></td>
                            <td>{{ $pais->activo ? __('labels.yes') : __('labels.no') }}</td>
                            <td>
                                <button class="btn-standard"
                                    onclick="insertModalPage('{{ route('form.country', $pais->getEncryptedId()) }}', 'modal-country-form', true, true)">{{ __('buttons.modify') }}</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

</div>
