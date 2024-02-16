<div class="tab-pane fade" id="nav-seats" role="tabpanel" aria-labelledby="nav-seats-tab">
    <div class="row">
        <div class="lod">
            <div class="loading"></div>
        </div>

        <div class="col-lg-5 col-md-5 col-sm-12 col-12">
            <div class="faqs_main_item">
                @if ($seat_response['exceptions'][0]['code'] == 0)
                    @php
                        $flightLoop = 1;
                    @endphp
                    @foreach ($seat_response['seatQuotes']['flights'] as $flights)
                        @php
                            $leg_details = getLegDetails($flights['pfID'], $res_data['search_result']['legDetails']);
                        @endphp

                        <div class="accordion" id="accordionExample{{ $flights['pfID'] }}">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingtwo{{ $flights['pfID'] }}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapsetwo{{ $flights['pfID'] }}" aria-expanded="true"
                                        aria-controls="collapsetwo{{ $flights['pfID'] }}">
                                        <div class="flight-card flights-list__item">
                                            <div class="flight-card-list-dt">
                                                <div class="flight-card__departure">
                                                    <h2 class="flight-card__city">
                                                        {{ getAirportData($leg_details['Origin'])['AirportName'] }}
                                                        ({{ $leg_details['Origin'] }})
                                                    </h2>
                                                </div>

                                                <div class="flight-card__route">
                                                    <div class="flight-card__route-line route-line" aria-hidden="true">
                                                        <i class="fas fa-plane-departure"></i>
                                                    </div>
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
                                <div id="collapsetwo{{ $flights['pfID'] }}" class="accordion-collapse collapse show"
                                    aria-labelledby="headingtwo{{ $flights['pfID'] }}"
                                    data-bs-parent="#accordionExample{{ $flights['pfID'] }}" style="">
                                    <div class="accordion-body">
                                        <div class="tabs-menus"> <!-- Tabs -->
                                            <ul class="nav panel-tabs" role="tablist">
                                                @if (isset($passengers['ADT']))
                                                    @for ($ad = 1; $ad <= $passengers['ADT']; $ad++)
                                                        <input type="hidden"
                                                            id="seat_input_ADT_{{ $ad }}_{{ $flights['pfID'] }}"
                                                            name="seat[ADT][{{ $ad }}][{{ $flights['pfID'] }}]" />
                                                        <li class="">
                                                            <a data-lfid="{{ $flights['pfID'] }}" data-user-type="ADT"
                                                                data-user-count="{{ $ad }}"
                                                                data-user_id="{{ $flights['pfID'] }}_ADT_{{ $ad }}"
                                                                href="#seats_{{ $flights['pfID'] }}"
                                                                class="seatselector {{ $flightLoop == 1 && $ad == 1 ? 'active' : '' }}"
                                                                data-bs-toggle="tab" aria-selected="false"
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
                                                                                    class="seta_pas_text text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
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
                                                        <input type="hidden"
                                                            id="seat_input_CHD_{{ $ad }}_{{ $flights['pfID'] }}"
                                                            name="seat[CHD][{{ $ad }}][{{ $flights['pfID'] }}]" />
                                                        <li class="">
                                                            <a data-lfid="{{ $flights['pfID'] }}" data-user-type="CHD"
                                                                data-user-count="{{ $ad }}"
                                                                data-user_id="{{ $flights['pfID'] }}_CHD_{{ $ad }}"
                                                                href="#seats_{{ $flights['pfID'] }}"
                                                                class="seatselector " data-bs-toggle="tab"
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
                                                                                    class="seta_pas_text text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">
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
                                                            <a href="javascript:void(0)">
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
                                                                                Infants aren't assigned their own
                                                                                seat
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
                    <button type="button" data-targetbtn="#nav-details-tab" data-target="#nav-details"
                        class="tabswitch_btn btn btn_theme w-100">Continue
                        passenger details</button>
                @endif
            </div>
        </div>

        <div class="col-lg-7 col-md-7 col-sm-12 col-12">
            <div class="tab-content">

                <script>
                    var flights = {!! json_encode($seat_response['seatQuotes']['flights']) !!};
                    var current_class = '{!! Str::upper($res_data['search_params']['class']) !!}';

                    var seat_order = ['BUSINESS', 'ECONOMY'];
                    var svg =
                        '<?xml version="1.0" encoding="UTF-8"?><svg width="30" height="30" fill="none" viewBox="0 0 464 564" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#a)" clip-rule="evenodd" fill="#434343" fill-rule="evenodd"><path d="m346.39 376.25h-222.87l-27.859-312.52s-16.235-63.247 139.25-63.247c155.58 0 139.3 63.247 139.3 63.247l-27.812 312.52z"/><path d="m421.64 528.62c0 19.53-11.859 35.295-26.494 35.295h-321.08c-14.635 0-26.447-15.765-26.447-35.295 0 0 20.188-102.87 53.365-102.87h267.39c37.6 0 53.271 102.87 53.271 102.87z"/><path d="m463.8 393.71c0 16.423-8.941 29.694-19.812 29.694-10.917 0-19.764-13.271-19.764-29.694v-126.26c0-16.424 8.847-29.694 19.764-29.694 10.824 0 19.812 13.27 19.812 29.694v126.26z"/><path d="m43.8 393.71c0 16.423-9.8352 29.694-21.882 29.694-12.141 0-21.929-13.271-21.929-29.694v-126.26c0-16.424 9.7882-29.694 21.929-29.694 12.047 0 21.882 13.27 21.882 29.694v126.26z"/></g><defs><clipPath id="a"><rect width="464" height="564" fill="#fff"/></clipPath></defs></svg>';
                    $(document).ready(function() {
                        if (flights.length > 0) {
                            flights.forEach(function(flight) {
                                var cabins = flight['cabins']
                                seat_order.forEach(order => {
                                    var html_ul = $('<ul></ul>').addClass('area-sbc');

                                    if (order !== current_class) {
                                        html_ul.addClass('disabled')
                                    }

                                    $('#seating_area_' + flight['pfID']).append(html_ul)

                                    cabins.forEach(function(cabin) {
                                        if (cabin['cabin'] == order) {
                                            cabin['seatMaps'].forEach(seat_map => {
                                                var li = $('<li></li>');
                                                var smt = $.trim(seat_map['seatMap']).replace(
                                                    '  ', ' ', );
                                                var seatMap = smt.split(' ');

                                                var seats = {};
                                                seat_map['seats'].forEach(item => {
                                                    seats[item.seat] = item;
                                                });

                                                seatMap.forEach(function(item, index) {
                                                    var div = $('<div></div>');
                                                    if (index == 0) {
                                                        div.addClass('left')
                                                    } else {
                                                        div.addClass('right')
                                                    }

                                                    var rw_sts = item.split("");

                                                    rw_sts.forEach(rw_st => {
                                                        var c_seat = seats[
                                                            rw_st];
                                                        var seat_avail = c_seat[
                                                                'assigned'] ||
                                                            c_seat[
                                                                'isBlocked'] ||
                                                            c_seat[
                                                                'isPreBlocked'];
                                                        var seat_class =
                                                            'gt-seat-standard';
                                                        if (order ==
                                                            'BUSINESS') {
                                                            seat_class =
                                                                'gt-seat-bus';
                                                        }

                                                        if (c_seat[
                                                                'serviceCode'
                                                            ] ==
                                                            'XLGR') {
                                                            seat_class =
                                                                'gt-seat-business';
                                                        }

                                                        var span = $('<span></span>')
                                                            .attr('data-seat-id', seat_map['rowNumber'] + '' + c_seat['seat']);
                                                        span.attr('data-user');
                                                        span.attr('data-selected');
                                                        span.attr('tooltip', c_seat['currency'] + ' ' +c_seat['amount']);
                                                        span.attr('data-rate',c_seat['amount']);
                                                        span.attr('data-code',c_seat['serviceCode'] + '_' + seat_map['rowNumber'] + '_' + c_seat['seat'] + '_' + c_seat['amount'] );
                                                        span.addClass(seat_class);

                                                        if (order ==
                                                            current_class) {
                                                            span.addClass(
                                                                'input_seat'
                                                            );
                                                        }
                                                        if (seat_avail) {
                                                            span.addClass(
                                                                'seatnot-available'
                                                            );
                                                        }

                                                        span.append(svg);
                                                        var p = $('<p></p>')
                                                            .addClass(
                                                                'seat-number')
                                                            .html(seat_map[
                                                                    'rowNumber'
                                                                ] + '' +
                                                                c_seat['seat']);
                                                        span.append(p);
                                                        div.append(span);
                                                    })

                                                    li.append(div);
                                                });

                                                html_ul.append(li);
                                            })
                                        }
                                    });
                                });
                            });
                        }
                        $('.lod').hide();
                    });
                </script>
                @php
                    $flightLoop = 1;
                @endphp
                @foreach ($seat_response['seatQuotes']['flights'] as $flights)
                    @php
                        $current_class = Str::upper($res_data['search_params']['class']);
                    @endphp
                    <div class="tab-pane table-responsive seattab userprof-tab {{ $flightLoop == 1 ? 'active' : '' }}"
                        id="seats_{{ $flights['pfID'] }}" role="tabpanel">
                        <div class="bookyour-seat">
                            <div class="seat-info">
                                <header>
                                    <h3>Select seat</h3>
                                </header>
                                <ul class="seat-type">
                                    <li>
                                        <span class="gt-seat-eco business-seat">
                                            {!! generateSeatSVG() !!}
                                        </span>
                                        Standard business seat
                                    </li>
                                    <li>
                                        <span class="gt-seat-eco standard-seat">
                                            {!! generateSeatSVG() !!}
                                        </span>
                                        Standard seat
                                    </li>
                                    <li>
                                        <span class="gt-seat-eco seat-extra-legroom">
                                            {!! generateSeatSVG() !!}
                                        </span>
                                        Extra legroom
                                    </li>
                                </ul>
                            </div>

                            <div class="chooseyourseat">
                                <span class="flight-body">
                                    <!-- <img src="{{ asset('assets/img/flight-structure-front.png') }}" alt=""> -->
                                    <img src="{{ asset('assets/img/f-front.png') }}" alt="">
                                </span>
                                <div class="seating-area" id="seating_area_{{ $flights['pfID'] }}">

                                </div>
                                <span>
                                    <img src="{{ asset('assets/img/f-back.png') }}" alt="">
                                </span>
                            </div>
                        </div>
                    </div>
                    @php
                        $flightLoop++;
                    @endphp
                @endforeach

            </div>
        </div>
    </div>
</div>


<style>
    #nav-seats {
        position: relative;
    }

    .lod {
        display: flex;
        justify-content: space-around;
        align-items: center;
        background: #ffffff59;
        position: absolute;
        height: 100%;
        width: 100%;
        z-index: 999;
    }

    .loading {
        border-radius: 50%;
        width: 80px;
        height: 80px;
        border: 0.25rem solid rgb(169 207 130);
        border-top-color: #5d8f3a;
        -webkit-animation: spin 1s infinite linear;
        animation: spin 1s infinite linear;
    }

    @-webkit-keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @-webkit-keyframes pulse {
        50% {
            background: white;
        }
    }

    @keyframes pulse {
        50% {
            background: white;
        }
    }
</style>
