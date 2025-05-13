    <div class="reserve-rate">
        <h3 id="nombre">{{ __('labels.rating_customer') }} {{ $customer }}</h3>
        <span class="close">&times;</span>
        <form action="{{ route('rate.customer', $reservation->getEncryptedId()) }}" method="post">
            @method('PUT')
            @csrf

            {{-- Question one --}}

            <div class="group-col">
                <div class="group-row">
                    <p>{{ __('questions.question_one') }}</p>
                    <div class="slider-value"><span id="slider-value-one">1</span></div>
                </div>
                <input type="range" name="one" min="1" max="10" step="1" value="1"
                    oninput="updateSliderValue(this.value, 'slider-value-one')">
            </div>

            {{-- Question two --}}
            <div class="group-col">
                <div class="group-row">
                    <p>{{ __('questions.question_two') }}</p>
                    <div class="slider-value"><span id="slider-value-two">1</span></div>
                </div>
                <input type="range" name="two" min="1" max="10" step="1" value="1"
                    oninput="updateSliderValue(this.value, 'slider-value-two')">
            </div>

            {{-- Question tree --}}
            <div class="group-col">
                <div class="group-row">
                    <p>{{ __('questions.question_three') }}</p>
                    <div class="slider-value"><span id="slider-value-three">1</span></div>
                </div>
                <input type="range" name="three" min="1" max="10" step="1" value="1"
                    oninput="updateSliderValue(this.value, 'slider-value-three')">
            </div>

            {{-- Question four --}}
            <div class="group-col">
                <div class="group-row">
                    <p>{{ __('questions.question_four') }}</p>
                    <div class="slider-value"><span id="slider-value-four">1</span></div>
                </div>
                <input type="range" name="four" min="1" max="10" step="1" value="1"
                    oninput="updateSliderValue(this.value, 'slider-value-four')">
            </div>

            {{-- Question five --}}
            <div class="group-col">
                <div class="group-row">
                    <p>{{ __('questions.question_five') }}</p>
                    <div class="slider-value"><span id="slider-value-five">1</span></div>
                </div>
                <input type="range" name="five" min="1" max="10" step="1" value="1"
                    oninput="updateSliderValue(this.value, 'slider-value-five')">
            </div>

            {{-- Question six --}}
            <div class="group-col">
                <div class="group-row">
                    <p>{{ __('questions.question_six') }}</p>
                    <div class="slider-value"><span id="slider-value-six">1</span></div>
                </div>
                <input type="range" name="six" min="1" max="10" step="1" value="1"
                    oninput="updateSliderValue(this.value, 'slider-value-six')">
            </div>

            {{-- Question seven --}}
            <div class="group-col">
                <div class="group-row">
                    <p>{{ __('questions.question_seven') }}</p>
                    <div class="slider-value"><span id="slider-value-seven">1</span></div>
                </div>
                <input type="range" name="seven" min="1" max="10" step="1" value="1"
                    oninput="updateSliderValue(this.value, 'slider-value-seven')">
            </div>

            <input class="btn-standard" type="submit" value="{{ __('buttons.send_evaluation') }}">
        </form>
    </div>
