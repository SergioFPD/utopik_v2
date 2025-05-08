@foreach (Config::get('languages') as $lang => $language)
    @if ($lang != App::getLocale())
        <a href="{{ route('lang', $lang) }}"><img
                src="
            
            @if ($lang == 'es') {{ asset('storage/images/flag-spain.svg') }}
@else
{{ asset('storage/images/flag-united-kingdom.svg') }} @endif
            
            "
                alt="">
        </a>
    @endif
@endforeach
