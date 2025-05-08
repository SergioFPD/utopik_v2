@extends('layouts.app')

@section('navMenu')
@include('menus.nav-menu-profile')
@endsection

@section('content')
    {{-- Recibe variable $experiencia y $mode en caso de modificacion --}}

    @php
        // Declaro variables del formulario para cada caso: Crear/Modificar
        if ($mode == 'modify') {
            $titulo = __('labels.modify_experience');
            $subtitulo = __('labels.activities_from') . $experiencia->nombre;
            $action = route('experience.update', $experiencia->getEncryptedId());
            $boton = __('buttons.save_experience');
            $nombre = $experiencia->nombre;
            $la_ciudad = $experiencia->ciudad->ciudad;
            $el_pais = $experiencia->ciudad->pais->pais;
            $descripcionCorta = $experiencia->descripcion_corta;
            $descripcion = $experiencia->descripcion;
            if ($experiencia->vip) {
                $vip = 'checked';
            } else {
                $vip = '';
            }
            if ($experiencia->activa) {
                $activa = 'checked';
            } else {
                $activa = '';
            }

            // Para las fechas, convierto los valores en un array
            // y éste en un string para pasar al formulario
            $las_fechas = [];
            if ($experiencia->exp_fecha != null) {
                foreach ($experiencia->exp_fecha as $una_fecha) {
                    $las_fechas[] = $una_fecha->fecha;
                }

                $las_fechas = json_encode($las_fechas);
            }

            $la_imagen = $experiencia->imagen->first()
                ? asset('storage/' . $experiencia->imagen->first()->ruta)
                : asset('storage/images/no-image.jpg');

            $duracion = $experiencia->duracion;
            $precio_adulto = $experiencia->precio_adulto;
            $precio_nino = $experiencia->precio_nino;
        } else {
            $titulo = __('labels.new_experience');
            $subtitulo = '';
            $action = route('experience-store');
            $boton = __('buttons.add_experience');
            $nombre = '';
            $la_ciudad = '';
            $el_pais = '';
            $descripcionCorta = '';
            $descripcion = '';
            $vip = '';
            $activa = 'checked';
            $las_fechas = '[]';
            $la_imagen = asset('storage/images/no-image.jpg');
            $duracion = '1';
            $precio_adulto = '200';
            $precio_nino = '200';
        }
    @endphp

    {{-- Formulario añadiendo las variables creadas --}}
    <div class="content form-experience">
        @component('components.row-profile')
            @slot('menuTitulo', $titulo)
            @slot('menuNombre', $subtitulo)
        @endcomponent
        <div class="exp-form-content">
            <form id="form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- Info block --}}
                <div class="exp-form-data">

                    <div class="left">
                        {{-- Nombre --}}
                        <label for="">{{ __('labels.name') }}</label>
                        <input type="text" id="nombreExp" name="nombre" value="{{ $nombre }}"
                            oninput="checkNombre('{{ $nombre }}')" required>
                        <span id="error-nombre"
                            style="color: red; display: none;">{{ __('labels.this_name_exists') }}</span>
                        @error('nombre')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                        {{-- Ciudad --}}
                        <label for="">{{ __('labels.city') }}</label>
                        <input type="text" name="ciudad" value="{{ $la_ciudad }}" required>
                        @error('ciudad')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                        {{-- Pais --}}
                        <label for="pais">{{ __('labels.select_country') }}</label>
                        <select id="pais" name="pais_id" required>
                            <option value="" selected disabled>{{ __('labels.select_country') }}</option>
                            @foreach ($paises as $pais)
                                @if ($pais->pais != 'World')
                                    <option value="{{ $pais->id }}" @if ($pais->pais == $el_pais) selected @endif>
                                        {{ $pais->pais }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="right">

                        {{-- Precio adulto --}}
                        <div class="group-col">
                            <div class="group-row">
                                <label for="">{{ __('labels.price_adult') }}</label>
                                <div class="slider-value"><span id="slider-value-adult">{{ $precio_adulto }}</span>€</div>
                            </div>
                            <input type="range" name="precio_adulto" min="200" max="10000" step="50"
                                value="{{ $precio_adulto }}" oninput="updateSliderValue(this.value, 'slider-value-adult')">
                        </div>

                        {{-- Precio niño --}}
                        <div class="group-col">
                            <div class="group-row">
                                <label for="">{{ __('labels.price_child') }}</label>
                                <div class="slider-value"><span id="slider-value-child">{{ $precio_nino }}</span>€</div>
                            </div>
                            <input type="range" name="precio_nino" min="200" max="10000" step="50"
                                value="{{ $precio_nino }}" oninput="updateSliderValue(this.value, 'slider-value-child')">
                        </div>
                        {{-- VIP --}}
                        <div class="group-input">

                            <input type="hidden" name="vip" value="0">
                            <input type="checkbox" name="vip" value="1" {{ $vip }} />
                            <label for="">{{ __('labels.is_vip') }}</label>
                        </div>

                        {{-- Activa --}}
                        <div class="group-input">

                            <input type="hidden" name="activa" value="0">
                            <input type="checkbox" name="activa" value="1" {{ $activa }} />
                            <label for="">{{ __('labels.active') }}</label>
                        </div>
                        {{-- Duración --}}

                        <div class="group-col">
                            <div class="group-row">
                                <label for="slider">{{ __('labels.days_count') }}</label>
                                <div class="slider-value"><span id="slider-value-duration">{{ $duracion }}</span></div>
                            </div>
                            <input type="range" name="duracion" min="1" max="20" step="1"
                                value="{{ $duracion }}"
                                oninput="updateSliderValue(this.value, 'slider-value-duration')">
                        </div>
                    </div>
                </div>

                <label for="">{{ __('labels.image_and_dates') }}</label>
                <div class="exp-form-date-img">

                    <div class="left">
                        {{-- Image --}}
                        <div class="experience-image">
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
                    <div class="right">
                        {{-- Dates --}}
                        <div>
                            <input class="btn-standard" type="text" id="fechaInput" value="Add date" readonly>
                        </div>
                        <div id="listaFechas" class="lista-fechas"></div>
                        <!-- Campo oculto para enviar las fechas al backend -->
                        <input type="hidden" name="fechas[]" id="fechasHidden" value="{{ $las_fechas }}" required>
                        @error('fechas*')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                {{-- Short description --}}
                <label for="">{{ __('labels.short_description') }}</label>
                <textarea name="descripcionCorta" rows="5">{{ $descripcionCorta }}</textarea>
                @error('descripcionCorta')
                    <p class="error-message">{{ $message }}</p>
                @enderror

                {{-- Description --}}
                <label for="">{{ __('labels.description') }}</label>
                <textarea id="editor-advanced" name="descripcion">{{ $descripcion }}</textarea>
                @error('descripcion')
                    <p class="error-message">{{ $message }}</p>
                @enderror

                <div class="button-container">
                    <input class="btn-standard" type="submit" value="{{ $boton }}">
                    <a class="btn-standard btn-cancel" href="{{ url()->previous() }}" class="btn">{{__('buttons.cancel')}}</a>
                </div>

            </form>

        </div>



        {{-- Footer variable según la página mostrada --}}
        @component('components.footer')
            @slot('footerContent')
                Este es el footer del formulario de experiencias
            @endslot
        @endcomponent

    </div>

@endsection
