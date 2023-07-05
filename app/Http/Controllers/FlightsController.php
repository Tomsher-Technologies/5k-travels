<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Airports;
use App\Models\Airlines;
use App\Models\Countries;
use App\Models\FlightBookings;
use App\Models\FlightPassengers;
use App\Models\FlightItineraryDetails;
use App;
use Session;
use Helper;
use DB;

class FlightsController extends Controller
{
    protected  $options = [];
    /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct()
    {
        if (App::environment('local')) {
            $this->options = ['verify'=>false];
        }
    }
    public function index(){
        return  view('web.index');
    }

    public function dashboard(){
        return  view('web.index');
    }

    public function search(Request $request){
        $airports = Airports::select('id', 'AirportCode', 'AirportName', 'City', 'Country')
                            ->orderBy('City','ASC')
                            ->get();
        //     echo '<pre>';
        //     print_r($request->all());
        //    die;
        

        $mFrom = $request->mFrom;
        $mTo = $request->mTo;
        $mDate = $request->mDate;
        $adult = $child = $infant = 0;
        $cabinClass = '';
        if($request->search_type == 'OneWay'){
            Session::put('flight_search_oneway', $request->all());
            $originDestinationInfo[] = [
                "departureDate"=> $request->oDate,
                "airportOriginCode"=> $request->oFrom,
                "airportDestinationCode"=> $request->oTo
            ];
            
            $adult = $request->oAdult;
            $child = $request->oChild;
            $infant = $request->oInfant;
            $cabinClass = $request->oClass;

            $airlineFilters = ($request->oairline_filter != '') ? explode(',', rtrim($request->oairline_filter, ',')) : array();
            $stopFilters = ($request->ostop_filter != '') ? explode(',', rtrim($request->ostop_filter, ',')) : array();
            $refundFilter = ($request->orefund_filter != '') ?  explode(',', rtrim($request->orefund_filter, ',')) : array();
            $isFilter  = 0;
            if(!empty($airlineFilters) || !empty($stopFilters) || !empty($refundFilter)){
                $isFilter = 1;
            }

        }elseif($request->search_type == 'Return'){
            Session::put('flight_search_return', $request->all());
            $originDestinationInfo[] = [
                "departureDate"=> $request->rDate,
                "returnDate" => $request->rReturnDate,
                "airportOriginCode"=> $request->rFrom,
                "airportDestinationCode"=> $request->rTo
            ];
            $adult = $request->rAdult;
            $child = $request->rChild;
            $infant = $request->rInfant;
            $cabinClass = $request->rClass;

            $airlineFilters = ($request->rairline_filter != '') ? explode(',', rtrim($request->rairline_filter, ',')) : array();
            $stopFilters = ($request->rstop_filter != '') ? explode(',', rtrim($request->rstop_filter, ',')) : array();
            $refundFilter = ($request->rrefund_filter != '') ?  explode(',', rtrim($request->rrefund_filter, ',')) : array();
            $isFilter  = 0;
            if(!empty($airlineFilters) || !empty($stopFilters) || !empty($refundFilter)){
                $isFilter = 1;
            }

        }elseif($request->search_type == 'Circle'){
            Session::put('flight_search_multi', $request->all());

            $multiCount = count($request->mFrom);
            for($i=0; $i<$multiCount; $i++){
                $originDestinationInfo[] = [
                    "departureDate"=> $mDate[$i],
                    "airportOriginCode"=> $mFrom[$i],
                    "airportDestinationCode"=> $mTo[$i]
                ];
            }
            $adult = $request->mAdult;
            $child = $request->mChild;
            $infant = $request->mInfant;
            $cabinClass = $request->mClass;

            $airlineFilters = ($request->mairline_filter != '') ? explode(',', rtrim($request->mairline_filter, ',')) : array();
            $stopFilters = ($request->mstop_filter != '') ? explode(',', rtrim($request->mstop_filter, ',')) : array();
            $refundFilter = ($request->mrefund_filter != '') ?  explode(',', rtrim($request->mrefund_filter, ',')) : array();
            $isFilter  = 0;
            if(!empty($airlineFilters) || !empty($stopFilters) || !empty($refundFilter)){
                $isFilter = 1;
            }
        }
        // print_r($request->session()->get('flight_search_oneway'));
        // // echo json_encode($originDestinationInfo);
        // die;
        
        $data = $flightCodes = [];
        $data['flightData'] = Airlines::get()->keyBy('AirLineCode')->toArray();

        $data['airports'] = Airports::get()->keyBy('AirportCode')->toArray();
       
        $response = Http::timeout(300)->withOptions($this->options)->post(config('global.api_base_url').'availability', [
                                                    "user_id"=> config('global.api_user_id'),
                                                    "user_password"=> config('global.api_user_password'),
                                                    "access"=> config('global.api_access'),
                                                    "ip_address"=> config('global.api_ip_address'),
                                                    "requiredCurrency"=> config('global.api_requiredCurrency'),
                                                    "journeyType"=> $request->search_type,
                                                    "OriginDestinationInfo"=> $originDestinationInfo,
                                                    "class"=> $cabinClass,
                                                    // "airlineCode"=> "QR",
                                                    "adults"=> (int)$adult,
                                                    "childs"=> (int)$child,
                                                    "infants"=> (int)$infant,
                                                    "directFlight" => (isset($request->direct) ? 1 : 0)
                                                ]);
        
        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);
        // echo '<pre>';
        // // print_r($request->all());
        // print_r($result);
        // die;
        $data['session_id'] = isset($result['AirSearchResponse']['session_id']) ? $result['AirSearchResponse']['session_id'] : '';
        $one_stop = $two_stop = $three_stop = $non_stop = $refund = $no_refund = 0;
        $flights = $flightsIn = [];
        $flightDetails = isset($result['AirSearchResponse']['AirSearchResult']['FareItineraries']) ? $result['AirSearchResponse']['AirSearchResult']['FareItineraries'] : array();
        /*================================================  One Way =============================================================*/
        if($request->search_type == 'OneWay'){
            if($flightDetails){
                $loop = 0;
                $unsetLoops = array();
                $airLoops = array();
                $stopsLoop = $refundLoop = array();
                foreach($flightDetails as $fd){
                    // echo '<br><br>Normal loop  ==== '.$loop;
                    $refundStatus = $fd['FareItinerary']['AirItineraryFareInfo']['IsRefundable'];
                    $flights[$loop]['FareSourceCode'] = $fd['FareItinerary']['AirItineraryFareInfo']['FareSourceCode'];
                    $flights[$loop]['FareType'] = $fd['FareItinerary']['AirItineraryFareInfo']['FareType'];
                    $flights[$loop]['IsRefundable'] = $refundStatus;
                    $flights[$loop]['TotalFares'] = $fd['FareItinerary']['AirItineraryFareInfo']['ItinTotalFares'];
                    $flights[$loop]['DirectionInd'] = $fd['FareItinerary']['DirectionInd'];
    
                    $baggage = [];
                    foreach($fd['FareItinerary']['AirItineraryFareInfo']['FareBreakdown'] as $fareBreak){
                        $baggage[$fareBreak['PassengerTypeQuantity']['Code']]['Baggage'] = $fareBreak['Baggage'];
                        $baggage[$fareBreak['PassengerTypeQuantity']['Code']]['CabinBaggage'] = $fareBreak['CabinBaggage'];
                    }
                    $flights[$loop]['Baggage'] = $baggage;
    
                    if(strtolower($refundStatus) == 'no' || strtolower($refundStatus) == false){
                        $no_refund++;
                    }else{
                        $refund++;
                    }
            
                    $totalStopsCount = $fd['FareItinerary']['OriginDestinationOptions'][0]['TotalStops'];
                    // print_r($stopFilters);
                    
                    if($totalStopsCount == 0){
                        $non_stop++;
                    }elseif($totalStopsCount == 1){
                        $one_stop++;
                    }elseif($totalStopsCount == 2){
                        $two_stop++;
                    }elseif($totalStopsCount == 3){
                        $three_stop++;
                    }
    
                    $flights[$loop]['totalOutStops'] = $totalStopsCount;
                    $flights[$loop]['OriginDestinationOptionsOutbound'] = $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'];
                        
                    $layover = [];
                    $journeyDurations = 0;
                    $flightBaggage = [];
                    // echo '<br><br><br> Mian loop ======== '.$loop;
                    // echo '<br>Total Stops ====== '.$totalStopsCount;
                    
                    for($i=0; $i <= $totalStopsCount; $i++){
                        $journeyDurations += $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'][$i]['FlightSegment']['JourneyDuration'];
                        $flightSegment = $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'];
                        if($totalStopsCount > 0){
                            if($i != 0 ){
                                // if($flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode'] == $flightSegment[$i-1]['FlightSegment']['ArrivalAirportLocationCode']){
                                    $timeInMin = getTimeDiffInMInutes($flightSegment[$i-1]['FlightSegment']['ArrivalDateTime'], $flightSegment[$i]['FlightSegment']['DepartureDateTime']);
                                    $layover[$flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode']] = $timeInMin;
                                    $layover['place'][] = $data['airports'][$flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode']]['City'];
                                    $layover['duration'][] = $timeInMin;                                
                                // }
                            }
                        }
                        $airlineCode = $flightSegment[$i]['FlightSegment']['MarketingAirlineCode'];
                        $flightCodes [] = $airlineCode;
                        $data['airlines'][$airlineCode] = isset($data['airlines'][$airlineCode]) ? ($data['airlines'][$airlineCode] + 1) : 1;

                        $originCode = $flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode'];
                        $destinationCode = $flightSegment[$i]['FlightSegment']['ArrivalAirportLocationCode'];
                        
                        if(!empty($airlineFilters) && in_array($airlineCode, $airlineFilters)){
                            $unsetLoops[] = $loop;
                        }
                        foreach($baggage as $key=>$value){
                            $flightBaggage[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['baggage'] = $value['Baggage'][$i];
                            $flightBaggage[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['cabin_baggage'] = $value['CabinBaggage'][$i];
                        }
                    }
                       
                    if($totalStopsCount == 0){
                        $totalDuration = $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'][0]['FlightSegment']['JourneyDuration'];
                    }else{
                        $totalDuration = (isset($layover['duration'])) ? array_sum($layover['duration']) + $journeyDurations : $journeyDurations;
                    }
                    $flights[$loop]['totalDuration'] = $totalDuration;
                    $flights[$loop]['layovers'] = $layover;
                    $flights[$loop]['flightBaggage'] = $flightBaggage;
                       
                    // print_r($unsetLoops);
                    if(!empty($stopFilters) && in_array($totalStopsCount, $stopFilters)){
                        $stopsLoop[] = $loop;
                    
                    }
                    if(!empty($refundFilter) && in_array(strtolower($refundStatus), $refundFilter)){
                        $refundLoop[] = $loop;
                    }
                    $loop++; 
                }
                $filterArrays[] = $unsetLoops;
                $filterArrays[] = $stopsLoop;
                $filterArrays[] = $refundLoop;
                $filterArrays = array_filter($filterArrays);
                $common = array();
                if(empty($airlineFilters) && empty($stopFilters) && empty($refundFilter)){
                    $common = array();
                }
                elseif(!empty($airlineFilters) && !empty($stopFilters) && !empty($refundFilter)){
                    $common = array_intersect($unsetLoops, $stopsLoop, $refundLoop);
                }
                elseif(!empty($airlineFilters) && !empty($stopFilters) && empty($refundFilter)){
                    $common = array_intersect($unsetLoops, $stopsLoop);
                }
                elseif((!empty($airlineFilters) && empty($stopFilters) && !empty($refundFilter))){
                    $common = array_intersect($unsetLoops, $refundLoop);
                }
                elseif(empty($airlineFilters) && !empty($stopFilters) && !empty($refundFilter)){
                    $common = array_intersect($stopsLoop, $refundLoop);
                }
                elseif(!empty($airlineFilters) && empty($stopFilters) && empty($refundFilter)){
                    $common = $unsetLoops;
                }
                elseif(empty($airlineFilters) && !empty($stopFilters) && empty($refundFilter)){
                    $common = $stopsLoop;
                }
                elseif(empty($airlineFilters) && empty($stopFilters) && !empty($refundFilter)){
                    $common = $refundLoop;
                }
               
                // print_r($common);
                $flights = ($isFilter == 0) ? $flights : ( (!empty($common)) ? array_intersect_key($flights, array_flip($common)) : array());
            }
        }
        /*================================================  Round/Return =============================================================*/
        else if($request->search_type == 'Return'){
            $flightDetailsInbound = isset($result['AirSearchResponse']['AirSearchResultInbound']['FareItineraries']) ? $result['AirSearchResponse']['AirSearchResultInbound']['FareItineraries'] : array();
            if(!empty($flightDetailsInbound)){
                if($flightDetails){
                    $loop = 0;
                    $unsetLoops = array();
                    $airLoops = array();
                    $stopsLoop = $refundLoop = array();
                    foreach($flightDetails as $fd){
                        // echo '<br><br>Normal loop  ==== '.$loop;
                        $refundStatus = $fd['FareItinerary']['AirItineraryFareInfo']['IsRefundable'];
                        $flights[$loop]['FareSourceCode'] = $fd['FareItinerary']['AirItineraryFareInfo']['FareSourceCode'];
                        $flights[$loop]['FareType'] = $fd['FareItinerary']['AirItineraryFareInfo']['FareType'];
                        $flights[$loop]['IsRefundable'] = $refundStatus;
                        $flights[$loop]['TotalFares'] = $fd['FareItinerary']['AirItineraryFareInfo']['ItinTotalFares'];
                        $flights[$loop]['DirectionInd'] = $fd['FareItinerary']['DirectionInd'];
        
                        $baggage = [];
                        foreach($fd['FareItinerary']['AirItineraryFareInfo']['FareBreakdown'] as $fareBreak){
                            $baggage[$fareBreak['PassengerTypeQuantity']['Code']]['Baggage'] = $fareBreak['Baggage'];
                            $baggage[$fareBreak['PassengerTypeQuantity']['Code']]['CabinBaggage'] = $fareBreak['CabinBaggage'];
                        }
                        $flights[$loop]['Baggage'] = $baggage;
        
                        if(strtolower($refundStatus) == 'no' || strtolower($refundStatus) == false){
                            $no_refund++;
                        }else{
                            $refund++;
                        }
                
                        $totalStopsOutCount = $fd['FareItinerary']['OriginDestinationOptions'][0]['TotalStops'];
                        if($totalStopsOutCount == 0){
                            $non_stop++;
                        }elseif($totalStopsOutCount == 1){
                            $one_stop++;
                        }elseif($totalStopsOutCount == 2){
                            $two_stop++;
                        }elseif($totalStopsOutCount == 3){
                            $three_stop++;
                        }
        
                        $flights[$loop]['totalOutStops'] = $totalStopsOutCount;
                        $flights[$loop]['OriginDestinationOptionsOutbound'] = $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'];
                        
                        $layover = [];
                        $journeyDurations = 0;
                        $bagCount = 0;
                        $flightBaggage = [];
                        for($i=0; $i <= $totalStopsOutCount; $i++){
                            $journeyDurations += $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'][$i]['FlightSegment']['JourneyDuration'];
                            $flightSegment = $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'];
                            if($totalStopsOutCount > 0){
                                if($i != 0){
                                    // if($flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode'] == $flightSegment[$i-1]['FlightSegment']['ArrivalAirportLocationCode']){

                                        $timeInMin = getTimeDiffInMInutes($flightSegment[$i-1]['FlightSegment']['ArrivalDateTime'], $flightSegment[$i]['FlightSegment']['DepartureDateTime']);
                                        $layover[$flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode']] = $timeInMin;
                                        $layover['place'][] = $data['airports'][$flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode']]['City'];
                                        $layover['duration'][] = $timeInMin;    
                                    // }
                                }
                            }
                            $airlineCode = $flightSegment[$i]['FlightSegment']['MarketingAirlineCode'];
                            $flightCodes [] = $airlineCode;
                            $data['airlines'][$airlineCode] = isset($data['airlines'][$airlineCode]) ? ($data['airlines'][$airlineCode] + 1) : 1;

                            $originCode = $flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode'];
                            $destinationCode = $flightSegment[$i]['FlightSegment']['ArrivalAirportLocationCode'];
                            
                            foreach($baggage as $key=>$value){
                                $flightBaggage[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['baggage'] = $value['Baggage'][$bagCount];
                                $flightBaggage[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['cabin_baggage'] = $value['CabinBaggage'][$bagCount];
                            }
                            $bagCount = $bagCount + 1;
                            if(!empty($airlineFilters) && in_array($airlineCode, $airlineFilters)){
                                $unsetLoops[] = $loop;
                            }
                        }

                        if($totalStopsOutCount == 0){
                            $totalDuration = $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'][0]['FlightSegment']['JourneyDuration'];
                        }else{
                            $totalDuration = array_sum($layover['duration']) + $journeyDurations;
                        }

                        $flights[$loop]['totalDuration'] = $totalDuration;
                        $flights[$loop]['layovers'] = $layover;
                        $flights[$loop]['flightBaggage'] = $flightBaggage;

                        if(!empty($stopFilters) && (in_array($totalStopsOutCount, $stopFilters))){
                            $stopsLoop[] = $loop;
                        }
                        if(!empty($refundFilter) && in_array(strtolower($refundStatus), $refundFilter)){
                            $refundLoop[] = $loop;
                        }
                        $loop++;
                    }
                    
                    $filterArrays[] = $unsetLoops;
                    $filterArrays[] = $stopsLoop;
                    $filterArrays[] = $refundLoop;
                    $filterArrays = array_filter($filterArrays);
                    $common = array();
                    if(empty($airlineFilters) && empty($stopFilters) && empty($refundFilter)){
                        $common = array();
                    }
                    elseif(!empty($airlineFilters) && !empty($stopFilters) && !empty($refundFilter)){
                        $common = array_intersect($unsetLoops, $stopsLoop, $refundLoop);
                    }
                    elseif(!empty($airlineFilters) && !empty($stopFilters) && empty($refundFilter)){
                        $common = array_intersect($unsetLoops, $stopsLoop);
                    }
                    elseif((!empty($airlineFilters) && empty($stopFilters) && !empty($refundFilter))){
                        $common = array_intersect($unsetLoops, $refundLoop);
                    }
                    elseif(empty($airlineFilters) && !empty($stopFilters) && !empty($refundFilter)){
                        $common = array_intersect($stopsLoop, $refundLoop);
                    }
                    elseif(!empty($airlineFilters) && empty($stopFilters) && empty($refundFilter)){
                        $common = $unsetLoops;
                    }
                    elseif(empty($airlineFilters) && !empty($stopFilters) && empty($refundFilter)){
                        $common = $stopsLoop;
                    }
                    elseif(empty($airlineFilters) && empty($stopFilters) && !empty($refundFilter)){
                        $common = $refundLoop;
                    }
                
                    $flights = ($isFilter == 0) ? $flights : ( (!empty($common)) ? array_intersect_key($flights, array_flip($common)) : array());
                }
                if($flightDetailsInbound){
                    $loopIn = 0;
                    $unsetLoopsIn = array();
                    $airLoopsIn = array();
                    $stopsLoopIn = $refundLoopIn = array();
                    foreach($flightDetailsInbound as $fdIn){
                        // echo '<br><br>Normal loop  ==== '.$loop;
                        $refundStatusIn = $fdIn['FareItinerary']['AirItineraryFareInfo']['IsRefundable'];
                        $flightsIn[$loopIn]['FareSourceCode'] = $fdIn['FareItinerary']['AirItineraryFareInfo']['FareSourceCode'];
                        $flightsIn[$loopIn]['FareType'] = $fdIn['FareItinerary']['AirItineraryFareInfo']['FareType'];
                        $flightsIn[$loopIn]['IsRefundable'] = $refundStatusIn;
                        $flightsIn[$loopIn]['TotalFares'] = $fdIn['FareItinerary']['AirItineraryFareInfo']['ItinTotalFares'];
                        $flightsIn[$loopIn]['DirectionInd'] = $fdIn['FareItinerary']['DirectionInd'];
        
                        $baggageIn = [];
                        foreach($fdIn['FareItinerary']['AirItineraryFareInfo']['FareBreakdown'] as $fareBreakIn){
                            $baggageIn[$fareBreakIn['PassengerTypeQuantity']['Code']]['Baggage'] = $fareBreakIn['Baggage'];
                            $baggageIn[$fareBreakIn['PassengerTypeQuantity']['Code']]['CabinBaggage'] = $fareBreakIn['CabinBaggage'];
                        }
                        $flightsIn[$loopIn]['Baggage'] = $baggageIn;
        
                        if(strtolower($refundStatusIn) == 'no' || strtolower($refundStatusIn) == false){
                            $no_refund++;
                        }else{
                            $refund++;
                        }
                            
                        $totalStopsInCount = $fdIn['FareItinerary']['OriginDestinationOptions'][0]['TotalStops'];
                        if($totalStopsInCount == 0){
                            $non_stop++;
                        }elseif($totalStopsInCount == 1){
                            $one_stop++;
                        }elseif($totalStopsInCount == 2){
                            $two_stop++;
                        }elseif($totalStopsInCount == 3){
                            $three_stop++;
                        }
        
                        $flightsIn[$loopIn]['totalInStops'] = $totalStopsInCount;
                        $flightsIn[$loopIn]['OriginDestinationOptionsInbound'] = $fdIn['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'];
        
                        $layoverIn = [];
                        $journeyDurationsIn = 0;
                        $bagCountIn = 0;
                        $flightBaggageIn = [];
                        for($j=0; $j <= $totalStopsInCount; $j++){
                            $journeyDurationsIn += $fdIn['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'][$j]['FlightSegment']['JourneyDuration'];
                            $flightSegmentIn = $fdIn['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'];
                            if($totalStopsInCount > 0){
                                if($j != 0){
                                    // if($flightSegmentIn[$j]['FlightSegment']['DepartureAirportLocationCode'] == $flightSegmentIn[$j-1]['FlightSegment']['ArrivalAirportLocationCode']){

                                        $timeInMinIn = getTimeDiffInMInutes($flightSegmentIn[$j-1]['FlightSegment']['ArrivalDateTime'], $flightSegmentIn[$j]['FlightSegment']['DepartureDateTime']);
                                        $layoverIn[$flightSegmentIn[$j]['FlightSegment']['DepartureAirportLocationCode']] = $timeInMinIn;
                                        $layoverIn['place'][] = $data['airports'][$flightSegmentIn[$j]['FlightSegment']['DepartureAirportLocationCode']]['City'];
                                        $layoverIn['duration'][] = $timeInMinIn;                               
                                    // }
                                }
                            }
                            $airlineCodeIn = $flightSegmentIn[$j]['FlightSegment']['MarketingAirlineCode'];
                            $flightCodesIn [] = $airlineCodeIn;
                            $data['airlines'][$airlineCodeIn] = isset($data['airlines'][$airlineCodeIn]) ? ($data['airlines'][$airlineCodeIn] + 1) : 1;

                            $originCodeIn = $flightSegmentIn[$j]['FlightSegment']['DepartureAirportLocationCode'];
                            $destinationCodeIn = $flightSegmentIn[$j]['FlightSegment']['ArrivalAirportLocationCode'];
                            
                            foreach($baggage as $keyIn=>$valueIn){
                                $flightBaggageIn[$airlineCodeIn.'_'.$originCodeIn.'_'.$destinationCodeIn][$keyIn]['baggage'] = $valueIn['Baggage'][$bagCountIn];
                                $flightBaggageIn[$airlineCodeIn.'_'.$originCodeIn.'_'.$destinationCodeIn][$keyIn]['cabin_baggage'] = $valueIn['CabinBaggage'][$bagCountIn];
                            }
                            $bagCountIn = $bagCountIn + 1;
                            if(!empty($airlineFilters) && in_array($airlineCodeIn, $airlineFilters)){
                                $unsetLoopsIn[] = $loopIn;
                            }
                        }

                        if($totalStopsInCount == 0){
                            $totalDurationIn = $fdIn['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'][0]['FlightSegment']['JourneyDuration'];
                        }else{
                            $totalDurationIn = array_sum($layoverIn['duration']) + $journeyDurationsIn;
                        }
        
                        $flightsIn[$loopIn]['totalDurationIn'] = $totalDurationIn;
                        $flightsIn[$loopIn]['layoversIn'] = $layoverIn;
                        $flightsIn[$loopIn]['flightBaggageIn'] = $flightBaggageIn;

                        if(!empty($stopFilters) && (in_array($totalStopsInCount, $stopFilters))){
                            $stopsLoopIn[] = $loopIn;
                        }
                        if(!empty($refundFilter) && in_array(strtolower($refundStatusIn), $refundFilter)){
                            $refundLoopIn[] = $loopIn;
                        }
                        
                        $loopIn++;
                    
                    }
                    
                    $filterArraysIn[] = $unsetLoopsIn;
                    $filterArraysIn[] = $stopsLoopIn;
                    $filterArraysIn[] = $refundLoopIn;
                    $filterArraysIn = array_filter($filterArraysIn);
                    $commonIn = array();
                    if(empty($airlineFilters) && empty($stopFilters) && empty($refundFilter)){
                        $commonIn = array();
                    }
                    elseif(!empty($airlineFilters) && !empty($stopFilters) && !empty($refundFilter)){
                        $commonIn = array_intersect($unsetLoopsIn, $stopsLoopIn, $refundLoopIn);
                    }
                    elseif(!empty($airlineFilters) && !empty($stopFilters) && empty($refundFilter)){
                        $commonIn = array_intersect($unsetLoopsIn, $stopsLoopIn);
                    }
                    elseif((!empty($airlineFilters) && empty($stopFilters) && !empty($refundFilter))){
                        $commonIn = array_intersect($unsetLoopsIn, $refundLoopIn);
                    }
                    elseif(empty($airlineFilters) && !empty($stopFilters) && !empty($refundFilter)){
                        $commonIn = array_intersect($stopsLoopIn, $refundLoopIn);
                    }
                    elseif(!empty($airlineFilters) && empty($stopFilters) && empty($refundFilter)){
                        $commonIn = $unsetLoopsIn;
                    }
                    elseif(empty($airlineFilters) && !empty($stopFilters) && empty($refundFilter)){
                        $commonIn = $stopsLoopIn;
                    }
                    elseif(empty($airlineFilters) && empty($stopFilters) && !empty($refundFilter)){
                        $commonIn = $refundLoopIn;
                    }
                
                    $flightsIn = ($isFilter == 0) ? $flightsIn : ( (!empty($commonIn)) ? array_intersect_key($flightsIn, array_flip($commonIn)) : array());
                }
            }else{
                if($flightDetails){
                    $loop = 0;
                    $unsetLoops = array();
                    $airLoops = array();
                    $stopsLoop = $refundLoop = array();
                    foreach($flightDetails as $fd){
                        // echo '<br><br>Normal loop  ==== '.$loop;
                        $refundStatus = $fd['FareItinerary']['AirItineraryFareInfo']['IsRefundable'];
                        $flights[$loop]['FareSourceCode'] = $fd['FareItinerary']['AirItineraryFareInfo']['FareSourceCode'];
                        $flights[$loop]['FareType'] = $fd['FareItinerary']['AirItineraryFareInfo']['FareType'];
                        $flights[$loop]['IsRefundable'] = $refundStatus;
                        $flights[$loop]['TotalFares'] = $fd['FareItinerary']['AirItineraryFareInfo']['ItinTotalFares'];
                        $flights[$loop]['DirectionInd'] = $fd['FareItinerary']['DirectionInd'];
        
                        $baggage = [];
                        foreach($fd['FareItinerary']['AirItineraryFareInfo']['FareBreakdown'] as $fareBreak){
                            $baggage[$fareBreak['PassengerTypeQuantity']['Code']]['Baggage'] = $fareBreak['Baggage'];
                            $baggage[$fareBreak['PassengerTypeQuantity']['Code']]['CabinBaggage'] = $fareBreak['CabinBaggage'];
                        }
                        $flights[$loop]['Baggage'] = $baggage;
        
                        if(strtolower($refundStatus) == 'no' || strtolower($refundStatus) == false){
                            $no_refund++;
                        }else{
                            $refund++;
                        }
                
                            
                        $totalStopsOutCount = $fd['FareItinerary']['OriginDestinationOptions'][0]['TotalStops'];
                        $totalStopsInCount = isset($fd['FareItinerary']['OriginDestinationOptions'][1]) ? $fd['FareItinerary']['OriginDestinationOptions'][1]['TotalStops'] : '';

                        if($totalStopsOutCount == 0){
                            $non_stop++;
                        }elseif($totalStopsOutCount == 1){
                            $one_stop++;
                        }elseif($totalStopsOutCount == 2){
                            $two_stop++;
                        }elseif($totalStopsOutCount == 3){
                            $three_stop++;
                        }
        
                        if($totalStopsInCount == 0){
                            $non_stop++;
                        }elseif($totalStopsInCount == 1){
                            $one_stop++;
                        }elseif($totalStopsInCount == 2){
                            $two_stop++;
                        }elseif($totalStopsInCount == 3){
                            $three_stop++;
                        }
        
                        $flights[$loop]['totalOutStops'] = $totalStopsOutCount;
                        $flights[$loop]['totalInStops'] = $totalStopsInCount;
                        $flights[$loop]['OriginDestinationOptionsOutbound'] = $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'];
                        $flights[$loop]['OriginDestinationOptionsInbound'] = isset($fd['FareItinerary']['OriginDestinationOptions'][1]) ? $fd['FareItinerary']['OriginDestinationOptions'][1]['OriginDestinationOption'] : [];
        
                        $layover = [];
                        $journeyDurations = 0;
                        $bagCount = 0;
                        $flightBaggage = [];
                        for($i=0; $i <= $totalStopsOutCount; $i++){
                            $journeyDurations += $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'][$i]['FlightSegment']['JourneyDuration'];
                            $flightSegment = $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'];
                            if($totalStopsOutCount > 0){
                                if($i != 0){
                                    // if($flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode'] == $flightSegment[$i-1]['FlightSegment']['ArrivalAirportLocationCode']){

                                        $timeInMin = getTimeDiffInMInutes($flightSegment[$i-1]['FlightSegment']['ArrivalDateTime'], $flightSegment[$i]['FlightSegment']['DepartureDateTime']);
                                        $layover[$flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode']] = $timeInMin;
                                        $layover['place'][] = $data['airports'][$flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode']]['City'];
                                        $layover['duration'][] = $timeInMin;    
                                    // }
                                }
                            }
                            $airlineCode = $flightSegment[$i]['FlightSegment']['MarketingAirlineCode'];
                            $flightCodes [] = $airlineCode;
                            $data['airlines'][$airlineCode] = isset($data['airlines'][$airlineCode]) ? ($data['airlines'][$airlineCode] + 1) : 1;

                            $originCode = $flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode'];
                            $destinationCode = $flightSegment[$i]['FlightSegment']['ArrivalAirportLocationCode'];
                            
                            foreach($baggage as $key=>$value){
                                $flightBaggage[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['baggage'] = $value['Baggage'][$bagCount];
                                $flightBaggage[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['cabin_baggage'] = $value['CabinBaggage'][$bagCount];
                            }
                            $bagCount = $bagCount + 1;
                            if(!empty($airlineFilters) && in_array($airlineCode, $airlineFilters)){
                                $unsetLoops[] = $loop;
                            }
                        }

                        if($totalStopsOutCount == 0){
                            $totalDuration = $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'][0]['FlightSegment']['JourneyDuration'];
                        }else{
                            $totalDuration = array_sum($layover['duration']) + $journeyDurations;
                        }


                        $layoverIn = [];
                        $journeyDurationsIn = 0;
                        $flightBaggageIn = [];
                        for($j=0; $j <= $totalStopsInCount; $j++){
                            if(isset($fd['FareItinerary']['OriginDestinationOptions'][1])){
                                $journeyDurationsIn += $fd['FareItinerary']['OriginDestinationOptions'][1]['OriginDestinationOption'][$j]['FlightSegment']['JourneyDuration'];
                                $flightSegment = $fd['FareItinerary']['OriginDestinationOptions'][1]['OriginDestinationOption'];
                                if($totalStopsInCount > 0){
                                    if($j != 0){
                                        // if($flightSegment[$j]['FlightSegment']['DepartureAirportLocationCode'] == $flightSegment[$j-1]['FlightSegment']['ArrivalAirportLocationCode']){

                                            $timeInMin = getTimeDiffInMInutes($flightSegment[$j-1]['FlightSegment']['ArrivalDateTime'], $flightSegment[$j]['FlightSegment']['DepartureDateTime']);
                                            $layoverIn[$flightSegment[$j]['FlightSegment']['DepartureAirportLocationCode']] = $timeInMin;
                                            $layoverIn['place'][] = $data['airports'][$flightSegment[$j]['FlightSegment']['DepartureAirportLocationCode']]['City'];
                                            $layoverIn['duration'][] = $timeInMin;                               
                                        // }
                                    }
                                }
                                $airlineCode = $flightSegment[$j]['FlightSegment']['MarketingAirlineCode'];
                                $flightCodes [] = $airlineCode;
                                $data['airlines'][$airlineCode] = isset($data['airlines'][$airlineCode]) ? ($data['airlines'][$airlineCode] + 1) : 1;

                                $originCode = $flightSegment[$j]['FlightSegment']['DepartureAirportLocationCode'];
                                $destinationCode = $flightSegment[$j]['FlightSegment']['ArrivalAirportLocationCode'];
                                
                                foreach($baggage as $key=>$value){
                                    $flightBaggageIn[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['baggage'] = $value['Baggage'][$bagCount];
                                    $flightBaggageIn[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['cabin_baggage'] = $value['CabinBaggage'][$bagCount];
                                }
                                $bagCount = $bagCount + 1;
                                if(!empty($airlineFilters) && in_array($airlineCode, $airlineFilters)){
                                    $unsetLoops[] = $loop;
                                }
                            }
                        }

                        if($totalStopsInCount == 0){
                            $totalDurationIn = isset($fd['FareItinerary']['OriginDestinationOptions'][1]) ?  $fd['FareItinerary']['OriginDestinationOptions'][1]['OriginDestinationOption'][0]['FlightSegment']['JourneyDuration'] : 0;
                        }else{
                            $totalDurationIn = isset($layoverIn['duration']) ? (array_sum($layoverIn['duration']) + $journeyDurationsIn) : $journeyDurationsIn;
                        }
        
                        $flights[$loop]['totalDurationIn'] = $totalDurationIn;
                        $flights[$loop]['layoversIn'] = $layoverIn;
                        $flights[$loop]['flightBaggageIn'] = $flightBaggageIn;

                        $flights[$loop]['totalDuration'] = $totalDuration;
                        $flights[$loop]['layovers'] = $layover;
                        $flights[$loop]['flightBaggage'] = $flightBaggage;

                        if(!empty($stopFilters) && (in_array($totalStopsOutCount, $stopFilters) || in_array($totalStopsInCount, $stopFilters))){
                            $stopsLoop[] = $loop;
                        }
                        if(!empty($refundFilter) && in_array(strtolower($refundStatus), $refundFilter)){
                            $refundLoop[] = $loop;
                        }
                        
                        $loop++;
                    
                    }
                    
                    $filterArrays[] = $unsetLoops;
                    $filterArrays[] = $stopsLoop;
                    $filterArrays[] = $refundLoop;
                    $filterArrays = array_filter($filterArrays);
                    $common = array();
                    if(empty($airlineFilters) && empty($stopFilters) && empty($refundFilter)){
                        $common = array();
                    }
                    elseif(!empty($airlineFilters) && !empty($stopFilters) && !empty($refundFilter)){
                        $common = array_intersect($unsetLoops, $stopsLoop, $refundLoop);
                    }
                    elseif(!empty($airlineFilters) && !empty($stopFilters) && empty($refundFilter)){
                        $common = array_intersect($unsetLoops, $stopsLoop);
                    }
                    elseif((!empty($airlineFilters) && empty($stopFilters) && !empty($refundFilter))){
                        $common = array_intersect($unsetLoops, $refundLoop);
                    }
                    elseif(empty($airlineFilters) && !empty($stopFilters) && !empty($refundFilter)){
                        $common = array_intersect($stopsLoop, $refundLoop);
                    }
                    elseif(!empty($airlineFilters) && empty($stopFilters) && empty($refundFilter)){
                        $common = $unsetLoops;
                    }
                    elseif(empty($airlineFilters) && !empty($stopFilters) && empty($refundFilter)){
                        $common = $stopsLoop;
                    }
                    elseif(empty($airlineFilters) && empty($stopFilters) && !empty($refundFilter)){
                        $common = $refundLoop;
                    }
                   
                    $flights = ($isFilter == 0) ? $flights : ( (!empty($common)) ? array_intersect_key($flights, array_flip($common)) : array());
                }
            }
        }
        // echo '<pre>';
        // print_r($flights);
        // die;
        $data['search_type'] = $request->search_type;
        $data['non_stop'] = $non_stop;
        $data['one_stop'] = $one_stop;
        $data['two_stop'] = $two_stop;
        $data['three_stop'] = $three_stop;
        $data['refund'] = $refund;
        $data['no_refund'] = $no_refund;

        if($request->search_type == 'Return' && isset($result['AirSearchResponse']['AirSearchResultInbound'])){
            $data['totalCount'] = count($flights) + count($flightsIn);
            $data['flightDetails'] = $flights;
            $data['flightDetailsInbound'] = $flightsIn;
            return  view('web.search_results_domestic',compact('data','airports'));
        }else{
            $data['totalCount'] = count($flights);
            $data['flightDetails'] = $flights;
            return  view('web.search_results',compact('data','airports'));
        }
       
    }

    // public function searchOld(Request $request){
    //     $airports = Airports::select('id', 'AirportCode', 'AirportName', 'City', 'Country')
    //                         ->orderBy('City','ASC')
    //                         ->get();
    //     //     echo '<pre>';
    //     //     print_r($request->all());
    //     //    die;
        

    //     $mFrom = $request->mFrom;
    //     $mTo = $request->mTo;
    //     $mDate = $request->mDate;
    //     $adult = $child = $infant = 0;
    //     $cabinClass = '';
    //     if($request->search_type == 'OneWay'){
    //         Session::put('flight_search_oneway', $request->all());
    //         $originDestinationInfo[] = [
    //             "departureDate"=> $request->oDate,
    //             "airportOriginCode"=> $request->oFrom,
    //             "airportDestinationCode"=> $request->oTo
    //         ];
            
    //         $adult = $request->oAdult;
    //         $child = $request->oChild;
    //         $infant = $request->oInfant;
    //         $cabinClass = $request->oClass;

    //         $airlineFilters = ($request->oairline_filter != '') ? explode(',', rtrim($request->oairline_filter, ',')) : array();
    //         $stopFilters = ($request->ostop_filter != '') ? explode(',', rtrim($request->ostop_filter, ',')) : array();
    //         $refundFilter = ($request->orefund_filter != '') ?  explode(',', rtrim($request->orefund_filter, ',')) : array();
    //         $isFilter  = 0;
    //         if(!empty($airlineFilters) || !empty($stopFilters) || !empty($refundFilter)){
    //             $isFilter = 1;
    //         }

    //     }elseif($request->search_type == 'Return'){
    //         Session::put('flight_search_return', $request->all());
    //         $originDestinationInfo[] = [
    //             "departureDate"=> $request->rDate,
    //             "returnDate" => $request->rReturnDate,
    //             "airportOriginCode"=> $request->rFrom,
    //             "airportDestinationCode"=> $request->rTo
    //         ];
    //         $adult = $request->rAdult;
    //         $child = $request->rChild;
    //         $infant = $request->rInfant;
    //         $cabinClass = $request->rClass;

    //         $airlineFilters = ($request->rairline_filter != '') ? explode(',', rtrim($request->rairline_filter, ',')) : array();
    //         $stopFilters = ($request->rstop_filter != '') ? explode(',', rtrim($request->rstop_filter, ',')) : array();
    //         $refundFilter = ($request->rrefund_filter != '') ?  explode(',', rtrim($request->rrefund_filter, ',')) : array();
    //         $isFilter  = 0;
    //         if(!empty($airlineFilters) || !empty($stopFilters) || !empty($refundFilter)){
    //             $isFilter = 1;
    //         }

    //     }elseif($request->search_type == 'Circle'){
    //         Session::put('flight_search_multi', $request->all());

    //         $multiCount = count($request->mFrom);
    //         for($i=0; $i<$multiCount; $i++){
    //             $originDestinationInfo[] = [
    //                 "departureDate"=> $mDate[$i],
    //                 "airportOriginCode"=> $mFrom[$i],
    //                 "airportDestinationCode"=> $mTo[$i]
    //             ];
    //         }
    //         $adult = $request->mAdult;
    //         $child = $request->mChild;
    //         $infant = $request->mInfant;
    //         $cabinClass = $request->mClass;

    //         $airlineFilters = ($request->mairline_filter != '') ? explode(',', rtrim($request->mairline_filter, ',')) : array();
    //         $stopFilters = ($request->mstop_filter != '') ? explode(',', rtrim($request->mstop_filter, ',')) : array();
    //         $refundFilter = ($request->mrefund_filter != '') ?  explode(',', rtrim($request->mrefund_filter, ',')) : array();
    //         $isFilter  = 0;
    //         if(!empty($airlineFilters) || !empty($stopFilters) || !empty($refundFilter)){
    //             $isFilter = 1;
    //         }
    //     }
    //     // print_r($request->session()->get('flight_search_oneway'));
    //     // // echo json_encode($originDestinationInfo);
    //     // die;
        
    //     $data = $flightCodes = [];
    //     $data['flightData'] = Airlines::get()->keyBy('AirLineCode')->toArray();

    //     $data['airports'] = Airports::get()->keyBy('AirportCode')->toArray();
       
    //     $response = Http::timeout(120)->withOptions($this->options)->post(config('global.api_base_url').'availability', [
    //                                                 "user_id"=> config('global.api_user_id'),
    //                                                 "user_password"=> config('global.api_user_password'),
    //                                                 "access"=> config('global.api_access'),
    //                                                 "ip_address"=> config('global.api_ip_address'),
    //                                                 "requiredCurrency"=> config('global.api_requiredCurrency'),
    //                                                 "journeyType"=> $request->search_type,
    //                                                 "OriginDestinationInfo"=> $originDestinationInfo,
    //                                                 "class"=> $cabinClass,
    //                                                 // "airlineCode"=> "QR",
    //                                                 "adults"=> (int)$adult,
    //                                                 "childs"=> (int)$child,
    //                                                 "infants"=> (int)$infant,
    //                                                 "directFlight" => (isset($request->direct) ? 1 : 0)
    //                                             ]);
        
    //     $result = $response->getBody()->getContents();
    //     $result = json_decode($result, true);
    //     // echo '<pre>';
    //     // // print_r($request->all());
    //     // print_r($result);
    //     // die;
    //     $data['session_id'] = isset($result['AirSearchResponse']['session_id']) ? $result['AirSearchResponse']['session_id'] : '';

    //     $flightDetails = isset($result['AirSearchResponse']['AirSearchResult']['FareItineraries']) ? $result['AirSearchResponse']['AirSearchResult']['FareItineraries'] : array();
        
    //     $one_stop = $two_stop = $three_stop = $non_stop = $refund = $no_refund = 0;
    //     // $one_stop_data = $two_stop_data = $three_stop_data = $non_stop_data = array();
    //     $flights = [];
    //     if($flightDetails){
    //         $loop = 0;
    //         $unsetLoops = array();
    //         $airLoops = array();
    //         $stopsLoop = $refundLoop = array();
    //         foreach($flightDetails as $fd){
    //             // echo '<br><br>Normal loop  ==== '.$loop;
    //             $refundStatus = $fd['FareItinerary']['AirItineraryFareInfo']['IsRefundable'];
    //             $flights[$loop]['FareSourceCode'] = $fd['FareItinerary']['AirItineraryFareInfo']['FareSourceCode'];
    //             $flights[$loop]['FareType'] = $fd['FareItinerary']['AirItineraryFareInfo']['FareType'];
    //             $flights[$loop]['IsRefundable'] = $refundStatus;
    //             $flights[$loop]['TotalFares'] = $fd['FareItinerary']['AirItineraryFareInfo']['ItinTotalFares'];
    //             $flights[$loop]['DirectionInd'] = $fd['FareItinerary']['DirectionInd'];

    //             $baggage = [];
    //             foreach($fd['FareItinerary']['AirItineraryFareInfo']['FareBreakdown'] as $fareBreak){
    //                 $baggage[$fareBreak['PassengerTypeQuantity']['Code']]['Baggage'] = $fareBreak['Baggage'];
    //                 $baggage[$fareBreak['PassengerTypeQuantity']['Code']]['CabinBaggage'] = $fareBreak['CabinBaggage'];
    //             }
    //             $flights[$loop]['Baggage'] = $baggage;

    //             if(strtolower($refundStatus) == 'no' || strtolower($refundStatus) == false){
    //                 $no_refund++;
    //             }else{
    //                 $refund++;
    //             }
        
    //             /*================================================  One Way =============================================================*/
    //             if($fd['FareItinerary']['DirectionInd'] == "OneWay"){  
    //                 $totalStopsCount = $fd['FareItinerary']['OriginDestinationOptions'][0]['TotalStops'];
    //                 // print_r($stopFilters);
                    
    //                 if($totalStopsCount == 0){
    //                     $non_stop++;
    //                 }elseif($totalStopsCount == 1){
    //                     $one_stop++;
    //                 }elseif($totalStopsCount == 2){
    //                     $two_stop++;
    //                 }elseif($totalStopsCount == 3){
    //                     $three_stop++;
    //                 }

    //                 $flights[$loop]['totalOutStops'] = $totalStopsCount;
    //                 $flights[$loop]['OriginDestinationOptionsOutbound'] = $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'];
                    
    //                 $layover = [];
    //                 $journeyDurations = 0;
    //                 $flightBaggage = [];
    //                 // echo '<br><br><br> Mian loop ======== '.$loop;
    //                 // echo '<br>Total Stops ====== '.$totalStopsCount;
                    
    //                 for($i=0; $i <= $totalStopsCount; $i++){
    //                     $journeyDurations += $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'][$i]['FlightSegment']['JourneyDuration'];
    //                     $flightSegment = $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'];
    //                     if($totalStopsCount > 0){
    //                         if($i != 0){
    //                             if($flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode'] == $flightSegment[$i-1]['FlightSegment']['ArrivalAirportLocationCode']){
    //                                 $timeInMin = getTimeDiffInMInutes($flightSegment[$i-1]['FlightSegment']['ArrivalDateTime'], $flightSegment[$i]['FlightSegment']['DepartureDateTime']);
    //                                 $layover[$flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode']] = $timeInMin;
    //                                 $layover['place'][] = $data['airports'][$flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode']]['City'];
    //                                 $layover['duration'][] = $timeInMin;                                
    //                             }
    //                         }
    //                     }
    //                     $airlineCode = $flightSegment[$i]['FlightSegment']['MarketingAirlineCode'];
    //                     $flightCodes [] = $airlineCode;
    //                     $data['airlines'][$airlineCode] = isset($data['airlines'][$airlineCode]) ? ($data['airlines'][$airlineCode] + 1) : 1;

    //                     $originCode = $flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode'];
    //                     $destinationCode = $flightSegment[$i]['FlightSegment']['ArrivalAirportLocationCode'];
                       
    //                     if(!empty($airlineFilters) && in_array($airlineCode, $airlineFilters)){
    //                         $unsetLoops[] = $loop;
    //                     }
    //                     foreach($baggage as $key=>$value){
    //                         $flightBaggage[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['baggage'] = $value['Baggage'][$i];
    //                         $flightBaggage[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['cabin_baggage'] = $value['CabinBaggage'][$i];
    //                     }
    //                 }
                   
    //                 if($totalStopsCount == 0){
    //                     $totalDuration = $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'][0]['FlightSegment']['JourneyDuration'];
    //                 }else{
    //                     $totalDuration = (isset($layover['duration'])) ? array_sum($layover['duration']) + $journeyDurations : $journeyDurations;
    //                 }
    //                 $flights[$loop]['totalDuration'] = $totalDuration;
    //                 $flights[$loop]['layovers'] = $layover;
    //                 $flights[$loop]['flightBaggage'] = $flightBaggage;
                   
    //                 // print_r($unsetLoops);
    //                 if(!empty($stopFilters) && in_array($totalStopsCount, $stopFilters)){
    //                     $stopsLoop[] = $loop;
                    
    //                 }
    //                 if(!empty($refundFilter) && in_array(strtolower($refundStatus), $refundFilter)){
    //                     $refundLoop[] = $loop;
    //                 }
    //             }
    //             /*================================================= Return ===========================================================================*/
    //             elseif($fd['FareItinerary']['DirectionInd'] == "Return"){          
    //                 $totalStopsOutCount = $fd['FareItinerary']['OriginDestinationOptions'][0]['TotalStops'];
    //                 $totalStopsInCount = $fd['FareItinerary']['OriginDestinationOptions'][1]['TotalStops'];

    //                 if($totalStopsOutCount == 0){
    //                     $non_stop++;
    //                 }elseif($totalStopsOutCount == 1){
    //                     $one_stop++;
    //                 }elseif($totalStopsOutCount == 2){
    //                     $two_stop++;
    //                 }elseif($totalStopsOutCount == 3){
    //                     $three_stop++;
    //                 }

    //                 if($totalStopsInCount == 0){
    //                     $non_stop++;
    //                 }elseif($totalStopsInCount == 1){
    //                     $one_stop++;
    //                 }elseif($totalStopsInCount == 2){
    //                     $two_stop++;
    //                 }elseif($totalStopsInCount == 3){
    //                     $three_stop++;
    //                 }

    //                 $flights[$loop]['totalOutStops'] = $totalStopsOutCount;
    //                 $flights[$loop]['totalInStops'] = $totalStopsInCount;
    //                 $flights[$loop]['OriginDestinationOptionsOutbound'] = $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'];
    //                 $flights[$loop]['OriginDestinationOptionsInbound'] = $fd['FareItinerary']['OriginDestinationOptions'][1]['OriginDestinationOption'];

    //                 $layover = [];
    //                 $journeyDurations = 0;
    //                 $bagCount = 0;
    //                 $flightBaggage = [];
    //                 for($i=0; $i <= $totalStopsOutCount; $i++){
    //                     $journeyDurations += $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'][$i]['FlightSegment']['JourneyDuration'];
    //                     $flightSegment = $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'];
    //                     if($totalStopsOutCount > 0){
    //                         if($i != 0){
    //                             if($flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode'] == $flightSegment[$i-1]['FlightSegment']['ArrivalAirportLocationCode']){

    //                                 $timeInMin = getTimeDiffInMInutes($flightSegment[$i-1]['FlightSegment']['ArrivalDateTime'], $flightSegment[$i]['FlightSegment']['DepartureDateTime']);
    //                                 $layover[$flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode']] = $timeInMin;
    //                                 $layover['place'][] = $data['airports'][$flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode']]['City'];
    //                                 $layover['duration'][] = $timeInMin;    
    //                             }
    //                         }
    //                     }
    //                     $airlineCode = $flightSegment[$i]['FlightSegment']['MarketingAirlineCode'];
    //                     $flightCodes [] = $airlineCode;
    //                     $data['airlines'][$airlineCode] = isset($data['airlines'][$airlineCode]) ? ($data['airlines'][$airlineCode] + 1) : 1;

    //                     $originCode = $flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode'];
    //                     $destinationCode = $flightSegment[$i]['FlightSegment']['ArrivalAirportLocationCode'];
                        
    //                     foreach($baggage as $key=>$value){
    //                         $flightBaggage[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['baggage'] = $value['Baggage'][$bagCount];
    //                         $flightBaggage[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['cabin_baggage'] = $value['CabinBaggage'][$bagCount];
    //                     }
    //                     $bagCount = $bagCount + 1;
    //                     if(!empty($airlineFilters) && in_array($airlineCode, $airlineFilters)){
    //                         $unsetLoops[] = $loop;
    //                     }
    //                 }

    //                 if($totalStopsOutCount == 0){
    //                     $totalDuration = $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'][0]['FlightSegment']['JourneyDuration'];
    //                 }else{
    //                     $totalDuration = array_sum($layover['duration']) + $journeyDurations;
    //                 }


    //                 $layoverIn = [];
    //                 $journeyDurationsIn = 0;
    //                 $flightBaggageIn = [];
    //                 for($j=0; $j <= $totalStopsInCount; $j++){
    //                     $journeyDurationsIn += $fd['FareItinerary']['OriginDestinationOptions'][1]['OriginDestinationOption'][$j]['FlightSegment']['JourneyDuration'];
    //                     $flightSegment = $fd['FareItinerary']['OriginDestinationOptions'][1]['OriginDestinationOption'];
    //                     if($totalStopsInCount > 0){
    //                         if($j != 0){
    //                             if($flightSegment[$j]['FlightSegment']['DepartureAirportLocationCode'] == $flightSegment[$j-1]['FlightSegment']['ArrivalAirportLocationCode']){

    //                                 $timeInMin = getTimeDiffInMInutes($flightSegment[$j-1]['FlightSegment']['ArrivalDateTime'], $flightSegment[$j]['FlightSegment']['DepartureDateTime']);
    //                                 $layoverIn[$flightSegment[$j]['FlightSegment']['DepartureAirportLocationCode']] = $timeInMin;
    //                                 $layoverIn['place'][] = $data['airports'][$flightSegment[$j]['FlightSegment']['DepartureAirportLocationCode']]['City'];
    //                                 $layoverIn['duration'][] = $timeInMin;                               
    //                             }
    //                         }
    //                     }
    //                     $airlineCode = $flightSegment[$j]['FlightSegment']['MarketingAirlineCode'];
    //                     $flightCodes [] = $airlineCode;
    //                     $data['airlines'][$airlineCode] = isset($data['airlines'][$airlineCode]) ? ($data['airlines'][$airlineCode] + 1) : 1;

    //                     $originCode = $flightSegment[$j]['FlightSegment']['DepartureAirportLocationCode'];
    //                     $destinationCode = $flightSegment[$j]['FlightSegment']['ArrivalAirportLocationCode'];
                       
    //                     foreach($baggage as $key=>$value){
    //                         $flightBaggageIn[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['baggage'] = $value['Baggage'][$bagCount];
    //                         $flightBaggageIn[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['cabin_baggage'] = $value['CabinBaggage'][$bagCount];
    //                     }
    //                     $bagCount = $bagCount + 1;
    //                     if(!empty($airlineFilters) && in_array($airlineCode, $airlineFilters)){
    //                         $unsetLoops[] = $loop;
    //                     }
    //                 }

    //                 if($totalStopsInCount == 0){
    //                     $totalDurationIn = $fd['FareItinerary']['OriginDestinationOptions'][1]['OriginDestinationOption'][0]['FlightSegment']['JourneyDuration'];
    //                 }else{
    //                     $totalDurationIn = array_sum($layoverIn['duration']) + $journeyDurationsIn;
    //                 }

    //                 $flights[$loop]['totalDurationIn'] = $totalDurationIn;
    //                 $flights[$loop]['layoversIn'] = $layoverIn;
    //                 $flights[$loop]['flightBaggageIn'] = $flightBaggageIn;

    //                 $flights[$loop]['totalDuration'] = $totalDuration;
    //                 $flights[$loop]['layovers'] = $layover;
    //                 $flights[$loop]['flightBaggage'] = $flightBaggage;

    //                 if(!empty($stopFilters) && (in_array($totalStopsOutCount, $stopFilters) || in_array($totalStopsInCount, $stopFilters))){
    //                     $stopsLoop[] = $loop;
    //                 }
    //                 if(!empty($refundFilter) && in_array(strtolower($refundStatus), $refundFilter)){
    //                     $refundLoop[] = $loop;
    //                 }
    //             }
    //             $loop++;
               
    //         }
    //         // die;
    //         // echo '<pre>';
    //         // print_r($flights);
    //         // echo '<br><br>';
    //         // echo '<br>Airline Loops ====== <br>';
    //         // print_r( $unsetLoops);
    //         // echo '<br>Stops Loops ====== <br>';
    //         // print_r($stopsLoop);
    //         // echo '<br>Refund Loop  ====== <br>';
    //         // print_r($refundLoop);
             
    //         $filterArrays[] = $unsetLoops;
    //         $filterArrays[] = $stopsLoop;
    //         $filterArrays[] = $refundLoop;
    //         $filterArrays = array_filter($filterArrays);
    //         $common = array();
    //         if(empty($airlineFilters) && empty($stopFilters) && empty($refundFilter)){
    //             $common = array();
    //         }
    //         elseif(!empty($airlineFilters) && !empty($stopFilters) && !empty($refundFilter)){
    //             $common = array_intersect($unsetLoops, $stopsLoop, $refundLoop);
    //         }
    //         elseif(!empty($airlineFilters) && !empty($stopFilters) && empty($refundFilter)){
    //             $common = array_intersect($unsetLoops, $stopsLoop);
    //         }
    //         elseif((!empty($airlineFilters) && empty($stopFilters) && !empty($refundFilter))){
    //             $common = array_intersect($unsetLoops, $refundLoop);
    //         }
    //         elseif(empty($airlineFilters) && !empty($stopFilters) && !empty($refundFilter)){
    //             $common = array_intersect($stopsLoop, $refundLoop);
    //         }
    //         elseif(!empty($airlineFilters) && empty($stopFilters) && empty($refundFilter)){
    //             $common = $unsetLoops;
    //         }
    //         elseif(empty($airlineFilters) && !empty($stopFilters) && empty($refundFilter)){
    //             $common = $stopsLoop;
    //         }
    //         elseif(empty($airlineFilters) && empty($stopFilters) && !empty($refundFilter)){
    //             $common = $refundLoop;
    //         }
           
    //         // print_r($common);
    //         $flights = ($isFilter == 0) ? $flights : ( (!empty($common)) ? array_intersect_key($flights, array_flip($common)) : array());
    //         // echo '<pre>';
    //         // print_r($flights);
    //         // die;
    //     }
    //     $data['search_type'] = $request->search_type;
    //     $data['totalCount'] = count($flights);
    //     $data['non_stop'] = $non_stop;
    //     $data['one_stop'] = $one_stop;
    //     $data['two_stop'] = $two_stop;
    //     $data['three_stop'] = $three_stop;
    //     $data['refund'] = $refund;
    //     $data['no_refund'] = $no_refund;
    //     $data['flightDetails'] = $flights;
    //     // print_r($data); die;
       
    //     return  view('web.search_results',compact('data','airports'));
    // }
    public function booking(Request $request){
        $data = [];
        // echo '<pre>';
        // print_r($request->all());
        if(isset($request->FareSourceCodeIn)){
            $apiKeys = [ 
                "session_id" => $request->session_id,
                "fare_source_code" => $request->FareSourceCode,
                "fare_source_code_inbound" => $request->FareSourceCodeIn
            ];
        }else{
            $apiKeys = [ 
                "session_id" => $request->session_id,
                "fare_source_code" => $request->FareSourceCode
            ];
        }
        $data['session_id'] = $request->session_id;
        $data['fare_sourceCode'] = $request->FareSourceCode;
        $data['search_type'] = $request->search_type;
        $data['airports'] = Airports::get()->keyBy('AirportCode')->toArray();
        $data['countries'] = Countries::orderBy('name','ASC')->get();
       
        $response = Http::timeout(300)->withOptions($this->options)->post(config('global.api_base_url').'revalidate', $apiKeys);
        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);
        // echo '<pre>';
        // // // print_r($request->all());
        // print_r($result);
        // die;
        $layover = $layoverIn = [];
        $journeyDurations = $journeyDurationsIn = 0;
        $flightBaggage = $flightBaggageIn = [];
        $bagCount = 0;

        $IsValid = $result['AirRevalidateResponse']['AirRevalidateResult']['IsValid'];
        if($IsValid == 1 || $IsValid == true){
            $FareItineraries = $result['AirRevalidateResponse']['AirRevalidateResult']['FareItineraries'];
            $ExtraServices = $result['AirRevalidateResponse']['AirRevalidateResult']['ExtraServices'];
            if(isset($FareItineraries['FareItinerary'])){
                $AirItineraryFareInfo = $FareItineraries['FareItinerary']['AirItineraryFareInfo'];
                $data['FareSourceCode'] = $AirItineraryFareInfo['FareSourceCode'];
                $data['FareType'] =  $AirItineraryFareInfo['FareType'];
                $data['IsRefundable'] = $AirItineraryFareInfo['IsRefundable'];
                $data['totalBaseFare'] = $AirItineraryFareInfo['ItinTotalFares']['BaseFare'];
                $data['totalTax'] = $AirItineraryFareInfo['ItinTotalFares']['TotalTax'];
                $data['totalFare'] = $AirItineraryFareInfo['ItinTotalFares']['TotalFare'];
                $data['ItinTotalFares'] = $AirItineraryFareInfo['ItinTotalFares'];
                $data['IsPassportMandatory'] =$FareItineraries['FareItinerary']['IsPassportMandatory'];
                $baggage = [];
                $passengers = [];
                $adultCount = $childCount = $infantCount = 0;
                
                foreach($AirItineraryFareInfo['FareBreakdown'] as $fareBreak){
                    if($fareBreak['PassengerTypeQuantity']['Code'] == "ADT"){
                        $adultCount = $fareBreak['PassengerTypeQuantity']['Quantity'];
                    }elseif($fareBreak['PassengerTypeQuantity']['Code'] == "CHD"){
                        $childCount = $fareBreak['PassengerTypeQuantity']['Quantity'];
                    }elseif($fareBreak['PassengerTypeQuantity']['Code'] == "INF"){
                        $infantCount = $fareBreak['PassengerTypeQuantity']['Quantity'];
                    }

                    $baggage[$fareBreak['PassengerTypeQuantity']['Code']]['Baggage'] = $fareBreak['Baggage'];
                    $baggage[$fareBreak['PassengerTypeQuantity']['Code']]['CabinBaggage'] = $fareBreak['CabinBaggage'];
                    $baggage[$fareBreak['PassengerTypeQuantity']['Code']]['Quantity'] = $fareBreak['PassengerTypeQuantity']['Quantity'];
                    $baggage[$fareBreak['PassengerTypeQuantity']['Code']]['CabinBaggage'] = $fareBreak['CabinBaggage'];
                    $baggage[$fareBreak['PassengerTypeQuantity']['Code']]['BaseFare'] = $fareBreak['PassengerFare']['BaseFare'];
                    $baggage[$fareBreak['PassengerTypeQuantity']['Code']]['ServiceTax'] = $fareBreak['PassengerFare']['ServiceTax'];
                    $baggage[$fareBreak['PassengerTypeQuantity']['Code']]['TotalFare'] = $fareBreak['PassengerFare']['TotalFare'];

                    $passengers[$fareBreak['PassengerTypeQuantity']['Code']] = $fareBreak['PassengerTypeQuantity']['Quantity'];
                }
                $data['adultCount'] = $adultCount;
                $data['childCount'] = $childCount;
                $data['infantCount'] = $infantCount;
                $data['FareBreakdown'] = $baggage;
                $data['passengers'] = $passengers;
                $flightOutgoing = isset($FareItineraries['FareItinerary']['OriginDestinationOptions'][0]) ? $FareItineraries['FareItinerary']['OriginDestinationOptions'][0] : [];
                if(!empty($flightOutgoing)){
                    $totalStopsCountOut = $flightOutgoing['TotalStops'];
                    $data['flightsOutgoing'] = $flightSegment = $flightOutgoing['OriginDestinationOption'];
                    for($i=0; $i <= $totalStopsCountOut; $i++){
                        $journeyDurations += $flightOutgoing['OriginDestinationOption'][$i]['FlightSegment']['JourneyDuration'];
                        if($totalStopsCountOut > 0){
                            if($i != 0){
                                // if($flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode'] == $flightSegment[$i-1]['FlightSegment']['ArrivalAirportLocationCode']){
                                    $timeInMin = getTimeDiffInMInutes($flightSegment[$i-1]['FlightSegment']['ArrivalDateTime'], $flightSegment[$i]['FlightSegment']['DepartureDateTime']);
                                    $layover[$flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode']] = $timeInMin;
                                    $layover['place'][] = $data['airports'][$flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode']]['City'];
                                    $layover['duration'][] = $timeInMin;                                
                                // }
                            }
                        }
                        $airlineCode = $flightSegment[$i]['FlightSegment']['MarketingAirlineCode'];
                        
                        $originCode = $flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode'];
                        $destinationCode = $flightSegment[$i]['FlightSegment']['ArrivalAirportLocationCode'];
                    
                        foreach($baggage as $key=>$value){
                            $flightBaggage[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['baggage'] = $value['Baggage'][$bagCount];
                            $flightBaggage[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['cabin_baggage'] = $value['CabinBaggage'][$bagCount];
                        }
                        $bagCount = $bagCount + 1;
                    }
                    $data['flightBaggageOut'] = $flightBaggage;
                    $data['layovers'] = $layover;
                }

                $flightIncoming = isset($FareItineraries['FareItinerary']['OriginDestinationOptions'][1]) ? $FareItineraries['FareItinerary']['OriginDestinationOptions'][1] : [];
                if(!empty($flightIncoming)){
                    $totalStopsCountIn = $flightIncoming['TotalStops'];
                    $data['flightsIncoming'] = $flightSegmentIn = $flightIncoming['OriginDestinationOption'];
                    for($in=0; $in <= $totalStopsCountIn; $in++){
                        $journeyDurationsIn += $flightIncoming['OriginDestinationOption'][$in]['FlightSegment']['JourneyDuration'];
                        if($totalStopsCountIn > 0){
                            if($in != 0){
                                // if($flightSegmentIn[$in]['FlightSegment']['DepartureAirportLocationCode'] == $flightSegmentIn[$in-1]['FlightSegment']['ArrivalAirportLocationCode']){
                                    $timeInMin = getTimeDiffInMInutes($flightSegmentIn[$in-1]['FlightSegment']['ArrivalDateTime'], $flightSegmentIn[$in]['FlightSegment']['DepartureDateTime']);
                                    $layoverIn[$flightSegmentIn[$in]['FlightSegment']['DepartureAirportLocationCode']] = $timeInMin;
                                    $layoverIn['place'][] = $data['airports'][$flightSegmentIn[$in]['FlightSegment']['DepartureAirportLocationCode']]['City'];
                                    $layoverIn['duration'][] = $timeInMin;                                
                                // }
                            }
                        }
                        $airlineCode = $flightSegmentIn[$in]['FlightSegment']['MarketingAirlineCode'];
                        
                        $originCode = $flightSegmentIn[$in]['FlightSegment']['DepartureAirportLocationCode'];
                        $destinationCode = $flightSegmentIn[$in]['FlightSegment']['ArrivalAirportLocationCode'];
                    
                        foreach($baggage as $key=>$value){
                            $flightBaggageIn[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['baggage'] = $value['Baggage'][$bagCount];
                            $flightBaggageIn[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['cabin_baggage'] = $value['CabinBaggage'][$bagCount];
                        }
                        $bagCount = $bagCount + 1;
                    }
                    $data['flightBaggageIn'] = $flightBaggageIn;
                    $data['layoversIn'] = $layoverIn;
                }
            }
            if(isset($ExtraServices['Services'])){
                $extraServicesData = $ExtraServices['Services'];
                foreach($extraServicesData as $extService){
                    $extraType = $extService['Service']['Type'];
                    $extraBehavior = $extService['Service']['Behavior'];
                    if($extraType == "BAGGAGE"){
                        
                        if($data['search_type'] == 'Return'){
                            if(strpos($extraBehavior, 'OUTBOUND') !== false){
                                $data['extraBaggage']['outGoing'][] = $extService;
                            } elseif(strpos($extraBehavior, 'INBOUND') !== false){
                                $data['extraBaggage']['inComing'][] = $extService;
                            }
                        }elseif($data['search_type'] == 'OneWay'){
                            $data['extraBaggage']['outGoing'][] = $extService;
                        }
                        
                    }elseif($extraType == "MEAL"){
                        $data['extraMeal'][] = $extService;
                    }elseif($extraType == "SPEEDY_BOARDING "){
                        $data['extraBording'][] = $extService;
                    }elseif($extraType == "CHECKIN_CHARGE"){
                        $data['extraCheckin'][] = $extService;
                    }
                }
            }
        }
        // echo '<pre>';
        // print_r($data);
        // die;
        $responseFare = Http::timeout(300)->withOptions($this->options)->post(config('global.api_base_url').'fare_rules', $apiKeys);
        $resultFare = $responseFare->getBody()->getContents();
        $resultFare = json_decode($resultFare, true);

        if(isset($resultFare['FareRules1_1Response']['FareRules1_1Result'])){
            $data['fareRulesOut'] = $resultFare['FareRules1_1Response']['FareRules1_1Result']['FareRules'];
        }
        //  echo '<pre>';
        // print_r($data['fareRulesOut']);
        // die;
       
        return  view('web.booking',compact('data'));
    }

    public function createBooking(Request $request){
        
        $adultArray = $childArray = $infantArray = [];
        $details = $request->all();
        // echo '<pre>';
        // print_r($details);
        // die;
        $data['flightBookingInfo']['flight_session_id'] = $request->session_id;
        $data['flightBookingInfo']['fare_source_code'] = $request->fare_source_code;
        $data['flightBookingInfo']['IsPassportMandatory'] = $request->IsPassportMandatory;
        $data['flightBookingInfo']['fareType'] = $request->FareType;
        $data['flightBookingInfo']['countryCode'] = $request->mobile_code;
        $data['flightBookingInfo']['areaCode'] = $request->mobile_code;

        $clientRef = str_replace(':','', str_replace("-","",date('d-m-yH:i:s')));
        $details['clientRef'] = $clientRef;
        $data["paxInfo"]["clientRef"] = $clientRef;
        $data["paxInfo"]["customerEmail"] = $request->email;
        $data["paxInfo"]["customerPhone"] = $request->mobile_no;

        if($request->adultCount != 0){
            $adultArray["title"] =  $request->adult_title;
            $adultArray["firstName"] =  $request->adult_first_name;
            $adultArray["lastName"] =   $request->adult_last_name;
            $adultArray["dob"] =   $request->adult_dob;
            $adultArray["nationality"] =   $request->adult_nationality;
            $adultArray["passportNo"] =   $request->adult_passport;
            $adultArray["passportIssueCountry"] =   $request->adult_passport_country;
            $adultArray["passportExpiryDate"] =   $request->adult_passport_expiry;
            $paxDetails["adult"] = $adultArray;
        }
        if($request->childCount != 0){
            $childArray["title"] =  $request->child_title;
            $childArray["firstName"] =  $request->child_first_name;
            $childArray["lastName"] =   $request->child_last_name;
            $childArray["dob"] =   $request->child_dob;
            $childArray["nationality"] =   $request->child_nationality;
            $childArray["passportNo"] =   $request->child_passport;
            $childArray["passportIssueCountry"] =   $request->child_passport_country;
            $childArray["passportExpiryDate"] =   $request->child_passport_expiry;
            $paxDetails["child"] = $childArray;
        }
        if($request->infantCount != 0){
            $infantArray["title"] =  $request->infant_title;
            $infantArray["firstName"] =  $request->infant_first_name;
            $infantArray["lastName"] =   $request->infant_last_name;
            $infantArray["dob"] =   $request->infant_dob;
            $infantArray["nationality"] =   $request->infant_nationality;
            $infantArray["passportNo"] =   $request->infant_passport;
            $infantArray["passportIssueCountry"] =   $request->infant_passport_country;
            $infantArray["passportExpiryDate"] =   $request->infant_passport_expiry;
            $paxDetails["infant"] = $infantArray;
        }
        $data["paxInfo"]["paxDetails"][] = $paxDetails;
        
        $response = Http::timeout(300)->withOptions($this->options)->post(config('global.api_base_url').'booking', $data);

        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);
        // echo '<pre>';
        // print_r($result);
        // die;
        if(!isset($result['status']['errors'])){
            $bookResult = $result['BookFlightResponse']['BookFlightResult'];
            if($bookResult['Success'] == 'true' || $bookResult['Success'] == '1'){
                $bookingId = $bookResult['UniqueID'];
                if(strtolower($request->FareType) != "webfare"){
                    $ticketOrderRes = $this->ticketOrder($bookingId);
                    $ticketOrderRes = json_decode($ticketOrderRes, true);
                    // echo '<pre>';
                    // print_r($ticketOrderRes);
                
                    $ticketOrderResSuccess = $ticketOrderRes['AirOrderTicketRS']['TicketOrderResult']['Success'];
                    if($ticketOrderResSuccess == "true" || $ticketOrderResSuccess == "1"){
                        $tripDetails = $this->getTripDetails($bookingId);
                        $tripDetails = json_decode($tripDetails, true);
                        if(isset($tripDetails['TripDetailsResponse'])){
                            $tripDetailsResult = $tripDetails['TripDetailsResponse']['TripDetailsResult'];
                            if($tripDetailsResult['Success'] == 'true'){
                                $this->saveFlightBookingData($tripDetailsResult, $details);
                            }
                        } 
                    }
                }else{
                    $tripDetails = $this->getTripDetails($bookingId);
                    $tripDetails = json_decode($tripDetails, true);
                    if(isset($tripDetails['TripDetailsResponse'])){
                        $tripDetailsResult = $tripDetails['TripDetailsResponse']['TripDetailsResult'];
                        if($tripDetailsResult['Success'] == 'true'){
                            $this->saveFlightBookingData($tripDetailsResult, $details);
                        }
                    }
                }
                $msg = 'success';
            }else{
                $msg =  $bookResult['Errors']['Error']['ErrorMessage'];
            }
        }else{
            $msg =  (isset($result['status']['errors'][0])) ? $result['status']['errors'][0]['errorMessage'] : 'Something went wrong';
        }   
        return  view('web.booking_success',compact('msg'));
   }

    public function ticketOrder($bookingId){
        $response = Http::timeout(300)->withOptions($this->options)->post(config('global.api_base_url').'ticket_order', [
                        "user_id"=> config('global.api_user_id'),
                        "user_password"=> config('global.api_user_password'),
                        "access"=> config('global.api_access'),
                        "ip_address"=> config('global.api_ip_address'),
                        "UniqueID"=> $bookingId
                    ]);

        $result = $response->getBody()->getContents();
        return $result;
    }

    public function getTripDetails($bookingId){
        $response = Http::timeout(300)->withOptions($this->options)->post(config('global.api_base_url').'trip_details', [
                        "user_id"=> config('global.api_user_id'),
                        "user_password"=> config('global.api_user_password'),
                        "access"=> config('global.api_access'),
                        "ip_address"=> config('global.api_ip_address'),
                        "UniqueID"=> $bookingId
                    ]);

        $result = $response->getBody()->getContents();
        return $result;
    }

    public function saveFlightBookingData($tripDetailsResult, $data){
        $travelItinerary = $tripDetailsResult['TravelItinerary'];
        // echo '<pre>';
        // print_r($data);
        // print_r($travelItinerary);
        
        $ItineraryInfo = $travelItinerary['ItineraryInfo'];
        $CustomerInfos = $ItineraryInfo['CustomerInfos'];
        $ReservationItems = $ItineraryInfo['ReservationItems'];
                        
        $bookData = [
            'user_id' => 5, 
            'unique_booking_id' => $travelItinerary['UniqueID'], 
            'client_ref' => $data['clientRef'], 
            'fare_type' => $data['FareType'],
            'origin' => $travelItinerary['Origin'], 
            'destination' => $travelItinerary['Destination'], 
            'customer_email' => $data['email'], 
            'phone_code' => $data['mobile_code'], 
            'customer_phone' => $data['mobile_no'], 
            'adult_count' => $data['adultCount'], 
            'child_count' => $data['childCount'], 
            'infant_count' => $data['infantCount'], 
            'booking_status' => $travelItinerary['BookingStatus'], 
            'ticket_status' => $travelItinerary['TicketStatus'], 
            'currency' => $data['currency'],
            'adult_amount' => $data['adult_amount'], 
            'child_amount' => $data['child_amount'], 
            'infant_amount' => $data['infant_amount'], 
            'total_amount' => $data['total_amount'], 
            'total_tax' => $data['total_tax'], 
            'addon_amount' => $data['total_addons'],
            'created_at'=> date('Y-m-d H:i:s')
        ];
        $flightBook = FlightBookings::create($bookData);
        $flightBookId = $flightBook->id;
       
        $passengers = $itinerary = [];
        if($CustomerInfos){
            foreach($CustomerInfos as $custInfo){
                $info = $custInfo['CustomerInfo'];
                $passengers[] = [
                    'booking_id' => $flightBookId,
                    'passenger_type' => $info['PassengerType'],
                    'passport_number' => $info['PassportNumber'],
                    'passenger_first_name' => $info['PassengerFirstName'],
                    'passenger_last_name' => $info['PassengerLastName'],
                    'passenger_title' => $info['PassengerTitle'],
                    'itemRPH' => $info['ItemRPH'],
                    'eticket_number' => $info['eTicketNumber'],
                    'date_of_birth' => $info['DateOfBirth'],
                    'gender' => $info['Gender'],
                    'passenger_nationality' => $info['PassengerNationality'],
                    'created_at'=> date('Y-m-d H:i:s')
                ];
            }
            // print_r($passengers);
            FlightPassengers::insert($passengers);
        }
       
        if($ReservationItems){
            foreach($ReservationItems as $resItem){
                $resInfo = $resItem['ReservationItem'];
                $itinerary[] = [
                    'booking_id' => $flightBookId,
                    'airline_pnr' => $resInfo['AirlinePNR'],
                    'arrival_airport' => $resInfo['ArrivalAirportLocationCode'],
                    'arrival_date_time' => $resInfo['ArrivalDateTime'],
                    'arrival_terminal' => $resInfo['ArrivalTerminal'],
                    'baggage' => $resInfo['Baggage'],
                    'cabin_class' => $resInfo['CabinClassText'],
                    'departure_airport' => $resInfo['DepartureAirportLocationCode'],
                    'departure_date_time' => $resInfo['DepartureDateTime'],
                    'departure_terminal' => $resInfo['DepartureTerminal'],
                    'flight_number' => $resInfo['FlightNumber'],
                    'item_rph' => $resInfo['ItemRPH'],
                    'journey_duration' => $resInfo['JourneyDuration'],
                    'marketing_airline_code' => $resInfo['MarketingAirlineCode'],
                    'number_in_party' => $resInfo['NumberInParty'],
                    'operating_airline_code' => $resInfo['OperatingAirlineCode'],
                    'res_book_desig_code' => $resInfo['ResBookDesigCode'],
                    'stop_quantity' => $resInfo['StopQuantity'],
                    'created_at'=> date('Y-m-d H:i:s')
                ];
            }
            // print_r($itinerary);
            FlightItineraryDetails::insert($itinerary);
        }
        // die;
    }

    public function revalidate(Request $request){
        $apiKeys = [ 
            "session_id" => $request->session_id,
            "fare_source_code" => $request->fare_source_code
        ];
        $response = Http::timeout(300)->withOptions($this->options)->post(config('global.api_base_url').'revalidate', $apiKeys);
        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);
        // echo '<pre>';
        // print_r($result);
        $IsValid = $result['AirRevalidateResponse']['AirRevalidateResult']['IsValid'];
        if($IsValid == 1 || $IsValid == true){
            $FareItineraries = $result['AirRevalidateResponse']['AirRevalidateResult']['FareItineraries'];
            $ExtraServices = $result['AirRevalidateResponse']['AirRevalidateResult']['ExtraServices'];
            if(isset($FareItineraries['FareItinerary'])){
                echo 'success';
            }else{
                echo 'failed';
            }
        }else{
            echo 'failed';
        }
    }

    public function cancelTicket(Request $request){
        $uniqueBookId = $request->bookId;
        // echo '<pre>';
        // echo $uniqueBookId; 
        $response = Http::timeout(300)->withOptions($this->options)->post(config('global.api_base_url').'cancel', [
                        "user_id"=> config('global.api_user_id'),
                        "user_password"=> config('global.api_user_password'),
                        "access"=> config('global.api_access'),
                        "ip_address"=> config('global.api_ip_address'),
                        "UniqueID"=> $uniqueBookId
                    ]);

        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);
        // print_r($result);
        // die;
        $CancelBookingResult = $result['CancelBookingResponse']['CancelBookingResult'];
        if( $CancelBookingResult['Success'] == true){
            FlightBookings::where('unique_booking_id', $uniqueBookId)->update(['cancel_request' => 1]);
            $msg = ['status' => 'success','msg' => 'Cancel request send successfully'];
        }else{
            $msg =  ['status' => 'failed','msg' => (isset($CancelBookingResult['Errors']['ErrorMessage'])) ? $CancelBookingResult['Errors']['ErrorMessage'] : 'Something went wrong'];
        }
        return  json_encode($msg);
    }

    public function voidQuote(Request $request){
        $uniqueBookId = $request->bookId;
        $id = $request->id;
        $bookDetails = FlightPassengers::where('booking_id', $id)->get();
        $paxDetails = [];
        foreach ($bookDetails as $key) {
            $paxDetails[] =  array(
                                    "type" => $key->passenger_type,
                                    "title" => $key->passenger_title,
                                    "firstName" => $key->passenger_first_name,
                                    "lastName" => $key->passenger_last_name, 
                                    "eTicket" => $key->eticket_number
                            );   
        }
                
        // echo '<pre>';
        // print_r($paxDetails);
        // echo json_encode($paxDetails);
        // die;
        // echo $uniqueBookId; 
        $data['id'] = $id;
        $response = Http::timeout(300)->withOptions($this->options)->post(config('global.api_base_url').'void_ticket_quote', [
                        "user_id"=> config('global.api_user_id'),
                        "user_password"=> config('global.api_user_password'),
                        "access"=> config('global.api_access'),
                        "ip_address"=> config('global.api_ip_address'),
                        "UniqueID"=> $uniqueBookId,
                        "paxDetails" => $paxDetails
                    ]);

        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);
        // print_r($result);
        $TotalVoidingFee = $TotalRefundAmount = 0;
        if(!isset($result['Errors'])){
            $VoidQuoteResult = $result['VoidQuoteResponse']['VoidQuoteResult'];
            if( $VoidQuoteResult['Success'] == true){
                $data['UniqueID'] = $VoidQuoteResult['UniqueID'];
                $data['ptrUniqueID'] = $VoidQuoteResult['ptrUniqueID'];
                if(isset($VoidQuoteResult['VoidQuotes'])){
                    foreach($VoidQuoteResult['VoidQuotes'] as $void){
                        $tVoid =  $void['QuotedFares']['TotalVoidingFee'];
                        $tRefund =  $void['QuotedFares']['TotalRefundAmount'];
                        $TotalVoidingFee = $TotalVoidingFee + $tVoid['Amount'];
                        $TotalRefundAmount = $TotalRefundAmount + $tRefund['Amount'];
                        $data['currency'] = $tRefund['CurrencyCode'];
                    }
                }
                $data['voidFee'] = number_format(floor($TotalVoidingFee*100)/100, 2);
                $data['refundAmount'] = number_format(floor($TotalRefundAmount*100)/100, 2);
                $msg = array('status' => true, 'data' => $data);
            }else{
                $msg = array('status' => false ,'data' => array(), 'msg' => (isset($VoidQuoteResult['Errors'])) ? $VoidQuoteResult['Errors']['ErrorMessage'] : 'Something went wrong');
            }
        }else{
            $msg = array('status' => false ,'data' => array(), 'msg' => (isset($result['Errors'])) ? $result['Errors']['ErrorMessage'] : 'Something went wrong');
        }
        // print_r($data);
        // die;
        
        return json_encode($msg);
    }

    public function voidAPI(Request $request){
        $uniqueBookId = $request->bookId;
        $id = $request->id;
        $bookDetails = FlightPassengers::where('booking_id', $id)->get();
        $paxDetails = [];
        foreach ($bookDetails as $key) {
            $paxDetails[] =  array(
                                    "type" => $key->passenger_type,
                                    "title" => $key->passenger_title,
                                    "firstName" => $key->passenger_first_name,
                                    "lastName" => $key->passenger_last_name, 
                                    "eTicket" => $key->eticket_number
                            );   
        }
                
        // echo '<pre>';
       
        $response = Http::timeout(300)->withOptions($this->options)->post(config('global.api_base_url').'void_ticket', [
                        "user_id"=> config('global.api_user_id'),
                        "user_password"=> config('global.api_user_password'),
                        "access"=> config('global.api_access'),
                        "ip_address"=> config('global.api_ip_address'),
                        "UniqueID"=> $uniqueBookId,
                        "paxDetails" => $paxDetails,
                        "remark" => "Kindly void booking."
                    ]);

        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);
        // echo '<pre>';
        // print_r($result);
        // die;
        if(!isset($result['Errors'])){
            $VoidQuoteResult = $result['VoidQuoteResponse']['VoidQuoteResult'];
            if( $VoidQuoteResult['Success'] == true){
                FlightBookings::where('unique_booking_id', $uniqueBookId)->update(['cancel_request' => 1,'cancel_ptr' => $VoidQuoteResult['ptrUniqueID']]);
                $msg = ['status' => true,'msg' => 'Cancel request send successfully'];
            }else{
                $msg = array('status' => false ,'msg' => (isset($VoidQuoteResult['Errors'])) ? $VoidQuoteResult['Errors']['ErrorMessage'] : 'Something went wrong');
            }
        }else{
            $msg = array('status' => false , 'msg' => (isset($result['Errors'])) ? $result['Errors']['ErrorMessage'] : 'Something went wrong');
        }
        return json_encode($msg);
    }

    public function ptrStatusCheck(Request $request){
        $uniqueId = $request->id;
        $ptrUniqueId = $request->ptr;

        $response = Http::timeout(300)->withOptions($this->options)->post(config('global.api_base_url').'search_post_ticket_status', [
            "user_id"=> config('global.api_user_id'),
            "user_password"=> config('global.api_user_password'),
            "access"=> config('global.api_access'),
            "ip_address"=> config('global.api_ip_address'),
            "UniqueID"=> $uniqueId,
            "ptrUniqueID" => $ptrUniqueId
        ]);

        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);
        // echo '<pre>';
        // print_r($result);

        if(isset($result['PtrResponse'])){
            $PtrResult = $result['PtrResponse']['PtrResult'];
            if($PtrResult['Success'] == true){
                if(isset($PtrResult['PtrDetails'][0])){
                    $PtrDetails = $PtrResult['PtrDetails'][0];
                    if($PtrDetails['PtrStatus'] == 'Completed'){
                        if($PtrDetails['PtrType'] == 'Void' || $PtrDetails['PtrType'] == 'Refund'){
                            FlightBookings::where('unique_booking_id', $uniqueId)->update(['is_cancelled' => 1]);
                        }
                        $msg = "Your Request for ticket cancellation is Completed.";
                    }else{
                        $msg = "Your Request for ticket cancellation is InProcess.";
                    }  
                }
            }else{
                $msg = (isset($PtrResult['Errors']['ErrorMessage'])) ? $PtrResult['Errors']['ErrorMessage'] : 'Something went wrong' ;
            }
        }else{
            $msg = (isset($result['Errors']['ErrorMessage'])) ? $result['Errors']['ErrorMessage'] : 'Something went wrong' ;
        }
        return $msg;
    }

    public function refundQuote(Request $request){
        $uniqueBookId = $request->bookId;
        $id = $request->id;
        $bookDetails = FlightPassengers::where('booking_id', $id)->get();
        $paxDetails = [];
        foreach ($bookDetails as $key) {
            $paxDetails[] =  array(
                                    "type" => $key->passenger_type,
                                    "title" => $key->passenger_title,
                                    "firstName" => $key->passenger_first_name,
                                    "lastName" => $key->passenger_last_name, 
                                    "eTicket" => $key->eticket_number
                            );   
        }
                
        // echo '<pre>';
        // print_r($paxDetails);
        // echo json_encode($paxDetails);
        // die;
        // echo $uniqueBookId; 
        $data['id'] = $id;
        $response = Http::timeout(300)->withOptions($this->options)->post(config('global.api_base_url').'refund_quote', [
                        "user_id"=> config('global.api_user_id'),
                        "user_password"=> config('global.api_user_password'),
                        "access"=> config('global.api_access'),
                        "ip_address"=> config('global.api_ip_address'),
                        "UniqueID"=> $uniqueBookId,
                        "paxDetails" => $paxDetails
                    ]);

        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);
        // print_r($result);
        $ptrUniqueId = '';
        $TotalRefundFee = $TotalRefundAmount = 0;
        if(!isset($result['Errors'])){
            $RefundQuoteResult = $result['RefundQuoteResponse']['RefundQuoteResult'];
            if( $RefundQuoteResult['Success'] == true){
                $ptrUniqueId = $RefundQuoteResult['ptrUniqueID'];
                if($ptrUniqueId != ''){
                    $responseCheck = Http::timeout(300)->withOptions($this->options)->post(config('global.api_base_url').'search_post_ticket_status', [
                        "user_id"=> config('global.api_user_id'),
                        "user_password"=> config('global.api_user_password'),
                        "access"=> config('global.api_access'),
                        "ip_address"=> config('global.api_ip_address'),
                        "UniqueID"=> $uniqueBookId,
                        "ptrUniqueID" => $ptrUniqueId
                    ]);
                    $resultCheck = $responseCheck->getBody()->getContents();
                    $resultCheck = json_decode($resultCheck, true);
                    // print_r($resultCheck);

                    if(!isset($resultCheck['Errors'])){
                        $PtrResult = $resultCheck['PtrResponse']['PtrResult'];
                        if( $PtrResult['Success'] == true){
                            $PtrDetails = (isset($PtrResult['PtrDetails'][0])) ? $PtrResult['PtrDetails'][0] : [];
                            if($PtrDetails){
                                $data['UniqueID'] = $PtrDetails['UniqueID'];
                                $data['ptrUniqueID'] = $PtrDetails['PtrUniqueID'];
                                if(isset($PtrDetails['PaxDetails'])){
                                    foreach($PtrDetails['PaxDetails'] as $refund){
                                        $tFee =  $refund['QuotedFares']['TotalRefundCharges'];
                                        $tRefund =  $refund['QuotedFares']['TotalRefundAmount'];
                                        $TotalRefundFee = $TotalRefundFee + $tFee['Amount'];
                                        $TotalRefundAmount = $TotalRefundAmount + $tRefund['Amount'];
                                        $data['currency'] = $tRefund['CurrencyCode'];
                                    }
                                }
                                $data['refundFee'] = number_format(floor($TotalRefundFee*100)/100, 2);
                                $data['refundAmount'] = number_format(floor($TotalRefundAmount*100)/100, 2);
                                $msg = array('status' => true, 'data' => $data);
                            }else{
                                $msg = array('status' => false, 'data' => $data, 'msg' => 'Something went wrong');
                            }
                            
                        }else{
                            $msg = array('status' => false ,'data' => array(), 'msg' => (isset($PtrResult['Errors'])) ? $PtrResult['Errors']['ErrorMessage'] : 'Something went wrong');
                        }
                    }else{
                        $msg = array('status' => false ,'data' => array(), 'msg' => (isset($result['Errors'])) ? $result['Errors']['ErrorMessage'] : 'Something went wrong');
                    }
                }else{
                    $msg = array('status' => false, 'data' => $data, 'msg' => 'Something went wrong');
                }
            }else{
                $msg = array('status' => false ,'data' => array(), 'msg' => (isset($RefundQuoteResult['Errors'])) ? $RefundQuoteResult['Errors']['ErrorMessage'] : 'Something went wrong');
            }
        }else{
            $msg = array('status' => false ,'data' => array(), 'msg' => (isset($result['Errors'])) ? $result['Errors']['ErrorMessage'] : 'Something went wrong');
        }
        // print_r($data);
        // die;
        
        return json_encode($msg);
    }

    public function refundAPI(Request $request){
        $uniqueBookId = $request->bookId;
        $id = $request->id;
        $bookDetails = FlightPassengers::where('booking_id', $id)->get();
        $paxDetails = [];
        foreach ($bookDetails as $key) {
            $paxDetails[] =  array(
                                    "type" => $key->passenger_type,
                                    "title" => $key->passenger_title,
                                    "firstName" => $key->passenger_first_name,
                                    "lastName" => $key->passenger_last_name, 
                                    "eTicket" => $key->eticket_number
                            );   
        }
                
        // echo '<pre>';
       
        $response = Http::timeout(300)->withOptions($this->options)->post(config('global.api_base_url').'refund', [
                        "user_id"=> config('global.api_user_id'),
                        "user_password"=> config('global.api_user_password'),
                        "access"=> config('global.api_access'),
                        "ip_address"=> config('global.api_ip_address'),
                        "UniqueID"=> $uniqueBookId,
                        "paxDetails" => $paxDetails,
                        "remark" => "Kindly void booking."
                    ]);

        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);
        // echo '<pre>';
        // print_r($result);
        // die;
        if(!isset($result['Errors'])){
            // $RefundResult = $result['RefundResponse']['RefundResult'];
            $RefundResult = $result['ReissueResponse']['ReissueResult'];
            if( $RefundResult['Success'] == true){
                FlightBookings::where('unique_booking_id', $uniqueBookId)->update(['cancel_request' => 1,'cancel_ptr' => $RefundResult['ptrUniqueID']]);
                $msg = ['status' => true,'msg' => (isset($RefundResult['Message']) && $RefundResult['Message'] != '') ? $RefundResult['Message'] : 'Cancel request send successfully'];
            }else{
                $msg = array('status' => false ,'msg' => (isset($RefundResult['Errors'])) ? $RefundResult['Errors']['ErrorMessage'] : 'Something went wrong');
            }
        }else{
            $msg = array('status' => false , 'msg' => (isset($result['Errors'])) ? $result['Errors']['ErrorMessage'] : 'Something went wrong');
        }
        return json_encode($msg);
    }
}



