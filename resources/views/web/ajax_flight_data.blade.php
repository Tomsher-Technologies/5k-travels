<div class="flight_show_down_wrapper" style="display:block;">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                data-bs-target="#flight_details_{{$data['id']}}" type="button" role="tab" aria-controls="home"
                aria-selected="true">Flight Details</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                data-bs-target="#fare_details_{{$data['id']}}" type="button" role="tab"
                aria-controls="profile" aria-selected="false">Fare Summary</button>
        </li>
    </ul>
    @php 
        $marginData = $data['margins'];
        $totalmargin = $marginData['totalmargin'];
    @endphp
    <!-- Tab panes -->
    <div class="tab-content" id="ex1-content">
        @isset($data['flightsOutgoing'])
            <div class="tab-pane fade show active" id="flight_details_{{$data['id']}}" role="tabpanel" aria-labelledby="ex1-tab-1" >
                @if($data['search_type'] != 'Circle')
                    @isset($data['flightsOutgoing'])
                        @php  
                            $flightsOutgoing   = $data['flightsOutgoing'];  
                        @endphp
                        @foreach($flightsOutgoing as $outGoing)

                            @php   
                                $outGoingSegment = $outGoing['FlightSegment'];
                                $outDepAirCode = $outGoingSegment['DepartureAirportLocationCode'];
                                $deptAirportData = getAirportData($outDepAirCode);

                                $outArrAirCode = $outGoingSegment['ArrivalAirportLocationCode'];
                                $arrAirportData = getAirportData($outArrAirCode);

                                $airlineCode = $outGoingSegment['MarketingAirlineCode'];
                                $airlineData = getAirlineData($airlineCode);
                            @endphp
                            <div class="flightDetails">
                                <p class="flightDetailsHead">{{ $deptAirportData[0]['City']}} to {{ $arrAirportData[0]['City'] }} - {{ date('d M, Y', strtotime($outGoingSegment['DepartureDateTime'])) }}</p>
                                <div class="flightDetailsInfo col-sm-12">
                                    <div class="flightDetailsRow  col-sm-12">
                                        <p class="makeFlex hrtlCenter appendBottom20 gap-x-10">
                                            <span class="icon32 bgProperties" style="background-image: url('{{ isset($airlineData[0]) ? $airlineData[0]['AirLineLogo']  : '' }}');"></span><span>
                                                <span color="#000000"><b>{{ isset($airlineData[0]) ? $airlineData[0]['AirLineName']  : '' }}</b></span>
                                                <span color="#6d7278">{{ $airlineCode }} | {{ $outGoingSegment['FlightNumber']}}</span>

                                                <span class="fontSize12">
                                                    ({{ isset($outGoing['ResBookDesigCode']) ? $outGoing['ResBookDesigCode'] : '' }})
                                                </span>
                                            </span>
                                        </p>
                                        <div class="makeFlex flightDtlInfo  col-sm-12">
                                            <div class="airlineInfo gap-x-10  col-sm-6">
                                                <div class="airlineDTInfoCol  col-sm-4">
                                                    <p class="fontSize18 blackText blackFont">{{ date('H:i', strtotime($outGoingSegment['DepartureDateTime'])) }}
                                                    </p>
                                                    <p  class="fontSize12 blackText boldFont appendBottom8">{{ date('d M, Y', strtotime($outGoingSegment['DepartureDateTime'])) }}</p>
                                                    <p class="fontSize12">{{ $deptAirportData[0]['City'] }}, {{ $deptAirportData[0]['Country'] }}</p>
                                                </div>
                                                <div class="text-center fontSize12  col-sm-4">{{ convertToHoursMins($outGoingSegment['JourneyDuration']) }}
                                                    <br> 
                                                    @php 
                                                        if(isset($outGoing['SeatsRemaining'])){
                                                            echo '<span class="seat-remaining">(Seats Remaining - '.$outGoing['SeatsRemaining']['Number'].')</span>';
                                                        }

                                                    @endphp
                                                    <div class="relative fliStopsSep">
                                                        <p class="fliStopsSepLine"
                                                            style="border-top: 3px solid rgb(81, 226, 194);">
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="airlineDTInfoCol  col-sm-4">
                                                    <p class="fontSize18 blackText blackFont">{{ date('H:i', strtotime($outGoingSegment['ArrivalDateTime'])) }} </p>
                                                    <p class="fontSize12 blackText boldFont appendBottom8">{{ date('d M, Y', strtotime($outGoingSegment['ArrivalDateTime'])) }}</p>
                                                    <p class="fontSize12">{{ $arrAirportData[0]['City'] }}, {{ $arrAirportData[0]['Country'] }}</p>
                                                </div>
                                            </div>
                                            <div class="baggageInfo  col-sm-6">
                                                <p class="makeFlex spaceBetween appendBottom3 fontSize14">
                                                    <span class=" col-sm-4 baggageInfoText blackFont">BAGGAGE : </span>
                                                    <span class=" col-sm-4 baggageInfoText blackFont text-center">CHECK IN</span>
                                                    <span class=" col-sm-4 baggageInfoText blackFont text-center">CABIN</span>
                                                </p>

                                                @php  
                                                    $bagKey = $airlineCode.'_'.$outDepAirCode.'_'.$outArrAirCode;
                                                @endphp
                                                @if(array_key_exists($bagKey, $data['flightBaggageOut']))
                                                    @foreach($data['flightBaggageOut'][$bagKey] as $bagKey=>$bagData)
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
                                    @if(array_key_exists($outArrAirCode, $data['layovers']))
                                    <div class="flightLayoverOuter">
                                        <div class="flightLayover mmtConnectLayover">
                                            <div class="makeFlex fontSize14">
                                                <p> <span style="color: #5d8f3a;">Change of planes</span> <b>{{ convertToHoursMins($data['layovers'][$outArrAirCode]) }}</b> Layover in {{ $arrAirportData[0]['City'] }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endisset

                    @isset($data['flightsIncoming'])
                        @php  
                            $flightsIncoming   = $data['flightsIncoming'];  
                        @endphp
                        @if(!empty($flightsIncoming))
                            <div class="return-title">
                                Return Trip 
                            </div>
                            @foreach($flightsIncoming as $InComing)
                                @php   
                                    $inComingSegment = $InComing['FlightSegment'];

                                    $inDepAirCode = $inComingSegment['DepartureAirportLocationCode'];
                                    $deptAirportDataIn = getAirportData($inDepAirCode);

                                    $inArrAirCode = $inComingSegment['ArrivalAirportLocationCode'];
                                    $arrAirportDataIn = getAirportData($inArrAirCode);

                                    $airlineCodeIn = $inComingSegment['MarketingAirlineCode'];
                                    $airlineDataIn = getAirlineData($airlineCodeIn);
                                @endphp
                                <div class="flightDetails " @if($data['id'] == 1 ) style="border-top:1px solid #dfdfdf !important;"  @endif>
                                    <p class="flightDetailsHead">{{ $deptAirportDataIn[0]['City']}} to {{ $arrAirportDataIn[0]['City'] }} - {{ date('d M, Y', strtotime($inComingSegment['DepartureDateTime'])) }}</p>
                                    <div class="flightDetailsInfo col-sm-12">
                                        <div class="flightDetailsRow  col-sm-12">
                                            <p class="makeFlex hrtlCenter appendBottom20 gap-x-10">
                                                <span class="icon32 bgProperties" style="background-image: url('{{  isset($airlineDataIn[0]) ? $airlineDataIn[0]['AirLineLogo'] : '' }}');"></span><span>
                                                    <span color="#000000"><b>{{ isset($airlineDataIn[0]) ? $airlineDataIn[0]['AirLineName']  : '' }}</b></span>
                                                    <span color="#6d7278">{{ $airlineCodeIn }} | {{ $inComingSegment['FlightNumber']}}</span>

                                                    <span class="fontSize12">
                                                        ({{ isset($InComing['ResBookDesigCode']) ? $InComing['ResBookDesigCode'] : '' }})
                                                    </span>
                                                </span>
                                            </p>
                                            <div class="makeFlex flightDtlInfo  col-sm-12">
                                                <div class="airlineInfo gap-x-10  col-sm-6">
                                                    <div class="airlineDTInfoCol  col-sm-4">
                                                        <p class="fontSize18 blackText blackFont">{{ date('H:i', strtotime($inComingSegment['DepartureDateTime'])) }}
                                                        </p>
                                                        <p  class="fontSize12 blackText boldFont appendBottom8">{{ date('d M, Y', strtotime($inComingSegment['DepartureDateTime'])) }}</p>
                                                        <p class="fontSize12">{{ $deptAirportDataIn[0]['City'] }}, {{ $deptAirportDataIn[0]['Country'] }}</p>
                                                    </div>
                                                    <div class="airlineDtlDuration fontSize12  col-sm-4">{{ convertToHoursMins($inComingSegment['JourneyDuration']) }}
                                                        <br>
                                                        @php 
                                                            if(isset($InComing['SeatsRemaining'])){
                                                                echo '<span class="seat-remaining">(Seats Remaining - '.$InComing['SeatsRemaining']['Number'].')</span>';
                                                            }

                                                        @endphp

                                                    
                                                        <div class="relative fliStopsSep">
                                                            <p class="fliStopsSepLine"
                                                                style="border-top: 3px solid rgb(81, 226, 194);">
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="airlineDTInfoCol  col-sm-4">
                                                        <p class="fontSize18 blackText blackFont">{{ date('H:i', strtotime($inComingSegment['ArrivalDateTime'])) }} </p>
                                                        <p class="fontSize12 blackText boldFont appendBottom8">{{ date('d M, Y', strtotime($inComingSegment['ArrivalDateTime'])) }}</p>
                                                        <p class="fontSize12">{{ $arrAirportDataIn[0]['City'] }}, {{ $arrAirportDataIn[0]['Country'] }}</p>
                                                    </div>
                                                </div>
                                                <div class="baggageInfo  col-sm-6">
                                                    <p class="makeFlex spaceBetween appendBottom3 fontSize14">
                                                        <span class=" col-sm-4 baggageInfoText blackFont">BAGGAGE : </span>
                                                        <span class=" col-sm-4 baggageInfoText blackFont text-center">CHECK IN</span>
                                                        <span class=" col-sm-4 baggageInfoText blackFont text-center">CABIN</span>
                                                    </p>

                                                    @php  
                                                        $bagKey = $airlineCodeIn.'_'.$inDepAirCode.'_'.$inArrAirCode;
                                                        $flightBaggageIn = $data['flightBaggageIn'];
                                                    
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
                                        @if(array_key_exists($inArrAirCode, $data['layoversIn']))
                                        <div class="flightLayoverOuter">
                                            <div class="flightLayover mmtConnectLayover">
                                                <div class="makeFlex fontSize14">
                                                    <p> <span style="color: #5d8f3a;">Change of planes</span> <b>{{ convertToHoursMins($data['layoversIn'][$inArrAirCode]) }}</b> Layover in {{ $arrAirportDataIn[0]['City'] }}</p>
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
                @else
                    @php  $flightsOutgoing   = $data['flightsOutgoing'];  @endphp
                    @foreach($flightsOutgoing as $outGoing)
                        @php   
                            $outGoingSegment = $outGoing['FlightSegment'];
                            $outDepAirCode = $outGoingSegment['DepartureAirportLocationCode'];
                            $deptAirportData = getAirportData($outDepAirCode);

                            $outArrAirCode = $outGoingSegment['ArrivalAirportLocationCode'];
                            $arrAirportData = getAirportData($outArrAirCode);

                            $airlineCode = $outGoingSegment['MarketingAirlineCode'];
                            $airlineData = getAirlineData($airlineCode);
                        @endphp
                        <div class="flightDetails">
                            <p class="flightDetailsHead">{{ $deptAirportData[0]['City'] }} to {{ $arrAirportData[0]['City'] }} - {{ date('d M, Y', strtotime($outGoingSegment['DepartureDateTime'])) }}</p>
                            <div class="flightDetailsInfo col-sm-12">
                                <div class="flightDetailsRow  col-sm-12">
                                    <p class="makeFlex hrtlCenter appendBottom20 gap-x-10">
                                        <span class="icon32 bgProperties" style="background-image: url('{{ isset($airlineData[0]) ? $airlineData[0]['AirLineLogo'] : '' }}');"></span><span>
                                            <span color="#000000"><b>{{ isset($airlineData[0]) ? $airlineData[0]['AirLineName']  : '' }}</b></span>
                                            <span color="#6d7278">{{ $airlineCode }} | {{ $outGoingSegment['FlightNumber']}}</span>
                                            <span class="fontSize12">
                                                ({{ isset($outGoing['ResBookDesigCode']) ? $outGoing['ResBookDesigCode'] : '' }})
                                            </span>

                                        </span>
                                    </p>
                                    <div class="makeFlex flightDtlInfo  col-sm-12">
                                        <div class="airlineInfo gap-x-10  col-sm-6">
                                            <div class="airlineDTInfoCol  col-sm-4">
                                                <p class="fontSize18 blackText blackFont">{{ date('H:i', strtotime($outGoingSegment['DepartureDateTime'])) }}
                                                </p>
                                                <p  class="fontSize12 blackText boldFont appendBottom8">{{ date('d M, Y', strtotime($outGoingSegment['DepartureDateTime'])) }}</p>
                                                <p class="fontSize12">{{ $deptAirportData[0]['City'] }}, {{ $deptAirportData[0]['Country'] }}</p>
                                            </div>
                                            <div class="airlineDtlDuration fontSize12  col-sm-4">{{ convertToHoursMins($outGoingSegment['JourneyDuration']) }}
                                                <br> 
                                                    @php 
                                                        if(isset($outGoing['SeatsRemaining'])){
                                                            echo '<span class="seat-remaining">(Seats Remaining - '.$outGoing['SeatsRemaining']['Number'].')</span>';
                                                        }

                                                    @endphp

                                                <div class="relative fliStopsSep">
                                                    <p class="fliStopsSepLine"
                                                        style="border-top: 3px solid rgb(81, 226, 194);">
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="airlineDTInfoCol  col-sm-4">
                                                <p class="fontSize18 blackText blackFont">{{ date('H:i', strtotime($outGoingSegment['ArrivalDateTime'])) }} </p>
                                                <p class="fontSize12 blackText boldFont appendBottom8">{{ date('d M, Y', strtotime($outGoingSegment['ArrivalDateTime'])) }}</p>
                                                <p class="fontSize12">{{ $arrAirportData[0]['City'] }}, {{ $arrAirportData[0]['Country'] }}</p>
                                            </div>
                                        </div>
                                        <div class="baggageInfo  col-sm-6">
                                            <p class="makeFlex spaceBetween appendBottom3 fontSize14">
                                                <span class=" col-sm-4 baggageInfoText blackFont">BAGGAGE : </span>
                                                <span class=" col-sm-4 baggageInfoText blackFont text-center">CHECK IN</span>
                                                <span class=" col-sm-4 baggageInfoText blackFont text-center">CABIN</span>
                                            </p>

                                            @php  
                                                $bagKey = $airlineCode.'_'.$outDepAirCode.'_'.$outArrAirCode;
                                            @endphp
                                            @if(array_key_exists($bagKey, $data['flightBaggageOut']))
                                                @foreach($data['flightBaggageOut'][$bagKey] as $bagKey=>$bagData)
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
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="tab-pane" id="fare_details_{{$data['id']}}" role="tabpanel" aria-labelledby="profile-tab">
                <div id="flightDetailsTab-29-tabpane-2" aria-labelledby="flightDetailsTab-29-tab-2" role="tabpanel" aria-hidden="false" class="fade tab-pane active show">
                    <div class="flightDetails">
                        <p class="flightDetailsHead">Fare Breakup</p>
                        <!-- $totalBaseMargin = (($fareBase['Amount']/100) * $totalmargin) + $fareBase['Amount']; -->
                        @php   
                            $fareTotal = $data['totalFare'];
                            $fareBase = $fareTotal['BaseFare'];
                            $fareTax = $fareTotal['TotalTax'];

                            $totalFares = $fareTotal['TotalFare'];
                            $totalFareAmount = $totalFares['Amount'];
                            $currency = $totalFares['CurrencyCode'];
                            $totalFareMargin = (($totalFareAmount/100) * $totalmargin) + $totalFareAmount;
                            $totalFareMargin = number_format(floor($totalFareMargin*100)/100, 2, '.', '');
                            
                            $totalBaseMargin = (($fareBase['Amount']/100) * $totalmargin) + $fareBase['Amount'];
                            $totalBaseMargin = number_format(floor($totalBaseMargin*100)/100, 2, '.', '');

                            $totalTaxMargin = (($fareTax['Amount']/100) * $totalmargin) + $fareTax['Amount'];
                            $totalTaxMargin = number_format(floor($totalTaxMargin*100)/100, 2, '.', '');
                        @endphp
                        <div class="flightDetailsInfo">
                            <p class="appendBottom8 fontSize12">
                                <span class="fareBreakupText"  style="font-size: 14px; color: rgb(0, 0, 0);">TOTAL</span>
                                <span style="font-size: 14px; color: rgb(0, 0, 0);">{{ $currency }} {{$totalFareMargin}}</span>
                            </p>
                            <p class="appendBottom8 fontSize12">
                                <span class="fareBreakupText" style="color: rgb(135, 135, 135);"> Base Fare </span>
                                <span style="color: rgb(135, 135, 135);">{{$currency}} {{ $totalBaseMargin }}</span>
                            </p>
                            <p class="appendBottom8 fontSize12">
                                <span class="fareBreakupText" style="color: rgb(135, 135, 135);">Tax</span>
                                <span style="color: rgb(135, 135, 135);">{{$currency}} {{$totalTaxMargin}}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endisset
        <!-- <div class="tab-pane" id="messages" role="tabpanel"
            aria-labelledby="messages-tab">...</div>
        <div class="tab-pane" id="settings" role="tabpanel"
            aria-labelledby="settings-tab">...</div> -->
    </div>

</div>