<div class="tab-pane fade" id="nav-meals" role="tabpanel" aria-labelledby="nav-meals-tab">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="faqs_main_item">

                @isset($acc_response['ancillaryQuotes']['flights'])
                    @php
                        $flightLoop = 1;
                    @endphp
                    @foreach ($acc_response['ancillaryQuotes']['flights'] as $flights)
                        @foreach ($flights['legs'] as $leg)
                            @php
                                $leg_details = getLegDetails($leg['pfID'], $res_data['search_result']['legDetails']);
                            @endphp
                            <div class="accordion" id="accordionExample{{ $leg['pfID'] }}">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne{{ $leg['pfID'] }}">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne{{ $leg['pfID'] }}" aria-expanded="true"
                                            aria-controls="collapseOne{{ $leg['pfID'] }}">
                                            <div class="flight-card flights-list__item">
                                                <div class="flight-card-list-dt">
                                                    <div class="flight-card__departure">
                                                        <h2 class="flight-card__city">
                                                            {{ getAirportData($leg_details['Origin'])['AirportName'] }}
                                                            ({{ $leg_details['Origin'] }})
                                                        </h2>
                                                        <!-- <time class="flight-card__day">Tuesday, Apr 21, 2020</time> -->
                                                    </div>

                                                    <div class="flight-card__route">
                                                        <div class="flight-card__route-line route-line" aria-hidden="true">
                                                            <i class="fas fa-plane-departure"></i>
                                                        </div>
                                                        <!-- flight-card__route-line -->
                                                    </div>

                                                    <div class="flight-card__arrival">
                                                        <h2 class="flight-card__city">
                                                            {{ getAirportData($leg_details['Destination'])['AirportName'] }}
                                                            ({{ $leg_details['Destination'] }})
                                                        </h2>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                        </button>
                                    </h2>


                                    <div id="collapseOne{{ $leg['pfID'] }}" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne{{ $leg['pfID'] }}"
                                        data-bs-parent="#accordionExample{{ $leg['lfID'] }}" style="">
                                        <div class="accordion-body">
                                            <div class="tabs-menus"> <!-- Tabs -->
                                                <ul class="nav panel-tabs" role="tablist">

                                                    @if (isset($passengers['ADT']))
                                                        @for ($ad = 1; $ad <= $passengers['ADT']; $ad++)
                                                            <li class="">
                                                                <a href="#meal{{ $leg['pfID'] }}ADT{{ $ad }}"
                                                                    class="mealselector {{ $flightLoop == 1 && $ad == 1 ? 'active' : '' }}"
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
                                                                                        Adult {{ $ad }}</span>
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
                                                                <a href="#meal{{ $leg['pfID'] }}CHD{{ $ad }}"
                                                                    class="mealselector" data-bs-toggle="tab"
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
                                                                                        Infant {{ $ad }}</span>
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                class="d-flex align-items-center justify-content-start">
                                                                                <div class="text-dark fw-bold text-md me-2">
                                                                                    Infants aren't assigned their own meal
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
                    @endforeach

                    <button type="button" data-target="#nav-seats" data-targetbtn="#nav-seats-tab"
                        class="tabswitch_btn btn btn_theme w-100">Continue
                        to seats</button>
                    <button type="button" data-targetbtn="#nav-details-tab" data-target="#nav-details"
                        class="tabswitch_btn btn btn_theme_white w-100">Continue to passenger details(Skip all
                        extras)</button>

                @endisset
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="tab-content meal-selector">

                @isset($acc_response['ancillaryQuotes']['flights'])
                    @php
                        $flightLoop = 1;
                    @endphp
                    @foreach ($acc_response['ancillaryQuotes']['flights'] as $flights)
                        @foreach ($flights['legs'] as $leg)
                            @php
                                $leg_details = getLegDetails($leg['pfID'], $res_data['search_result']['legDetails']);
                            @endphp
                            @if (isset($passengers['ADT']))
                                @for ($ad = 1; $ad <= $passengers['ADT']; $ad++)
                                    <div class="tab-pane table-responsive userprof-tab meal-tab {{ $flightLoop == 1 && $ad == 1 ? 'active' : '' }}"
                                        id="meal{{ $leg['pfID'] }}ADT{{ $ad }}" role="tabpanel">
                                        <div class="baggage-allw">
                                            <p class="info-b pt-2">
                                                Please select your dietary preference. All food served on board is
                                                halal.
                                            </p>
                                            <div class="included_baggage">
                                                <div class="row align-items-center justify-content-between g-2 mb-2">
                                                    @foreach ($leg['serviceQuotes'] as $meals)
                                                        <div class="col-6">
                                                            <div class="meal-box-w">
                                                                <input class="input_meal" type="radio"
                                                                    data-user="Adult {{ $ad }}"
                                                                    data-des="({{ $meals['description'] }})"
                                                                    data-rate="{{ convertCurrency($meals['amount'], $meals['currency']) }}"
                                                                    id="meal[{{ $leg['pfID'] }}]ADT{{ $ad }}{{ $meals['code'] }}"
                                                                    name="meal[ADT][{{ $ad }}][{{ $leg['pfID'] }}]"
                                                                    value="{{ $meals['code'] }}">
                                                                <label
                                                                    for="meal[{{ $leg['pfID'] }}]ADT{{ $ad }}{{ $meals['code'] }}">
                                                                    <h5>{{ $meals['description'] }}</h5>
                                                                    <span> {{ getDisplyPrice($meals['amount']) }} </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <div class="col-12">
                                                        <button type="button"
                                                            class="btn btn_theme btn_md removeMealSelection"
                                                            data-mealseleted="meal[{{ $leg['pfID'] }}][ADT][{{ $ad }}]">Remove
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
                                    <div class="tab-pane table-responsive userprof-tab meal-tab"
                                        id="meal{{ $leg['pfID'] }}CHD{{ $ad }}" role="tabpanel">
                                        <div class="baggage-allw">
                                            <p class="info-b pt-2">
                                                Please select your dietary preference. All food served on board is
                                                halal.
                                            </p>
                                            <div class="included_baggage">
                                                <div class="row align-items-center justify-content-between g-2 mb-2">
                                                    @foreach ($leg['serviceQuotes'] as $meals)
                                                        <div class="col-6">
                                                            <div class="meal-box-w">
                                                                <input class="input_meal" type="radio"
                                                                    data-user="Child {{ $ad }}"
                                                                    data-des="({{ $meals['description'] }})"
                                                                    data-rate="{{ convertCurrency($meals['amount'], $meals['currency']) }}"
                                                                    id="meal{{ $leg['pfID'] }}CHD{{ $ad }}{{ $meals['code'] }}"
                                                                    name="meal[CHD][{{ $ad }}][{{ $leg['pfID'] }}]"
                                                                    value="{{ $meals['code'] }}">
                                                                <label
                                                                    for="meal{{ $leg['pfID'] }}CHD{{ $ad }}{{ $meals['code'] }}">
                                                                    <h5>{{ $meals['description'] }}</h5>
                                                                    <span> {{ getDisplyPrice($meals['amount']) }} </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <div class="col-12">
                                                        <button type="button"
                                                            class="btn btn_theme btn_md removeMealSelection"
                                                            data-mealseleted="meal[{{ $leg['pfID'] }}][CHD][{{ $ad }}]">Remove
                                                            Selection</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            @endif
                        @endforeach
                        @php
                            $flightLoop++;
                        @endphp
                    @endforeach
                @endisset
            </div>
        </div>
    </div>
</div>
