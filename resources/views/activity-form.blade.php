@extends('layouts.app')

@section('navMenu')
    @include('menus.nav-menu-profile')
@endsection

@section('content')
    {{-- Recibe variable $experiencia, $actividad y $modo --}}

    @php
        // Declaro variables del formulario

        $subtitulo = __('labels.activities_from') . $experiencia->nombre;

        if ($mode == 'modify') {
            $textoBoton = __('buttons.update_activity');
            $titulo = __('labels.modify_activity');
            $action = route('activity.update', $actividad->getEncryptedId());
            $nombre = $actividad->nombre;
            $descripcion = $actividad->descripcion;
            $dias = $actividad->dia;
            $la_imagen = $actividad->imagen
                ? asset('storage/' . $actividad->imagen)
                : asset('storage/images/no-image.jpg');
        } else {
            $textoBoton = __('buttons.save_activity');
            $titulo = __('labels.add_activity');
            $action = route('activity.store');
            $nombre = '';
            $descripcion = '';
            $dias = '1';
            $la_imagen = asset('storage/images/no-image.jpg');
        }

    @endphp

    {{-- Formulario añadiendo las variables creadas --}}
    <div class="content form-activity">
        @component('components.row-profile')
            @slot('menuTitulo', $titulo)
            @slot('menuNombre', $subtitulo)
        @endcomponent
        <div class="act-form-content row">

            <div class="act-item-content">
                <form id="form" action="{{ $action }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="experience_id" value="{{ $experiencia->getEncryptedId() }}">
                    {{-- Info block --}}
                    <div class="act-form-data">

                        <div class="left">
                            {{-- Nombre --}}
                            <label for="">{{ __('labels.name') }}</label>
                            <input type="text" id="nombreExp" name="nombre" value="{{ $nombre }}" required>
                            @error('nombre')
                                <p class="error-message">{{ $message }}</p>
                            @enderror

                            {{-- Dias --}}
                            <div class="group-col">
                                <div class="group-row">
                                    <label for="">{{ __('labels.days') }}</label>
                                    <div class="slider-value"><span id="slider-value-days">{{ $dias }}</span></div>
                                </div>
                                <input type="range" name="dia" min="1" max="30" step="1"
                                    value="{{ $dias }}"
                                    oninput="updateSliderValue(this.value, 'slider-value-days')">
                            </div>
                        </div>

                        <div class="right">
                            <div class="act-form-date-img">
                                {{-- Image --}}
                                <div class="activity-image">
                                    <label for="image" class="btn-standard">{{ __('buttons.charge_image') }}</label>
                                    @error('image')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror

                                    <input type="file" name="image" id="image" accept="image/*">
                                </div>
                                <div class="image-preview-container">
                                    <!-- Contenedor para la previsualización -->
                                    <img id="image-preview" src="{{ $la_imagen }}" alt="experience">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="act-description">
                        {{-- Description --}}
                        <label for="">{{ __('labels.description') }}</label>
                        <textarea id="editor-advanced" name="descripcion">{{ $descripcion }}</textarea>
                        @error('descripcion')
                            <p class="error-message">{{ $message }}</p>
                        @enderror

                    </div>
                    <div class="button-container">
                        <input class="btn-standard" type="submit" value="{{$textoBoton}}">
                        <a class="btn-standard btn-cancel" href="{{ url()->previous() }}" class="btn">{{__('buttons.cancel')}}</a>
                    </div>
                </form>

                <div class="button-container">

                    @if ($mode == 'modify')
                        <form action="{{ route('activity.delete', $actividad->getEncryptedId()) }}" method="post" onsubmit="return confirmDelete('{{__('alerts.delete_activity')}}');">
                            @method('DELETE')
                            @csrf
                            <input class="btn-standard delete" type="submit" value="{{ __('buttons.delete_activity') }}">
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- Footer variable según la página mostrada --}}
        @component('components.footer')
            @slot('footerContent')
                Este es el footer del formulario de actividad
            @endslot
        @endcomponent
    </div>

@endsection
