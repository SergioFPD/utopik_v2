@extends('layouts.app')

@section('navMenu')
    @include('menus.nav-menu-profile')
@endsection

@section('content')
    <div class="content provider-login">

        @include('layouts.row-provider-login')

        @include('layouts.row-info-empresa')

        {{-- Footer variable según la página mostrada --}}
        @component('components.footer')
            @slot('footerContent')
                Este es el footer del provider login
            @endslot
        @endcomponent
    </div>
@endsection
