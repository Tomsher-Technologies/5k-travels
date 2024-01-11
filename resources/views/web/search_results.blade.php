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
                                    @php  $flightKey = isset($data['flightData'][$airKey]) ? $data['flightData'][$airKey] : [];  @endphp
                                <div class="form-check">
                                    <input class="form-check-input airlineFilter" {{ (in_array($airKey, $airlineFilter)) ? 'checked="checked"' : '' }} type="checkbox" value="{{$airKey}}" id="flexCheckDefaults1">
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

                                                    $firstFlightSegmentAirlineCode = $firstFlightSegment['MarketingAirlineCode'];
                                                @endphp

                                                <div class="flight_multis_area_wrapper">
                                                    
                                                     <div class="flight_logo">
                                                            <img src="{{ isset($data['flightData'][$firstFlightSegmentAirlineCode]) ? $data['flightData'][$firstFlightSegmentAirlineCode]['AirLineLogo'] : ''}}"
                                                                alt="img">
                                                            <div class="flight-details">
                                                                <h4>{{ isset($data['flightData'][$firstFlightSegmentAirlineCode]) ? $data['flightData'][$firstFlightSegmentAirlineCode]['AirLineName'] : '' }}
                                                                </h4>
                                                                <h6>{{ $firstFlightSegmentAirlineCode }}
                                                                    {{ $firstFlightSegment['FlightNumber']}}</h6>
                                                            </div>
                                                        </div>
                                                        
                                                    <div class="flight_search_left">
                                                       
                                                        <div class="flight_search_destination">
                                                            <p>From</p>
                                                            <span>{{ date('d M, Y', strtotime($firstFlightSegment['DepartureDateTime'])) }}</span>
                                                            <h2>{{ date('H:i', strtotime($firstFlightSegment['DepartureDateTime'])) }}
                                                            </h2>
                                                            <h3>{{ isset($data['airports'][$firstFlightSegment['DepartureAirportLocationCode']]) ? $data['airports'][$firstFlightSegment['DepartureAirportLocationCode']]['City'] : $firstFlightSegment['DepartureAirportLocationCode'] }}
                                                            </h3>
                                                            <h6>{{ isset($data['airports'][$firstFlightSegment['DepartureAirportLocationCode']]) ? $data['airports'][$firstFlightSegment['DepartureAirportLocationCode']]['AirportName'] : '' }}
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
                                                        
                                                       
                                                    </div>
                                                    
                                                       <div class="flight_search_third">
                                                        
                                                        <div class="flight_search_destination">
                                                            <p>To</p>
                                                            <span>{{ date('d M, Y', strtotime($lastFlightSegment['ArrivalDateTime'])) }}</span>
                                                            <h2>{{ date('H:i', strtotime($lastFlightSegment['ArrivalDateTime'])) }}
                                                            </h2>
                                                            <h3>{{ isset($data['airports'][$lastFlightSegment['ArrivalAirportLocationCode']]) ? $data['airports'][$lastFlightSegment['ArrivalAirportLocationCode']]['City'] : $lastFlightSegment['ArrivalAirportLocationCode']}}
                                                            </h3>
                                                            <h6>{{ isset($data['airports'][$lastFlightSegment['ArrivalAirportLocationCode']]) ? $data['airports'][$lastFlightSegment['ArrivalAirportLocationCode']]['AirportName'] : '' }}
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
                                                            $firstFlightInSegmentAirlineCode = $firstFlightInSegment['MarketingAirlineCode'];
                                                        @endphp
                                                        <div class="flight_multis_area_wrapper">
                                                             <div class="flight_logo">
                                                                    <img src="{{ isset($data['flightData'][$firstFlightInSegmentAirlineCode]) ? $data['flightData'][$firstFlightInSegmentAirlineCode]['AirLineLogo'] : ''}}"
                                                                        alt="img">
                                                                    <div class="flight-details">
                                                                        <h4>{{ isset($data['flightData'][$firstFlightInSegmentAirlineCode]) ? $data['flightData'][$firstFlightInSegmentAirlineCode]['AirLineName'] : '' }}
                                                                        </h4>
                                                                        <h6>{{ $firstFlightInSegmentAirlineCode }}
                                                                            {{ $firstFlightInSegment['FlightNumber']}}</h6>
                                                                    </div>
                                                                </div>
                                                            <div class="flight_search_left">
                                                               
                                                                <div class="flight_search_destination">
                                                                    <p>From</p>
                                                                    <span>{{ date('d M, Y', strtotime($firstFlightInSegment['DepartureDateTime'])) }}</span>
                                                                    <h2>{{ date('H:i', strtotime($firstFlightInSegment['DepartureDateTime'])) }}
                                                                    </h2>
                                                                    <h3>{{ isset($data['airports'][$firstFlightInSegment['DepartureAirportLocationCode']]) ? $data['airports'][$firstFlightInSegment['DepartureAirportLocationCode']]['City'] : $firstFlightInSegment['DepartureAirportLocationCode']}}
                                                                    </h3>
                                                                    <h6>{{ isset($data['airports'][$firstFlightInSegment['DepartureAirportLocationCode']]) ? $data['airports'][$firstFlightInSegment['DepartureAirportLocationCode']]['AirportName'] : ''}}
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
                                                                
                                                               
                                                                
                                                                
                                                            </div>
                                                            
                                                             <div class="flight_search_third">
                                                             <div class="flight_search_destination">
                                                                    <p>To</p>
                                                                    <span>{{ date('d M, Y', strtotime($lastFlightInSegment['ArrivalDateTime'])) }}</span>
                                                                    <h2>{{ date('H:i', strtotime($lastFlightInSegment['ArrivalDateTime'])) }}
                                                                    </h2>
                                                                    <h3>{{ isset($data['airports'][$lastFlightInSegment['ArrivalAirportLocationCode']]) ? $data['airports'][$lastFlightInSegment['ArrivalAirportLocationCode']]['City'] : $lastFlightInSegment['ArrivalAirportLocationCode']}}
                                                                    </h3>
                                                                    <h6>{{ isset($data['airports'][$lastFlightInSegment['ArrivalAirportLocationCode']]) ? $data['airports'][$lastFlightInSegment['ArrivalAirportLocationCode']]['AirportName'] : ''}}
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
                                                        $FlightSegmentAirlineCode = $FlightSegment['MarketingAirlineCode'];
                                                    @endphp
                                                    <div class="flight_multis_area_wrapper">
                                                        
                                                         <div class="flight_logo">
                                                                <img src="{{ (isset($data['flightData'][$FlightSegmentAirlineCode])) ? $data['flightData'][$FlightSegmentAirlineCode]['AirLineLogo'] : '' }}"
                                                                    alt="img">
                                                                <div class="flight-details">
                                                                    <h4>{{ (isset($data['flightData'][$FlightSegmentAirlineCode])) ? $data['flightData'][$FlightSegmentAirlineCode]['AirLineName'] : ''  }}
                                                                    </h4>
                                                                    <h6>{{ $FlightSegmentAirlineCode }}
                                                                        {{ $FlightSegment['FlightNumber']}}</h6>
                                                                </div>
                                                            </div>
                                                            
                                                        <div class="flight_search_left">
                                                           
                                                            <div class="flight_search_destination">
                                                                <p>From</p>
                                                                <span>{{ date('d M, Y', strtotime($FlightSegment['DepartureDateTime'])) }}</span>
                                                                <h2>{{ date('H:i', strtotime($FlightSegment['DepartureDateTime'])) }}
                                                                </h2>
                                                                <h3>{{ isset($data['airports'][$FlightSegment['DepartureAirportLocationCode']]) ? $data['airports'][$FlightSegment['DepartureAirportLocationCode']]['City'] : $FlightSegment['DepartureAirportLocationCode']}}
                                                                </h3>
                                                                <h6>{{ isset($data['airports'][$FlightSegment['DepartureAirportLocationCode']]) ? $data['airports'][$FlightSegment['DepartureAirportLocationCode']]['AirportName'] : ''}}
                                                                </h6>
                                                            </div>
                                                        </div>

                                                        <div class="flight_search_middel">
                                                            <div class="flight_right_arrow">
                                                                <img src="{{ asset('assets/img/icon/right_arrow.png') }}"
                                                                    alt="icon">
                                                                <p>{{ convertToHoursMins($FlightSegment['JourneyDuration']) }} </p>
                                                                
                                                            </div>
                                                           
                                                        </div>
                                                        
                                                          <div class="flight_search_third">
                                                            <div class="flight_search_destination">
                                                                <p>To</p>
                                                                <span>{{ date('d M, Y', strtotime($FlightSegment['ArrivalDateTime'])) }}</span>
                                                                <h2>{{ date('H:i', strtotime($FlightSegment['ArrivalDateTime'])) }}
                                                                </h2>
                                                                <h3>{{ isset($data['airports'][$FlightSegment['ArrivalAirportLocationCode']]) ? $data['airports'][$FlightSegment['ArrivalAirportLocationCode']]['City'] : $FlightSegment['ArrivalAirportLocationCode'] }}
                                                                </h3>
                                                                <h6>{{ isset($data['airports'][$FlightSegment['ArrivalAirportLocationCode']]) ? $data['airports'][$FlightSegment['ArrivalAirportLocationCode']]['AirportName'] : '' }}
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
                                            <span class="crc"> {{ $totalFares['CurrencyCode'] }}</span>
                                              
                                                <!-- <sup>*20% OFF</sup> -->
                                               
                                                {{ $totalFareMargin }}

                                                <!-- {{ $totalmargin }} -->
                                            </h2>
                                            <div class="d-flex justify-content-evenly">
                                            <a href="{{ route('flight.booking',['search_type' => $data['search_type'], 'session_id' => $data['session_id'],'FareSourceCode' => $fdata['FareSourceCode']]) }}" target="_blank" class="btn btn_theme btn_sm">Book now</a>
                                            <!-- <p>*Discount applicable on some conditions</p> -->
                                            <h6 data-id="{{$loop->iteration}}" data-search_type="{{$data['search_type']}}" data-session_id="{{$data['session_id']}}" 
                                                data-fareCode="{{$fdata['FareSourceCode']}}" class="viewFlightDetails" ><i class="fas fa-chevron-down"></i></h6>
                                                </div>
                                        </div>
                                    </div>





                                    <div class="pricing__table pricing__style-2 white-bg">
    <div class="pricing__table-wrapper">
        <!-- pricng header -->
        <div class="pricing__header grey-bg-13">
            <div class="row gx-0 ">

                <div class="col-xl-3 col-3">
                    

                    <div class="pricing__feature-item-wrapper">
                        <!-- pricing features item -->
                        <div class="pricing__feature-info-item">
                        <div class="pricing__header-content">
                        <h3 class="pricing__header-title">Fare type
                        </h3>
                    </div>

                        
                        
                        <div class="pricing__feature-info-content d-flex align-items-center">
                                        <div class="pricing__feature-info-details">
                                            <span>
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M9 1.5C4.99594 1.5 1.75 4.74594 1.75 8.75C1.75 12.7541 4.99594 16 9 16C13.0041 16 16.25 12.7541 16.25 8.75C16.25 4.74594 13.0041 1.5 9 1.5ZM0.25 8.75C0.25 3.91751 4.16751 0 9 0C13.8325 0 17.75 3.91751 17.75 8.75C17.75 13.5825 13.8325 17.5 9 17.5C4.16751 17.5 0.25 13.5825 0.25 8.75ZM9 7.75C9.55229 7.75 10 8.19771 10 8.75V11.95C10 12.5023 9.55229 12.95 9 12.95C8.44771 12.95 8 12.5023 8 11.95V8.75C8 8.19771 8.44771 7.75 9 7.75ZM9 4.5498C8.44771 4.5498 8 4.99752 8 5.5498C8 6.10209 8.44771 6.5498 9 6.5498H9.008C9.56028 6.5498 10.008 6.10209 10.008 5.5498C10.008 4.99752 9.56028 4.5498 9.008 4.5498H9Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                            <div class="pricing__feature-info-tooltip transition-3">
                                                <p>Add gradient heading, button,
                                                    pricing table testimonial
                                                    etc.</p>
                                            </div>
                                        </div>
                                        <div class="pricing__feature-info-text">
                                            <p>Hand baggage</p>
                                        </div>
                                    </div>


                                    <div class="pricing__feature-info-content d-flex align-items-center">
                                        <div class="pricing__feature-info-details">
                                            <span>
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M9 1.5C4.99594 1.5 1.75 4.74594 1.75 8.75C1.75 12.7541 4.99594 16 9 16C13.0041 16 16.25 12.7541 16.25 8.75C16.25 4.74594 13.0041 1.5 9 1.5ZM0.25 8.75C0.25 3.91751 4.16751 0 9 0C13.8325 0 17.75 3.91751 17.75 8.75C17.75 13.5825 13.8325 17.5 9 17.5C4.16751 17.5 0.25 13.5825 0.25 8.75ZM9 7.75C9.55229 7.75 10 8.19771 10 8.75V11.95C10 12.5023 9.55229 12.95 9 12.95C8.44771 12.95 8 12.5023 8 11.95V8.75C8 8.19771 8.44771 7.75 9 7.75ZM9 4.5498C8.44771 4.5498 8 4.99752 8 5.5498C8 6.10209 8.44771 6.5498 9 6.5498H9.008C9.56028 6.5498 10.008 6.10209 10.008 5.5498C10.008 4.99752 9.56028 4.5498 9.008 4.5498H9Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                            <div class="pricing__feature-info-tooltip transition-3">
                                                <p>Add gradient heading, button,
                                                    pricing table testimonial
                                                    etc.</p>
                                            </div>
                                        </div>
                                        <div class="pricing__feature-info-text">
                                            <p>Checked baggage</p>
                                        </div>
                                    </div>

                                    <div class="pricing__feature-info-content d-flex align-items-center">
                                        <div class="pricing__feature-info-details">
                                            <span>
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M9 1.5C4.99594 1.5 1.75 4.74594 1.75 8.75C1.75 12.7541 4.99594 16 9 16C13.0041 16 16.25 12.7541 16.25 8.75C16.25 4.74594 13.0041 1.5 9 1.5ZM0.25 8.75C0.25 3.91751 4.16751 0 9 0C13.8325 0 17.75 3.91751 17.75 8.75C17.75 13.5825 13.8325 17.5 9 17.5C4.16751 17.5 0.25 13.5825 0.25 8.75ZM9 7.75C9.55229 7.75 10 8.19771 10 8.75V11.95C10 12.5023 9.55229 12.95 9 12.95C8.44771 12.95 8 12.5023 8 11.95V8.75C8 8.19771 8.44771 7.75 9 7.75ZM9 4.5498C8.44771 4.5498 8 4.99752 8 5.5498C8 6.10209 8.44771 6.5498 9 6.5498H9.008C9.56028 6.5498 10.008 6.10209 10.008 5.5498C10.008 4.99752 9.56028 4.5498 9.008 4.5498H9Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                            <div class="pricing__feature-info-tooltip transition-3">
                                                <p>Add gradient heading, button,
                                                    pricing table testimonial
                                                    etc.</p>
                                            </div>
                                        </div>
                                        <div class="pricing__feature-info-text">
                                            <p>Meal
                                            </p>
                                        </div>
                                    </div>


                                    <div class="pricing__feature-info-content d-flex align-items-center">
                                        <div class="pricing__feature-info-details">
                                            <span>
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M9 1.5C4.99594 1.5 1.75 4.74594 1.75 8.75C1.75 12.7541 4.99594 16 9 16C13.0041 16 16.25 12.7541 16.25 8.75C16.25 4.74594 13.0041 1.5 9 1.5ZM0.25 8.75C0.25 3.91751 4.16751 0 9 0C13.8325 0 17.75 3.91751 17.75 8.75C17.75 13.5825 13.8325 17.5 9 17.5C4.16751 17.5 0.25 13.5825 0.25 8.75ZM9 7.75C9.55229 7.75 10 8.19771 10 8.75V11.95C10 12.5023 9.55229 12.95 9 12.95C8.44771 12.95 8 12.5023 8 11.95V8.75C8 8.19771 8.44771 7.75 9 7.75ZM9 4.5498C8.44771 4.5498 8 4.99752 8 5.5498C8 6.10209 8.44771 6.5498 9 6.5498H9.008C9.56028 6.5498 10.008 6.10209 10.008 5.5498C10.008 4.99752 9.56028 4.5498 9.008 4.5498H9Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                            <div class="pricing__feature-info-tooltip transition-3">
                                                <p>Add gradient heading, button,
                                                    pricing table testimonial
                                                    etc.</p>
                                            </div>
                                        </div>
                                        <div class="pricing__feature-info-text">
                                            <p>Seat Selection</p>
                                        </div>
                                    </div>


                                    <div class="pricing__feature-info-content d-flex align-items-center">
                                        <div class="pricing__feature-info-details">
                                            <span>
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M9 1.5C4.99594 1.5 1.75 4.74594 1.75 8.75C1.75 12.7541 4.99594 16 9 16C13.0041 16 16.25 12.7541 16.25 8.75C16.25 4.74594 13.0041 1.5 9 1.5ZM0.25 8.75C0.25 3.91751 4.16751 0 9 0C13.8325 0 17.75 3.91751 17.75 8.75C17.75 13.5825 13.8325 17.5 9 17.5C4.16751 17.5 0.25 13.5825 0.25 8.75ZM9 7.75C9.55229 7.75 10 8.19771 10 8.75V11.95C10 12.5023 9.55229 12.95 9 12.95C8.44771 12.95 8 12.5023 8 11.95V8.75C8 8.19771 8.44771 7.75 9 7.75ZM9 4.5498C8.44771 4.5498 8 4.99752 8 5.5498C8 6.10209 8.44771 6.5498 9 6.5498H9.008C9.56028 6.5498 10.008 6.10209 10.008 5.5498C10.008 4.99752 9.56028 4.5498 9.008 4.5498H9Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                            <div class="pricing__feature-info-tooltip transition-3">
                                                <p>Add gradient heading, button,
                                                    pricing table testimonial
                                                    etc.</p>
                                            </div>
                                        </div>
                                        <div class="pricing__feature-info-text">
                                            <p>Seat type</p>
                                        </div>
                                    </div>



                                    
                                    <div class="pricing__feature-info-content d-flex align-items-center">
                                        <div class="pricing__feature-info-details">
                                            <span>
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M9 1.5C4.99594 1.5 1.75 4.74594 1.75 8.75C1.75 12.7541 4.99594 16 9 16C13.0041 16 16.25 12.7541 16.25 8.75C16.25 4.74594 13.0041 1.5 9 1.5ZM0.25 8.75C0.25 3.91751 4.16751 0 9 0C13.8325 0 17.75 3.91751 17.75 8.75C17.75 13.5825 13.8325 17.5 9 17.5C4.16751 17.5 0.25 13.5825 0.25 8.75ZM9 7.75C9.55229 7.75 10 8.19771 10 8.75V11.95C10 12.5023 9.55229 12.95 9 12.95C8.44771 12.95 8 12.5023 8 11.95V8.75C8 8.19771 8.44771 7.75 9 7.75ZM9 4.5498C8.44771 4.5498 8 4.99752 8 5.5498C8 6.10209 8.44771 6.5498 9 6.5498H9.008C9.56028 6.5498 10.008 6.10209 10.008 5.5498C10.008 4.99752 9.56028 4.5498 9.008 4.5498H9Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                            <div class="pricing__feature-info-tooltip transition-3">
                                                <p>Add gradient heading, button,
                                                    pricing table testimonial
                                                    etc.</p>
                                            </div>
                                        </div>
                                        <div class="pricing__feature-info-text">
                                            <p></p>
                                        </div>
                                    </div>
                        </div>
                    </div>
                </div>




                <div class="col-xl-3 col-3">

<div class="pricing__header-top-wrapper">

   
    <!-- pricing heading one -->
    <div class="pricing__top-7 p-relative text-center">
        <div class="pricing__tag-7">
            <span> Lite</span>
        </div>
        <div class="pricing__title-wrapper-7">
            <h3 class="pricing__title-7">
                <span>AED</span>950.00
            </h3>

        </div>
    </div>

</div>



<div class="pricing__feature-info-wrapper">
<div class="pricing__feature-info-available text-center">
    <p>
        <span class="done">
            <svg width="11" height="9" viewBox="0 0 11 9" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M9.5451 1.27344L3.9201 7.04884L1.36328 4.42366"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </span>
    </p>
</div>

</div>





<div class="pricing__feature-info-wrapper">
<div class="pricing__feature-info-available text-center">
    <p>
        <span class="cross">
            <svg width="10" height="11" viewBox="0 0 12 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11 1L1 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                </path>
                <path d="M1 1L11 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                </path>
            </svg>
        </span>
    </p>
</div>
</div>




<div class="pricing__feature-info-wrapper">
<div class="pricing__feature-info-available text-center">
    <p>
        <span class="done">
            <svg width="11" height="9" viewBox="0 0 11 9" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M9.5451 1.27344L3.9201 7.04884L1.36328 4.42366"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </span>
    </p>
</div>
</div>


<div class="pricing__feature-info-wrapper">
<div class="pricing__feature-info-available text-center">
    <p>
        <span class="cross">
            <svg width="10" height="11" viewBox="0 0 12 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11 1L1 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                </path>
                <path d="M1 1L11 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                </path>
            </svg>
        </span>
    </p>
</div>
</div>

<div class="pricing__feature-info-wrapper">
<div class="pricing__feature-info-available text-center">
    <p>
        <span class="done">
            <svg width="11" height="9" viewBox="0 0 11 9" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M9.5451 1.27344L3.9201 7.04884L1.36328 4.42366"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </span>
    </p>
</div>
</div>
</div>



                <div class="col-xl-3 col-3">

                    <div class="pricing__header-top-wrapper">

                       
                        <!-- pricing heading one -->
                        <div class="pricing__top-7 p-relative text-center">
                            <div class="pricing__tag-7">
                                <span> Lite</span>
                            </div>
                            <div class="pricing__title-wrapper-7">
                                <h3 class="pricing__title-7">
                                    <span>AED</span>950.00
                                </h3>
          
                            </div>
                        </div>

                </div>



                <div class="pricing__feature-info-wrapper">
                    <div class="pricing__feature-info-available text-center">
                        <p>
                            <span class="done">
                                <svg width="11" height="9" viewBox="0 0 11 9" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.5451 1.27344L3.9201 7.04884L1.36328 4.42366"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                        </p>
                    </div>
                   
                </div>



                

                <div class="pricing__feature-info-wrapper">
                    <div class="pricing__feature-info-available text-center">
                        <p>
                            <span class="cross">
                                <svg width="10" height="11" viewBox="0 0 12 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 1L1 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                    <path d="M1 1L11 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                </svg>
                            </span>
                        </p>
                    </div>
                </div>



                
                <div class="pricing__feature-info-wrapper">
                    <div class="pricing__feature-info-available text-center">
                        <p>
                            <span class="done">
                                <svg width="11" height="9" viewBox="0 0 11 9" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.5451 1.27344L3.9201 7.04884L1.36328 4.42366"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                        </p>
                    </div>
                </div>

                
                <div class="pricing__feature-info-wrapper">
                    <div class="pricing__feature-info-available text-center">
                        <p>
                            <span class="cross">
                                <svg width="10" height="11" viewBox="0 0 12 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 1L1 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                    <path d="M1 1L11 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                </svg>
                            </span>
                        </p>
                    </div>
                </div>

                <div class="pricing__feature-info-wrapper">
                    <div class="pricing__feature-info-available text-center">
                        <p>
                            <span class="done">
                                <svg width="11" height="9" viewBox="0 0 11 9" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.5451 1.27344L3.9201 7.04884L1.36328 4.42366"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                        </p>
                    </div>
                </div>
            </div>




            <div class="col-xl-3 col-3">

<div class="pricing__header-top-wrapper">

   
    <!-- pricing heading one -->
    <div class="pricing__top-7 p-relative text-center">
        <div class="pricing__tag-7">
            <span> Lite</span>
        </div>
        <div class="pricing__title-wrapper-7">
            <h3 class="pricing__title-7">
                <span>AED</span>950.00
            </h3>

        </div>
    </div>

</div>



<div class="pricing__feature-info-wrapper">
<div class="pricing__feature-info-available text-center">
    <p>
        <span class="done">
            <svg width="11" height="9" viewBox="0 0 11 9" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M9.5451 1.27344L3.9201 7.04884L1.36328 4.42366"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </span>
    </p>
</div>

</div>





<div class="pricing__feature-info-wrapper">
<div class="pricing__feature-info-available text-center">
    <p>
        <span class="cross">
            <svg width="10" height="11" viewBox="0 0 12 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11 1L1 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                </path>
                <path d="M1 1L11 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                </path>
            </svg>
        </span>
    </p>
</div>
</div>




<div class="pricing__feature-info-wrapper">
<div class="pricing__feature-info-available text-center">
    <p>
        <span class="done">
            <svg width="11" height="9" viewBox="0 0 11 9" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M9.5451 1.27344L3.9201 7.04884L1.36328 4.42366"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </span>
    </p>
</div>
</div>


<div class="pricing__feature-info-wrapper">
<div class="pricing__feature-info-available text-center">
    <p>
        <span class="cross">
            <svg width="10" height="11" viewBox="0 0 12 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11 1L1 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                </path>
                <path d="M1 1L11 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                </path>
            </svg>
        </span>
    </p>
</div>
</div>

<div class="pricing__feature-info-wrapper">
<div class="pricing__feature-info-available text-center">
    <p>
        <span class="done">
            <svg width="11" height="9" viewBox="0 0 11 9" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M9.5451 1.27344L3.9201 7.04884L1.36328 4.42366"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </span>
    </p>
</div>
</div>
</div>








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

    </script>
@endpush
