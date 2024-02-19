<div class="tab-pane fade show active" id="nav-baggage" role="tabpanel" aria-labelledby="nav-baggage-tab">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="faqs_main_item">
                @isset($acc_response['ancillaryQuotes']['flights'])
                    @php
                        $flightLoop = 1;
                    @endphp
                    @foreach ($acc_response['ancillaryQuotes']['flights'] as $flights)
                        @php
                            $segments = $flights['segments'];
                            $segment_details = getSegmentDetails($segments['lfID'], $segments['depDate'], $res_data['search_result']['segmentDetails']);
                        @endphp
                        <div class="accordion" id="accordionExample{{ $segments['lfID'] }}">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne{{ $segments['lfID'] }}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne{{ $segments['lfID'] }}" aria-expanded="true"
                                        aria-controls="collapseOne{{ $segments['lfID'] }}">
                                        <div class="flight-card flights-list__item">
                                            <div class="flight-card-list-dt">
                                                <div class="flight-card__departure">
                                                    <h2 class="flight-card__city">
                                                        {{ getAirportData($segment_details['Origin'])['AirportName'] }}
                                                        ({{ $segment_details['Origin'] }})
                                                    </h2>
                                                </div>

                                                <div class="flight-card__route">
                                                    <div class="flight-card__route-line route-line" aria-hidden="true">
                                                        <i class="fas fa-plane-departure"></i>
                                                    </div>
                                                </div>

                                                <div class="flight-card__arrival">
                                                    <h2 class="flight-card__city">
                                                        {{ getAirportData($segment_details['Destination'])['AirportName'] }}
                                                        ({{ $segment_details['Destination'] }})</h2>
                                                </div>
                                            </div>

                                        </div>
                                    </button>
                                </h2>
                                <div id="collapseOne{{ $segments['lfID'] }}" class="accordion-collapse collapse show"
                                    aria-labelledby="headingOne{{ $segments['lfID'] }}"
                                    data-bs-parent="#accordionExample{{ $segments['lfID'] }}" style="">
                                    <div class="accordion-body">

                                        <div class="tabs-menus"> <!-- Tabs -->
                                            <ul class="nav panel-tabs" role="tablist">
                                                @if (isset($passengers['ADT']))
                                                    @for ($ad = 1; $ad <= $passengers['ADT']; $ad++)
                                                        <li class="">
                                                            <a href="#tab{{ $segments['lfID'] }}ADT{{ $ad }}"
                                                                class="tabselector {{ $flightLoop == 1 && $ad == 1 ? 'active' : '' }}"
                                                                data-bs-toggle="tab"
                                                                aria-selected="{{ $flightLoop == 1 && $ad == 1 ? 'true' : 'false' }}"
                                                                role="tab" tabindex="-1">
                                                                <div class="card border">
                                                                    <div class="card-header">
                                                                        <div
                                                                            class="crd-heady102 d-flex align-items-center justify-content-start">
                                                                            <div
                                                                                class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">

                                                                                <img width="25"
                                                                                    src="{{ asset('assets/img/adult.svg') }}"
                                                                                    alt="img">
                                                                            </div>
                                                                            <div class="crd-heady102Title lh-1 ps-2">
                                                                                <span
                                                                                    class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                                                                    Adult {{ $ad }}
                                                                                    {{ $ad == 1 ? '(Primary)' : '' }}</span>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="d-flex align-items-center justify-content-start">
                                                                            <div class="text-dark fw-bold text-md me-2">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    @endfor
                                                @endif
                                                @if (isset($passengers['CHD']))
                                                    @for ($ad = 1; $ad <= $passengers['CHD']; $ad++)
                                                        <li class="">
                                                            <a href="#tab{{ $segments['lfID'] }}CHD{{ $ad }}"
                                                                class="tabselector" data-bs-toggle="tab"
                                                                aria-selected="false" role="tab" tabindex="-1">

                                                                <div class="card border">
                                                                    <div class="card-header">
                                                                        <div
                                                                            class="crd-heady102 d-flex align-items-center justify-content-start">
                                                                            <div
                                                                                class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">

                                                                                <img width="25"
                                                                                    src="{{ asset('assets/img/adult.svg') }}"
                                                                                    alt="img">
                                                                            </div>
                                                                            <div class="crd-heady102Title lh-1 ps-2">
                                                                                <span
                                                                                    class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                                                                    Child {{ $ad }}</span>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="d-flex align-items-center justify-content-start">
                                                                            <div class="text-dark fw-bold text-md me-2">
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    @endfor
                                                @endif
                                                @if (isset($passengers['INF']))
                                                    @for ($ad = 1; $ad <= $passengers['INF']; $ad++)
                                                        <li class="">
                                                            <a href="javascript:void(0)" class="">
                                                                <div class="card border">
                                                                    <div class="card-header">
                                                                        <div
                                                                            class="crd-heady102 d-flex align-items-center justify-content-start">
                                                                            <div
                                                                                class="square--30 circle bg-light-primary  text-secondary flex-shrink-0">

                                                                                <img width="25"
                                                                                    src="{{ asset('assets/img/infant.svg') }}"
                                                                                    alt="img">
                                                                            </div>
                                                                            <div class="crd-heady102Title lh-1 ps-2">
                                                                                <span
                                                                                    class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
                                                                                    Infent {{ $ad }}</span>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="d-flex align-items-center justify-content-start">
                                                                            <div class="text-dark fw-bold text-md me-2">
                                                                                Infants can't buy extra baggage allowance
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    @endfor
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $flightLoop++;
                        @endphp
                    @endforeach

                    <button type="button" data-target="#nav-meals" data-targetbtn="#nav-meals-tab"
                        class="tabswitch_btn btn btn_theme w-100">Continue
                        to meals</button>
                    <button type="button" data-targetbtn="#nav-details-tab" data-target="#nav-details"
                        class="tabswitch_btn btn btn_theme_white w-100">Continue to passenger details(Skip all
                        extras)</button>
                @endisset
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="tab-content">

                @isset($acc_response['ancillaryQuotes']['flights'])
                    @php
                        $flightLoop = 1;
                    @endphp
                    @foreach ($acc_response['ancillaryQuotes']['flights'] as $flights)
                        @php
                            $segments = $flights['segments'];
                            $segment_details = getSegmentDetails($segments['lfID'], $segments['depDate'], $res_data['search_result']['segmentDetails']);
                            $baggage = array_combine(array_column($segments['serviceQuotes'], 'code'), $segments['serviceQuotes']);
                        @endphp

                        @if (isset($passengers['ADT']))
                            @for ($ad = 1; $ad <= $passengers['ADT']; $ad++)
                                <div class="tab-pane table-responsive userprof-tab {{ $flightLoop == 1 && $ad == 1 ? 'active' : '' }}"
                                    id="tab{{ $segments['lfID'] }}ADT{{ $ad }}" role="tabpanel">
                                    <div class="baggage-allw">
                                        <p class="info-b py-2">If your fare includes checked baggage, you can take
                                            up to 3 bags up to the
                                            combined weight of your baggage allowance. Max. dimension 165 cm (height
                                            + width + depth).
                                        </p>
                                        <div class="included_baggage">
                                            <div class="row align-items-center justify-content-between g-2 mb-2">

                                                {{-- @isset($baggage['BAGI'])
                                                    <div class="col-12">
                                                        <p class="pt-2">{{ $baggage['BAGI']['description'] }}</p>
                                                    </div>
                                                @endisset --}}

                                                @foreach ($baggage as $bag)
                                                    @if (Str::contains($bag['description'], 'Upgrade'))
                                                        <div class="col-12">
                                                            <input class="input_baggage"
                                                                data-user="Adult {{ $ad }}"
                                                                data-des="({{ $bag['description'] }})"
                                                                data-rate="{{ convertCurrency($bag['amount'], $bag['currency']) }}"
                                                                type="radio" value="{{ $bag['code'] }}"
                                                                name="bag[ADT][{{ $ad }}][{{ $segments['lfID'] }}]"
                                                                id="{{ $segments['lfID'] }}ADT{{ $ad }}{{ $bag['code'] }}">
                                                            <label class="w-100"
                                                                for="{{ $segments['lfID'] }}ADT{{ $ad }}{{ $bag['code'] }}">
                                                                <div class="bg-white rounded-2 p-2">
                                                                    <div
                                                                        class="d-flex align-items-center justify-content-between g-2">
                                                                        <div class="img-baggage">
                                                                            <img width="50"
                                                                                src="{{ asset('assets/img/hand-baggage.svg') }}"
                                                                                alt="img">
                                                                        </div>
                                                                        <div class="">
                                                                            <small
                                                                                class="d-block text-muted text-md fw-medium ">
                                                                                {{ $bag['description'] }}
                                                                            </small>
                                                                            <p
                                                                                class="text-dark text-right fw-bold lh-base text-md mb-0">

                                                                                {{ getDisplyPrice($bag['amount']) }}

                                                                                {{-- {{ getActiveCurrency() }}{{ convertCurrency($bag['amount'],"AED") }} --}}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                                <div class="col-12">
                                                    <button type="button"
                                                        class="btn btn_theme btn_md removeSeatSelection"
                                                        data-seatseleted="bag[{{ $segments['lfID'] }}][ADT][{{ $ad }}]">Remove
                                                        Selection</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        @endif
                        @if (isset($passengers['CHD']))
                            @for ($ad = 1; $ad <= $passengers['CHD']; $ad++)
                                <div class="tab-pane table-responsive userprof-tab"
                                    id="tab{{ $segments['lfID'] }}CHD{{ $ad }}" role="tabpanel">
                                    <div class="baggage-allw">
                                        <p class="info-b pt-2">If your fare includes checked baggage, you can take
                                            up to 3 bags up to the
                                            combined weight of your baggage allowance. Max. dimension 165 cm (height
                                            + width + depth).
                                        </p>
                                        <div class="included_baggage">
                                            <div class="row align-items-center justify-content-between g-2 mb-2">
                                                {{-- @isset($baggage['BAGI'])
                                                    <div class="col-12">
                                                        <p class="pt-2">{{ $baggage['BAGI']['description'] }}</p>
                                                    </div>
                                                @endisset --}}
                                                @foreach ($baggage as $bag)
                                                    @if (Str::contains($bag['description'], 'Upgrade'))
                                                        <div class="col-12">
                                                            <input class="input_baggage"
                                                                data-user="Child {{ $ad }}"
                                                                data-des="({{ $bag['description'] }})"
                                                                data-rate="{{ convertCurrency($bag['amount'], $bag['currency']) }}"
                                                                value="{{ $bag['code'] }}" type="radio"
                                                                name="bag[CHD][{{ $ad }}][{{ $segments['lfID'] }}]"
                                                                id="{{ $segments['lfID'] }}CHD{{ $ad }}{{ $bag['code'] }}">
                                                            <label class="w-100"
                                                                for="{{ $segments['lfID'] }}CHD{{ $ad }}{{ $bag['code'] }}">
                                                                <div class="bg-white rounded-2 p-2">
                                                                    <div
                                                                        class="d-flex align-items-center justify-content-between g-2">
                                                                        <div class="img-baggage">
                                                                            <img width="50"
                                                                                src="{{ asset('assets/img/hand-baggage.svg') }}"
                                                                                alt="img">
                                                                        </div>
                                                                        <div class="">
                                                                            <small
                                                                                class="d-block text-muted text-md fw-medium ">
                                                                                {{ $bag['description'] }}
                                                                            </small>
                                                                            <p
                                                                                class="text-dark text-right fw-bold lh-base text-md mb-0">
                                                                                {{-- {{ getActiveCurrency() }}{{ convertCurrency($bag['amount'],"AED") }} --}}

                                                                                {{ getDisplyPrice($bag['amount']) }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    @endif
                                                @endforeach

                                                <div class="col-12">
                                                    <button type="button"
                                                        class="btn btn_theme btn_md removeSeatSelection"
                                                        data-seatseleted="bag[{{ $segments['lfID'] }}][CHD][{{ $ad }}]">Remove
                                                        Selection</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        @endif
                        @php
                            $flightLoop++;
                        @endphp
                    @endforeach
                @endisset
            </div>
        </div>
    </div>
</div>
<style>
    .included_baggage input[type="radio"] {
        display: none;
    }

    .included_baggage label>div {
        border: 1px solid transparent;
    }

    .included_baggage input[type=radio]:checked+label>div {
        border: 1px solid #1fba71;
    }
</style>
