<div class="flight_search_result_wrapper" id="one_way_trip">
    @if ($data['flightDetails'])
        @foreach ($data['flightDetails'] as $fdata)
            @php
                $cls = '';
                if (request()->direct == '1') {
                    if ($fdata['stops'] == 0) {
                        $cls = '';
                    } else {
                        $cls = 'hide';
                    }
                }
            @endphp
            <div class="flight_search_item_wrappper {{ $cls }}" data-stops="{{ $fdata['stops'] }}"
                data-airline="{{ $fdata['airline'] }}">

                @if ($fdata['api_provider'] == 'flydubai')
                    <div class="flight_search_items">
                        <div class="multi_city_flight_lists">
                            <div class="flight_multis_area_wrapper">
                                <div class="flight_logo">
                                    <img src="{{ isset($fdata['airline']) ? $data['flightData'][$fdata['airline']]['AirLineLogo'] : '' }}"
                                        alt="img">
                                    <div class="flight-details">
                                        <h4>{{ isset($fdata['airline']) ? $data['flightData'][$fdata['airline']]['AirLineName'] : '' }}
                                        </h4>
                                        <h6>{{ $fdata['flightNum'] }}</h6>
                                    </div>
                                </div>
                                <div class="flight_search_left">
                                    <div class="flight_search_destination">
                                        <p>From</p>
                                        <span>{{ date('d M, Y', strtotime($fdata['dep_time'])) }}</span>
                                        <h2>{{ date('H:i', strtotime($fdata['dep_time'])) }}
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
                                                {{ $fdata['stops'] . ' ' . Str::plural('stop', (int) $fdata['stops']) }}
                                                Via
                                                {{ getFDStops($fdata, $data['legDetails']) }}
                                            @else
                                                Non-stop
                                            @endif
                                        </h6>
                                        <p>{{ $fdata['flightTime'] }}</p>
                                    </div>
                                </div>
                                <div class="flight_search_third">
                                    <div class="flight_search_destination">
                                        <p>To</p>
                                        <span>{{ date('d M, Y', strtotime($fdata['arv_time'])) }}</span>
                                        <h2>{{ date('H:i', strtotime($fdata['arv_time'])) }}
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
                            @php
                                $totalFareMargin = ($fdata['lowest_fare'] / 100) * $totalmargin + $fdata['lowest_fare'];
                                $totalFareMargin = floor($totalFareMargin * 100) / 100;
                                $displayAmount = convertCurrency($totalFareMargin, $data['currency'][$fdata['api_provider']]);
                            @endphp
                            <h2>
                                <span class="crc">
                                    {{ getActiveCurrency() }}</span>
                                {{ $displayAmount }}
                            </h2>
                            <h6 data-id="{{ $loop->iteration }}" data-api_provider="{{ $fdata['api_provider'] }}"
                                data-LFID="{{ $fdata['LFID'] }}" data-search_type="{{ $data['search_type'] }}"
                                data-cabin_type="{{ $data['cabin_type'] }}" data-session_id="{{ $data['search_id'] }}"
                                data-data_loaded="false" class="viewFlightDetails">View Details<i
                                    class="fas fa-chevron-down"></i></h6>
                        </div>
                    </div>
                @elseif ($fdata['api_provider'] == 'yasin')
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
                                    // $displayAmount = convertCurrency($totalFareMargin, $data['currency'][$fdata['api_provider']]);
                                    echo $displayAmount;
                                @endphp
                            </h2>
                            <a href="#" class="btn btn_theme btn_sm">Book now</a>

                        </div>
                    </div>
                @endif


                <div class="flight_policy_refund collapse" id="detialsView_{{ $loop->iteration }}">
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center fontSize24">
            <span>No Flights Found. </span>
        </div>
    @endif

    <div class="text-center fontSize24" style="display: none" id="noFlightDiv">
        <span>No Flights Found. </span>
    </div>
</div>
