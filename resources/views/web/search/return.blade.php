<div class="flight_search_result_wrapper" id="return_trip">
    @if ($data['flightDetails'])

        @php
            $seach_params = getOrginDestinationSession($data['search_type']);
            $startRoute = $seach_params['origin'] . $seach_params['destination'];
            $endRoute = $seach_params['destination'] . $seach_params['origin'];

            $from_count = $to_count = 0;
            $from_flight = Arr::where($data['flightDetails'], function ($value, $key) use ($startRoute, &$from_count) {
                if ($value['api_provider'] == 'yasin') {
                    if ($value['Route'] == $startRoute) {
                        $from_count++;
                        return true;
                    }
                    return;
                } elseif ($value['api_provider'] == 'flydubai') {
                    return $value['leg_count'] == 1;
                }
            });

            $to_flight = Arr::where($data['flightDetails'], function ($value, $key) use ($startRoute, $endRoute, &$to_count) {
                if ($value['api_provider'] == 'yasin') {
                    if ($value['Route'] == $endRoute) {
                        $to_count++;
                        return true;
                    }
                } elseif ($value['api_provider'] == 'flydubai') {
                    return $value['leg_count'] == 2;
                }
            });

            $total_count = count($from_flight) + count($to_flight);

        @endphp

        @if ($total_count == 0 && $from_count == 0 && $to_count == 0)
            <div class="text-center fontSize24">
                <span>No Flights Found. </span>
            </div>
        @else
            <div class="departing_flight">
                <h3>SELECT DEPARTING FLIGHT</h3>
                @foreach ($from_flight as $fdata)
                    @if ($fdata['api_provider'] == 'flydubai')
                        @include('web.search.providers.return-flydubai')
                    @elseif ($fdata['api_provider'] == 'yasin')
                        @include('web.search.providers.return-yasin_from')
                    @endif
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
                    @foreach ($to_flight as $fdata)
                        @if ($fdata['api_provider'] == 'flydubai')
                            @include('web.search.providers.return-flydubai')
                        @elseif ($fdata['api_provider'] == 'yasin')
                            @include('web.search.providers.return-yasin_to')
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
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
                    <p class="white font22 bold stickyTotalCont" style="display: none">
                        {{ getActiveCurrency() }}&nbsp;<span class="white font22 bold" id="stickyTotal"></span></p>
                </div>
                <div class="d-flex align-center">
                    <div>
                        <form method="POST" id="addToCart" action="{{ route('flight.booking') }}">
                            @csrf
                            <input type="hidden" name="search_id" value="">

                            <input type="hidden" name="dep_LFID" value="">
                            <input type="hidden" name="rtn_LFID" value="">

                            <input type="hidden" name="dep_FareTypeID" value="">
                            <input type="hidden" name="rtn_FareTypeID" value="">

                            <input type="hidden" name="dep_solnid" value="">
                            <input type="hidden" name="rtn_solnid" value="">

                            <button id="stickyButton" style="display: none"
                                class="button bookingBtn btn-40 ret_book_btn" type="submit">Book Now</button>
                        </form>

                        <form method="POST" id="yasaddToCart" action="{{ route('yasin.details') }}">
                            @csrf
                            <input type="hidden" name="search_id" value="">

                            <input type="hidden" name="dep_airline" value="">
                            <input type="hidden" name="rtn_airline" value="">

                            <input type="hidden" name="dep_route" value="">
                            <input type="hidden" name="rtn_route" value="">

                            <input type="hidden" name="dep_date_time" value="">
                            <input type="hidden" name="rtn_date_time" value="">

                            <input type="hidden" name="dep_flight_num" value="">
                            <input type="hidden" name="rtn_flight_num" value="">

                            <input type="hidden" name="dep_rbd" value="">
                            <input type="hidden" name="rtn_rbd" value="">

                            <input type="hidden" name="dep_rph" value="">
                            <input type="hidden" name="rtn_rph" value="">

                            <input type="hidden" name="price" value="">

                            <button id="yasstickyButton" style="display: none"
                                class="button bookingBtn btn-40 ret_book_btn" type="submit">Book Now</button>
                        </form>

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

            $('#addToCart input[name=search_id]').val(dep_search_id);

            $('#addToCart input[name=rtn_LFID]').val('');
            $('#addToCart input[name=rtn_FareTypeID]').val('');
            $('#addToCart input[name=rtn_solnid]').val('');

            $('#addToCart input[name=dep_LFID]').val(dep_lfid);
            $('#addToCart input[name=dep_FareTypeID]').val(dep_faretypeid);
            $('#addToCart input[name=dep_solnid]').val(dep_solnid);

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


            $('#addToCart input[name=rtn_LFID]').val(rtn_lfid);
            $('#addToCart input[name=rtn_FareTypeID]').val(rtn_faretypeid);
            $('#addToCart input[name=rtn_solnid]').val(rtn_solnid);

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


    var dep_search_id = 0;
    var dep_airline = "";
    var dep_route = "";
    var dep_date_time = "";
    var dep_flight_num = "";
    var dep_rbd = "";
    var dep_rph = "";
    var dep_loop_id = 0;
    var dep_fare = 0;

    var rtn_search_id = 0;
    var rtn_airline = "";
    var rtn_route = "";
    var rtn_date_time = "";
    var rtn_flight_num = "";
    var rtn_rbd = "";
    var rtn_loop_id = 0;
    var rtn_rph = "";
    var rtn_fare = 0;

    $(document).on('click', '.yas_ret_add_to_cart', function() {
        $('.bottomStickyBooking').show();

        if ($(this).data('flight_type') == 'dep') {
            dep_search_id = $(this).data('search_id');
            dep_airline = $(this).data('airline');
            dep_route = $(this).data('route');
            dep_date_time = $(this).data('date_time');
            dep_flight_num = $(this).data('flight_num');
            dep_rbd = $(this).data('rbd');
            dep_rph = $(this).data('rph');
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


            $('#yasaddToCart input[name=search_id]').val(dep_search_id);

            $('#yasaddToCart input[name=rtn_airline]').val('');
            $('#yasaddToCart input[name=rtn_route]').val('');
            $('#yasaddToCart input[name=rtn_date_time]').val('');
            $('#yasaddToCart input[name=rtn_date_time]').val('');
            $('#yasaddToCart input[name=rtn_rph]').val('');
            $('#yasaddToCart input[name=rtn_rbd]').val('');

            $('#yasaddToCart input[name=dep_airline]').val(dep_airline);
            $('#yasaddToCart input[name=dep_route]').val(dep_route);
            $('#yasaddToCart input[name=dep_date_time]').val(dep_date_time);
            $('#yasaddToCart input[name=dep_flight_num]').val(dep_flight_num);
            $('#yasaddToCart input[name=dep_rbd]').val(dep_rbd);
            $('#yasaddToCart input[name=dep_rph]').val(dep_rph);

            $('#stickyReturnFlight').html('')
            $('#stickyReturnFromTime').html('')
            $('#stickyReturnToTime').html('')
            $('#stickyReturnFare').html('')

        } else {

            rtn_search_id = $(this).data('search_id');
            rtn_airline = $(this).data('r_airline');
            rtn_route = $(this).data('r_route');
            rtn_date_time = $(this).data('r_date_time');
            rtn_flight_num = $(this).data('r_flight_num');
            rtn_rbd = $(this).data('r_rbd');
            rtn_rph = $(this).data('r_rph');
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

            $('#yasaddToCart input[name=rtn_airline]').val(rtn_airline);
            $('#yasaddToCart input[name=rtn_route]').val(rtn_route);
            $('#yasaddToCart input[name=rtn_date_time]').val(rtn_date_time);
            $('#yasaddToCart input[name=rtn_flight_num]').val(rtn_flight_num);
            $('#yasaddToCart input[name=rtn_rph]').val(rtn_rph);
            $('#yasaddToCart input[name=rtn_rbd]').val(rtn_rbd);
        }

        console.log([dep_rbd, rtn_rbd]);

        if (dep_rbd !== '' && rtn_rbd !== '') {
            $('#yasstickyButton').show();
            $('.stickyTotalCont').show();
            var total = parseFloat(rtn_fare) + parseFloat(dep_fare);
            $('#stickyTotal').html(Math.round(total * 100) / 100);
            $('#yasaddToCart input[name=price]').val(Math.round(total * 100) / 100);
        } else {
            $('#yasstickyButton').hide();
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
