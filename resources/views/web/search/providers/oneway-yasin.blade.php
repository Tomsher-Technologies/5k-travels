<div class="flight_search_items">
    <div class="multi_city_flight_lists">
        <div class="flight_multis_area_wrapper">
            <div class="flight_logo">
                <img src="{{ isset($fdata['airline']) ? $data['flightData'][$fdata['airline']]['AirLineLogo'] : '' }}"
                    alt="img">
                <div class="flight-details">
                    <h4>{{ isset($fdata['airline']) ? $data['flightData'][$fdata['airline']]['AirLineName'] : '' }}
                    </h4>
                    <h6>{{ $fdata['flight_no'] }}</h6>
                </div>
            </div>
            <div class="flight_search_left">
                <div class="flight_search_destination">
                    <p>From</p>
                    <span>{{ date('d M, Y', strtotime($fdata['depature_date'])) }}</span>
                    <h2>{{ date('H:i', strtotime($fdata['depature_date'])) }}
                    </h2>
                    <h3>{{ isset($data['airports'][$fdata['origin']]) ? $data['airports'][$fdata['origin']]['City'] : $fdata['origin'] }}
                    </h3>
                    <h6>{{ isset($data['airports'][$fdata['origin']]) ? $data['airports'][$fdata['origin']]['AirportName'] : '' }}
                    </h6>
                </div>
            </div>

            <div class="flight_search_middel">
                <div class="flight_right_arrow">
                    <img src="{{ asset('assets/img/icon/right_arrow.png') }}" alt="icon">
                    <h6>
                        @if ($fdata['stops'] > 0)
                        @else
                            Non-stop
                        @endif
                    </h6>
                    <p>{{ $fdata['flight_duration'] }}</p>
                </div>
            </div>
            <div class="flight_search_third">
                <div class="flight_search_destination">
                    <p>To</p>
                    <span>{{ date('d M, Y', strtotime($fdata['arrival_time'])) }}</span>
                    <h2>{{ date('H:i', strtotime($fdata['arrival_time'])) }}
                    </h2>
                    <h3>{{ isset($data['airports'][$fdata['destination']]) ? $data['airports'][$fdata['destination']]['City'] : $fdata['destination'] }}
                    </h3>
                    <h6>{{ isset($data['airports'][$fdata['destination']]) ? $data['airports'][$fdata['destination']]['AirportName'] : '' }}
                    </h6>
                </div>
            </div>
        </div>
    </div>
    <div class="flight_search_right">
        <h2>
            <span class="crc">{{ getActiveCurrency() }}</span>
            @php
                $totalFareMargin = ($fdata['total_price'] / 100) * $totalmargin + $fdata['total_price'];
                $totalFareMargin = floor($totalFareMargin * 100) / 100;
                $displayAmount = $totalFareMargin;
                $displayAmount = convertCurrency($totalFareMargin, $data['currency'][$fdata['api_provider']]);
                echo $displayAmount;
            @endphp
        </h2>
        <form action="{{ route('yasin.details') }}" method="POST">
            @csrf
            <input value="{{ $data['search_id'] }}" type="hidden" name="search_id">
            <input value="{{ $fdata['AirLine'] }}" type="hidden" name="Airline">
            <input value="{{ $fdata['Route'] }}" type="hidden" name="FlightRoute">
            <input value="{{ $fdata['depature_date'] }}" type="hidden" name="FlightDateTime">
            <input value="{{ $fdata['FlightNo'] }}" type="hidden" name="FlightNo">
            <input value="{{ $fdata['RBD'] }}" type="hidden" name="RBD">
            <input value="{{ $fdata['RPH'] }}" type="hidden" name="RPH">
            <input value="{{ $fdata['total_price'] }}" type="hidden" name="price">
            <button type="submit" class="btn btn_theme btn_sm w-100">Book Now</button>
        </form>
    </div>
</div>