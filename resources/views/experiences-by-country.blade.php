@extends('layouts.app')
@php
    $esVip = Auth::check() && (Auth::user()->vip || Auth::user()->rol == 'admin');
    $esCliente = Auth::check() && Auth::user()->rol == 'cliente';
@endphp

@section('navMenu')
    @include('menus.nav-menu')
@endsection

@section('content')
    <div class="content experiences">
        @if ($paisElegido != null)
            @component('components.row-country-head')
                @slot('pais')
                {{__('countries.'.$paisElegido->pais)}}
                @endslot
                @slot('descripcion', $paisElegido->descripcion)
                @slot('imagenPais', asset('storage/' . $paisElegido->imagen))
            @endcomponent
        @endif

        @include('layouts.row-experiences')

        @include('layouts.row-conditions')

        @include('layouts.row-last-experiences')

        {{-- Footer variable según la página mostrada --}}
        @component('components.footer')
            @slot('footerContent')
                Este es el footer del landing
            @endslot
        @endcomponent
    </div>
@endsection
