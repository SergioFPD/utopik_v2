@extends('layouts.app')

@section('navMenu')
    @include('menus.nav-menu')
@endsection

@section('content')
    <div class="content home">
        {{-- @php
            $esVip = Auth::check() && (Auth::user()->vip || Auth::user()->rol == 'admin');
            $esCliente = Auth::check() && Auth::user()->rol == 'cliente';
        @endphp --}}
        @include('layouts.row-home-head')

        @include('layouts.row-last-experiences')

        @include('layouts.row-video')


        {{-- Footer variable según la página mostrada --}}
        @component('components.footer')
            @slot('footerContent')
                Este es el footer del home
            @endslot
        @endcomponent
    </div>
@endsection
