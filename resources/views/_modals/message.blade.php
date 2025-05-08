@if ($message = Session::get('success'))
    <div id="modal-message" class="modal center show">

        <div class="modal-content">
            <img src="{{ asset('storage/images/happy.svg') }}" alt="">
            <p>{{ $message }}</p>
            <a class="btn-standard" href="">
                <p>{{ __('buttons.close') }}</p>
            </a>
        </div>
    </div>
@endif

@if ($message = Session::get('error'))
    <div id="modal-message" class="modal center show">

        <div class="modal-content">
            <img src="{{ asset('storage/images/unhappy.svg') }}" alt="">
            <p>{{ $message }}</p>
            <a class="btn-standard" href="">
                <p>{{ __('buttons.close') }}</p>
            </a>
        </div>
    </div>
@endif
