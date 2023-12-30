<div class="flightDetailsContainer flydubai">
    <div class="flightDetails">

        @php
            $fares = $matchingFlight['fares'];
            $col_class = floor(12 / count($fares));
        @endphp

        <p class="flightDetailsHead">{{ getAirportData($matchingFlight['origin'])['AirportName'] }} to
            {{ getAirportData($matchingFlight['destination'])['AirportName'] }} -
            {{ date('d M, Y', strtotime($matchingFlight['dep_time'])) }}</p>
        <div class="flightDetailsInfo col-sm-12">
            <div class="flightDetailsRow  col-sm-12">
                <div class="row">
                    <div class="col-sm-2">
                        <h4>Fare type</h4>
                        <ul>
                            <li>Rebooking</li>
                            <li>Cancellation</li>
                            <li>Price</li>
                        </ul>
                    </div>
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
                        @endphp
                        @if (strcasecmp($cabin_type, $cabin) == 0)
                            <div id="solnID{{ $fare['SolnId'] }}" class="fd-items col-sm-{{ $col_class }}">
                                <h4>{{ $fare['FareTypeName'] }}</h4>
                                <ul>
                                    <li>
                                        @if (isset($penalities['changeFees']))
                                            <a class="btn btn-primary" data-bs-toggle="collapse"
                                                href="#collapseExample{{ $loop->index }}" role="button"
                                                aria-expanded="false"
                                                aria-controls="collapseExample{{ $loop->index }}">
                                                Penalites Apply
                                            </a>
                                            <div class="collapse" id="collapseExample{{ $loop->index }}">
                                                <div class="card card-body">
                                                    <ul>
                                                        @foreach ($penalities['changeFees'] as $item)
                                                            <li>{!! $item !!}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @else
                                            Not Available
                                        @endif
                                    </li>
                                    <li>
                                        @if (isset($penalities['cancellationFees']))
                                            <a class="btn btn-primary" data-bs-toggle="collapse"
                                                href="#collapseExample1{{ $loop->index }}" role="button"
                                                aria-expanded="false"
                                                aria-controls="collapseExample1{{ $loop->index }}">
                                                Penalites Apply
                                            </a>
                                            <div class="collapse" id="collapseExample1{{ $loop->index }}">
                                                <div class="card card-body">
                                                    <ul>
                                                        @foreach ($penalities['cancellationFees'] as $item)
                                                            <li>{!! $item !!}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @else
                                            Not Available
                                        @endif
                                    </li>
                                    <li class="d_fare">
                                        @php
                                            $fare_amt = getFDLowestFare($fare['FareInfos']);
                                            $totalFareMargin = ($fare_amt / 100) * $margin['totalmargin'] + $fare_amt;
                                            $totalFareMargin = floor($totalFareMargin * 100) / 100;
                                            $displayAmount = convertCurrency($totalFareMargin, 'AED');
                                        @endphp
                                        <span class="crc">{{ getActiveCurrency() }}</span>
                                        {{ $displayAmount }}
                                    </li>
                                    <li>
                                        @if (request()->search_type == 'OneWay')
                                            <form class="addToCart" action="{{ route('flight.booking') }}">
                                                @csrf
                                                <input type="hidden" name="search_id"
                                                    value="{{ request()->session_id }}">
                                                <input type="hidden" name="LFID" value="{{ $LFID }}">
                                                <input type="hidden" name="FareTypeID"
                                                    value="{{ $fare['FareTypeID'] }}">
                                                <button type="submit">Add To Cart</button>
                                            </form>

                                            {{-- <button class="ret_add_to_cart addToCart" 
                                            data-action="{{ route('flight.booking') }}"
                                                data-loop_id="{{ request()->id }}"
                                                data-search_id="{{ request()->session_id }}"
                                                data-LFID="{{ $LFID }}" data-solnID="{{ $fare['SolnId'] }}"
                                                data-FareTypeID="{{ $fare['FareTypeID'] }}"
                                                type="button">Add To
                                                Cart</button> --}}

                                        @elseif(request()->search_type == 'Return')
                                            <button class="ret_add_to_cart" 
                                            data-fare="{{ $displayAmount }}"
                                            data-loop_id="{{ request()->id }}"
                                                data-search_id="{{ request()->session_id }}"
                                                data-LFID="{{ $LFID }}" data-solnID="{{ $fare['SolnId'] }}"
                                                data-FareTypeID="{{ $fare['FareTypeID'] }}"
                                                data-flight_type={{ $matchingFlight['leg_count'] == 1 ? 'dep' : 'ret' }}
                                                type="button">Add To
                                                Cart</button>
                                        @else
                                            <button data-search_id="{{ request()->session_id }}"
                                                data-LFID="{{ $LFID }}"
                                                data-FareTypeID="{{ $fare['FareTypeID'] }}" type="button">Add To
                                                Cart</button>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
