
@component('components.barra')
@slot('color', 'fondo-azul-tres')
@endcomponent
 <div class="row-footer">
 
        <div class="footer-left">
            <div class="footer-logo">
                <img src="{{ asset('storage/images/utopik_logo_footer.png') }}" alt="">
            </div>
        </div>
        <div class="footer-right">
            {{-- <p>{{$footerContent}}</p> --}}
            <p>Contacta con nosotros</p>
            <p>+677 453 433</p>
            <p>info@utopik.com</p>
        </div>
    </div>
