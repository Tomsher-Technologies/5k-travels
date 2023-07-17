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
                        <div class="flight_search_result_wrapper">
                           
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
                                        </div>
                                        <div class="flight_search_right">
                                            <!-- <h5><del>AED 1260</del></h5> -->
                                            <h2>
                                            {{ $totalFares['Amount'] }}
                                            ==
                                            {{ $totalFares['CurrencyCode'] }}
                                              
                                                <!-- <sup>*20% OFF</sup> -->
                                               
                                                {{ $totalFareMargin }}

                                                <!-- {{ $fdata['FareType'] }} -->
                                            </h2>
                                            <a href="{{ route('flight.booking',['search_type' => $data['search_type'], 'session_id' => $data['session_id'],'FareSourceCode' => $fdata['FareSourceCode']]) }}" target="_blank" class="btn btn_theme btn_sm">Book now</a>
                                            <!-- <p>*Discount applicable on some conditions</p> -->
                                            <h6 data-bs-toggle="collapse" data-bs-target="#detialsView_{{$loop->iteration}}"
                                                aria-expanded="false" aria-controls="collapseExample">View Details<i
                                                    class="fas fa-chevron-down"></i></h6>
                                        </div>
                                    </div>

                                    
                                    <div class="flight_policy_refund collapse" id="detialsView_{{$loop->iteration}}">
                                        <div class="flight_show_down_wrapper" style="display:block;">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                                        data-bs-target="#flight_details_{{$loop->iteration}}" type="button" role="tab" aria-controls="home"
                                                        aria-selected="true">Flight Details</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                                        data-bs-target="#fare_details_{{$loop->iteration}}" type="button" role="tab"
                                                        aria-controls="profile" aria-selected="false">Fare Summary</button>
                                                </li>
                                                <!-- <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="messages-tab" data-bs-toggle="tab"
                                                        data-bs-target="#messages" type="button" role="tab"
                                                        aria-controls="messages" aria-selected="false">Messages</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="settings-tab" data-bs-toggle="tab"
                                                        data-bs-target="#settings" type="button" role="tab"
                                                        aria-controls="settings" aria-selected="false">Settings</button>
                                                </li> -->
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content" id="ex1-content">
                                                <div class="tab-pane fade show active" id="flight_details_{{$loop->iteration}}" role="tabpanel" aria-labelledby="ex1-tab-1" >
                                                    @isset($fdata['OriginDestinationOptionsOutbound'])
                                                        @php  $OriginDestinationOptionsOutboundDet   = $fdata['OriginDestinationOptionsOutbound'];  @endphp
                                                        @foreach($OriginDestinationOptionsOutboundDet as $outGoing)

                                                            @php   
                                                                $outGoingSegment = $outGoing['FlightSegment'];
                                                            @endphp
                                                            <div class="flightDetails">
                                                                <p class="flightDetailsHead">{{ $data['airports'][$outGoingSegment['DepartureAirportLocationCode']]['City']}} to {{ $data['airports'][$outGoingSegment['ArrivalAirportLocationCode']]['City'] }} - {{ date('d M, Y', strtotime($outGoingSegment['DepartureDateTime'])) }}</p>
                                                                <div class="flightDetailsInfo col-sm-12">
                                                                    <div class="flightDetailsRow  col-sm-12">
                                                                        <p class="makeFlex hrtlCenter appendBottom20 gap-x-10">
                                                                            <span class="icon32 bgProperties" style="background-image: url('{{ $data['flightData'][$outGoingSegment['MarketingAirlineCode']]['AirLineLogo'] }}');"></span><span>
                                                                                <span color="#000000"><b>{{ $outGoingSegment['MarketingAirlineName'] }}</b></span>
                                                                                <span color="#6d7278">{{ $outGoingSegment['MarketingAirlineCode'] }} | {{ $outGoingSegment['FlightNumber']}}</span>
                                                                            </span>
                                                                        </p>
                                                                        <div class="makeFlex flightDtlInfo  col-sm-12">
                                                                            <div class="airlineInfo gap-x-10  col-sm-6">
                                                                                <div class="airlineDTInfoCol  col-sm-4">
                                                                                    <p class="fontSize18 blackText blackFont">{{ date('H:i', strtotime($outGoingSegment['DepartureDateTime'])) }}
                                                                                    </p>
                                                                                    <p  class="fontSize12 blackText boldFont appendBottom8">{{ date('d M, Y', strtotime($outGoingSegment['DepartureDateTime'])) }}</p>
                                                                                    <p class="fontSize12">{{ $data['airports'][$outGoingSegment['DepartureAirportLocationCode']]['City'] }}, {{ $data['airports'][$outGoingSegment['DepartureAirportLocationCode']]['Country'] }}</p>
                                                                                </div>
                                                                                <div class="airlineDtlDuration fontSize12  col-sm-4">{{ convertToHoursMins($outGoingSegment['JourneyDuration']) }}
                                                                                    <div class="relative fliStopsSep">
                                                                                        <p class="fliStopsSepLine"
                                                                                            style="border-top: 3px solid rgb(81, 226, 194);">
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="airlineDTInfoCol  col-sm-4">
                                                                                    <p class="fontSize18 blackText blackFont">{{ date('H:i', strtotime($outGoingSegment['ArrivalDateTime'])) }} </p>
                                                                                    <p class="fontSize12 blackText boldFont appendBottom8">{{ date('d M, Y', strtotime($outGoingSegment['ArrivalDateTime'])) }}</p>
                                                                                    <p class="fontSize12">{{ $data['airports'][$outGoingSegment['ArrivalAirportLocationCode']]['City'] }}, {{ $data['airports'][$outGoingSegment['ArrivalAirportLocationCode']]['Country'] }}</p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="baggageInfo  col-sm-6">
                                                                                <p class="makeFlex spaceBetween appendBottom3 fontSize14">
                                                                                    <span class=" col-sm-4 baggageInfoText blackFont">BAGGAGE : </span>
                                                                                    <span class=" col-sm-4 baggageInfoText blackFont text-center">CHECK IN</span>
                                                                                    <span class=" col-sm-4 baggageInfoText blackFont text-center">CABIN</span>
                                                                                </p>

                                                                                @php  
                                                                                    $bagKey = $outGoingSegment['MarketingAirlineCode'].'_'.$outGoingSegment['DepartureAirportLocationCode'].'_'.$outGoingSegment['ArrivalAirportLocationCode'];
                                                                                @endphp
                                                                                @if(array_key_exists($bagKey, $fdata['flightBaggage']))
                                                                                    @foreach($fdata['flightBaggage'][$bagKey] as $bagKey=>$bagData)
                                                                                        <p class="makeFlex spaceBetween appendBottom3 fontSize14">
                                                                                            <span class="baggageInfoText darkText col-sm-4"> {{ ($bagKey=='ADT') ? "Adult" : (($bagKey=="CHD") ? "Child" : "Infant") }} </span>
                                                                                            <span class="baggageInfoText darkText col-sm-4 text-center">{{ ($bagData['baggage'] != '') ? $bagData['baggage'] : '-' }}</span>
                                                                                            <span class="baggageInfoText darkText col-sm-4 text-center">{{ ($bagData['cabin_baggage'] != '') ? $bagData['cabin_baggage'] : '-' }}</span>
                                                                                        </p>
                                                                                    @endforeach
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @if(array_key_exists($outGoingSegment['ArrivalAirportLocationCode'], $fdata['layovers']))
                                                                    <div class="flightLayoverOuter">
                                                                        <div class="flightLayover mmtConnectLayover">
                                                                            <div class="makeFlex fontSize14">
                                                                                <p> <span style="color: #5d8f3a;">Change of planes</span> <b>{{ convertToHoursMins($fdata['layovers'][$outGoingSegment['ArrivalAirportLocationCode']]) }}</b> Layover in {{ $data['airports'][$outGoingSegment['ArrivalAirportLocationCode']]['City'] }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endisset

                                                    @isset($fdata['OriginDestinationOptionsInbound'])
                                                        @php  $OriginDestinationOptionsInboundDet   = $fdata['OriginDestinationOptionsInbound'];  @endphp
                                                        @if(!empty($OriginDestinationOptionsInboundDet))
                                                            <div class="return-title">
                                                                Return Trip 
                                                            </div>
                                                            @foreach($OriginDestinationOptionsInboundDet as $InComing)
                                                                @php   
                                                                    $inComingSegment = $InComing['FlightSegment'];
                                                                @endphp
                                                                <div class="flightDetails " @if($loop->iteration == 1 ) style="border-top:1px solid #dfdfdf !important;"  @endif>
                                                                    <p class="flightDetailsHead">{{ $data['airports'][$inComingSegment['DepartureAirportLocationCode']]['City']}} to {{ $data['airports'][$inComingSegment['ArrivalAirportLocationCode']]['City'] }} - {{ date('d M, Y', strtotime($inComingSegment['DepartureDateTime'])) }}</p>
                                                                    <div class="flightDetailsInfo col-sm-12">
                                                                        <div class="flightDetailsRow  col-sm-12">
                                                                            <p class="makeFlex hrtlCenter appendBottom20 gap-x-10">
                                                                                <span class="icon32 bgProperties" style="background-image: url('{{ $data['flightData'][$inComingSegment['MarketingAirlineCode']]['AirLineLogo'] }}');"></span><span>
                                                                                    <span color="#000000"><b>{{ $inComingSegment['MarketingAirlineName'] }}</b></span>
                                                                                    <span color="#6d7278">{{ $inComingSegment['MarketingAirlineCode'] }} | {{ $inComingSegment['FlightNumber']}}</span>
                                                                                </span>
                                                                            </p>
                                                                            <div class="makeFlex flightDtlInfo  col-sm-12">
                                                                                <div class="airlineInfo gap-x-10  col-sm-6">
                                                                                    <div class="airlineDTInfoCol  col-sm-4">
                                                                                        <p class="fontSize18 blackText blackFont">{{ date('H:i', strtotime($inComingSegment['DepartureDateTime'])) }}
                                                                                        </p>
                                                                                        <p  class="fontSize12 blackText boldFont appendBottom8">{{ date('d M, Y', strtotime($inComingSegment['DepartureDateTime'])) }}</p>
                                                                                        <p class="fontSize12">{{ $data['airports'][$inComingSegment['DepartureAirportLocationCode']]['City'] }}, {{ $data['airports'][$inComingSegment['DepartureAirportLocationCode']]['Country'] }}</p>
                                                                                    </div>
                                                                                    <div class="airlineDtlDuration fontSize12  col-sm-4">{{ convertToHoursMins($inComingSegment['JourneyDuration']) }}
                                                                                        <div class="relative fliStopsSep">
                                                                                            <p class="fliStopsSepLine"
                                                                                                style="border-top: 3px solid rgb(81, 226, 194);">
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="airlineDTInfoCol  col-sm-4">
                                                                                        <p class="fontSize18 blackText blackFont">{{ date('H:i', strtotime($inComingSegment['ArrivalDateTime'])) }} </p>
                                                                                        <p class="fontSize12 blackText boldFont appendBottom8">{{ date('d M, Y', strtotime($inComingSegment['ArrivalDateTime'])) }}</p>
                                                                                        <p class="fontSize12">{{ $data['airports'][$inComingSegment['ArrivalAirportLocationCode']]['City'] }}, {{ $data['airports'][$inComingSegment['ArrivalAirportLocationCode']]['Country'] }}</p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="baggageInfo  col-sm-6">
                                                                                    <p class="makeFlex spaceBetween appendBottom3 fontSize14">
                                                                                        <span class=" col-sm-4 baggageInfoText blackFont">BAGGAGE : </span>
                                                                                        <span class=" col-sm-4 baggageInfoText blackFont text-center">CHECK IN</span>
                                                                                        <span class=" col-sm-4 baggageInfoText blackFont text-center">CABIN</span>
                                                                                    </p>

                                                                                    @php  
                                                                                        $bagKey = $inComingSegment['MarketingAirlineCode'].'_'.$inComingSegment['DepartureAirportLocationCode'].'_'.$inComingSegment['ArrivalAirportLocationCode'];
                                                                                        $flightBaggageIn = $fdata['flightBaggageIn'];
                                                                                    
                                                                                    @endphp
                                                                                    @if(array_key_exists($bagKey, $flightBaggageIn))
                                                                                        @foreach($flightBaggageIn[$bagKey] as $bagKey=>$bagData)
                                                                                            <p class="makeFlex spaceBetween appendBottom3 fontSize14">
                                                                                                <span class="baggageInfoText darkText col-sm-4"> {{ ($bagKey=='ADT') ? "Adult" : (($bagKey=="CHD") ? "Child" : "Infant") }} </span>
                                                                                                <span class="baggageInfoText darkText col-sm-4 text-center">{{ ($bagData['baggage'] != '') ? $bagData['baggage'] : '-' }}</span>
                                                                                                <span class="baggageInfoText darkText col-sm-4 text-center">{{ ($bagData['cabin_baggage'] != '') ? $bagData['cabin_baggage'] : '-' }}</span>
                                                                                            </p>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @if(array_key_exists($inComingSegment['ArrivalAirportLocationCode'], $fdata['layoversIn']))
                                                                        <div class="flightLayoverOuter">
                                                                            <div class="flightLayover mmtConnectLayover">
                                                                                <div class="makeFlex fontSize14">
                                                                                    <p> <span style="color: #5d8f3a;">Change of planes</span> <b>{{ convertToHoursMins($fdata['layoversIn'][$inComingSegment['ArrivalAirportLocationCode']]) }}</b> Layover in {{ $data['airports'][$inComingSegment['ArrivalAirportLocationCode']]['City'] }}</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <div class="return-title" style="color:red;">
                                                                <h5>No Return Flight Found. </h5>
                                                            </div>
                                                        @endif
                                                    @endisset
                                                 
                                                </div>
                                                <div class="tab-pane" id="fare_details_{{$loop->iteration}}" role="tabpanel" aria-labelledby="profile-tab">
                                                    <div id="flightDetailsTab-29-tabpane-2" aria-labelledby="flightDetailsTab-29-tab-2" role="tabpanel" aria-hidden="false" class="fade tab-pane active show">
                                                        <div class="flightDetails">
                                                            <p class="flightDetailsHead">Fare Breakup</p>
                                                            <!-- $totalBaseMargin = (($fareBase['Amount']/100) * $totalmargin) + $fareBase['Amount']; -->
                                                            @php   
                                                                $fareTotal = $fdata['TotalFares'];
                                                                $fareBase = $fareTotal['BaseFare'];
                                                                $fareTax = $fareTotal['TotalTax'];
                                                                
                                                                $totalBaseMargin = (($fareBase['Amount']/100) * $totalmargin) + $fareBase['Amount'];
                                                                $totalBaseMargin = number_format(floor($totalBaseMargin*100)/100, 2, '.', '');

                                                                $totalTaxMargin = (($fareTax['Amount']/100) * $totalmargin) + $fareTax['Amount'];
                                                                $totalTaxMargin = number_format(floor($totalTaxMargin*100)/100, 2, '.', '');
                                                            @endphp
                                                            <div class="flightDetailsInfo">
                                                                <p class="appendBottom8 fontSize12">
                                                                    <span class="fareBreakupText"  style="font-size: 14px; color: rgb(0, 0, 0);">TOTAL</span>
                                                                    <span style="font-size: 14px; color: rgb(0, 0, 0);">{{$totalFares['CurrencyCode']}} {{$totalFareMargin}}</span>
                                                                </p>
                                                                <p class="appendBottom8 fontSize12">
                                                                    <span class="fareBreakupText" style="color: rgb(135, 135, 135);"> Base Fare </span>
                                                                    <span style="color: rgb(135, 135, 135);">{{$fareBase['CurrencyCode']}} {{ $totalBaseMargin }}</span>
                                                                </p>
                                                                <p class="appendBottom8 fontSize12">
                                                                    <span class="fareBreakupText" style="color: rgb(135, 135, 135);">Tax</span>
                                                                    <span style="color: rgb(135, 135, 135);">{{$fareTax['CurrencyCode']}} {{$totalTaxMargin}}</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="tab-pane" id="messages" role="tabpanel"
                                                    aria-labelledby="messages-tab">...</div>
                                                <div class="tab-pane" id="settings" role="tabpanel"
                                                    aria-labelledby="settings-tab">...</div> -->
                                            </div>

                                        </div>
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
    let one_way_session = '{!! json_encode(Session::get("flight_search_oneway"))  !!}';
    one_way_session = JSON.parse(one_way_session);

    let return_session = '{!!  json_encode(Session::get("flight_search_return")) !!}';
    return_session = JSON.parse(return_session);

    let multi_session = '{!! json_encode(Session::get("flight_search_multi")) !!}';
    multi_session = JSON.parse(multi_session);


    </script>
@endpush
