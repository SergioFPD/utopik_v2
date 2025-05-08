<!DOCTYPE html>
<html lang="{{App::getLocale()}}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Incluir jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Incluir jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Incluir jQuery UI JS -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <title>{{ __('labels.app-title') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    {{-- VER ERRORES --}}
     {{-- <div style="margin-top: 100px; color: #fff">
        <p>LISTA DE ERRORES</p>
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color: #fff">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div> --}}
    {{-- VER ERRORES END --}}

    {{-- Modal message window --}}
    @include('_modals.message')
    {{-- Navigation menu --}}
    @yield('navMenu')

    @yield('content')
</body>

</html>
