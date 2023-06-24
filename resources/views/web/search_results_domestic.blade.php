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

                    @if($data['search_type'] == 'Return')
                        @if(Session::has("flight_search_return"))
                            @php
                                $stopFilter = explode(',', rtrim(Session::get("flight_search_return")['rstop_filter']));
                                $airlineFilter = explode(',', rtrim(Session::get("flight_search_return")['rairline_filter']));
                                $refundFilter = explode(',', rtrim(Session::get("flight_search_return")['rrefund_filter']));
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

                                <div class="form-check">
                                    <input class="form-check-input airlineFilter" {{ (in_array($airKey, $airlineFilter)) ? 'checked="checked"' : '' }} type="checkbox" value="{{$airKey}}" id="flexCheckDefaults1">
                                    <label class="form-check-label" for="flexCheckDefaults1">
                                        <span class="area_flex_one">
                                            <span>{{ $data['flightData'][$airKey]['AirLineName'] }}</span>
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
                    <div class="col-lg-6">
                        <div class="flight_search_result_wrapper">
                            @if($data['flightDetails'])
                                @foreach($data['flightDetails'] as $fdata)

                                <div class="flight_search_item_wrappper">
                                    <div class="flight_search_items">
                                        <div class="multi_city_flight_lists">
                                            @php
                                            $firstFlight = head($fdata['OriginDestinationOptionsOutbound']);
                                            $lastFlight = last($fdata['OriginDestinationOptionsOutbound']);
                                            @endphp

                                            <div class="flight_multis_area_wrapper">
                                                <div class="col-lg-12">
                                                    <div class="flight_logo" style="display:flex; padding: 10px;">
                                                        <img src="{{ $data['flightData'][$firstFlight['FlightSegment']['MarketingAirlineCode']]['AirLineLogo'] }}"
                                                            alt="img">
                                                        <div class="flight-details" style="    margin-left: 10px;">
                                                            <h4>{{ $firstFlight['FlightSegment']['MarketingAirlineName'] }}
                                                            </h4>
                                                            <h6>{{ $firstFlight['FlightSegment']['MarketingAirlineCode'] }}
                                                                {{ $firstFlight['FlightSegment']['FlightNumber']}}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12" style="display: flex; padding-top: 10px;">
                                                    <div class=" col-lg-5 flight_search_destination">
                                                        <p>From</p>
                                                        <h5>{{ date('d M, Y', strtotime($firstFlight['FlightSegment']['DepartureDateTime'])) }}</span>
                                                        <h3>{{ date('H:i', strtotime($firstFlight['FlightSegment']['DepartureDateTime'])) }}
                                                        </h3>
                                                        <h5>{{ $data['airports'][$firstFlight['FlightSegment']['DepartureAirportLocationCode']]['City'] }}
                                                        </h5>
                                                        <h6>{{ $data['airports'][$firstFlight['FlightSegment']['DepartureAirportLocationCode']]['AirportName'] }}
                                                        </h6>
                                                    </div>
                                                
                                                    <div class=" col-lg-2 flight_search_middel">
                                                        <div class="flight_right_arrow">
                                                            <img src="{{ asset('assets/img/icon/right_arrow.png') }}"
                                                                alt="icon">
                                                            <h6>
                                                                {{ ($fdata['totalOutStops'] == 0) ? 'Non-stop' : (($fdata['totalOutStops'] == 1) ?  '1 Stop via '.implode(',',$fdata['layovers']['place']) : ($fdata['totalOutStops']).' Stops via '.implode(',',$fdata['layovers']['place'])) }}
                                                            </h6>
                                                            <p>{{ convertToHoursMins($fdata['totalDuration']) }} </p>

                                                        </div>
                                                        
                                                    </div>
                                                    <div class=" col-lg-5 flight_search_destination">
                                                        <p>To</p>
                                                        <h5>{{ date('d M, Y', strtotime($lastFlight['FlightSegment']['ArrivalDateTime'])) }}</h5>
                                                        <h3>{{ date('H:i', strtotime($lastFlight['FlightSegment']['ArrivalDateTime'])) }}
                                                        </h3>
                                                        <h4>{{ $data['airports'][$lastFlight['FlightSegment']['ArrivalAirportLocationCode']]['City'] }}
                                                        </h4>
                                                        <h6>{{ $data['airports'][$lastFlight['FlightSegment']['ArrivalAirportLocationCode']]['AirportName'] }}
                                                        </h6>
                                                    </div>
                                                </div>
                                                
                                                
                                            </div>
                                        </div>

                                        <div class="flight_search_right" style="display:flex;">
                                            <!-- <h5><del>AED 1260</del></h5> -->
                                            <div class="col-lg-8">
                                                <h2>{{ $fdata['TotalFares']['TotalFare']['CurrencyCode'] }}
                                                {{ $fdata['TotalFares']['TotalFare']['Amount'] }}
                                                    <!-- <sup>*20% OFF</sup> -->
                                                </h2>
                                                
                                                <!-- <p>*Discount applicable on some conditions</p> -->
                                                <h6 data-bs-toggle="collapse" data-bs-target="#detialsView1_{{$loop->iteration}}"
                                                    aria-expanded="false" aria-controls="collapseExample">View Details<i
                                                        class="fas fa-chevron-down"></i></h6>
                                            </div>
                                            <div class="col-lg-4" style="text-align: center;margin: auto;">
                                                <input type="radio" name="bookOut" id="bookOut" class="col-form-control" style="width: 30px;height: 30px;">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="flight_policy_refund collapse" id="detialsView1_{{$loop->iteration}}">
                                        <div class="flight_show_down_wrapper" style="display:block;">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                                        data-bs-target="#flight_details1_{{$loop->iteration}}" type="button" role="tab" aria-controls="home"
                                                        aria-selected="true">Flight Details</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                                        data-bs-target="#fare_details1_{{$loop->iteration}}" type="button" role="tab"
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
                                                <div class="tab-pane fade show active" id="flight_details1_{{$loop->iteration}}" role="tabpanel" aria-labelledby="ex1-tab-1" >
                                                    @foreach($fdata['OriginDestinationOptionsOutbound'] as $outGoing)
                                                        <div class="flightDetails">
                                                            <p class="flightDetailsHead">{{ $data['airports'][$outGoing['FlightSegment']['DepartureAirportLocationCode']]['City']}} to {{ $data['airports'][$outGoing['FlightSegment']['ArrivalAirportLocationCode']]['City'] }} - {{ date('d M, Y', strtotime($outGoing['FlightSegment']['DepartureDateTime'])) }}</p>
                                                            <div class="flightDetailsInfo col-sm-12">
                                                                <div class="flightDetailsRow  col-sm-12">
                                                                    <p class="makeFlex hrtlCenter appendBottom20 gap-x-10">
                                                                        <span class="icon32 bgProperties" style="background-image: url('{{ $data['flightData'][$outGoing['FlightSegment']['MarketingAirlineCode']]['AirLineLogo'] }}');"></span><span>
                                                                            <span color="#000000"><b>{{ $outGoing['FlightSegment']['MarketingAirlineName'] }}</b></span>
                                                                            <span color="#6d7278">{{ $outGoing['FlightSegment']['MarketingAirlineCode'] }} | {{ $outGoing['FlightSegment']['FlightNumber']}}</span>
                                                                        </span>
                                                                    </p>
                                                                    <div class=" flightDtlInfo  col-sm-12">
                                                                        <div class="d-flex gap-x-10  col-sm-12">
                                                                            <div class="airlineDTInfoCol  col-sm-4">
                                                                                <p class="fontSize18 blackText blackFont">{{ date('H:i', strtotime($outGoing['FlightSegment']['DepartureDateTime'])) }}
                                                                                </p>
                                                                                <p  class="fontSize12 blackText boldFont appendBottom8">{{ date('d M, Y', strtotime($outGoing['FlightSegment']['DepartureDateTime'])) }}</p>
                                                                                <p class="fontSize12">{{ $data['airports'][$outGoing['FlightSegment']['DepartureAirportLocationCode']]['City'] }}, {{ $data['airports'][$outGoing['FlightSegment']['DepartureAirportLocationCode']]['Country'] }}</p>
                                                                            </div>
                                                                            <div class="airlineDtlDuration fontSize12  col-sm-4">{{ convertToHoursMins($outGoing['FlightSegment']['JourneyDuration']) }}
                                                                                <div class="relative fliStopsSep">
                                                                                    <p class="fliStopsSepLine"
                                                                                        style="border-top: 3px solid rgb(81, 226, 194);">
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="airlineDTInfoCol  col-sm-4">
                                                                                <p class="fontSize18 blackText blackFont">{{ date('H:i', strtotime($outGoing['FlightSegment']['ArrivalDateTime'])) }} </p>
                                                                                <p class="fontSize12 blackText boldFont appendBottom8">{{ date('d M, Y', strtotime($outGoing['FlightSegment']['ArrivalDateTime'])) }}</p>
                                                                                <p class="fontSize12">{{ $data['airports'][$outGoing['FlightSegment']['ArrivalAirportLocationCode']]['City'] }}, {{ $data['airports'][$outGoing['FlightSegment']['ArrivalAirportLocationCode']]['Country'] }}</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <p class="makeFlex  appendBottom3 fontSize14">
                                                                                <span class=" col-sm-3 baggageInfoText blackFont">BAGGAGE : </span>
                                                                                <span class=" col-sm-3 baggageInfoText blackFont text-center">CHECK IN</span>
                                                                                <span class=" col-sm-3 baggageInfoText blackFont text-center">CABIN</span>
                                                                            </p>

                                                                            @php  
                                                                                $bagKey = $outGoing['FlightSegment']['MarketingAirlineCode'].'_'.$outGoing['FlightSegment']['DepartureAirportLocationCode'].'_'.$outGoing['FlightSegment']['ArrivalAirportLocationCode'];
                                                                            @endphp
                                                                            @if(array_key_exists($bagKey, $fdata['flightBaggage']))
                                                                                @foreach($fdata['flightBaggage'][$bagKey] as $bagKey=>$bagData)
                                                                                    <p class="makeFlex  appendBottom3 fontSize14">
                                                                                        <span class="baggageInfoText darkText col-sm-3"> {{ ($bagKey=='ADT') ? "Adult" : (($bagKey=="CHD") ? "Child" : "Infant") }} </span>
                                                                                        <span class="baggageInfoText darkText col-sm-3 text-center">{{ ($bagData['baggage'] != '') ? $bagData['baggage'] : '-' }}</span>
                                                                                        <span class="baggageInfoText darkText col-sm-3 text-center">{{ ($bagData['cabin_baggage'] != '') ? $bagData['cabin_baggage'] : '-' }}</span>
                                                                                    </p>
                                                                                @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @if(array_key_exists($outGoing['FlightSegment']['ArrivalAirportLocationCode'], $fdata['layovers']))
                                                                <div class="flightLayoverOuter">
                                                                    <div class="flightLayover mmtConnectLayover">
                                                                        <div class="makeFlex fontSize14">
                                                                            <p> <span style="color: #5d8f3a;">Change of planes</span> <b>{{ convertToHoursMins($fdata['layovers'][$outGoing['FlightSegment']['ArrivalAirportLocationCode']]) }}</b> Layover in {{ $data['airports'][$outGoing['FlightSegment']['ArrivalAirportLocationCode']]['City'] }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    @isset($fdata['OriginDestinationOptionsInbound'])
                                                        <div class="return-title">
                                                            Return Trip 
                                                        </div>
                                                        @foreach($fdata['OriginDestinationOptionsInbound'] as $InComing)
                                                            <div class="flightDetails " @if($loop->iteration == 1 ) style="border-top:1px solid #dfdfdf !important;"  @endif>
                                                                <p class="flightDetailsHead">{{ $data['airports'][$InComing['FlightSegment']['DepartureAirportLocationCode']]['City']}} to {{ $data['airports'][$InComing['FlightSegment']['ArrivalAirportLocationCode']]['City'] }} - {{ date('d M, Y', strtotime($InComing['FlightSegment']['DepartureDateTime'])) }}</p>
                                                                <div class="flightDetailsInfo col-sm-12">
                                                                    <div class="flightDetailsRow  col-sm-12">
                                                                        <p class="makeFlex hrtlCenter appendBottom20 gap-x-10">
                                                                            <span class="icon32 bgProperties" style="background-image: url('{{ $data['flightData'][$InComing['FlightSegment']['MarketingAirlineCode']]['AirLineLogo'] }}');"></span><span>
                                                                                <span color="#000000"><b>{{ $InComing['FlightSegment']['MarketingAirlineName'] }}</b></span>
                                                                                <span color="#6d7278">{{ $InComing['FlightSegment']['MarketingAirlineCode'] }} | {{ $InComing['FlightSegment']['FlightNumber']}}</span>
                                                                            </span>
                                                                        </p>
                                                                        <div class=" flightDtlInfo  col-sm-12">
                                                                            <div class="d-flex gap-x-10  col-sm-12">
                                                                                <div class="airlineDTInfoCol  col-sm-4">
                                                                                    <p class="fontSize18 blackText blackFont">{{ date('H:i', strtotime($InComing['FlightSegment']['DepartureDateTime'])) }}
                                                                                    </p>
                                                                                    <p  class="fontSize12 blackText boldFont appendBottom8">{{ date('d M, Y', strtotime($InComing['FlightSegment']['DepartureDateTime'])) }}</p>
                                                                                    <p class="fontSize12">{{ $data['airports'][$InComing['FlightSegment']['DepartureAirportLocationCode']]['City'] }}, {{ $data['airports'][$InComing['FlightSegment']['DepartureAirportLocationCode']]['Country'] }}</p>
                                                                                </div>
                                                                                <div class="airlineDtlDuration fontSize12  col-sm-4">{{ convertToHoursMins($InComing['FlightSegment']['JourneyDuration']) }}
                                                                                    <div class="relative fliStopsSep">
                                                                                        <p class="fliStopsSepLine"
                                                                                            style="border-top: 3px solid rgb(81, 226, 194);">
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="airlineDTInfoCol  col-sm-4">
                                                                                    <p class="fontSize18 blackText blackFont">{{ date('H:i', strtotime($InComing['FlightSegment']['ArrivalDateTime'])) }} </p>
                                                                                    <p class="fontSize12 blackText boldFont appendBottom8">{{ date('d M, Y', strtotime($InComing['FlightSegment']['ArrivalDateTime'])) }}</p>
                                                                                    <p class="fontSize12">{{ $data['airports'][$InComing['FlightSegment']['ArrivalAirportLocationCode']]['City'] }}, {{ $data['airports'][$InComing['FlightSegment']['ArrivalAirportLocationCode']]['Country'] }}</p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-12">
                                                                                <p class="makeFlex  appendBottom3 fontSize14">
                                                                                    <span class=" col-sm-3 baggageInfoText blackFont">BAGGAGE : </span>
                                                                                    <span class=" col-sm-3 baggageInfoText blackFont text-center">CHECK IN</span>
                                                                                    <span class=" col-sm-3 baggageInfoText blackFont text-center">CABIN</span>
                                                                                </p>

                                                                                @php  
                                                                                    $bagKey = $InComing['FlightSegment']['MarketingAirlineCode'].'_'.$InComing['FlightSegment']['DepartureAirportLocationCode'].'_'.$InComing['FlightSegment']['ArrivalAirportLocationCode'];
                                                                                @endphp
                                                                                @if(array_key_exists($bagKey, $fdata['flightBaggageIn']))
                                                                                    @foreach($fdata['flightBaggageIn'][$bagKey] as $bagKey=>$bagData)
                                                                                        <p class="makeFlex  appendBottom3 fontSize14">
                                                                                            <span class="baggageInfoText darkText col-sm-3"> {{ ($bagKey=='ADT') ? "Adult" : (($bagKey=="CHD") ? "Child" : "Infant") }} </span>
                                                                                            <span class="baggageInfoText darkText col-sm-3 text-center">{{ ($bagData['baggage'] != '') ? $bagData['baggage'] : '-' }}</span>
                                                                                            <span class="baggageInfoText darkText col-sm-3 text-center">{{ ($bagData['cabin_baggage'] != '') ? $bagData['cabin_baggage'] : '-' }}</span>
                                                                                        </p>
                                                                                    @endforeach
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @if(array_key_exists($InComing['FlightSegment']['ArrivalAirportLocationCode'], $fdata['layoversIn']))
                                                                    <div class="flightLayoverOuter">
                                                                        <div class="flightLayover mmtConnectLayover">
                                                                            <div class="makeFlex fontSize14">
                                                                                <p> <span style="color: #5d8f3a;">Change of planes</span> <b>{{ convertToHoursMins($fdata['layoversIn'][$InComing['FlightSegment']['ArrivalAirportLocationCode']]) }}</b> Layover in {{ $data['airports'][$InComing['FlightSegment']['ArrivalAirportLocationCode']]['City'] }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endisset
                                                </div>
                                                <div class="tab-pane" id="fare_details1_{{$loop->iteration}}" role="tabpanel" aria-labelledby="profile-tab">
                                                    <div id="flightDetailsTab-29-tabpane-2" aria-labelledby="flightDetailsTab-29-tab-2" role="tabpanel" aria-hidden="false" class="fade tab-pane active show">
                                                        <div class="flightDetails">
                                                            <p class="flightDetailsHead">Fare Breakup</p>
                                                            <div class="flightDetailsInfo">
                                                                <p class="appendBottom8 fontSize12">
                                                                    <span class="fareBreakupText"  style="font-size: 14px; color: rgb(0, 0, 0);">TOTAL</span>
                                                                    <span style="font-size: 14px; color: rgb(0, 0, 0);">{{$fdata['TotalFares']['TotalFare']['CurrencyCode']}} {{$fdata['TotalFares']['TotalFare']['Amount']}}</span>
                                                                </p>
                                                                <p class="appendBottom8 fontSize12">
                                                                    <span class="fareBreakupText" style="color: rgb(135, 135, 135);"> Base Fare </span>
                                                                    <span style="color: rgb(135, 135, 135);">{{$fdata['TotalFares']['BaseFare']['CurrencyCode']}} {{$fdata['TotalFares']['BaseFare']['Amount']}}</span>
                                                                </p>
                                                                <p class="appendBottom8 fontSize12">
                                                                    <span class="fareBreakupText" style="color: rgb(135, 135, 135);">Tax</span>
                                                                    <span style="color: rgb(135, 135, 135);">{{$fdata['TotalFares']['TotalTax']['CurrencyCode']}} {{$fdata['TotalFares']['TotalTax']['Amount']}}</span>
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
                    </div>

                    <div class="col-lg-6">
                        <div class="flight_search_result_wrapper">
                            @if($data['flightDetailsInbound'])
                                @foreach($data['flightDetailsInbound'] as $fdataIn)

                                <div class="flight_search_item_wrappper">
                                    <div class="flight_search_items">
                                        <div class="multi_city_flight_lists">
                                            @php
                                            $firstFlight = head($fdataIn['OriginDestinationOptionsInbound']);
                                            $lastFlight = last($fdataIn['OriginDestinationOptionsInbound']);
                                            @endphp

                                            <div class="flight_multis_area_wrapper">
                                                <div class="col-lg-12">
                                                    <div class="flight_logo" style="display:flex; padding: 10px;">
                                                        <img src="{{ $data['flightData'][$firstFlight['FlightSegment']['MarketingAirlineCode']]['AirLineLogo'] }}"
                                                            alt="img">
                                                        <div class="flight-details" style="    margin-left: 10px;">
                                                            <h4>{{ $firstFlight['FlightSegment']['MarketingAirlineName'] }}
                                                            </h4>
                                                            <h6>{{ $firstFlight['FlightSegment']['MarketingAirlineCode'] }}
                                                                {{ $firstFlight['FlightSegment']['FlightNumber']}}</h6>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12" style="display: flex;padding-top: 10px;">
                                                    <div class=" col-lg-5 flight_search_destination">
                                                        <p>From</p>
                                                        <h5>{{ date('d M, Y', strtotime($firstFlight['FlightSegment']['DepartureDateTime'])) }}</span>
                                                        <h3>{{ date('H:i', strtotime($firstFlight['FlightSegment']['DepartureDateTime'])) }}
                                                        </h3>
                                                        <h5>{{ $data['airports'][$firstFlight['FlightSegment']['DepartureAirportLocationCode']]['City'] }}
                                                        </h5>
                                                        <h6>{{ $data['airports'][$firstFlight['FlightSegment']['DepartureAirportLocationCode']]['AirportName'] }}
                                                        </h6>
                                                    </div>
                                                
                                                    <div class=" col-lg-2 flight_search_middel">
                                                        <div class="flight_right_arrow">
                                                            <img src="{{ asset('assets/img/icon/right_arrow.png') }}" alt="icon">
                                                            <h6>
                                                            {{ ($fdataIn['totalInStops'] == 0) ? 'Non-stop' : (($fdataIn['totalInStops'] == 1) ?  '1 Stop via '.implode(',',$fdataIn['layoversIn']['place']) : ($fdataIn['totalInStops']).' Stops via '.implode(',',$fdataIn['layoversIn']['place'])) }}
                                                            </h6>
                                                            <p>{{ convertToHoursMins($fdataIn['totalDurationIn']) }} </p>
                                                        </div>
                                                    </div>
                                                    <div class=" col-lg-5 flight_search_destination">
                                                        <p>To</p>
                                                        <h5>{{ date('d M, Y', strtotime($lastFlight['FlightSegment']['ArrivalDateTime'])) }}</h5>
                                                        <h3>{{ date('H:i', strtotime($lastFlight['FlightSegment']['ArrivalDateTime'])) }}
                                                        </h3>
                                                        <h4>{{ $data['airports'][$lastFlight['FlightSegment']['ArrivalAirportLocationCode']]['City'] }}
                                                        </h4>
                                                        <h6>{{ $data['airports'][$lastFlight['FlightSegment']['ArrivalAirportLocationCode']]['AirportName'] }}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flight_search_right" style="display:flex;">
                                            <!-- <h5><del>AED 1260</del></h5> -->
                                            <div class="col-lg-8">
                                                <h2>{{ $fdataIn['TotalFares']['TotalFare']['CurrencyCode'] }}
                                                    {{ $fdataIn['TotalFares']['TotalFare']['Amount'] }}
                                                    <!-- <sup>*20% OFF</sup> -->
                                                </h2>
                                                
                                                <!-- <p>*Discount applicable on some conditions</p> -->
                                                <h6 data-bs-toggle="collapse" data-bs-target="#detialsView_{{$loop->iteration}}"
                                                    aria-expanded="false" aria-controls="collapseExample">View Details<i
                                                        class="fas fa-chevron-down"></i></h6>
                                            </div>
                                            <div class="col-lg-4" style="text-align: center;margin: auto;">
                                                <input type="radio" name="bookIn" id="bookIn" class="col-form-control" style="width: 30px;height: 30px;">
                                            </div>
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
                                                    @foreach($fdataIn['OriginDestinationOptionsInbound'] as $InComing)
                                                        <div class="flightDetails">
                                                            <p class="flightDetailsHead">{{ $data['airports'][$InComing['FlightSegment']['DepartureAirportLocationCode']]['City']}} to {{ $data['airports'][$InComing['FlightSegment']['ArrivalAirportLocationCode']]['City'] }} - {{ date('d M, Y', strtotime($InComing['FlightSegment']['DepartureDateTime'])) }}</p>
                                                            <div class="flightDetailsInfo col-sm-12">
                                                                <div class="flightDetailsRow  col-sm-12">
                                                                    <p class="makeFlex hrtlCenter appendBottom20 gap-x-10">
                                                                        <span class="icon32 bgProperties" style="background-image: url('{{ $data['flightData'][$InComing['FlightSegment']['MarketingAirlineCode']]['AirLineLogo'] }}');"></span><span>
                                                                            <span color="#000000"><b>{{ $InComing['FlightSegment']['MarketingAirlineName'] }}</b></span>
                                                                            <span color="#6d7278">{{ $InComing['FlightSegment']['MarketingAirlineCode'] }} | {{ $InComing['FlightSegment']['FlightNumber']}}</span>
                                                                        </span>
                                                                    </p>
                                                                    <div class="flightDtlInfo  col-sm-12">
                                                                        <div class="d-flex gap-x-10  col-sm-12">
                                                                            <div class="airlineDTInfoCol  col-sm-4">
                                                                                <p class="fontSize18 blackText blackFont">{{ date('H:i', strtotime($InComing['FlightSegment']['DepartureDateTime'])) }}
                                                                                </p>
                                                                                <p  class="fontSize12 blackText boldFont appendBottom8">{{ date('d M, Y', strtotime($InComing['FlightSegment']['DepartureDateTime'])) }}</p>
                                                                                <p class="fontSize12">{{ $data['airports'][$InComing['FlightSegment']['DepartureAirportLocationCode']]['City'] }}, {{ $data['airports'][$InComing['FlightSegment']['DepartureAirportLocationCode']]['Country'] }}</p>
                                                                            </div>
                                                                            <div class="airlineDtlDuration fontSize12  col-sm-4">{{ convertToHoursMins($InComing['FlightSegment']['JourneyDuration']) }}
                                                                                <div class="relative fliStopsSep">
                                                                                    <p class="fliStopsSepLine"
                                                                                        style="border-top: 3px solid rgb(81, 226, 194);">
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="airlineDTInfoCol  col-sm-4">
                                                                                <p class="fontSize18 blackText blackFont">{{ date('H:i', strtotime($InComing['FlightSegment']['ArrivalDateTime'])) }} </p>
                                                                                <p class="fontSize12 blackText boldFont appendBottom8">{{ date('d M, Y', strtotime($InComing['FlightSegment']['ArrivalDateTime'])) }}</p>
                                                                                <p class="fontSize12">{{ $data['airports'][$InComing['FlightSegment']['ArrivalAirportLocationCode']]['City'] }}, {{ $data['airports'][$InComing['FlightSegment']['ArrivalAirportLocationCode']]['Country'] }}</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <p class="makeFlex  appendBottom3 fontSize14">
                                                                                <span class=" col-sm-3 baggageInfoText blackFont">BAGGAGE : </span>
                                                                                <span class=" col-sm-3 baggageInfoText blackFont text-center">CHECK IN</span>
                                                                                <span class=" col-sm-3 baggageInfoText blackFont text-center">CABIN</span>
                                                                            </p>

                                                                            @php  
                                                                                $bagKey = $InComing['FlightSegment']['MarketingAirlineCode'].'_'.$InComing['FlightSegment']['DepartureAirportLocationCode'].'_'.$InComing['FlightSegment']['ArrivalAirportLocationCode'];
                                                                            @endphp
                                                                            @if(array_key_exists($bagKey, $fdataIn['flightBaggageIn']))
                                                                                @foreach($fdataIn['flightBaggageIn'][$bagKey] as $bagKey=>$bagData)
                                                                                    <p class="makeFlex  appendBottom3 fontSize14">
                                                                                        <span class="baggageInfoText darkText col-sm-3"> {{ ($bagKey=='ADT') ? "Adult" : (($bagKey=="CHD") ? "Child" : "Infant") }} </span>
                                                                                        <span class="baggageInfoText darkText col-sm-3 text-center">{{ ($bagData['baggage'] != '') ? $bagData['baggage'] : '-' }}</span>
                                                                                        <span class="baggageInfoText darkText col-sm-3 text-center">{{ ($bagData['cabin_baggage'] != '') ? $bagData['cabin_baggage'] : '-' }}</span>
                                                                                    </p>
                                                                                @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @if(array_key_exists($InComing['FlightSegment']['ArrivalAirportLocationCode'], $fdataIn['layoversIn']))
                                                                <div class="flightLayoverOuter">
                                                                    <div class="flightLayover mmtConnectLayover">
                                                                        <div class="makeFlex fontSize14">
                                                                            <p> <span style="color: #5d8f3a;">Change of planes</span> <b>{{ convertToHoursMins($fdataIn['layoversIn'][$InComing['FlightSegment']['ArrivalAirportLocationCode']]) }}</b> Layover in {{ $data['airports'][$InComing['FlightSegment']['ArrivalAirportLocationCode']]['City'] }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                   
                                                </div>
                                                <div class="tab-pane" id="fare_details_{{$loop->iteration}}" role="tabpanel" aria-labelledby="profile-tab">
                                                    <div id="flightDetailsTab-29-tabpane-2" aria-labelledby="flightDetailsTab-29-tab-2" role="tabpanel" aria-hidden="false" class="fade tab-pane active show">
                                                        <div class="flightDetails">
                                                            <p class="flightDetailsHead">Fare Breakup</p>
                                                            <div class="flightDetailsInfo">
                                                                <p class="appendBottom8 fontSize12">
                                                                    <span class="fareBreakupText"  style="font-size: 14px; color: rgb(0, 0, 0);">TOTAL</span>
                                                                    <span style="font-size: 14px; color: rgb(0, 0, 0);">{{$fdataIn['TotalFares']['TotalFare']['CurrencyCode']}} {{$fdataIn['TotalFares']['TotalFare']['Amount']}}</span>
                                                                </p>
                                                                <p class="appendBottom8 fontSize12">
                                                                    <span class="fareBreakupText" style="color: rgb(135, 135, 135);"> Base Fare </span>
                                                                    <span style="color: rgb(135, 135, 135);">{{$fdataIn['TotalFares']['BaseFare']['CurrencyCode']}} {{$fdataIn['TotalFares']['BaseFare']['Amount']}}</span>
                                                                </p>
                                                                <p class="appendBottom8 fontSize12">
                                                                    <span class="fareBreakupText" style="color: rgb(135, 135, 135);">Tax</span>
                                                                    <span style="color: rgb(135, 135, 135);">{{$fdataIn['TotalFares']['TotalTax']['CurrencyCode']}} {{$fdataIn['TotalFares']['TotalTax']['Amount']}}</span>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- newsletter content -->
@include('web.includes.newsletter')
<!-- /newsletter content -->
@endsection
@push('header')
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/search_flights.css') }}" />

<style>
.flight_search_items{
    display: block !important;
}
.flight_search_destination {
    padding-left: 20px;
}
.flight_search_middel{
    padding-left:0 !important;
}
.flight_multis_area_wrapper{
    display:block !important;
}
</style>
@endpush
@push('footer')
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/search_flights.js') }}"></script>
<script type="text/javascript">
let one_way_session = '{!! json_encode(Session::get("flight_search_oneway")) !!}';
one_way_session = JSON.parse(one_way_session);

let return_session = '{!! json_encode(Session::get("flight_search_return")) !!}';
return_session = JSON.parse(return_session);

let multi_session = '{!! json_encode(Session::get("flight_search_multi")) !!}';
multi_session = JSON.parse(multi_session);


</script>
@endpush