@extends('web.layouts.app')
@section('content')
<!-- Common Banner Area -->
<section id="common_banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="common_bannner_text text-dark">
                    @if($data['search_type'] == 'OneWay' && Session::has("flight_search_oneway"))
                        <h2>Your trip to {{ $data['airports'][session('flight_search_oneway')['oTo']]['City'] }} <img src="{{ asset('assets/img/icon/flight.png') }}" alt=""></h2>
                    @elseif($data['search_type'] == 'Return' && Session::has("flight_search_return"))
                        <h2>Your trip to {{ $data['airports'][session('flight_search_return')['rTo']]['City'] }} and back <img src="{{ asset('assets/img/icon/flight.png') }}" alt=""></h2>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
    @php  $data['flightData'] = getAirlines(); @endphp
</section>
<!-- Tour Booking Submission Areas -->
<section id="tour_booking_submission" class="section_padding">
    <div class="container container-bboking">
        <div class="row">
            @if(isset($data['flightsOutgoing']))
                <div class="col-lg-8">
                    <div class="tou_booking_form_Wrapper">
                        <div class="tour_detail_right_sidebar">
                            <div class="tour_details_right_boxed">
                                <div class="tour_details_right_box_heading">
                                    <h3>Flights</h3>
                                </div>
                                    @php  
                                        $outFrom = $outTo = '';
                                        $countOut = count($data['flightsOutgoing']);
                                        $out =1;
                                      
                                    @endphp
                                    @foreach($data['flightsOutgoing'] as $outGoing)
                                        @php  
                                            $outGoingFLightSegment =  $outGoing['FlightSegment'];
                                            if($out ==1){
                                                $outFrom = $outGoingFLightSegment['DepartureAirportLocationCode'];
                                            }elseif($out == $countOut){
                                                $outTo = $outGoingFLightSegment['ArrivalAirportLocationCode'];
                                            }

                                            if($countOut == 1){
                                                $outTo = $outGoingFLightSegment['ArrivalAirportLocationCode'];
                                            }
                                            
                                        @endphp

                                        <div class="py-20 px-30">
                                            <div class="row justify-between items-center">
                                                <div class="col-auto">
                                                    <div class="fw-500 text-dark-1">Depart • {{ date('d M, Y', strtotime($outGoingFLightSegment['DepartureDateTime'])) }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="text-14 text-light-1">Duration: {{ convertToHoursMins($outGoingFLightSegment['JourneyDuration']) }}</div>
                                                </div>
                                                @if($outGoingFLightSegment['CabinClassCode'] == 'Y')
                                                    @php $cabinClass = "Economy"; @endphp
                                                @elseif($outGoingFLightSegment['CabinClassCode'] == 'S')
                                                    @php $cabinClass = "Premium Economy"; @endphp
                                                @elseif($outGoingFLightSegment['CabinClassCode'] == 'C')
                                                    @php $cabinClass = "Business"; @endphp
                                                @elseif($outGoingFLightSegment['CabinClassCode'] == 'F')
                                                    @php $cabinClass = "First"; @endphp
                                                @else
                                                    @php $cabinClass = $outGoingFLightSegment['CabinClassCode']; @endphp
                                                @endif
                                                <div class="col-auto">
                                                    <div class="text-14 text-light-1">Cabin Class: {{$cabinClass}}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="py-30 px-30 border-top-light">
                                            <div class="row y-gap-10 justify-between">
                                                <div class="col-auto col-sm-8">
                                                    <div class="d-flex items-center mb-15">
                                                        <div class="w-28 d-flex justify-center mr-15"><img
                                                                src="{{ $data['flightData'][$outGoingFLightSegment['MarketingAirlineCode']]['AirLineLogo'] }}" alt="image"></div>
                                                        <div class="text-14 text-light-1">{{ $outGoingFLightSegment['MarketingAirlineName'] }} {{ $outGoingFLightSegment['MarketingAirlineCode'] }} | {{ $outGoingFLightSegment['FlightNumber']}}</div>
                                                    </div>
                                                    <div class="relative z-0">
                                                        <div class="border-line-2"></div>
                                                        <div class="d-flex items-center">
                                                            <div class="w-28 d-flex justify-center mr-15">
                                                                <div class="size-10 border-light rounded-full bg-white"></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-auto">
                                                                    <div class="lh-14 fw-500">{{ date('H:i', strtotime($outGoingFLightSegment['DepartureDateTime'])) }}</div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="lh-14 fw-500">{{$data['airports'][$outGoingFLightSegment['DepartureAirportLocationCode']]['AirportName'] }} ({{$outGoingFLightSegment['DepartureAirportLocationCode']}})</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex items-center mt-15">
                                                            <div class="w-28 d-flex justify-center mr-15"><img
                                                                    src="{{ asset('assets/img/icon/plane.svg') }}" alt="image">
                                                            </div>
                                                            <div class="text-14 text-light-1">{{ convertToHoursMins($outGoingFLightSegment['JourneyDuration']) }}</div>
                                                        </div>
                                                        <div class="d-flex items-center mt-15">
                                                            <div class="w-28 d-flex justify-center mr-15">
                                                                <div class="size-10 border-light rounded-full bg-border"></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-auto">
                                                                    <div class="lh-14 fw-500">{{ date('H:i', strtotime($outGoingFLightSegment['ArrivalDateTime'])) }}</div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="lh-14 fw-500">{{$data['airports'][$outGoingFLightSegment['ArrivalAirportLocationCode']]['AirportName'] }} ({{$outGoingFLightSegment['ArrivalAirportLocationCode']}})</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-sm-4">
                                                    <div class="makeFlex spaceBetween appendBottom3 fontSize14">
                                                        <span class=" col-sm-4 baggageInfoText blackFont">BAGGAGE : </span>
                                                        <span class=" col-sm-4 baggageInfoText blackFont text-center">CHECK IN</span>
                                                        <span class=" col-sm-4 baggageInfoText blackFont text-center">CABIN</span>
                                                    </div>

                                                    @php  
                                                        $bagKey = $outGoingFLightSegment['MarketingAirlineCode'].'_'.$outGoingFLightSegment['DepartureAirportLocationCode'].'_'.$outGoingFLightSegment['ArrivalAirportLocationCode'];
                                                    @endphp
                                                    @if(array_key_exists($bagKey, $data['flightBaggageOut']))
                                                        @php   $flightBagOutKey = $data['flightBaggageOut'][$bagKey]; @endphp
                                                        @foreach($flightBagOutKey as $bagKeys=>$bagData)
                                                            <div class="makeFlex spaceBetween appendBottom3 fontSize14">
                                                                <span class="baggageInfoText darkText col-sm-4"> {{ ($bagKeys=='ADT') ? "Adult" : (($bagKeys=="CHD") ? "Child" : "Infant") }} </span>
                                                                <span class="baggageInfoText darkText col-sm-4 text-center">{{ ($bagData['baggage'] != '') ? $bagData['baggage'] : '-' }}</span>
                                                                <span class="baggageInfoText darkText col-sm-4 text-center">{{ ($bagData['cabin_baggage'] != '') ? $bagData['cabin_baggage'] : '-' }}</span>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                @if(array_key_exists($outGoingFLightSegment['ArrivalAirportLocationCode'], $data['layovers']))
                                                    <div class="flightLayoverOuter">
                                                        <div class="flightLayover mmtConnectLayover">
                                                            <div class="makeFlex fontSize14">
                                                                <p> <span style="color: #5d8f3a;">Change of planes</span> <b>{{ convertToHoursMins($data['layovers'][$outGoingFLightSegment['ArrivalAirportLocationCode']]) }}</b> Layover in {{ $data['airports'][$outGoingFLightSegment['ArrivalAirportLocationCode']]['City'] }}</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                @endif
                                            </div>
                                        </div>
                                        @php  $out++;  @endphp
                                    @endforeach
                                    @if($data['search_type'] == 'Return')
                                        @if(isset($data['flightsIncoming']))
                                            <hr>
                                            <div class="return-title fs-20">
                                                Return Trip 
                                            </div>
                                            <hr>
                                            @php  
                                                $inFrom = $inTo = '';
                                                $countIn = count($data['flightsIncoming']);
                                                $inn = 1;
                                            @endphp
                                            @foreach($data['flightsIncoming'] as $inComing)
                                                @php  
                                                    $incomingFlightSegment = $inComing['FlightSegment'];
                                                    if($inn ==1){
                                                        $inFrom = $incomingFlightSegment['DepartureAirportLocationCode'];
                                                    }elseif($inn == $countIn){
                                                        $inTo = $incomingFlightSegment['ArrivalAirportLocationCode'];
                                                    }

                                                    if($countIn == 1){
                                                        $inTo = $incomingFlightSegment['ArrivalAirportLocationCode'];
                                                    }
                                                @endphp
                                                <div class="py-20 px-30">
                                                    <div class="row justify-between items-center">
                                                        <div class="col-auto">
                                                            <div class="fw-500 text-dark-1">Depart • {{ date('d M, Y', strtotime($incomingFlightSegment['DepartureDateTime'])) }}</div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="text-14 text-light-1">Duration: {{ convertToHoursMins($incomingFlightSegment['JourneyDuration']) }}</div>
                                                        </div>
                                                        @if($incomingFlightSegment['CabinClassCode'] == 'Y')
                                                            @php $cabinClass = "Economy"; @endphp
                                                        @elseif($incomingFlightSegment['CabinClassCode'] == 'S')
                                                            @php $cabinClass = "Premium Economy"; @endphp
                                                        @elseif($incomingFlightSegment['CabinClassCode'] == 'C')
                                                            @php $cabinClass = "Business"; @endphp
                                                        @elseif($incomingFlightSegment['CabinClassCode'] == 'F')
                                                            @php $cabinClass = "First"; @endphp
                                                        @else
                                                            @php $cabinClass = $incomingFlightSegment['CabinClassCode']; @endphp
                                                        @endif
                                                        <div class="col-auto">
                                                            <div class="text-14 text-light-1">Cabin Class: {{$cabinClass}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="py-30 px-30 border-top-light">
                                                    <div class="row y-gap-10 justify-between">
                                                        <div class="col-auto col-sm-8">
                                                            <div class="d-flex items-center mb-15">
                                                                <div class="w-28 d-flex justify-center mr-15"><img
                                                                        src="{{ $data['flightData'][$incomingFlightSegment['MarketingAirlineCode']]['AirLineLogo'] }}" alt="image"></div>
                                                                <div class="text-14 text-light-1">{{ $incomingFlightSegment['MarketingAirlineName'] }} {{ $incomingFlightSegment['MarketingAirlineCode'] }} | {{ $incomingFlightSegment['FlightNumber']}}</div>
                                                            </div>
                                                            <div class="relative z-0">
                                                                <div class="border-line-2"></div>
                                                                <div class="d-flex items-center">
                                                                    <div class="w-28 d-flex justify-center mr-15">
                                                                        <div class="size-10 border-light rounded-full bg-white"></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-auto">
                                                                            <div class="lh-14 fw-500">{{ date('H:i', strtotime($incomingFlightSegment['DepartureDateTime'])) }}</div>
                                                                        </div>
                                                                        <div class="col-auto">
                                                                            <div class="lh-14 fw-500">{{$data['airports'][$incomingFlightSegment['DepartureAirportLocationCode']]['AirportName'] }} ({{$incomingFlightSegment['DepartureAirportLocationCode']}})</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex items-center mt-15">
                                                                    <div class="w-28 d-flex justify-center mr-15"><img
                                                                            src="{{ asset('assets/img/icon/plane.svg') }}" alt="image">
                                                                    </div>
                                                                    <div class="text-14 text-light-1">{{ convertToHoursMins($incomingFlightSegment['JourneyDuration']) }}</div>
                                                                </div>
                                                                <div class="d-flex items-center mt-15">
                                                                    <div class="w-28 d-flex justify-center mr-15">
                                                                        <div class="size-10 border-light rounded-full bg-border"></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-auto">
                                                                            <div class="lh-14 fw-500">{{ date('H:i', strtotime($incomingFlightSegment['ArrivalDateTime'])) }}</div>
                                                                        </div>
                                                                        <div class="col-auto">
                                                                            <div class="lh-14 fw-500">{{$data['airports'][$incomingFlightSegment['ArrivalAirportLocationCode']]['AirportName'] }} ({{$incomingFlightSegment['ArrivalAirportLocationCode']}})</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-sm-4">
                                                            <div class="makeFlex spaceBetween appendBottom3 fontSize14">
                                                                <span class=" col-sm-4 baggageInfoText blackFont">BAGGAGE : </span>
                                                                <span class=" col-sm-4 baggageInfoText blackFont text-center">CHECK IN</span>
                                                                <span class=" col-sm-4 baggageInfoText blackFont text-center">CABIN</span>
                                                            </div>

                                                            @php  
                                                                $bagKey = $incomingFlightSegment['MarketingAirlineCode'].'_'.$incomingFlightSegment['DepartureAirportLocationCode'].'_'.$incomingFlightSegment['ArrivalAirportLocationCode'];
                                                            @endphp
                                                            @if(array_key_exists($bagKey, $data['flightBaggageIn']))
                                                                @php   $flightBagInKey = $data['flightBaggageIn'][$bagKey]; @endphp
                                                                @foreach($flightBagInKey as $bagKey2=>$bagData)
                                                                    <div class="makeFlex spaceBetween appendBottom3 fontSize14">
                                                                        <span class="baggageInfoText darkText col-sm-4"> {{ ($bagKey2=='ADT') ? "Adult" : (($bagKey2=="CHD") ? "Child" : "Infant") }} </span>
                                                                        <span class="baggageInfoText darkText col-sm-4 text-center">{{ ($bagData['baggage'] != '') ? $bagData['baggage'] : '-' }}</span>
                                                                        <span class="baggageInfoText darkText col-sm-4 text-center">{{ ($bagData['cabin_baggage'] != '') ? $bagData['cabin_baggage'] : '-' }}</span>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        @if(array_key_exists($incomingFlightSegment['ArrivalAirportLocationCode'], $data['layoversIn']))
                                                            <div class="flightLayoverOuter">
                                                                <div class="flightLayover mmtConnectLayover">
                                                                    <div class="makeFlex fontSize14">
                                                                        <p> <span style="color: #5d8f3a;">Change of planes</span> <b>{{ convertToHoursMins($data['layoversIn'][$incomingFlightSegment['ArrivalAirportLocationCode']]) }}</b> Layover in {{ $data['airports'][$incomingFlightSegment['ArrivalAirportLocationCode']]['City'] }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        @endif
                                                    </div>
                                                </div>
                                                @php  $inn++;  @endphp
                                            @endforeach
                                        @else
                                            <hr>
                                            <div class="return-title fs-20" style="color:red;">
                                                <h5>No Return Flight Found. </h5>
                                            </div>
                                        @endif
                                    @endif
                            </div>
                        </div>
                        @php 
                            $amountLi  = $passengerName ='';
                            $totalBase = $totalTax = 0;
                            $adult_amount = $child_amount = $infant_amount = 0;
                            if(isset($data['FareBreakdown'])){
                                foreach($data['FareBreakdown'] as $fkey=>$fvalue){
                                    $totalBase = $totalBase + $fvalue['BaseFare']['Amount'];
                                    $currencyCode = $fvalue['BaseFare']['CurrencyCode'];
                                    if($fkey == 'ADT'){
                                        $passengerName = 'Adult';
                                        $adult_amount = $fvalue['BaseFare']['Amount'];
                                    }elseif($fkey == 'CHD'){
                                        $passengerName = 'Child';
                                        $child_amount = $fvalue['BaseFare']['Amount'];
                                    }elseif($fkey == 'INF'){
                                        $passengerName = 'Infant';
                                        $infant_amount = $fvalue['BaseFare']['Amount'];
                                    }
                                    $amountLi .= "<li> ".$passengerName." Price x ". $fvalue['Quantity']."  <span>".$fvalue['BaseFare']['CurrencyCode']." ".$fvalue['BaseFare']['Amount']."</span></li>";
                                }
                            }
                        
                      
                            $desc = array(
                                'GROUP_PAX' => '(Entire group)', 
                                'PER_PAX' => '(Each passenger)', 
                                'GROUP_PAX_INBOUND' => '(Entire group only on the return trip)',
                                'GROUP_PAX_OUTBOUND' => '(Entire group only on for the onward travel)', 
                                'PER_PAX_INBOUND' => '(Each passenger only on the return trip)', 
                                'PER_PAX_OUTBOUND' => '(Each passenger only on for the onward travel)'
                            );
                            $description = '';
                                            
                            $ItinTotalFares =  $data['ItinTotalFares'];

                            $TotalFare = $ItinTotalFares['TotalFare'];
                            $BaseFare = $ItinTotalFares['BaseFare'];
                            $TotalTax = $ItinTotalFares['TotalTax'];
                            $currencyCode = $TotalFare['CurrencyCode'];
            
                        @endphp
                        <form action="{{ route('flight.create-booking') }}" method="post" id="bookingForm">
                                @csrf
                            @if(isset($data['extraBaggage']))
                            <div class="tour_detail_right_sidebar">
                                <div class="tour_details_right_boxed">
                                    <div class="tour_details_right_box_heading">
                                        <h3>Extra Baggage</h3>
                                        <input type="hidden" name="total_addons" id="total_addons" value="0">
                                        <input type="hidden" name="currency" id="currency" value="{{$currencyCode}}">
                                        <input type="hidden" name="total_amount" id="total_amount" value="{{$TotalFare['Amount']}}">
                                        <input type="hidden" name="total_tax" id="total_tax" value="{{$TotalTax['Amount']}}">
                                        <input type="hidden" name="adult_amount" id="adult_amount" value="{{$adult_amount}}">
                                        <input type="hidden" name="child_amount" id="child_amount" value="{{$child_amount}}">
                                        <input type="hidden" name="infant_amount" id="infant_amount" value="{{$infant_amount}}">
                                    </div>
                                    <div class="tour_package_details_bar_list">
                                        @php  
                                            $adultCount = (isset($data['adultCount'])) ? $data['adultCount'] : 0;
                                            $childCount = (isset($data['childCount'])) ? $data['childCount'] : 0;
                                            $infantCount = (isset($data['infantCount'])) ? $data['infantCount'] : 0;

                                            $bagRestict = $adultCount + $childCount;
                                            
                                        @endphp
                                        @if(isset($data['extraBaggage']['outGoing']))
                                            <h4 class="fareRule-heading"><i class="fa fa-suitcase"></i>&nbsp;{{ ($outFrom != '') ? $data['airports'][$outFrom]['AirportName'] : '' }} -> {{ ($outTo != '') ?  $data['airports'][$outTo]['AirportName'] : '' }}</h4>
                                            <table>
                                            @php 
                                                $bout = 0; 
                                                $bagRestictOut = $bagRestict;
                                                $extraBaggageOutGoing = $data['extraBaggage']['outGoing'];
                                            @endphp

                                            @foreach( $extraBaggageOutGoing as $exBagOut)
                                                @php    
                                                    $exBagOutService = $exBagOut['Service'];
                                                @endphp
                                                @if(isset($exBagOutService['Description']))
                                                    @php  
                                                        $description = explode('||',$exBagOutService['Description']);
                                                        $description = $description[0];
                                                    @endphp

                                                @endif

                                                @php
                                                    if(($bout == 0) && strpos($exBagOutService['Behavior'], 'GROUP') !== false){
                                                        $bagRestictOut = 1;
                                                    }

                                                    $exBagOutServiceServiceCost = $exBagOutService['ServiceCost'];
                                                @endphp
                                                <tr>
                                                    <td>{{ $description }} {{ (isset($desc[$exBagOutService['Behavior']])) ? $desc[$exBagOutService['Behavior']] : '' }} </td>
                                                    <td>{{ $exBagOutServiceServiceCost['CurrencyCode'] }} {{ $exBagOutServiceServiceCost['Amount'] }}   </td>
                                                    <td class="text"> 
                                                        <div class="d-flex"> 
                                                            <button type="button" class="extraService bag_countOut f-7" id="minusBag" data-max="{{$bagRestictOut}}"  data-price="{{$exBagOutServiceServiceCost['Amount']}}" data-id="{{ $exBagOutService['ServiceId'] }}">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                            <input type="text" name="baggageOut[{{ $exBagOutService['ServiceId'] }}][]" id="baggageOut" class="baggage_count" value="0">
                                                            <button type="button" class=" extraService bag_countOut" data-max="{{$bagRestictOut}}" data-price="{{$exBagOutServiceServiceCost['Amount']}}" data-id="{{ $exBagOutService['ServiceId'] }}" id="plusBag">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @php $bout++; @endphp
                                            @endforeach
                                            </table>
                                            <span class="hide bagError" id="bagOutError" > </span>
                                        @endif

                                        @if(isset($data['extraBaggage']['inComing']))
                                            <h4 class="fareRule-heading"><i class="fa fa-suitcase"></i>&nbsp;{{ ($inFrom != '') ? $data['airports'][$inFrom]['AirportName'] : '' }} -> {{ ($inTo != '') ? $data['airports'][$inTo]['AirportName'] : '' }}</h4>
                                            <table>
                                            @php 
                                                $bin = 0; 
                                                $bagRestictIn = $bagRestict; 
                                                $extraBaggageinComing = $data['extraBaggage']['inComing'];
                                            @endphp
                                            @foreach($extraBaggageinComing as $exBagIn)
                                                @php
                                                    $exBagInService = $exBagIn['Service'];
                                                @endphp
                                                @if(isset($exBagInService['Description']))
                                                    @php  
                                                        $description = explode('||',$exBagInService['Description']);
                                                        $description = $description[0];
                                                    @endphp

                                                @endif
                                                @php
                                                    if(($bin == 0) && strpos($exBagInService['Behavior'], 'GROUP') !== false){
                                                        $bagRestictIn = 1;
                                                    } 
                                                @endphp
                                                <tr>
                                                    <td>{{ $description }} {{ (isset($desc[$exBagInService['Behavior']])) ? $desc[$exBagInService['Behavior']] : '' }} </td>
                                                    <td>{{ $exBagInService['ServiceCost']['CurrencyCode'] }} {{ $exBagInService['ServiceCost']['Amount'] }}   </td>
                                                    <td> 
                                                        <div class="d-flex"> 
                                                            <button type="button" class=" extraService bag_countIn f-7" id="minusBagIn" data-max="{{$bagRestictIn}}" data-price="{{$exBagInService['ServiceCost']['Amount']}}" data-id="{{ $exBagInService['ServiceId'] }}">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                            <input type="text" name="baggageIn[{{ $exBagInService['ServiceId'] }}][]" id="baggage" class="baggage_countIn" value="0">
                                                            <button type="button" class=" extraService bag_countIn" data-max="{{$bagRestictIn}}" data-price="{{$exBagInService['ServiceCost']['Amount']}}" data-id="{{ $exBagInService['ServiceId'] }}" id="plusBagIn">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @php $bin++; @endphp
                                            @endforeach
                                            </table>
                                            <span class="hide bagError" id="bagInError" > </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if(isset($data['extraMeals']))
                            <div class="tour_detail_right_sidebar">
                                <div class="tour_details_right_boxed">
                                    <div class="tour_details_right_box_heading">
                                        <h3>Extra Meal</h3>
                                    </div>
                                    <div class="tour_package_details_bar_list">
                                        <table>
                                        @foreach($data['extraMeal'] as $exMeal)
                                            @php  $exMealService = $exMeal['Service'];  @endphp
                                            <tr>
                                                <td>{{ $exMealService['Description'] }} {{ $desc[$exMealService['Behavior']] }} </td>
                                                <td>{{ $exMealService['ServiceCost']['CurrencyCode'] }} {{ $exMealService['ServiceCost']['Amount'] }}   </td>
                                                <td> <input type="checkbox" value="{{ $exMealService['ServiceId'] }}" class="" name="extraMeals" id="extraMeals"> </td>
                                            </tr>
                                        @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if(isset($data['fareRulesOut']))
                            <div class="tour_detail_right_sidebar">
                                <div class="tour_details_right_boxed">
                                    <div class="tour_details_right_box_heading">
                                        <h3>Fare rules</h3>
                                    </div>
                                    <div class="tour_package_details_bar_list">
                                        @foreach($data['fareRulesOut'] as $farerule)
                                            @php
                                                $fareruleCityPair = $farerule['FareRule']['CityPair'];
                                                $fromCity = $toCity = '';
                                                $cityString = (isset($fareruleCityPair) && $fareruleCityPair != '') ? str_split($fareruleCityPair, 3) : '';
                                                if($cityString){
                                                    $fromCity = $cityString[0];
                                                    $toCity = $cityString[1];
                                                }
                                                
                                            @endphp

                                            @if(($fromCity != '') && ($toCity != ''))
                                                <h4 class="fareRule-heading"><i class="fa fa-plane"></i>&nbsp;{{  $data['airports'][$fromCity]['AirportName'] }} -> {{  $data['airports'][$toCity]['AirportName'] }}</h4>
                                            @endif
                                            <h5> {!! $farerule['FareRule']['Category'] !!} </h5>
                                            {!! $farerule['FareRule']['Rules'] !!}
                                        @endforeach
                                    
                                    </div>
                                    <!-- <div class="tour_package_details_bar_price">
                                        <h5>Price</h5>
                                        <div class="tour_package_bar_price">
                                            <h6><del>$ 35,500</del></h6>
                                            <h3>$ 30,500 <sub> / Adult X 1</sub> </h3>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            @endif

                            @php   
                                $passengers = $data['passengers'];
                            @endphp
                            @if(isset($passengers))
                                @php $countries = ''; $passCount = 1; @endphp
                                
                                @foreach($data['countries'] as $country)
                                    @php $countries .= '<option value="'.$country->code.'"> '.$country->name.' </option>'; @endphp
                                @endforeach
                            @endif
                            
                            <div class="booking_tour_form">
                                <h3 class="heading_theme">Passenger information</h3>
                                
                                    @if(isset($passengers['ADT']))

                                        @for($ad=1; $ad <= $passengers['ADT']; $ad++)
                                            <div class="tour_booking_form_box {{ ($ad!=1) ? 'mt-3' : '' }}">
                                                <h3>Passenger {{$passCount}} (Adult)</h3>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label for="gender">Title</label>
                                                        <div class="form-group">
                                                            <select class="form-control appearance-auto" name="adult_title[]" id="adult_title{{$passCount}}">
                                                                <option value=""> Select</option>
                                                                <option value="Mr">Mr</option>
                                                                <option value="Mrs">Mrs</option>
                                                                <option value="Miss">Miss</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="first_name">First Name</label>
                                                            <input type="text"  class="form-control bg_input " id="adult_first_name{{$passCount}}" name="adult_first_name[]" placeholder="First Name">
                                                            <div class="error-div"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="last_name">Last Name</label>
                                                            <input type="text"  class="form-control bg_input" id="adult_last_name{{$passCount}}" name="adult_last_name[]" placeholder="Last Name">
                                                            <div class="error-div"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="gender">Gender</label>
                                                        <div class="form-group">
                                                            <select class="form-control appearance-auto" name="adult_gender[]" id="adult_gender{{$passCount}}">
                                                                <option value=""> Select</option>
                                                                <option value="male">Male</option>
                                                                <option value="female">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-lg-4">
                                                        <label for="date">Date Of Birth</label>
                                                        <input type="text" class="form-control bg_input datepickerAdult" readonly placeholder="DD-MM-YYYY" name="adult_dob[]" id="datepickerAdult{{$passCount}}" />
                                                        <div class="error-div" id="adult_date_error{{$passCount}}" ></div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="date">Nationality</label>
                                                            <select class="form-control appearance-auto" name="adult_nationality[]" id="adult_nationality{{$passCount}}" placeholder="MM">
                                                                <option value=""> Select</option>
                                                                {!! $countries !!}
                                                            </select>
                                                            <div class="error-div"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="date">Passport Number</label>
                                                            <input type="text" class="form-control bg_input" placeholder="Passport Number" id="adult_passport{{$passCount}}" name="adult_passport[]">
                                                            <div class="error-div"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="date">Passport Issuing Country</label>
                                                            <select class="form-control appearance-auto" name="adult_passport_country[]" id="adult_passport_country{{$passCount}}">
                                                                <option value=""> Select</option>
                                                                {!! $countries !!}
                                                            </select>
                                                            <div class="error-div"></div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-4">
                                                        <label for="date">Passport Expiry</label>
                                                        <input type="text" class="form-control bg_input passportExpiry" readonly placeholder="DD-MM-YYYY" name="adult_passport_expiry[]" id="passportExpiry{{$passCount}}" />
                                                        <div class="error-div"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            @php  $passCount++; @endphp
                                        @endfor
                                    @endif
                                    @if(isset($passengers['CHD']))
                                        
                                        @for($ch=1; $ch <= $passengers['CHD']; $ch++)
                                            <div class="tour_booking_form_box mt-3">
                                                <h3>Passenger {{$passCount}} (Child)</h3>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label for="gender">Title</label>
                                                        <div class="form-group">
                                                            <select class="form-control appearance-auto" name="child_title[]" id="child_title{{$passCount}}">
                                                                <option value=""> Select</option>
                                                                <option value="Master">Master</option>
                                                                <option value="Miss">Miss</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="first_name">First Name</label>
                                                            <input type="text"  class="form-control bg_input " name="child_first_name[]" id="child_first_name{{$passCount}}" placeholder="First Name">
                                                            <div class="error-div"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="last_name">Last Name</label>
                                                            <input type="text"  class="form-control bg_input" name="child_last_name[]" id="child_last_name{{$passCount}}" placeholder="Last Name">
                                                            <div class="error-div"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="gender">Gender</label>
                                                        <div class="form-group">
                                                            <select class="form-control appearance-auto" name="child_gender[]" id="child_gender{{$passCount}}">
                                                                <option value=""> Select</option>
                                                                <option value="male">Male</option>
                                                                <option value="female">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="date">Date Of Birth</label>
                                                        <input type="text" class="form-control bg_input datepickerChild" readonly placeholder="DD-MM-YYYY" name="child_dob[]" id="datepickerChild{{$passCount}}" />
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="date">Nationality</label>
                                                            <select class="form-control appearance-auto" name="child_nationality[]" id="child_nationality{{$passCount}}" placeholder="MM">
                                                                <option value=""> Select</option>
                                                                {!! $countries !!}
                                                            </select>
                                                            <div class="error-div"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="date">Passport Number</label>
                                                            <input type="text" class="form-control bg_input" placeholder="Passport Number"  id="child_passport{{$passCount}}" name="child_passport[]">
                                                            <div class="error-div"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="date">Passport Issuing Country</label>
                                                            <select class="form-control appearance-auto" name="child_passport_country[]"  id="child_passport_country{{$passCount}}">
                                                                <option value=""> Select</option>
                                                                {!! $countries !!}
                                                            </select>
                                                            <div class="error-div"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <label for="date">Passport Expiry</label>
                                                        <input type="text" class="form-control bg_input passportExpiry" readonly placeholder="DD-MM-YYYY" name="child_passport_expiry[]" id="passportExpiry{{$passCount}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            @php  $passCount++; @endphp
                                        @endfor
                                    @endif
                                    @if(isset($passengers['INF']))

                                        @for($inf=1; $inf <= $passengers['INF']; $inf++)
                                            <div class="tour_booking_form_box mt-3">
                                                <h3>Passenger {{$passCount}} (Infant)</h3>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label for="gender">Title</label>
                                                        <div class="form-group">
                                                            <select class="form-control appearance-auto" name="infant_title[]" id="infant_title{{$passCount}}">
                                                                <option value=""> Select</option>
                                                                <option value="Master">Master</option>
                                                                <option value="Miss">Miss</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="first_name">First Name</label>
                                                            <input type="text"  class="form-control bg_input " name="infant_first_name[]"  id="infant_first_name{{$passCount}}" placeholder="First Name">
                                                            <div class="error-div"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="last_name">Last Name</label>
                                                            <input type="text"  class="form-control bg_input" name="infant_last_name[]" id="infant_last_name{{$passCount}}"  placeholder="Last Name">
                                                            <div class="error-div"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="gender">Gender</label>
                                                        <div class="form-group">
                                                            <select class="form-control appearance-auto" name="infant_gender[]" id="infant_gender{{$passCount}}">
                                                                <option value=""> Select</option>
                                                                <option value="male">Male</option>
                                                                <option value="female">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="date">Date Of Birth</label>
                                                        <input type="text" id="datepickerInfant{{$passCount}}" readonly placeholder="DD-MM-YYYY" class="form-control bg_input datepickerInfant" name="infant_dob[]" />
                                                        <div class="error-div"></div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="date">Nationality</label>
                                                            <select class="form-control appearance-auto" name="infant_nationality[]" id="infant_nationality{{$passCount}}" placeholder="MM">
                                                                <option value=""> Select</option>
                                                                {!! $countries !!}
                                                            </select>
                                                            <div class="error-div"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="date">Passport Number</label>
                                                            <input type="text" class="form-control bg_input" placeholder="Passport Number"  id="infant_passport{{$passCount}}" name="infant_passport[]">
                                                            <div class="error-div"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="date">Passport Issuing Country</label>
                                                            <select class="form-control appearance-auto" name="infant_passport_country[]"  id="infant_passport_country{{$passCount}}">
                                                                <option value=""> Select</option>
                                                                {!! $countries !!}
                                                            </select>
                                                            <div class="error-div"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <label for="date">Passport Expiry</label>
                                                        <input type="text" class="form-control bg_input passportExpiry" readonly placeholder="DD-MM-YYYY" name="infant_passport_expiry[]" id="passportExpiry{{$passCount}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            @php  $passCount++; @endphp
                                        @endfor
                                    @endif

                                    <div class="tour_booking_form_box mt-3">
                                        <h3>Contact Details</h3>
                                        <div class="row">
                                            <!-- <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="first_name">Country Code</label>
                                                    <input type="text"  class="form-control bg_input " name="country_code"  id="country_code" >
                                                    <div class="error-div"></div>
                                                </div>
                                            </div> -->
                                            <div class="col-lg-6">
                                                <input type="hidden" name="mobile_code" id="mobile_code">
                                                <div class="form-group">
                                                    <label for="first_name">Mobile No</label>
                                                    <input type="text"  class="form-control bg_input " autocomplete="none" placeholder="Mobile No" name="mobile_no"  id="mobile_no" >
                                                    <div class="error-div"></div>
                                                    <span id="valid-msg" class="hide">✓ Valid</span>
                                                    <span id="error-msg" class="hide"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="last_name">Email</label>
                                                    <input type="text"  class="form-control bg_input" name="email" id="email"  placeholder="Email">
                                                    <div class="error-div"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tour_booking_form_box mt-3">
                                        <div class="form-check write_spical_check mt-3">
                                            <input class="form-check-input" type="checkbox" value="" id="terms_conditions" name="terms_conditions">
                                            <label class="form-check-label" for="flexCheckDefaultf1">
                                                I read and accept all <a href="terms-service.html">Terms and conditios</a>
                                            </label>
                                        </div>

                                        <input type="hidden" name="fare_source_code" id="fare_source_code" value="{{$data['FareSourceCode']}}">
                                        <input type="hidden" name="session_id" id="session_id" value="{{ $data['session_id'] }}">
                                        <input type="hidden" name="IsPassportMandatory" id="IsPassportMandatory" value="{{ ($data['IsPassportMandatory'] == 1 || $data['IsPassportMandatory'] == true) ? 'true' : 'false'}}">
                                        <input type="hidden" name="FareType" id="FareType" value="{{$data['FareType']}}">
                                        <input type="hidden" name="adultCount" id="adultCount" value="{{$data['adultCount']}}">
                                        <input type="hidden" name="childCount" id="childCount" value="{{$data['childCount']}}">
                                        <input type="hidden" name="infantCount" id="infantCount" value="{{$data['infantCount']}}">

                                    </div>
                                    <div class="booking_btn float-right">
                                        <button type="submit" class="btn btn_theme btn_lg mt-30">Continue to payment</button>
                                    </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="tour_details_right_sidebar_wrapper">
                        <!-- <div class="tour_detail_right_sidebar">
                            <div class="tour_details_right_boxed">
                                <div class="tour_details_right_box_heading">
                                    <h3>Coupon code</h3>
                                </div>
                                <div class="coupon_code_area_booking">
                                    <form action="#!">
                                        <div class="form-group">
                                            <input type="text" class="form-control bg_input"
                                                placeholder="Enter coupon code">
                                        </div>
                                        <div class="coupon_code_submit">
                                            <button class="btn btn_theme btn_md">Apply voucher</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> -->
                        <div class="tour_detail_right_sidebar">
                            <div class="tour_details_right_boxed">
                                <div class="tour_details_right_box_heading">
                                    <h3>Booking amount</h3>
                                </div>
                                <div class="tour_booking_amount_area">
                                    <ul>
                                       
                                       {!! $amountLi !!}
                                    </ul>
                                    <div class="tour_bokking_subtotal_area">
                                        <h6>Total Base Fare <span>{{$currencyCode}} {{ $BaseFare['Amount'] }}</span></h6>
                                    </div>
                                    <div class="tour_bokking_subtotal_area">
                                        <h6>Total Tax <span>{{$currencyCode}} {{ $TotalTax['Amount'] }}</span></h6>
                                    </div>

                                    <div class="tour_bokking_subtotal_area">
                                        <h6>Add Ons <span id="addons">{{$currencyCode}} 0</span></h6>
                                    </div>
                                    <div class="coupon_add_area">
                                        <!-- <h6><span class="remove_coupon_tour">Remove</span> Coupon code (OFF 50)
                                            <span>AED 50.00</span>
                                        </h6> -->
                                    </div>
                                    <div class="total_subtotal_booking">
                                        <h4>Total Amount <span id="amountSpan">{{$currencyCode}} {{ $TotalFare['Amount'] }}</span> </h4>
                                    </div>
                                    <!-- <hr>
                                    <div class="form-check write_spical_check mt-3">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefaultf1">
                                        <label class="form-check-label" for="flexCheckDefaultf1">
                                            I read and accept all <a href="terms-service.html">Terms and conditios</a>
                                        </label>
                                    </div>
                                    <div class="booking_btn">
                                        <button class="btn btn_theme btn_md pay-btn">Pay now</button>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
            <div class="col-lg-12">
                <div class="tou_booking_form_Wrapper text-center">
                    <h3>Flight details not available. Choose another one.</h3>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
<!-- newsletter content -->
@include('web.includes.newsletter')
<!-- /newsletter content -->
@endsection
@push('header')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/intlTelInput.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/search_flights.css') }}" />
<style>
    .baggage_count, .baggage_countIn{
        border: none;
        width: 25px;
        text-align: center;
        pointer-events: none;
    }
    .f-7{
        font-size: 7px !important;
    }
    .extraService{
        font-size: 12px;
        color: #4c4c4c;
        border: 1px solid #d8d8d8;
        width: 20px;
        height: 20px;
        margin-top: 3px;
    }
    #valid-msg{
        color:#00a457 ;
    }
    .iti {
        position: relative;
        display: block;
    }
    .total_subtotal_booking h4 {
        font-size: 20px;
        font-weight: 500;
        display: flex;
        justify-content: space-between;
    }
   
    .btn_lg{
        padding: 12px 100px;
        font-size: 18px;
    }
    .mt-30{
       margin-top: 30px;
    }
  
    .form-control:disabled, .form-control[readonly] {
        background-color: #ffffff;
        opacity: 1;
    }
    .tour_package_details_bar_list table td {
        border: 1px solid #cdcdcd;
    }
    .tour_package_details_bar_list table{
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
        vertical-align: top;
        border-color: #dee2e6;
    }
    table>:not(caption)>*>* {
        padding: 0.5rem 0.5rem;
    }
    .tour_package_details_bar_list ul li{
        display:block;
    }

    fieldset {
        padding: 0rem 1rem !important;
        border: 1px solid #c1c1c1 !important;
    }
    legend {
        float: none;
        width: 69px;
    }
    legend b{
        color: #818090;
    }
    .appearance-auto{
        appearance: auto !important;
    }    

    @media (min-width: 1400px){
        .container-bboking{
            max-width: 1600px;
        }
    }
    
</style>
@endpush
@push('footer')
<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/intlTelInput.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript">

    var input = document.querySelector("#mobile_no"),
    errorMsg = document.querySelector("#error-msg"),
    validMsg = document.querySelector("#valid-msg");

    // Error messages based on the code returned from getValidationError
    var errorMap = [ "Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

    // Initialise plugin
    var intl = window.intlTelInput(input, {
        separateDialCode: true,
        preferredCountries:['ae','us','gb'],
        utilsScript: "{{ asset('assets/js/utils.js') }}",
        autoFormat:false
    });

    var code = intl.getSelectedCountryData();
    $('#mobile_code').val(code.dialCode);

    var reset = function() {
        input.classList.remove("error");
        errorMsg.innerHTML = "";
        errorMsg.classList.add("hide");
        validMsg.classList.add("hide");
    };

    // Validate on blur event
    input.addEventListener('blur', function() {
        reset();
        var code = intl.getSelectedCountryData();
        console.log(code);
        $('#mobile_code').val(code.dialCode);
        if(input.value.trim()){
            if(intl.isValidNumber()){
                validMsg.classList.remove("hide");
            }else{
                input.classList.add("error");
                var errorCode = intl.getValidationError();
                errorMsg.innerHTML = errorMap[errorCode];
                errorMsg.classList.remove("hide");
            }
        }
    });

    // Reset on keyup/change event
    input.addEventListener('change', reset);
    input.addEventListener('keyup', reset);

    let one_way_session = '{!! json_encode(Session::get("flight_search_oneway")) !!}';
    one_way_session = JSON.parse(one_way_session);
    let return_session = '{!! json_encode(Session::get("flight_search_return")) !!}';
    return_session = JSON.parse(return_session);
    let multi_session = '{!! json_encode(Session::get("flight_search_multi")) !!}';
    multi_session = JSON.parse(multi_session);

    $(".passportExpiry").datepicker({
        dateFormat: "yy-mm-dd",
        changeYear: true,
        changeMonth: true,
         maxDate: "+10y",
       	 minDate: "y"
    });
    $(".datepickerAdult").datepicker({
        dateFormat: "yy-mm-dd",
        changeYear: true,
        changeMonth: true,
        maxDate: "-12y",
        minDate: "-100y",
        yearRange: '-100y:-12y'
    });
     $(".datepickerChild").datepicker({
        dateFormat: "yy-mm-dd",
       	changeYear: true,
        	changeMonth: true,
         maxDate: "-2y",
       	 minDate: "-12y"
    });
     $(".datepickerInfant").datepicker({
        dateFormat: "dd-mm-yy",
        changeYear: true,
        changeMonth: true,
         maxDate: "y",
       	 minDate: "-2y"
    });
    
    $(document).ready(function () {
        $("#bookingForm").validate({
            rules: {
                terms_conditions:{
                    required:true
                },
                mobile_no:{
                    required:true
                },
                email:{
                    required:true,
                    email:true
                },
                // country_code:{
                //     required:true
                // },
                "adult_title[]": {
                    required: true
                },
                "adult_first_name[]": {
                    required: true,
                    maxlength: 50
                },
                "adult_last_name[]": {
                    required: true,
                    maxlength: 50,
                    minlength: 2,
                },
                "adult_gender[]": {
                    required: true
                },
                "adult_nationality[]": {
                    required: true
                },
                "adult_passport[]": {
                    required: true
                },
                "adult_passport_country[]": {
                    required: true
                },
                "adult_dob[]": {
                    required: true
                },
                "adult_passport_expiry[]": {
                    required: true
                },
                "child_title[]": {
                    required: true
                },
                "child_first_name[]": {
                    required: true,
                    maxlength: 50
                },
                "child_last_name[]": {
                    required: true,
                    maxlength: 50,
                    minlength: 2
                },
                "child_gender[]": {
                    required: true
                },
                "child_nationality[]": {
                    required: true
                },
                "child_passport[]": {
                    required: true
                },
                "child_passport_country[]": {
                    required: true
                },
                "child_dob[]": {
                    required: true
                },
                "child_passport_expiry[]": {
                    required: true
                },
                "infant_title[]": {
                    required: true
                },
                "infant_first_name[]": {
                    required: true,
                    maxlength: 50
                },
                "infant_last_name[]": {
                    required: true,
                    maxlength: 50,
                    minlength: 2,
                },
                "infant_gender[]": {
                    required: true
                },
                "infant_nationality[]": {
                    required: true
                },
                "infant_passport[]": {
                    required: true
                },
                "infant_passport_country[]": {
                    required: true
                },
                "infant_dob[]": {
                    required: true
                },
                "infant_passport_expiry[]": {
                    required: true
                },
            },
            errorPlacement: function (error, element) {
                error.appendTo(element.parent("div"));
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });

    $('.bag_countOut').on('click', function () {
        $('#bagOutError').addClass('hide');
        $('#bagOutError').removeClass('show');
        var elemIdOut = $(this).attr('id');
        var price = $(this).attr('data-price');
        var addonTotal = $('#total_addons').val();
        var maxOut = $(this).attr('data-max');
        var currency = $('#currency').val();
        var totalAmount = $('#total_amount').val();
        
        if(elemIdOut == "minusBag"){
            var counterOut =  $(this).next('input').val();
            var total = parseFloat(addonTotal) - parseFloat(price);
            totalAmount = parseFloat(totalAmount) - parseFloat(price);
        }else{
            var counterOut =  $(this).prev('input').val();
            var total = parseFloat(addonTotal) + parseFloat(price);
            totalAmount = parseFloat(totalAmount) + parseFloat(price);
        }
        total = (total >= 0) ? parseFloat(total).toFixed(2) : 0;
        totalAmount = parseFloat(totalAmount).toFixed(2);
       
        var parsedOut = parseInt(counterOut);
        var resultOut = elemIdOut == "minusBag" ? parsedOut - 1 : parsedOut + 1;
        
        var restrictOut = 0;

        $('.baggage_count').each(function() {
            restrictOut = parseInt(restrictOut) + parseInt($(this).val());
        })
       
        if(elemIdOut == "minusBag"){
            restrictOut = parseInt(restrictOut) - 1;
        }else{
            restrictOut = parseInt(restrictOut) + 1;
        }
        
        if(resultOut >= 0){
            if(restrictOut <= maxOut){
                $('#total_addons').val(total);
                $('#total_amount').val(totalAmount);
                $('#addons').html(currency+' '+total);
                $('#amountSpan').html(currency+' '+totalAmount);

                if(elemIdOut == "minusBag"){
                    $(this).next('input').val(resultOut);
                }else{
                    $(this).prev('input').val(resultOut);
                }
            }else{
                $('#bagOutError').html("You can't add more than "+maxOut+" baggage");
                $('#bagOutError').addClass('show');
                $('#bagOutError').removeClass('hide');
            }
        }
    });

    $('.bag_countIn').on('click', function () {
        $('#bagInError').addClass('hide');
        $('#bagInError').removeClass('show');
        var elemIdIn = $(this).attr('id');
        var maxIn = $(this).attr('data-max');
        var price = $(this).attr('data-price');
        var addonTotal = $('#total_addons').val();

        var currency = $('#currency').val();
        var totalAmount = $('#total_amount').val();

        if(elemIdIn == "minusBagIn"){
            var counterIn = $(this).next('input').val();
            var total = parseFloat(addonTotal) - parseFloat(price);
            totalAmount = parseFloat(totalAmount) - parseFloat(price);
        }else{
            var counterIn = $(this).prev('input').val();
            var total = parseFloat(addonTotal) + parseFloat(price);
            totalAmount = parseFloat(totalAmount) + parseFloat(price);
        }
        total = (total >= 0) ? parseFloat(total).toFixed(2) : 0;
        totalAmount = parseFloat(totalAmount).toFixed(2);

        var parsedIn = parseInt(counterIn);
        var resultIn = elemIdIn == "minusBagIn" ? parsedIn - 1 : parsedIn + 1;

        var restrict = 0;

        $('.baggage_countIn').each(function() {
            restrict = parseInt(restrict) + parseInt($(this).val());
        })
       
        if(elemIdIn == "minusBagIn"){
            restrict = parseInt(restrict) - 1;
        }else{
            restrict = parseInt(restrict) + 1;
        }
      
        if(resultIn >= 0){
            if(restrict <= maxIn){
                $('#addons').html(currency+' '+total);
                $('#total_addons').val(total);
                $('#total_amount').val(totalAmount);
                $('#amountSpan').html(currency+' '+totalAmount);
                if(elemIdIn == "minusBagIn"){
                    $(this).next('input').val(resultIn);
                }else{
                    $(this).prev('input').val(resultIn);
                }
            }else{
                $('#bagInError').html("You can't add more than "+maxIn+" baggage");
                $('#bagInError').addClass('show');
                $('#bagInError').removeClass('hide');
            }
            
        }
    });

</script>
@endpush