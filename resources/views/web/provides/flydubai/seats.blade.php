@php
    $start_time = microtime(true);
@endphp

<div class="tab-pane fade" id="nav-seats" role="tabpanel" aria-labelledby="nav-seats-tab">
    <div class="row">

        <div class="col-lg-5 col-md-5 col-sm-12 col-12">
            <div class="faqs_main_item">
                @if ($seat_response['exceptions'][0]['code'] == 0)
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
                                <div id="collapsetwo{{ $flights['pfID'] }}" class="accordion-collapse collapse"
                                    aria-labelledby="headingtwo{{ $flights['pfID'] }}"
                                    data-bs-parent="#accordionExample{{ $flights['pfID'] }}" style="">
                                    <div class="accordion-body">
                                        <div class="tabs-menus"> <!-- Tabs -->
                                            <ul class="nav panel-tabs" role="tablist">
                                                @if (isset($passengers['ADT']))
                                                    @for ($ad = 1; $ad <= $passengers['ADT']; $ad++)
                                                        <li class="">
                                                            <a href="#seatADT{{ $ad }}" class=""
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
                                                            <a href="#seatCHD{{ $ad }}" class=""
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
                                                            <a href="javascript:void(0)" class=""
                                                                data-bs-toggle="tab" aria-selected="false"
                                                                role="tab" tabindex="-1">
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
                                                                            <div
                                                                                class="d-flex align-items-center justify-content-start">
                                                                                <div
                                                                                    class="text-dark fw-bold text-md me-2">
                                                                                    Infants aren't assigned their own
                                                                                    seat
                                                                                </div>
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
                    @endforeach
                @endif
            </div>
        </div>




        <div class="col-lg-7 col-md-7 col-sm-12 col-12">
            <div class="tab-content">
                @foreach ($seat_response['seatQuotes']['flights'] as $flights)
                    @php
                        $current_class = Str::upper($res_data['search_params']['class']);
                        $seat_order = ['BUSINESS', 'ECONOMY'];
                        $cabins = array_combine(array_column($flights['cabins'], 'cabin'), $flights['cabins']);
                    @endphp

                    <div class="tab-pane table-responsive userprof-tab" id="seatADT{{ $ad }}"
                        role="tabpanel">
                        <div class="bookyour-seat">
                            <div class="seat-info">
                                <header>
                                    <h3>Select seat</h3>
                                    {{-- <h4>Boeing 777-300</h4>
                                <span>Cathay Pacific</span>
                                <span>CX-5169</span> --}}
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

                                <div class="seating-area">
                                    @foreach ($seat_order as $order)
                                        @php
                                            $seat = $cabins[$order];
                                        @endphp
                                        <ul class="area-sbc {{ $order !== $current_class ? 'disabled' : '' }}">
                                            @foreach ($seat['seatMaps'] as $seat_map)
                                                <li>
                                                    @php
                                                        $stm = str_replace('  ', ' ', trim($seat_map['seatMap']));
                                                        $seatMap = explode(' ', $stm);
                                                        $seats = array_combine(array_column($seat_map['seats'], 'seat'), $seat_map['seats']);
                                                    @endphp
                                                    @foreach ($seatMap as $item)
                                                        <div class="{{ $loop->index == 0 ? 'left' : 'right' }}">
                                                            @php
                                                                $rw_sts = str_split($item);
                                                            @endphp
                                                            @foreach ($rw_sts as $rw_st)
                                                                @php
                                                                    $c_seat = $seats[$rw_st];
                                                                    $seat_avail = $c_seat['assigned'] || $c_seat['isBlocked'] || $c_seat['isPreBlocked'];

                                                                    $seat_class = 'gt-seat-standard';

                                                                    if ($order == 'BUSINESS') {
                                                                        $seat_class = 'gt-seat-bus';
                                                                    }

                                                                    if ($c_seat['serviceCode'] == 'XLGR') {
                                                                        $seat_class = 'gt-seat-business';
                                                                    }
                                                                @endphp
                                                                <span data-selected="false"
                                                                    tooltip="{{ getDisplyPrice($c_seat['amount'], $c_seat['currency']) }}"
                                                                    class="{{ $seat_class }} {{ $order == $current_class ? 'input_seat' : '' }} {{ $seat_avail ? 'seatnot-available' : '' }}"
                                                                    data-seat-id="{{ $seat_map['rowNumber'] . $c_seat['seat'] }}">
                                                                    {!! generateSeatSVG() !!}
                                                                    <p class="seat-number">
                                                                        {{ $seat_map['rowNumber'] . $c_seat['seat'] }}
                                                                    </p>
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @endforeach
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endforeach
                                </div>
                                <span>
                                    <img src="{{ asset('assets/img/f-back.png') }}" alt="">
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


@php
    $end_time = microtime(true);
    $execution_time = $end_time - $start_time;
@endphp
seat: {{ $execution_time }}
