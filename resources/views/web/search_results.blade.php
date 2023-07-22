@extends('web.layouts.app')

@section('content')
<!-- Common Banner Area -->
<section id="common_banner">
    <!-- Form Area -->
    @include('web.common.search_flight')
</section>
<!-- Flight Search Areas -->
<section id="explore_area" class="section_padding">
    <div class="container">

        @php
            $marginData = $data['margins'];
            $totalmargin = $marginData['totalmargin'];
        @endphp
        <!-- Section Heading -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="section_heading_left">
                    @if($data['search_type'] == 'OneWay')
                    <h2>Flights from {{ $data['airports'][session('flight_search_oneway')['oFrom']]['City'] }} <span
                            class="range_plan-place"><i
                                class="fas fa-arrow-right"></i></span>{{ $data['airports'][session('flight_search_oneway')['oTo']]['City'] }}
                    </h2>
                    @elseif($data['search_type'] == 'Return')
                    <h2>Flights from {{ $data['airports'][session('flight_search_return')['rFrom']]['City'] }} <span
                            class="range_plan-place"><i
                                class="fas fa-exchange-alt"></i></span>{{ $data['airports'][session('flight_search_return')['rTo']]['City'] }}
                    </h2>
                    @endif
                    <h5 class="section_heading_left-sub">{{ $data['totalCount'] }} results Found</h5>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="left_side_search_area">

                    @php $stopFilter = $airlineFilter = $refundFilter = array(); @endphp

                    @if($data['search_type'] == 'OneWay')
                        @if(Session::has("flight_search_oneway"))
                            @php
                                $stopFilter = explode(',', rtrim(Session::get("flight_search_oneway")['ostop_filter']));
                                $airlineFilter = explode(',', rtrim(Session::get("flight_search_oneway")['oairline_filter']));
                                $refundFilter = explode(',', rtrim(Session::get("flight_search_oneway")['orefund_filter']));
                            @endphp
                        @endif
                    @elseif($data['search_type'] == 'Return')
                        @if(Session::has("flight_search_return"))
                            @php
                                $stopFilter = explode(',', rtrim(Session::get("flight_search_return")['rstop_filter']));
                                $airlineFilter = explode(',', rtrim(Session::get("flight_search_return")['rairline_filter']));
                                $refundFilter = explode(',', rtrim(Session::get("flight_search_return")['rrefund_filter']));
                            @endphp
                        @endif
                    @elseif($data['search_type'] == 'Circle')
                        @if(Session::has("flight_search_multi"))
                            @php
                                $stopFilter = explode(',', rtrim(Session::get("flight_search_multi")['mstop_filter']));
                                $airlineFilter = explode(',', rtrim(Session::get("flight_search_multi")['mairline_filter']));
                                $refundFilter = explode(',', rtrim(Session::get("flight_search_multi")['mrefund_filter']));
                            @endphp
                        @endif
                    @endif

                    <input type="hidden" name="search_typeResult" id="search_typeResult" value="{{$data['search_type']}}">
                    <div class="left_side_search_boxed">
                        <div class="left_side_search_heading">
                            <h5>Number of stops</h5>
                        </div>
                        <div class="tour_search_type">
                            <div class="form-check">
                                <input class="form-check-input stopFilter" {{ (in_array("1", $stopFilter)) ? 'checked="checked"' : '' }} type="checkbox" value="1" id="flexCheckDefaultf1">
                                <label class="form-check-label" for="flexCheckDefaultf1">
                                    <span class="area_flex_one">
                                        <span>1 stop</span>
                                        <span>{{ $data['one_stop'] }}</span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input stopFilter" type="checkbox" {{ (in_array("2", $stopFilter)) ? 'checked="checked"' : '' }} value="2" id="flexCheckDefaultf2">
                                <label class="form-check-label" for="flexCheckDefaultf2">
                                    <span class="area_flex_one">
                                        <span>2 stop</span>
                                        <span>{{ $data['two_stop'] }}</span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input stopFilter" type="checkbox" {{ (in_array("3", $stopFilter)) ? 'checked="checked"' : '' }} value="3" id="flexCheckDefaultf3">
                                <label class="form-check-label" for="flexCheckDefaultf3">
                                    <span class="area_flex_one">
                                        <span>3 stop</span>
                                        <span>{{ $data['three_stop'] }}</span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input stopFilter" type="checkbox" {{ (in_array("0", $stopFilter)) ? 'checked="checked"' : '' }} value="0" id="flexCheckDefaultf4">
                                <label class="form-check-label" for="flexCheckDefaultf4">
                                    <span class="area_flex_one">
                                        <span>Non-stop</span>
                                        <span> {{ $data['non_stop'] }}</span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="left_side_search_boxed">
                        <div class="left_side_search_heading">
                            <h5>Airlines</h5>
                        </div>
                        <div class="tour_search_type">
                            @isset($data['airlines'])
                                @foreach($data['airlines'] as $airKey => $airValue)
                                    @php  $flightKey = $data['flightData'][$airKey];  @endphp
                                <div class="form-check">
                                    <input class="form-check-input airlineFilter" {{ (in_array($airKey, $airlineFilter)) ? 'checked="checked"' : '' }} type="checkbox" value="{{$airKey}}" id="flexCheckDefaults1">
                                    <label class="form-check-label" for="flexCheckDefaults1">
                                        <span class="area_flex_one">
                                            <span>{{ $flightKey['AirLineName'] }}</span>
                                            <span>{{ $airValue }}</span>
                                        </span>
                                    </label>
                                </div>
                                @endforeach
                            @endisset
                        </div>
                    </div>
                    <div class="left_side_search_boxed">
                        <div class="left_side_search_heading">
                            <h5>Refundable</h5>
                        </div>
                        <div class="tour_search_type">
                            <div class="form-check">
                                <input class="form-check-input refundFilter" type="checkbox" {{ (in_array('yes', $refundFilter)) ? 'checked="checked"' : '' }} value="yes" name="refund_yes" id="refundYes">
                                <label class="form-check-label" for="refundYes">
                                    <span class="area_flex_one">
                                        <span>Yes</span>
                                        <span>{{ $data['refund'] }}</span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input refundFilter" type="checkbox" value="no" {{ (in_array('no', $refundFilter)) ? 'checked="checked"' : '' }} name="refund_no" id="refundNo">
                                <label class="form-check-label" for="refundNo">
                                    <span class="area_flex_one">
                                        <span>No</span>
                                        <span> {{ $data['no_refund'] }}</span>
                                    </span>
                                </label>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-12">
                        @php
                            $divId = '';
                            if($data['search_type'] == 'OneWay'){
                                $divId = 'one_way_trip';
                            }elseif($data['search_type'] == 'Return'){
                                $divId = 'return_trip';
                            }elseif($data['search_type'] == 'Circle'){
                                $divId = 'multi_city_trip';
                            }
                        @endphp
                        <div class="flight_search_result_wrapper" id="{{$divId}}">
                           
                            @if($data['flightDetails'])
                                @foreach($data['flightDetails'] as $fdata)

                                <div class="flight_search_item_wrappper">
                                    <div class="flight_search_items">
                                        <div class="multi_city_flight_lists">
                                            @php 
                                                $OriginDestinationOptionsOutbound   = $fdata['OriginDestinationOptionsOutbound'];  
                                                $totalFares = $fdata['TotalFares']['TotalFare'];
                                                $totalFareMargin = (($totalFares['Amount']/100) * $totalmargin) + $totalFares['Amount'];
                                                $totalFareMargin = number_format(floor($totalFareMargin*100)/100, 2, '.', '');
                                            @endphp

                                            @if($data['search_type'] != "Circle")
                                                @php
                                                    $firstFlight = head($OriginDestinationOptionsOutbound);
                                                    $lastFlight = last($OriginDestinationOptionsOutbound);
                                                    $firstFlightSegment = $firstFlight['FlightSegment'];
                                                    $lastFlightSegment = $lastFlight['FlightSegment'];
                                                @endphp

                                                <div class="flight_multis_area_wrapper">
                                                    <div class="flight_search_left">
                                                        <div class="flight_logo">
                                                            <img src="{{ $data['flightData'][$firstFlightSegment['MarketingAirlineCode']]['AirLineLogo'] }}"
                                                                alt="img">
                                                            <div class="flight-details">
                                                                <h4>{{ $firstFlightSegment['MarketingAirlineName'] }}
                                                                </h4>
                                                                <h6>{{ $firstFlightSegment['MarketingAirlineCode'] }}
                                                                    {{ $firstFlightSegment['FlightNumber']}}</h6>
                                                            </div>
                                                        </div>
                                                        <div class="flight_search_destination">
                                                            <p>From</p>
                                                            <span>{{ date('d M, Y', strtotime($firstFlightSegment['DepartureDateTime'])) }}</span>
                                                            <h2>{{ date('H:i', strtotime($firstFlightSegment['DepartureDateTime'])) }}
                                                            </h2>
                                                            <h3>{{ $data['airports'][$firstFlightSegment['DepartureAirportLocationCode']]['City'] }}
                                                            </h3>
                                                            <h6>{{ $data['airports'][$firstFlightSegment['DepartureAirportLocationCode']]['AirportName'] }}
                                                            </h6>
                                                        </div>
                                                    </div>

                                                    <div class="flight_search_middel">
                                                        <div class="flight_right_arrow">
                                                            <img src="{{ asset('assets/img/icon/right_arrow.png') }}"
                                                                alt="icon">
                                                            <h6>
                                                                {{ ($fdata['totalOutStops'] == 0) ? 'Non-stop' : (($fdata['totalOutStops'] == 1) ?  '1 Stop via '.implode(',',$fdata['layovers']['place']) : ($fdata['totalOutStops']).' Stops via '.implode(',',$fdata['layovers']['place'])) }}
                                                            </h6>
                                                            <p>{{ convertToHoursMins($fdata['totalDuration']) }} </p>

                                                        </div>
                                                        <div class="flight_search_destination">
                                                            <p>To</p>
                                                            <span>{{ date('d M, Y', strtotime($lastFlightSegment['ArrivalDateTime'])) }}</span>
                                                            <h2>{{ date('H:i', strtotime($lastFlightSegment['ArrivalDateTime'])) }}
                                                            </h2>
                                                            <h3>{{ $data['airports'][$lastFlightSegment['ArrivalAirportLocationCode']]['City'] }}
                                                            </h3>
                                                            <h6>{{ $data['airports'][$lastFlightSegment['ArrivalAirportLocationCode']]['AirportName'] }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>

                                                @isset($fdata['OriginDestinationOptionsInbound'])

                                                    @php  $OriginDestinationOptionsInbound   = $fdata['OriginDestinationOptionsInbound'];  @endphp

                                                    @if(!empty($OriginDestinationOptionsInbound))
                                                    
                                                        @php
                                                            $firstFlightIn = head($OriginDestinationOptionsInbound);
                                                            $lastFlightIn = last($OriginDestinationOptionsInbound);

                                                            $firstFlightInSegment = $firstFlightIn['FlightSegment'];
                                                            $lastFlightInSegment = $lastFlightIn['FlightSegment'];
                                                        @endphp
                                                        <div class="flight_multis_area_wrapper">
                                                            <div class="flight_search_left">
                                                                <div class="flight_logo">
                                                                    <img src="{{ $data['flightData'][$firstFlightInSegment['MarketingAirlineCode']]['AirLineLogo'] }}"
                                                                        alt="img">
                                                                    <div class="flight-details">
                                                                        <h4>{{ $firstFlightInSegment['MarketingAirlineName'] }}
                                                                        </h4>
                                                                        <h6>{{ $firstFlightInSegment['MarketingAirlineCode'] }}
                                                                            {{ $firstFlightInSegment['FlightNumber']}}</h6>
                                                                    </div>
                                                                </div>
                                                                <div class="flight_search_destination">
                                                                    <p>From</p>
                                                                    <span>{{ date('d M, Y', strtotime($firstFlightInSegment['DepartureDateTime'])) }}</span>
                                                                    <h2>{{ date('H:i', strtotime($firstFlightInSegment['DepartureDateTime'])) }}
                                                                    </h2>
                                                                    <h3>{{ $data['airports'][$firstFlightInSegment['DepartureAirportLocationCode']]['City'] }}
                                                                    </h3>
                                                                    <h6>{{ $data['airports'][$firstFlightInSegment['DepartureAirportLocationCode']]['AirportName'] }}
                                                                    </h6>
                                                                </div>
                                                            </div>

                                                            <div class="flight_search_middel">
                                                                <div class="flight_right_arrow">
                                                                    <img src="{{ asset('assets/img/icon/right_arrow.png') }}"
                                                                        alt="icon">
                                                                    <h6>
                                                                        {{ ($fdata['totalInStops'] == 0) ? 'Non-stop' : (($fdata['totalInStops'] == 1) ?  '1 Stop via '.implode(',',$fdata['layoversIn']['place']) : ($fdata['totalInStops']).' Stops via '.implode(',',$fdata['layoversIn']['place'])) }}
                                                                    </h6>
                                                                    <p>{{ convertToHoursMins($fdata['totalDurationIn']) }} </p>

                                                                </div>
                                                                <div class="flight_search_destination">
                                                                    <p>To</p>
                                                                    <span>{{ date('d M, Y', strtotime($lastFlightInSegment['ArrivalDateTime'])) }}</span>
                                                                    <h2>{{ date('H:i', strtotime($lastFlightInSegment['ArrivalDateTime'])) }}
                                                                    </h2>
                                                                    <h3>{{ $data['airports'][$lastFlightInSegment['ArrivalAirportLocationCode']]['City'] }}
                                                                    </h3>
                                                                    <h6>{{ $data['airports'][$lastFlightInSegment['ArrivalAirportLocationCode']]['AirportName'] }}
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="flight_multis_area_wrapper offset-lg-6">
                                                            <div class="flight_search_destination">
                                                                <div class="return-title" style="color:red;">
                                                                    <h5>No Return Flight Found. </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endisset
                                            @else
                                                @foreach($OriginDestinationOptionsOutbound as $multiOut)
                                                    @php    
                                                        $FlightSegment = $multiOut['FlightSegment']; 
                                                    @endphp
                                                    <div class="flight_multis_area_wrapper">
                                                        <div class="flight_search_left">
                                                            <div class="flight_logo">
                                                                <img src="{{ $data['flightData'][$FlightSegment['MarketingAirlineCode']]['AirLineLogo'] }}"
                                                                    alt="img">
                                                                <div class="flight-details">
                                                                    <h4>{{ $FlightSegment['MarketingAirlineName'] }}
                                                                    </h4>
                                                                    <h6>{{ $FlightSegment['MarketingAirlineCode'] }}
                                                                        {{ $FlightSegment['FlightNumber']}}</h6>
                                                                </div>
                                                            </div>
                                                            <div class="flight_search_destination">
                                                                <p>From</p>
                                                                <span>{{ date('d M, Y', strtotime($FlightSegment['DepartureDateTime'])) }}</span>
                                                                <h2>{{ date('H:i', strtotime($FlightSegment['DepartureDateTime'])) }}
                                                                </h2>
                                                                <h3>{{ $data['airports'][$FlightSegment['DepartureAirportLocationCode']]['City'] }}
                                                                </h3>
                                                                <h6>{{ $data['airports'][$FlightSegment['DepartureAirportLocationCode']]['AirportName'] }}
                                                                </h6>
                                                            </div>
                                                        </div>

                                                        <div class="flight_search_middel">
                                                            <div class="flight_right_arrow">
                                                                <img src="{{ asset('assets/img/icon/right_arrow.png') }}"
                                                                    alt="icon">
                                                                <p>{{ convertToHoursMins($FlightSegment['JourneyDuration']) }} </p>
                                                                
                                                            </div>
                                                            <div class="flight_search_destination">
                                                                <p>To</p>
                                                                <span>{{ date('d M, Y', strtotime($FlightSegment['ArrivalDateTime'])) }}</span>
                                                                <h2>{{ date('H:i', strtotime($FlightSegment['ArrivalDateTime'])) }}
                                                                </h2>
                                                                <h3>{{ $data['airports'][$FlightSegment['ArrivalAirportLocationCode']]['City'] }}
                                                                </h3>
                                                                <h6>{{ $data['airports'][$FlightSegment['ArrivalAirportLocationCode']]['AirportName'] }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="flight_search_right">
                                            <!-- <h5><del>AED 1260</del></h5> -->
                                            <h2>
                                            <!-- {{ $totalFares['Amount'] }}
                                            == -->
                                            {{ $totalFares['CurrencyCode'] }}
                                              
                                                <!-- <sup>*20% OFF</sup> -->
                                               
                                                {{ $totalFareMargin }}

                                                <!-- {{ $totalmargin }} -->
                                            </h2>
                                            <a href="{{ route('flight.booking',['search_type' => $data['search_type'], 'session_id' => $data['session_id'],'FareSourceCode' => $fdata['FareSourceCode']]) }}" target="_blank" class="btn btn_theme btn_sm">Book now</a>
                                            <!-- <p>*Discount applicable on some conditions</p> -->
                                            <h6 data-id="{{$loop->iteration}}" data-search_type="{{$data['search_type']}}" data-session_id="{{$data['session_id']}}" 
                                                data-fareCode="{{$fdata['FareSourceCode']}}" class="viewFlightDetails" >View Details<i class="fas fa-chevron-down"></i></h6>
                                        </div>
                                    </div>

                                    
                                    <div class="flight_policy_refund collapse" id="detialsView_{{$loop->iteration}}">
                                        
                                    </div>
                                </div>   
                                @endforeach
                                
                            @else
                                <div class="text-center fontSize24">
                                    <span>No Flights Found. </span>
                                </div>
                            @endif
                        </div>
                        <!-- <div class="load_more_flight">
                            <button class="btn btn_md"><i class="fas fa-spinner"></i> Load more..</button>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- @php echo 'Bottom'; @endphp -->
</section>
<!-- newsletter content -->
@include('web.includes.newsletter')
<!-- /newsletter content -->
@endsection

@push('header')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/search_flights.css') }}" />

    <style>

    </style>
@endpush
@push('footer')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/search_flights.js') }}"></script>
    <script type="text/javascript">

    </script>
@endpush
