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

                    @if($data['search_type'] == 'Return')
                    @if(Session::has("flight_search_return"))
                    @php
                    $stopFilter = explode(',', rtrim(Session::get("flight_search_return")['rstop_filter']));
                    $airlineFilter = explode(',', rtrim(Session::get("flight_search_return")['rairline_filter']));
                    $refundFilter = explode(',', rtrim(Session::get("flight_search_return")['rrefund_filter']));
                    @endphp
                    @endif
                    @endif

                    <input type="hidden" name="search_typeResult" id="search_typeResult"
                        value="{{$data['search_type']}}">
                    <div class="left_side_search_boxed">
                        <div class="left_side_search_heading">
                            <h5>Number of stops</h5>
                        </div>
                        <div class="tour_search_type">
                            <div class="form-check">
                                <input class="form-check-input stopFilter"
                                    {{ (in_array("1", $stopFilter)) ? 'checked="checked"' : '' }} type="checkbox"
                                    value="1" id="flexCheckDefaultf1">
                                <label class="form-check-label" for="flexCheckDefaultf1">
                                    <span class="area_flex_one">
                                        <span>1 stop</span>
                                        <span>{{ $data['one_stop'] }}</span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input stopFilter" type="checkbox"
                                    {{ (in_array("2", $stopFilter)) ? 'checked="checked"' : '' }} value="2"
                                    id="flexCheckDefaultf2">
                                <label class="form-check-label" for="flexCheckDefaultf2">
                                    <span class="area_flex_one">
                                        <span>2 stop</span>
                                        <span>{{ $data['two_stop'] }}</span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input stopFilter" type="checkbox"
                                    {{ (in_array("3", $stopFilter)) ? 'checked="checked"' : '' }} value="3"
                                    id="flexCheckDefaultf3">
                                <label class="form-check-label" for="flexCheckDefaultf3">
                                    <span class="area_flex_one">
                                        <span>3 stop</span>
                                        <span>{{ $data['three_stop'] }}</span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input stopFilter" type="checkbox"
                                    {{ (in_array("0", $stopFilter)) ? 'checked="checked"' : '' }} value="0"
                                    id="flexCheckDefaultf4">
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
                            @php  $flightKey = isset($data['flightData'][$airKey]) ? $data['flightData'][$airKey] : [];  @endphp
                            <div class="form-check">
                                <input class="form-check-input airlineFilter"
                                    {{ (in_array($airKey, $airlineFilter)) ? 'checked="checked"' : '' }} type="checkbox"
                                    value="{{$airKey}}" id="flexCheckDefaults1">
                                <label class="form-check-label" for="flexCheckDefaults1">
                                    <span class="area_flex_one">
                                        <span>{{ isset($flightKey['AirLineName']) ? $flightKey['AirLineName'] : '' }}</span>
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
                                <input class="form-check-input refundFilter" type="checkbox"
                                    {{ (in_array('yes', $refundFilter)) ? 'checked="checked"' : '' }} value="yes"
                                    name="refund_yes" id="refundYes">
                                <label class="form-check-label" for="refundYes">
                                    <span class="area_flex_one">
                                        <span>Yes</span>
                                        <span>{{ $data['refund'] }}</span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input refundFilter" type="checkbox" value="no"
                                    {{ (in_array('no', $refundFilter)) ? 'checked="checked"' : '' }} name="refund_no"
                                    id="refundNo">
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
                        <input type="hidden" value="{{$data['session_id']}}" name="session_id" id="session_id">
                        <div class="flight_search_result_wrapper">
                            @if($data['flightDetails'])
                            @foreach($data['flightDetails'] as $fdata)
                            @php
                            $OriginDestinationOptionsOutbound = $fdata['OriginDestinationOptionsOutbound'];
                            $totalFares = $fdata['TotalFares']['TotalFare'];
                            $totalFareMargin = (($totalFares['Amount']/100) * $totalmargin) + $totalFares['Amount'];
                            $totalFareMargin = number_format(floor($totalFareMargin*100)/100, 2, '.', '');
                            @endphp
                            <div class="flight_search_item_wrappper">
                                <div class="flight_search_items">
                                    <div class="multi_city_flight_lists">
                                        @php
                                        $firstFlight = head($OriginDestinationOptionsOutbound);
                                        $lastFlight = last($OriginDestinationOptionsOutbound);
                                        $firstFlightSegment = $firstFlight['FlightSegment'];
                                        $lastFlightSegment = $lastFlight['FlightSegment'];

                                        $firstFlightSegmentAirlineCode  = $firstFlightSegment['MarketingAirlineCode'];
                                        @endphp

                                        <div class="flight_multis_area_wrapper">
                                            <div class="col-lg-12">
                                                <div class="flight_logo" style="display:flex; padding: 10px;">
                                                    <img class="flight-logo-img"
                                                        src="{{ isset($data['flightData'][$firstFlightSegmentAirlineCode]) ? $data['flightData'][$firstFlightSegmentAirlineCode]['AirLineLogo'] : ''}}"
                                                        alt="img">
                                                    <div class="flight-details" style="    margin-left: 10px;">
                                                        <h4 id="depFlight{{$loop->iteration}}">{{ isset($data['flightData'][$firstFlightSegmentAirlineCode]) ? $data['flightData'][$firstFlightSegmentAirlineCode]['AirLineName'] : '' }} </h4>
                                                        <h6>{{ $firstFlightSegmentAirlineCode }}
                                                            {{ $firstFlightSegment['FlightNumber']}}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12"
                                                style="display: flex; padding-top: 10px;padding-bottom: 10px;">
                                                <div class=" col-lg-5 flight_search_destination">
                                                    <p>From</p>
                                                    <span>{{ date('d M, Y', strtotime($firstFlightSegment['DepartureDateTime'])) }}</span>
                                                    <h3 class="bold"  id="depFromTIme{{$loop->iteration}}">
                                                        {{ date('H:i', strtotime($firstFlightSegment['DepartureDateTime'])) }}
                                                    </h3>
                                                    <h5 class="bold overflow-text">
                                                        {{ isset($data['airports'][$firstFlightSegment['DepartureAirportLocationCode']]) ? $data['airports'][$firstFlightSegment['DepartureAirportLocationCode']]['City'] : $firstFlightSegment['DepartureAirportLocationCode'] }}
                                                    </h5>
                                                    <h6>{{ isset($data['airports'][$firstFlightSegment['DepartureAirportLocationCode']]) ? $data['airports'][$firstFlightSegment['DepartureAirportLocationCode']]['AirportName'] : '' }}
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
                                                    <span>{{ date('d M, Y', strtotime($lastFlightSegment['ArrivalDateTime'])) }}</span>
                                                    <h3 class="bold"  id="depToTIme{{$loop->iteration}}">
                                                        {{ date('H:i', strtotime($lastFlightSegment['ArrivalDateTime'])) }}
                                                    </h3>
                                                    <h5 class="bold overflow-text">
                                                        {{ isset($data['airports'][$lastFlightSegment['ArrivalAirportLocationCode']]) ? $data['airports'][$lastFlightSegment['ArrivalAirportLocationCode']]['City'] : $lastFlightSegment['ArrivalAirportLocationCode']}}
                                                    </h5>
                                                    <h6>{{ isset($data['airports'][$lastFlightSegment['ArrivalAirportLocationCode']]) ? $data['airports'][$lastFlightSegment['ArrivalAirportLocationCode']]['AirportName'] :''}}
                                                    </h6>
                                                </div>
                                            </div>
                                            

                                        </div>
                                    </div>

                                    <div class="flight_search_right" style="display:flex;">
                                        <!-- <h5><del>AED 1260</del></h5> -->
                                        <div class="col-lg-8">
                                            <h3 class="bold"><span  id="depCurrency{{$loop->iteration}}">{{ $totalFares['CurrencyCode'] }}</span>
                                                <!-- {{ $fdata['TotalFares']['TotalFare']['Amount'] }}  -->
                                               <span  id="depAmount{{$loop->iteration}}"> {{ $totalFareMargin }}</span>
                                                <!-- <sup>*20% OFF</sup> -->
                                            </h3>
                                           
                                            <input type="hidden" value="{{$fdata['FareSourceCode']}}" name="fare_code_dep_{{$loop->iteration}}" id="fare_code_dep_{{$loop->iteration}}">
                                            
                                            <!-- <p>*Discount applicable on some conditions</p> -->
                                            <h6 data-id="{{$loop->iteration}}" data-type="departure" data-search_type="{{$data['search_type']}}" data-session_id="{{$data['session_id']}}" 
                                                data-fareCode="{{$fdata['FareSourceCode']}}"  class="viewDomFlightDetails">View Details<i
                                                    class="fas fa-chevron-down"></i></h6>
                                        </div>
                                        <div class="col-lg-4" style="text-align: center;margin: auto;">
                                            <input type="radio" class="bookOut"  value="{{$loop->iteration}}" @if($loop->iteration == 1) checked @endif name="bookOut"
                                            id="bookOut" class="col-form-control" style="width: 25px;height: 25px;">
                                        </div>
                                    </div>
                                </div>





                                


                                <div class="flight_policy_refund collapse" id="detialsDomDepView_{{$loop->iteration}}">


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
                            @php
                            $OriginDestinationOptionsInbound = $fdataIn['OriginDestinationOptionsInbound'];
                            $totalFaresIn = $fdataIn['TotalFares']['TotalFare'];
                            $totalFareMarginIn = (($totalFaresIn['Amount']/100) * $totalmargin) +
                            $totalFaresIn['Amount'];
                            $totalFareMarginIn = number_format(floor($totalFareMarginIn*100)/100, 2, '.', '');
                            @endphp
                            <div class="flight_search_item_wrappper">
                                <div class="flight_search_items">
                                    <div class="multi_city_flight_lists">
                                        @php
                                        $firstFlightIn = head($OriginDestinationOptionsInbound);
                                        $lastFlightIn = last($OriginDestinationOptionsInbound);
                                        $firstFlightSegmentIn = $firstFlightIn['FlightSegment'];
                                        $lastFlightSegmentIn = $lastFlightIn['FlightSegment'];

                                        $firstFlightSegmentInAirlineCode = $firstFlightSegmentIn['MarketingAirlineCode'];
                                        @endphp

                                        <div class="flight_multis_area_wrapper">
                                            <div class="col-lg-12">
                                                <div class="flight_logo" style="display:flex; padding: 10px;">
                                                    <img class="flight-logo-img"
                                                        src="{{ isset($data['flightData'][$firstFlightSegmentInAirlineCode]) ? $data['flightData'][$firstFlightSegmentInAirlineCode]['AirLineLogo'] : ''}}"
                                                        alt="img">
                                                    <div class="flight-details" style="    margin-left: 10px;">
                                                        <h4 id="returnFlight{{$loop->iteration}}">{{ isset($data['flightData'][$firstFlightSegmentInAirlineCode]) ? $data['flightData'][$firstFlightSegmentInAirlineCode]['AirLineName'] : '' }}
                                                        </h4>
                                                        <h6>{{ $firstFlightSegmentInAirlineCode }}
                                                            {{ $firstFlightSegmentIn['FlightNumber']}}</h6>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12"
                                                style="display: flex;padding-top: 10px;padding-bottom: 10px;">
                                                <div class=" col-lg-5 flight_search_destination">
                                                    <p>From</p>
                                                    <span>{{ date('d M, Y', strtotime($firstFlightSegmentIn['DepartureDateTime'])) }}</span>
                                                    <h3 class="bold"  id="returnFromTIme{{$loop->iteration}}">
                                                        {{ date('H:i', strtotime($firstFlightSegmentIn['DepartureDateTime'])) }}
                                                    </h3>
                                                    <h5 class="bold overflow-text">
                                                        {{ isset($data['airports'][$firstFlightSegmentIn['DepartureAirportLocationCode']]) ? $data['airports'][$firstFlightSegmentIn['DepartureAirportLocationCode']]['City'] : $firstFlightSegmentIn['DepartureAirportLocationCode'] }}
                                                    </h5>
                                                    <h6>{{ isset($data['airports'][$firstFlightSegmentIn['DepartureAirportLocationCode']]) ? $data['airports'][$firstFlightSegmentIn['DepartureAirportLocationCode']]['AirportName'] : '' }}
                                                    </h6>
                                                </div>

                                                <div class=" col-lg-2 flight_search_middel">
                                                    <div class="flight_right_arrow">
                                                        <img src="{{ asset('assets/img/icon/right_arrow.png') }}"
                                                            alt="icon">
                                                        <h6>
                                                            {{ ($fdataIn['totalInStops'] == 0) ? 'Non-stop' : (($fdataIn['totalInStops'] == 1) ?  '1 Stop via '.implode(',',$fdataIn['layoversIn']['place']) : ($fdataIn['totalInStops']).' Stops via '.implode(',',$fdataIn['layoversIn']['place'])) }}
                                                        </h6>
                                                        <p>{{ convertToHoursMins($fdataIn['totalDurationIn']) }} </p>
                                                    </div>
                                                </div>
                                                <div class=" col-lg-5 flight_search_destination">
                                                    <p>To</p>
                                                    <span>{{ date('d M, Y', strtotime($lastFlightSegmentIn['ArrivalDateTime'])) }}</span>
                                                    <h3 class="bold" id="returnToTIme{{$loop->iteration}}">
                                                        {{ date('H:i', strtotime($lastFlightSegmentIn['ArrivalDateTime'])) }}
                                                    </h3>
                                                    <h5 class="bold overflow-text">
                                                        {{ isset($data['airports'][$lastFlightSegmentIn['ArrivalAirportLocationCode']]) ? $data['airports'][$lastFlightSegmentIn['ArrivalAirportLocationCode']]['City'] : $lastFlightSegmentIn['ArrivalAirportLocationCode'] }}
                                                    </h5>
                                                    <h6>{{ isset($data['airports'][$lastFlightSegmentIn['ArrivalAirportLocationCode']]) ? $data['airports'][$lastFlightSegmentIn['ArrivalAirportLocationCode']]['AirportName'] :''}}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flight_search_right" style="display:flex;">
                                        <!-- <h5><del>AED 1260</del></h5> -->
                                        <div class="col-lg-8">
                                            <h3 class="bold"><span  id="returnCurrency{{$loop->iteration}}">{{ $totalFaresIn['CurrencyCode'] }}</span>
                                                <!-- {{ $fdataIn['TotalFares']['TotalFare']['Amount'] }} -->
                                                <span  id="returnAmount{{$loop->iteration}}">{{ $totalFareMarginIn }}</span>
                                                <!-- <sup>*20% OFF</sup> -->
                                            </h3>

                                            <input type="hidden" value="{{$fdataIn['FareSourceCode']}}" name="fare_code_return{{$loop->iteration}}" id="fare_code_return{{$loop->iteration}}">

                                            <!-- <p>*Discount applicable on some conditions</p> -->
                                            <h6 data-id="{{$loop->iteration}}"  data-type="return" data-search_type="{{$data['search_type']}}" data-session_id="{{$data['session_id']}}" 
                                                data-fareCode="{{$fdataIn['FareSourceCode']}}" class="viewDomFlightDetails">View Details<i
                                                    class="fas fa-chevron-down"></i></h6>
                                        </div>
                                        <div class="col-lg-4" style="text-align: center;margin: auto;">
                                            <input type="radio"  class="bookIn" value="{{$loop->iteration}}" @if($loop->iteration == 1) checked @endif name="bookIn"
                                            id="bookIn" class="col-form-control" style="width: 25px;height: 25px;">
                                        </div>
                                    </div>
                                </div>


                                <div class="flight_policy_refund collapse" id="detialsDomReturnView_{{$loop->iteration}}">

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
                                    <p class="white bold font16"  id="stickyReturnFare"></p>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex stickyFlightDetails">
                            <div class="d-flex align-center margin-left-auto">
                                <div class="margin-right10">
                                    <p><span class="white font22 bold" id="stickyTotal"></span></p>
                                </div>
                                <div class="d-flex align-center">
                                    <div>
                                        <a href="#" target="_blank" id="stickyButton" class="button bookingBtn btn-40 ">Book Now</a>
                                    </div>
                                </div>
                            </div>
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
.flight_search_items {
    display: block !important;
}

.flight_search_destination {
    padding-left: 20px;
}

.flight_search_middel {
    padding-left: 0 !important;
}

.flight_multis_area_wrapper {
    display: block !important;
}

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
    background-image: linear-gradient(100deg,#4a9913,#000000 140%);
    color: white;
}
.button{
    display: flex;
    border-radius: 35px;
    box-shadow: 0 1px 7px 0 rgba(0,0,0,.22);
    cursor: pointer;
    align-items: center;
    justify-content: center;
    height: 32px;
    padding: 0 20px;
    border: none;
    outline: none!important;
    font-weight: 900;
}

.font22 {
    font-size: calc(var(--font-scale, 1)*22px);
}
</style>
@endpush
@push('footer')
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/search_flights.js') }}"></script>
<script type="text/javascript">

getSelectedData();
function getSelectedData(){
    var departureFlight = $("input:radio.bookOut:checked").val();
    var returnFlight = $("input:radio.bookIn:checked").val();
    var rAmount = parseFloat($('#returnAmount'+returnFlight).html());
    var dAmount = parseFloat($('#depAmount'+departureFlight).html());
    var total = rAmount + dAmount;
    total = Math.floor(total * 100) / 100;
   
    $('#stickyDepFlight').html($('#depFlight'+departureFlight).html());
    $('#stickyDepFromTime').html($('#depFromTIme'+departureFlight).html());
    $('#stickyDepToTime').html($('#depToTIme'+departureFlight).html());
    $('#stickyDepFare').html($('#depCurrency'+departureFlight).html()+' '+$('#depAmount'+departureFlight).html());
    $('#stickyReturnFlight').html($('#returnFlight'+returnFlight).html());
    $('#stickyReturnFromTime').html($('#returnFromTIme'+returnFlight).html());
    $('#stickyReturnToTime').html($('#returnToTIme'+returnFlight).html());
    $('#stickyReturnFare').html($('#returnCurrency'+returnFlight).html()+' '+$('#returnAmount'+returnFlight).html());
    $('#stickyTotal').html($('#returnCurrency'+returnFlight).html() +' '+(total));

    var session_id = $('#session_id').val();
    var search_type = $('#search_typeResult').val();
    var fare_code_dep = $('#fare_code_dep_'+departureFlight).val();
    var fare_code_return = $('#fare_code_return'+returnFlight).val();

    var url = "{{ route('flight.booking') }}";
    url = url+"?search_type="+search_type+"&session_id="+session_id+"&FareSourceCode="+fare_code_dep+"&FareSourceCodeIn="+fare_code_return;

    $('#stickyButton').attr('href',url);
}

$(document).on('click','.bookOut',function(){
    getSelectedData()
});
$(document).on('click','.bookIn',function(){
    getSelectedData()
});

</script>
@endpush