<div class="flight_search_result_wrapper" id="return_trip">
    @if ($data['flightDetails'])

        @php
            $from_fligth = Arr::where($data['flightDetails'], function ($value, $key) {
                return $value['leg_count'] == 1;
            });

            $to_fligth = Arr::where($data['flightDetails'], function ($value, $key) {
                return $value['leg_count'] == 2;
            });
        @endphp

        <div class="departing_flight">
            <h3>SELECT DEPARTING FLIGHT</h3>
            @foreach ($from_fligth as $fdata)
                <div class="flight_search_item_wrappper" id="cont_{{ $loop->iteration }}">
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
                                            <h6 class="flight_num">{{ $fdata['flightNum'] }}</h6>
                                        </div>
                                    </div>
                                    <div class="flight_search_left">
                                        <div class="flight_search_destination">
                                            <p>From</p>
                                            <span
                                                class="dep_date">{{ date('d M, Y', strtotime($fdata['dep_time'])) }}</span>
                                            <h2 class="dep_time">{{ date('H:i', strtotime($fdata['dep_time'])) }}
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
                                            <span
                                                class="arr_date">{{ date('d M, Y', strtotime($fdata['arv_time'])) }}</span>
                                            <h2 class="arr_time">{{ date('H:i', strtotime($fdata['arv_time'])) }}</h2>
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
                                $totalFareMargin = ($fdata['lowest_fare'] / 100) * $totalmargin + $fdata['lowest_fare'];
                                $totalFareMargin = floor($totalFareMargin * 100) / 100;
                                $displayAmount = convertCurrency($totalFareMargin, $data['currency']);
                            @endphp
                            <p class="text-center">Lowest Fare</p>
                            <h2 class="d_fare">
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

                    <div class="flight_policy_refund collapse" id="detialsView_{{ $loop->iteration }}">
                    </div>
                </div>
            @endforeach
        </div>
        <div class="returning_flight">
            <h3>SELECT RETURNING FLIGHT</h3>

            <div class="r_flight_contaier">
                <div class="r_flight_overlay">
                    <p>
                        Please select a departure flight first.
                    </p>
                </div>
                @foreach ($to_fligth as $fdata)
                    <div class="flight_search_item_wrappper" id="cont_r_{{ $loop->iteration }}">
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
                                                <h6 class="flight_num">{{ $fdata['flightNum'] }}</h6>
                                            </div>
                                        </div>
                                        <div class="flight_search_left">
                                            <div class="flight_search_destination">
                                                <p>From</p>
                                                <span>{{ date('d M, Y', strtotime($fdata['dep_time'])) }}</span>
                                                <h2 class="dep_time">{{ date('H:i', strtotime($fdata['dep_time'])) }}
                                                </h2>
                                                <h3>{{ isset($data['airports'][$fdata['origin']]) ? $data['airports'][$fdata['origin']]['City'] : $fdata['origin'] }}
                                                </h3>
                                                <h6>{{ isset($data['airports'][$fdata['origin']]) ? $data['airports'][$fdata['origin']]['AirportName'] : '' }}
                                                </h6>
                                            </div>
                                        </div>

                                        <div class="flight_search_middel">
                                            <div class="flight_right_arrow">
                                                <img src="{{ asset('assets/img/icon/right_arrow.png') }}"
                                                    alt="icon">
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
                                                <h2 class="arr_time">{{ date('H:i', strtotime($fdata['arv_time'])) }}
                                                </h2>
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
                                    $totalFareMargin = ($fdata['lowest_fare'] / 100) * $totalmargin + $fdata['lowest_fare'];
                                    $totalFareMargin = floor($totalFareMargin * 100) / 100;
                                    $displayAmount = convertCurrency($totalFareMargin, $data['currency']);
                                @endphp
                                <p class="text-center">Lowest Fare</p>
                                <h2 class="d_fare">
                                    <span class="crc">
                                        {{ getActiveCurrency() }}</span>
                                    {{ $displayAmount }}
                                </h2>
                                <h6 data-id="r_{{ $loop->iteration }}"
                                    data-api_provider="{{ $fdata['api_provider'] }}" data-LFID="{{ $fdata['LFID'] }}"
                                    data-search_type="{{ $data['search_type'] }}"
                                    data-cabin_type="{{ $data['cabin_type'] }}"
                                    data-session_id="{{ $data['search_id'] }}" data-data_loaded="false"
                                    class="viewFlightDetails">View Details<i class="fas fa-chevron-down"></i></h6>
                            </div>
                        </div>

                        <div class="flight_policy_refund collapse" id="detialsView_r_{{ $loop->iteration }}">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center fontSize24">
            <span>No Flights Found. </span>
        </div>
    @endif
</div>


<div class="bottomStickyBooking ">
    <div class="splitviewSticky d-flex">
        <div class="stickyFlightDetails margin-right15">
            <p class="white">Departure ・ <span id="stickyDepFlight"> </span> </p>
            <div class="d-flex spaceBetween">
                <div class="d-flex">
                    <div class="">
                        <p class="white bold font16">
                            <span id="stickyDepFromTime"></span> →
                            <span id="stickyDepToTime"></span>
                        </p>
                    </div>
                </div>
                <div class="">
                    <p class="white bold font16" id="stickyDepFare"></p>
                </div>
            </div>
        </div>

        <div class="stickyFlightDetails margin-right15">
            <p class="white">Return ・ <span id="stickyReturnFlight"> </span></p>
            <div class="d-flex spaceBetween">
                <div class="d-flex">
                    <div class="">
                        <p class="white bold font16">
                            <span id="stickyReturnFromTime"></span> →
                            <span id="stickyReturnToTime"></span>
                        </p>
                    </div>
                </div>
                <div class="">
                    <p class="white bold font16" id="stickyReturnFare"></p>
                </div>
            </div>
        </div>

        <div class="d-flex stickyFlightDetails">
            <div class="d-flex align-center margin-left-auto">
                <div class="margin-right10">
                    <p class="white font22 bold stickyTotalCont" style="display: none">{{ getActiveCurrency() }}&nbsp;<span
                            class="white font22 bold" id="stickyTotal"></span></p>
                </div>
                <div class="d-flex align-center">
                    <div>
                        <a href="#" target="_blank" id="stickyButton" style="display: none"
                            class="button bookingBtn btn-40 ">Book
                            Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .bold {
        font-weight: 700 !important;
    }

    .overflow-text {
        overflow: hidden;
        text-overflow: ellipsis;
        width: 160px;
    }

    .flight-logo-img {
        width: 60px;
        height: 40px;
        margin-top: 6px;
    }

    .bottomStickyBooking {
        display: none;
        position: fixed;
        bottom: 10px;
        width: 900px;
        z-index: 12;
        margin-left: 5%;
    }

    .splitviewSticky {
        border-radius: 4px;
        box-shadow: 0 2px 4px 0 rgba(0 0 0 .15);
        background-color: #1fba71;
        padding: 12px;
    }

    .d-flex {
        display: flex;
    }

    .margin-right15 {
        margin-right: 15px;
    }

    .stickyFlightDetails {
        width: 280px;
        border-right: 1px solid rgba(255 255 255 .4);
        padding: 0 15px 0 0;
    }

    .white {
        color: #ffffff;
    }

    .d-flex.spaceBetween {
        justify-content: space-between;
    }

    .font16 {
        font-size: calc(var(--font-scale, 1)*16px);
    }

    .margin-left-auto {
        margin-left: auto;
    }

    .d-flex.align-center {
        align-items: center;
    }

    .margin-right10 {
        margin-right: 10px;
    }

    .btn-40 {
        height: 40px;
    }

    .bookingBtn {
        background-image: linear-gradient(100deg, #4a9913, #000000 140%);
        color: white;
    }

    .button {
        display: flex;
        border-radius: 35px;
        box-shadow: 0 1px 7px 0 rgba(0, 0, 0, .22);
        cursor: pointer;
        align-items: center;
        justify-content: center;
        height: 32px;
        padding: 0 20px;
        border: none;
        outline: none !important;
        font-weight: 900;
    }

    .font22 {
        font-size: calc(var(--font-scale, 1)*22px);
    }
</style>
<style>
    .r_flight_contaier {
        position: relative;
    }

    .r_flight_overlay {
        position: absolute;
        height: 100%;
        width: 100%;
        left: 0;
        right: 0;
        display: flex;
        align-items: center;
        background: #ffffffe6;
        justify-content: center;
    }
</style>
<script>
    let compatibility = {!! json_encode($data['combinability']) !!};

    var dep_search_id = 0;
    var dep_lfid = 0;
    var dep_solnid = 0;
    var dep_faretypeid = 0;
    var dep_flight_type = 0;
    var dep_loop_id = 0;
    var dep_fare = 0;

    var rtn_search_id = 0;
    var rtn_lfid = 0;
    var rtn_solnid = 0;
    var rtn_faretypeid = 0;
    var rtn_flight_type = 0;
    var rtn_loop_id = 0;
    var rtn_fare = 0;

    $(document).on('click', '.ret_add_to_cart', function() {

        $('.bottomStickyBooking').show();

        if ($(this).data('flight_type') == 'dep') {
            dep_search_id = $(this).data('search_id');
            dep_lfid = $(this).data('lfid');
            dep_solnid = $(this).data('solnid');
            dep_faretypeid = $(this).data('faretypeid');
            dep_flight_type = $(this).data('flight_type');
            dep_loop_id = $(this).data('loop_id');
            dep_fare = $(this).data('fare');

            dep_time = $('#cont_' + dep_loop_id + ' .dep_time').html()
            arr_time = $('#cont_' + dep_loop_id + ' .arr_time').html()
            flight_num = $('#cont_' + dep_loop_id + ' .flight_num').html()
            d_fare = $(this).parent().siblings('.d_fare').html()

            $('#stickyDepFlight').html(flight_num)
            $('#stickyDepFromTime').html(dep_time)
            $('#stickyDepToTime').html(arr_time)
            $('#stickyDepFare').html(d_fare)

            $('.r_flight_overlay').hide();

            hideIncompatible()


            rtn_search_id = 0;
            rtn_lfid = 0;
            rtn_solnid = 0;
            rtn_faretypeid = 0;
            rtn_flight_type = 0;
            rtn_loop_id = 0;
            rtn_fare = 0;

            $('#stickyReturnFlight').html('')
            $('#stickyReturnFromTime').html('')
            $('#stickyReturnToTime').html('')
            $('#stickyReturnFare').html('')

        } else {
            rtn_search_id = $(this).data('search_id');
            rtn_lfid = $(this).data('lfid');
            rtn_solnid = $(this).data('solnid');
            rtn_faretypeid = $(this).data('faretypeid');
            rtn_flight_type = $(this).data('flight_type');
            rtn_loop_id = $(this).data('loop_id');
            rtn_fare = $(this).data('fare');

            dep_time = $('#cont_' + rtn_loop_id + ' .dep_time').html()
            arr_time = $('#cont_' + rtn_loop_id + ' .arr_time').html()
            flight_num = $('#cont_' + rtn_loop_id + ' .flight_num').html()
            d_fare = $(this).parent().siblings('.d_fare').html()

            $('#stickyReturnFlight').html(flight_num)
            $('#stickyReturnFromTime').html(dep_time)
            $('#stickyReturnToTime').html(arr_time)
            $('#stickyReturnFare').html(d_fare)
        }

        if (rtn_lfid !== 0 && dep_lfid !== 0) {
            $('#stickyButton').show();
            $('.stickyTotalCont').show();
            var total = parseFloat(rtn_fare) + parseFloat(dep_fare);
            $('#stickyTotal').html(Math.round(total * 100) / 100)
        } else {
            $('#stickyButton').hide();
            $('.stickyTotalCont').hide();
            $('#stickyTotal').html('');
        }

    });

    function hideIncompatible() {
        if (dep_solnid !== 0) {
            var shownIds = compatibility[dep_solnid];
            $('.r_flight_contaier .fd-items').hide();
            shownIds.forEach(element => {
                $('#solnID' + element).show();
            });
        }
    }

    $(document).on("rtn_details_loaded", null, function(event) {
        hideIncompatible()
    });
</script>
