    @php 
        $RequestedPreferences = $PtrDetails['RequestedPreferences'];
        $arrrowImg = asset('assets/img/icon/right_arrow.png');
    @endphp 
    @foreach($RequestedPreferences as $pref)
        <div class="flight_search_items">
            <div class="multi_city_flight_lists">
                @foreach($pref['QuotedSegments'] as $segment)
                    @php
                        $airlineData = getAirlineData($segment['AirlineCode']);
                        $deptAirportData = getAirportData($segment['DepartureAirportLocationCode']);
                        $arrAirportData = getAirportData($segment['ArrivalAirportLocationCode']);
                    @endphp
                    <div class="flight_multis_area_wrapper">
                        <div class="flight_search_left">
                            <div class="flight_logo">
                                <img src="{{ isset($airlineData[0]) ? $airlineData[0]['AirLineLogo'] : '' }}" alt="img">
                                <div class="flight-details">
                                    <h4> {{ isset($airlineData[0]) ? $airlineData[0]['AirLineName'] : ''}} </h4>
                                    <h6> {{ $segment['FlightNumber']  }}</h6>
                                </div>
                            </div>
                            <div class="flight_search_destination">
                                <p>From</p>
                                <span>{{ date('d M, Y', strtotime($segment['DepartureDateTime'])) }}</span>
                                <h2>{{  date('H:i', strtotime($segment['DepartureDateTime'])) }} </h2>
                                <h4>{{ $deptAirportData[0]['City'] }} </h4>
                                <h6>{{ $deptAirportData[0]['AirportName'] }}</h6>
                            </div>
                        </div>

                        <div class="flight_search_middel">
                            <div class="flight_right_arrow">
                                <img src="{{ $arrrowImg }}" alt="icon">
                            
                                <p>{{ convertToHoursMins($segment['JourneyDuration']) }} </p>
                            </div>
                            <div class="flight_search_destination">
                                <p>To</p>
                                <span>{{ date('d M, Y', strtotime($segment['ArrivalDateTime'])) }}</span>
                                <h2>{{ date('H:i', strtotime($segment['ArrivalDateTime'])) }} </h2>
                                <h4>{{  $arrAirportData[0]['City']  }} </h4>
                                <h6>{{ $arrAirportData[0]['AirportName'] }} </h6>
                            </div>
                        </div>
                    </div>
                @endforeach
                @php
                    $fareDiff = 0;
                    $currency = '';
                    foreach($pref['QuotedFares'] as $fares){
                        $fareDiff = $fareDiff + $fares['TotalFareDifference']['Amount'];
                        $currency = $fares['TotalFareDifference']['CurrencyCode'];
                    }
                @endphp 
                <div class="flight_search_right">
                    <h4> Total fare difference </h4>
                    <h2>{{ $currency }} {{ $fareDiff }} </h2>
                    <button type="submit" class="btn btn_theme btn_lg mt-10 reissueButton" data-uniqueID="{{ $uniqueBookId }}" data-ptrUniqueID="{{ $ptrUniqueId }}" data-currency="{{ $currency }}" data-fare="{{ $fareDiff }}" data-preference="{{ $pref['PreferenceOption'] }}" name="reissueButton" id="reissueButton">Send Reschedule Request</button>
                </div>
            </div>
        </div>
    @endforeach