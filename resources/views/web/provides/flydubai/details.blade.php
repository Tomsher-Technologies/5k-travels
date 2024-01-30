<div class="pricing__table pricing__style-2 white-bg flydubai">
    <div class="pricing__table-wrapper">
        <!-- pricng header -->
        <div class="pricing__header grey-bg-13">
            <div class="row gx-0 ">
                <div class="col-xl-3 col-3">
                    <div class="pricing__feature-item-wrapper">
                        <!-- pricing features item -->
                        <div class="pricing__feature-info-item">
                            <div class="pricing__header-content">
                                <h3 class="pricing__header-title">Fare type
                                </h3>
                            </div>
                            <div class="pricing__feature-info-content d-flex align-items-center">
                                <div class="pricing__feature-info-text">
                                    <p>Meal</p>
                                </div>
                            </div>
                            <div class="pricing__feature-info-content d-flex align-items-center">
                                <div class="pricing__feature-info-text">
                                    <p>Seat</p>
                                </div>
                            </div>

                            <div class="pricing__feature-info-content d-flex align-items-center">
                                <div class="pricing__feature-info-text">
                                    <p>Rebooking</p>
                                </div>
                            </div>

                            <div class="pricing__feature-info-content d-flex align-items-center">
                                <div class="pricing__feature-info-text">
                                    <p>Cancellation</p>
                                </div>
                            </div>

                            <div class="pricing__feature-info-content d-flex align-items-center">
                                <div class="pricing__feature-info-text">
                                    <p>Price</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $fares = $matchingFlight['fares'];
                @endphp

                @foreach ($fares as $fare)
                    @php
                        $cabin = '';
                        $pax = '';
                        foreach ($fare['FareInfos']['FareInfo'] as $fareInfo) {
                            foreach ($fareInfo['Pax'] as $pax) {
                                $cabin = $pax['Cabin'];
                            }
                        }
                        $penalities = getFDPenalities($fare['FareInfos']);

                        $seat_meal = [
                            'meal' => null,
                            'seat' => null,
                        ];

                        if (isset($fare['service'])) {
                            foreach ($fare['service'] as $service) {
                                if ($service['Code'] == 'MLIN') {
                                    $seat_meal['meal'] = $service['Description'];
                                } elseif ($service['Code'] == 'INST') {
                                    $seat_meal['seat'] = $service['Description'];
                                }
                            }
                        }

                    @endphp
                    @if (strcasecmp($cabin_type, $cabin) == 0)
                        <div id="solnID{{ $fare['SolnId'] }}" class="col-xl-3 col-3">
                            <div class="pricing__header-top-wrapper">
                                <!-- pricing heading one -->
                                <div class="pricing__top-7 p-relative text-center">
                                    <div class="pricing__title-wrapper-7">
                                        <span>&nbsp;</span>
                                        <h3 class="pricing__title-7">
                                            {{-- <span>AED</span>950.00 --}}
                                            {{ $fare['FareTypeName'] }}
                                        </h3>
                                    </div>
                                </div>
                            </div>

                            <div class="pricing__feature-info-wrapper">
                                <div
                                    class="pricing__feature-info-available pricing__feature-info-available2  text-center">

                                    @if ($seat_meal['meal'])
                                        <p>
                                            <span class="done">
                                                <svg width="11" height="9" viewBox="0 0 11 9" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9.5451 1.27344L3.9201 7.04884L1.36328 4.42366"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </p>
                                        <div class="pricing__feature-info-tooltip2 transition-3">
                                            <p>
                                                {{ $seat_meal['meal'] }}
                                            </p>
                                        </div>
                                    @else
                                        <p>
                                            <span class="cross">
                                                <svg width="10" height="11" viewBox="0 0 12 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11 1L1 10" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                    </path>
                                                    <path d="M1 1L11 10" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                    </path>
                                                </svg>
                                            </span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="pricing__feature-info-wrapper">
                                <div
                                    class="pricing__feature-info-available pricing__feature-info-available2  text-center">

                                    @if ($seat_meal['seat'])
                                        <p>
                                            <span class="done">
                                                <svg width="11" height="9" viewBox="0 0 11 9" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9.5451 1.27344L3.9201 7.04884L1.36328 4.42366"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </p>
                                        <div class="pricing__feature-info-tooltip2 transition-3">
                                            <p>
                                                {{ $seat_meal['meal'] }}
                                            </p>
                                        </div>
                                    @else
                                        <p>
                                            <span class="cross">
                                                <svg width="10" height="11" viewBox="0 0 12 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11 1L1 10" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                    </path>
                                                    <path d="M1 1L11 10" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                    </path>
                                                </svg>
                                            </span>
                                        </p>
                                    @endif
                                </div>
                            </div>


                            <div class="pricing__feature-info-wrapper">
                                <div
                                    class="pricing__feature-info-available pricing__feature-info-available2  text-center">

                                    @if (isset($penalities['changeFees']))
                                        <p>
                                            <span class="done">
                                                <svg width="11" height="9" viewBox="0 0 11 9" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9.5451 1.27344L3.9201 7.04884L1.36328 4.42366"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </p>
                                        <div class="pricing__feature-info-tooltip2 transition-3">
                                            <ul>
                                                @foreach ($penalities['changeFees'] as $item)
                                                    <li>{!! $item !!}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <p>
                                            <span class="cross">
                                                <svg width="10" height="11" viewBox="0 0 12 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11 1L1 10" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                    </path>
                                                    <path d="M1 1L11 10" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                    </path>
                                                </svg>
                                            </span>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="pricing__feature-info-wrapper">
                                <div
                                    class="pricing__feature-info-available pricing__feature-info-available2 text-center">
                                    @if (isset($penalities['cancellationFees']))
                                        <p>
                                            <span class="done">
                                                <svg width="11" height="9" viewBox="0 0 11 9" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9.5451 1.27344L3.9201 7.04884L1.36328 4.42366"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </p>
                                        <div class="pricing__feature-info-tooltip2 transition-3">
                                            <ul>
                                                @foreach ($penalities['cancellationFees'] as $item)
                                                    <li>{!! $item !!}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <p>
                                            <span class="cross">
                                                <svg width="10" height="11" viewBox="0 0 12 16"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11 1L1 10" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                    </path>
                                                    <path d="M1 1L11 10" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                    </path>
                                                </svg>
                                            </span>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="pricing__feature-info-wrapper">
                                <div class="pricing__feature-info-available text-center">
                                    <h3 class="pricing__title-7">
                                        @php
                                            $fare_amt = getFDLowestFare($fare['FareInfos']);
                                            $totalFareMargin = ($fare_amt / 100) * $margin['totalmargin'] + $fare_amt;
                                            $totalFareMargin = floor($totalFareMargin * 100) / 100;
                                            $displayAmount = convertCurrency($totalFareMargin, 'AED');
                                        @endphp
                                        <span class="crc">{{ getActiveCurrency() }}</span> {{ $displayAmount }}
                                    </h3>
                                </div>
                            </div>
                            <div class="pricing__feature-info-wrapper">
                                <div class="pricing__feature-info-available text-center">
                                    @if (request()->search_type == 'OneWay')
                                        {{-- <form class="addToCart" action="{{ route('flight.booking') }}">
                                                @csrf
                                                <input type="hidden" name="search_id"
                                                    value="{{ request()->session_id }}">
                                                <input type="hidden" name="LFID" value="{{ $LFID }}">
                                                <input type="hidden" name="FareTypeID"
                                                    value="{{ $fare['FareTypeID'] }}">
                                                <button type="submit">Add To Cart</button>
                                            </form> --}}

                                        <button class="btn btn_theme btn_md  ret_add_to_cart addToCart"
                                            data-action="{{ route('flight.booking') }}"
                                            data-loop_id="{{ request()->id }}"
                                            data-search_id="{{ request()->session_id }}"
                                            data-LFID="{{ $LFID }}" data-solnID="{{ $fare['SolnId'] }}"
                                            data-FareTypeID="{{ $fare['FareTypeID'] }}" type="button">Book
                                            Now</button>
                                    @elseif(request()->search_type == 'Return')
                                        <button class="btn btn_theme btn_md  ret_add_to_cart"
                                            data-fare="{{ $displayAmount }}" data-loop_id="{{ request()->id }}"
                                            data-search_id="{{ request()->session_id }}"
                                            data-LFID="{{ $LFID }}" data-solnID="{{ $fare['SolnId'] }}"
                                            data-FareTypeID="{{ $fare['FareTypeID'] }}"
                                            data-flight_type={{ $matchingFlight['leg_count'] == 1 ? 'dep' : 'ret' }}
                                            type="button">Add To
                                            Cart</button>
                                    @else
                                        <button class="btn btn_theme btn_md "
                                            data-search_id="{{ request()->session_id }}"
                                            data-LFID="{{ $LFID }}"
                                            data-FareTypeID="{{ $fare['FareTypeID'] }}" type="button">Add To
                                            Cart</button>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @endif
                @endforeach

            </div>
        </div>
    </div>
</div>
