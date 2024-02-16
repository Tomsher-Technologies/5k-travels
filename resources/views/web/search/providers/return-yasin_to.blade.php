<div class="flight_search_item_wrappper" id="cont_r_{{ $loop->iteration }}" data-stops="{{ $fdata['stops'] }}"
    data-airline="{{ $fdata['airline'] }}">
    <div class="flight_search_items">
        <div class="multi_city_flight_lists">
            @if ($data['search_type'] == 'Return')
                <div class="flight_multis_area_wrapper">
                    <div class="flight_logo">
                        <img src="{{ isset($fdata['airline']) ? $data['flightData'][$fdata['airline']]['AirLineLogo'] : '' }}"
                            alt="img">
                        <div class="flight-details">
                            <h4>{{ isset($fdata['airline']) ? $data['flightData'][$fdata['airline']]['AirLineName'] : '' }}
                            </h4>
                            <h6 class="flight_num">{{ $fdata['FlightNo'] }}</h6>
                        </div>
                    </div>
                    <div class="flight_search_left">
                        <div class="flight_search_destination">
                            <p>From</p>
                            <span class="dep_date">{{ date('d M, Y', strtotime($fdata['FlightDate'])) }}</span>
                            <h2 class="dep_time">{{ date('H:i', strtotime($fdata['DepatureTime'])) }}
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
                        </div>
                    </div>

                    <div class="flight_search_third">
                        <div class="flight_search_destination">
                            <p>To</p>
                            <span class="arr_date">{{ date('d M, Y', strtotime($fdata['ArrivalDate'])) }}</span>
                            <h2 class="arr_time">{{ date('H:i', strtotime($fdata['ArrivalTime'])) }}</h2>
                            <h3>{{ isset($data['airports'][$fdata['destination']]) ? $data['airports'][$fdata['destination']]['City'] : $fdata['destination'] }}
                            </h3>
                            <h6>{{ isset($data['airports'][$fdata['destination']]) ? $data['airports'][$fdata['destination']]['AirportName'] : '' }}
                            </h6>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="flight_search_right">
            @php
                $totalFareMargin = ($fdata['total_price'] / 100) * $totalmargin + $fdata['total_price'];
                $totalFareMargin = floor($totalFareMargin * 100) / 100;
                $displayAmount = convertCurrency($totalFareMargin, $data['currency'][$fdata['api_provider']]);
            @endphp
            <p class="text-center">Lowest Fare</p>
            <h2 class="d_fare">
                <span class="crc">
                    {{ getActiveCurrency() }}</span>
                {{ $displayAmount }}
            </h2>

            <button class="btn btn_theme btn_md  yas_ret_add_to_cart" data-fare="{{ $displayAmount }}"
                data-loop_id="r_{{ $loop->iteration }}" data-api="yasin" data-search_id="{{ $data['search_id'] }}"
                data-flight_type="arv"
                data-r_airline="{{$fdata['airline']}}"
                data-r_route="{{$fdata['route']}}" 
                data-r_date_time="{{$fdata['depature_date']}}" 
                data-r_flight_num="{{$fdata['flight_no']}}" 
                data-r_rbd="{{$fdata['rbd']}}"
                data-r_rph="{{$fdata['rph']}}"
                type="button">Add To
                Cart</button>
        </div>
    </div>

    <div class="flight_policy_refund collapse" id="detialsView_{{ $loop->iteration }}">
    </div>
</div>
