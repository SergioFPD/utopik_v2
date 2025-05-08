@component('components.barra')
    @slot('color', 'fondo-azul-dos')
@endcomponent
<div class="row-video row">
    <div class="video-container">
        <iframe width="560" height="315"
            src="https://www.youtube.com/embed/Rx7VBDrGyDQ?si=49G_asKsotPIE2Et=hd720&rel=0&controls=1&modestbranding=1"
            title="YouTube video player"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen>
        </iframe>


    </div>
    <p class="text-title text-small texto-blanco">{{ __('labels.explore-utopic') }}</p>

</div>
