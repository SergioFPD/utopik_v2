@php
    $imagen = $customer->imagen ? asset('storage/' . $customer->imagen) : asset('storage/images/no-image.jpg');
    $mensaje = __('alerts.delete_customer', ['name' => $customer->nombre]);
@endphp
<div id="modal-userdata" class="modal center">
    <div class="modal-content">
        <h3>{{ __('labels.modify_customer') }}</h3>

        <span class="close">&times;</span>
        <form id="myForm" action="{{route('admin.customer.update', $customer->getEncryptedId())}}" method="post">
            @method('PUT')
            @csrf
            <div class="data">

                <div class="left">
                    <p id="nombre">{{ __('labels.name') }}: {{ $customer->nombre }}</p>
                    {{-- estate --}}
                    <div class="group-input">

                        <input type="hidden" name="bloqueado" value="0">
                        <input type="checkbox" name="bloqueado" value="1"
                            {{ $customer->bloqueado ? 'checked' : '' }} />
                        <label for="">{{ __('labels.blocked') }}</label>
                    </div>
                    {{-- Rol --}}
                    <select id="rol" name="rol">
                        <option value="cliente" {{ $customer->rol == 'cliente' ? 'selected' : '' }}>
                            {{ __('labels.customer') }}
                        </option>
                        <option value="admin" {{ $customer->rol == 'admin' ? 'selected' : '' }}>
                            {{ __('labels.admin') }}
                        </option>
                    </select>

                </div>
                <div class="right">

                    <div class="image-container">

                        <img src="{{ $imagen }}" alt="">
                    </div>

                </div>

            </div>


            <div class="button-contanier">
                <input id="submitButton" class="btn-standard" type="submit" value="{{ __('buttons.modify') }}">
            </div>
        </form>
        <div class="button-contanier">
            <form action="{{route('admin.customer.delete', $customer->getEncryptedId())}}" method="post" onsubmit="return confirmDelete('{{$mensaje}}');">
                @method('DELETE')
                @csrf
                <input class="btn-standard" type="submit" value="{{ __('buttons.delete') }}">
            </form>

        </div>

    </div>
</div>
