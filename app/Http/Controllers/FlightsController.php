<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Models\Airports;
use App\Models\Airlines;
use App\Models\Countries;
use App\Models\FlightBookings;
use App\Models\FlightPassengers;
use App\Models\FlightItineraryDetails;
use App\Models\FlightMarginAmounts;
use App\Models\FlightExtraServices;
use App\Models\FlightSearches;
use App\Models\UserDetails;
use App\Models\User;

use App;
use Session;
use Helper;
use DB;
use Auth;
use Mail;

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
        // $airports = Airports::select('id', 'AirportCode', 'AirportName', 'City', 'Country')
        //                     ->orderBy('City','ASC')
        //                     ->get();

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
                                                    "requiredCurrency"=> (Session::has('user_currency') ? Session::get('user_currency') : config('global.api_requiredCurrency')),
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
        if($request->search_type == 'OneWay' || $request->search_type == 'Circle'){
            if($flightDetails){
                $loop = 0;
                $unsetLoops = array();
                $airLoops = array();
                $stopsLoop = $refundLoop = array();
                foreach($flightDetails as $fd){
                    // echo '<br><br>Normal loop  ==== '.$loop;
                    $AirItineraryFareInfoOne = $fd['FareItinerary']['AirItineraryFareInfo'];
                    $refundStatus = $AirItineraryFareInfoOne['IsRefundable'];
                    $flights[$loop]['FareSourceCode'] = $AirItineraryFareInfoOne['FareSourceCode'];
                    $flights[$loop]['FareType'] = $AirItineraryFareInfoOne['FareType'];
                    $flights[$loop]['IsRefundable'] = $refundStatus;
                    $flights[$loop]['TotalFares'] = $AirItineraryFareInfoOne['ItinTotalFares'];
                    $flights[$loop]['DirectionInd'] = $fd['FareItinerary']['DirectionInd'];
    
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
                    $flightSegment = $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'];
                    $flights[$loop]['OriginDestinationOptionsOutbound'] = $flightSegment;
                        
                    $layover = [];
                    $journeyDurations = 0;
                    $flightBaggage = [];
                    // echo '<br><br><br> Mian loop ======== '.$loop;
                    // echo '<br>Total Stops ====== '.$totalStopsCount;
                    
                    for($i=0; $i <= $totalStopsCount; $i++){
                        $journeyDurations += $flightSegment[$i]['FlightSegment']['JourneyDuration'];
                        $DepartureAirportLocationCode = $flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode'];
                        if($totalStopsCount > 0){
                            if($i != 0 ){
                                // if($flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode'] == $flightSegment[$i-1]['FlightSegment']['ArrivalAirportLocationCode']){
                                    $timeInMin = getTimeDiffInMInutes($flightSegment[$i-1]['FlightSegment']['ArrivalDateTime'], $flightSegment[$i]['FlightSegment']['DepartureDateTime']);
                                    $layover[$DepartureAirportLocationCode] = $timeInMin;
                                    $layover['place'][] = $data['airports'][$DepartureAirportLocationCode]['City'];
                                    $layover['duration'][] = $timeInMin;                                
                                // }
                            }
                        }
                        $airlineCode = $flightSegment[$i]['FlightSegment']['MarketingAirlineCode'];
                        $flightCodes [] = $airlineCode;
                        $data['airlines'][$airlineCode] = isset($data['airlines'][$airlineCode]) ? ($data['airlines'][$airlineCode] + 1) : 1;

                        $originCode = $DepartureAirportLocationCode;
                        $destinationCode = $flightSegment[$i]['FlightSegment']['ArrivalAirportLocationCode'];
                        
                        if(!empty($airlineFilters) && in_array($airlineCode, $airlineFilters)){
                            $unsetLoops[] = $loop;
                        }
                       
                    }
                       
                    if($totalStopsCount == 0){
                        $totalDuration = $flightSegment[0]['FlightSegment']['JourneyDuration'];
                    }else{
                        $totalDuration = (isset($layover['duration'])) ? array_sum($layover['duration']) + $journeyDurations : $journeyDurations;
                    }
                    $flights[$loop]['totalDuration'] = $totalDuration;
                    $flights[$loop]['layovers'] = $layover;
                   
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
                        $AirItineraryFareInfoRe = $fd['FareItinerary']['AirItineraryFareInfo'];
                        $refundStatus = $AirItineraryFareInfoRe['IsRefundable'];
                        $flights[$loop]['FareSourceCode'] = $AirItineraryFareInfoRe['FareSourceCode'];
                        $flights[$loop]['FareType'] = $AirItineraryFareInfoRe['FareType'];
                        $flights[$loop]['IsRefundable'] = $refundStatus;
                        $flights[$loop]['TotalFares'] = $AirItineraryFareInfoRe['ItinTotalFares'];
                        $flights[$loop]['DirectionInd'] = $fd['FareItinerary']['DirectionInd'];
        
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
                        $OriginDestinationOption = $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'];
                        $flights[$loop]['totalOutStops'] = $totalStopsOutCount;
                        $flights[$loop]['OriginDestinationOptionsOutbound'] = $OriginDestinationOption;
                        
                        $layover = [];
                        $journeyDurations = 0;
                       
                        $flightBaggage = [];
                        for($i=0; $i <= $totalStopsOutCount; $i++){
                            $journeyDurations += $OriginDestinationOption[$i]['FlightSegment']['JourneyDuration'];
                            $flightSegment = $OriginDestinationOption;
                            $newFlightSegment = $flightSegment[$i]['FlightSegment'];
                            $DepartureAirportLocationCode = $newFlightSegment['DepartureAirportLocationCode'];
                            if($totalStopsOutCount > 0){
                                if($i != 0){
                                    // if($flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode'] == $flightSegment[$i-1]['FlightSegment']['ArrivalAirportLocationCode']){

                                        $timeInMin = getTimeDiffInMInutes($flightSegment[$i-1]['FlightSegment']['ArrivalDateTime'], $newFlightSegment['DepartureDateTime']);
                                        $layover[$DepartureAirportLocationCode] = $timeInMin;
                                        $layover['place'][] = $data['airports'][$DepartureAirportLocationCode]['City'];
                                        $layover['duration'][] = $timeInMin;    
                                    // }
                                }
                            }
                            $airlineCode = $newFlightSegment['MarketingAirlineCode'];
                            $flightCodes [] = $airlineCode;
                            $data['airlines'][$airlineCode] = isset($data['airlines'][$airlineCode]) ? ($data['airlines'][$airlineCode] + 1) : 1;

                            $originCode = $DepartureAirportLocationCode;
                            $destinationCode = $newFlightSegment['ArrivalAirportLocationCode'];
                           
                            if(!empty($airlineFilters) && in_array($airlineCode, $airlineFilters)){
                                $unsetLoops[] = $loop;
                            }
                        }

                        if($totalStopsOutCount == 0){
                            $totalDuration = $OriginDestinationOption[0]['FlightSegment']['JourneyDuration'];
                        }else{
                            $totalDuration = array_sum($layover['duration']) + $journeyDurations;
                        }

                        $flights[$loop]['totalDuration'] = $totalDuration;
                        $flights[$loop]['layovers'] = $layover;
                        
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
                        $inAirItineraryFareInfo = $fdIn['FareItinerary']['AirItineraryFareInfo'];
                        $refundStatusIn = $inAirItineraryFareInfo['IsRefundable'];
                        $flightsIn[$loopIn]['FareSourceCode'] = $inAirItineraryFareInfo['FareSourceCode'];
                        $flightsIn[$loopIn]['FareType'] = $inAirItineraryFareInfo['FareType'];
                        $flightsIn[$loopIn]['IsRefundable'] = $refundStatusIn;
                        $flightsIn[$loopIn]['TotalFares'] = $inAirItineraryFareInfo['ItinTotalFares'];
                        $flightsIn[$loopIn]['DirectionInd'] = $fdIn['FareItinerary']['DirectionInd'];
        
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
                        $flightSegmentIn = $fdIn['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'];
                        $flightsIn[$loopIn]['totalInStops'] = $totalStopsInCount;
                        $flightsIn[$loopIn]['OriginDestinationOptionsInbound'] = $flightSegmentIn;
        
                        $layoverIn = [];
                        $journeyDurationsIn = 0;
                        $bagCountIn = 0;
                        $flightBaggageIn = [];
                        for($j=0; $j <= $totalStopsInCount; $j++){
                            $jFlightSegment  = $flightSegmentIn[$j]['FlightSegment'];
                            $journeyDurationsIn += $jFlightSegment['JourneyDuration'];
                            
                            if($totalStopsInCount > 0){
                                if($j != 0){
                                    // if($jFlightSegment['DepartureAirportLocationCode'] == $flightSegmentIn[$j-1]['FlightSegment']['ArrivalAirportLocationCode']){

                                        $timeInMinIn = getTimeDiffInMInutes($flightSegmentIn[$j-1]['FlightSegment']['ArrivalDateTime'], $jFlightSegment['DepartureDateTime']);
                                        $layoverIn[$jFlightSegment['DepartureAirportLocationCode']] = $timeInMinIn;
                                        $layoverIn['place'][] = $data['airports'][$jFlightSegment['DepartureAirportLocationCode']]['City'];
                                        $layoverIn['duration'][] = $timeInMinIn;                               
                                    // }
                                }
                            }
                            $airlineCodeIn = $jFlightSegment['MarketingAirlineCode'];
                            $flightCodesIn [] = $airlineCodeIn;
                            $data['airlines'][$airlineCodeIn] = isset($data['airlines'][$airlineCodeIn]) ? ($data['airlines'][$airlineCodeIn] + 1) : 1;

                            $originCodeIn = $jFlightSegment['DepartureAirportLocationCode'];
                            $destinationCodeIn = $jFlightSegment['ArrivalAirportLocationCode'];
                        
                            if(!empty($airlineFilters) && in_array($airlineCodeIn, $airlineFilters)){
                                $unsetLoopsIn[] = $loopIn;
                            }
                        }

                        if($totalStopsInCount == 0){
                            $totalDurationIn = $flightSegmentIn[0]['FlightSegment']['JourneyDuration'];
                        }else{
                            $totalDurationIn = array_sum($layoverIn['duration']) + $journeyDurationsIn;
                        }
        
                        $flightsIn[$loopIn]['totalDurationIn'] = $totalDurationIn;
                        $flightsIn[$loopIn]['layoversIn'] = $layoverIn;
                       
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
                        $AirItineraryFareInfoReN  = $fd['FareItinerary']['AirItineraryFareInfo'];
                        $refundStatus = $AirItineraryFareInfoReN['IsRefundable'];
                        $flights[$loop]['FareSourceCode'] = $AirItineraryFareInfoReN['FareSourceCode'];
                        $flights[$loop]['FareType'] = $AirItineraryFareInfoReN['FareType'];
                        $flights[$loop]['IsRefundable'] = $refundStatus;
                        $flights[$loop]['TotalFares'] = $AirItineraryFareInfoReN['ItinTotalFares'];
                        $flights[$loop]['DirectionInd'] = $fd['FareItinerary']['DirectionInd'];
        
                        if(strtolower($refundStatus) == 'no' || strtolower($refundStatus) == false){
                            $no_refund++;
                        }else{
                            $refund++;
                        }
                        $newOriginDestinationOptions  =  $fd['FareItinerary']['OriginDestinationOptions'];
                        
                        $totalStopsOutCount = $newOriginDestinationOptions[0]['TotalStops'];
                        $totalStopsInCount = isset($newOriginDestinationOptions[1]) ? $newOriginDestinationOptions[1]['TotalStops'] : '';

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
                        $flightSegment = $newOriginDestinationOptions[0]['OriginDestinationOption'];
                        $flights[$loop]['totalOutStops'] = $totalStopsOutCount;
                        $flights[$loop]['totalInStops'] = $totalStopsInCount;
                        $flights[$loop]['OriginDestinationOptionsOutbound'] = $flightSegment;
                        $flights[$loop]['OriginDestinationOptionsInbound'] = isset($newOriginDestinationOptions[1]) ? $newOriginDestinationOptions[1]['OriginDestinationOption'] : [];
        
                        $layover = [];
                        $journeyDurations = 0;
                        $bagCount = 0;
                        $flightBaggage = [];
                        for($i=0; $i <= $totalStopsOutCount; $i++){
                            $iFlightSegment = $flightSegment[$i]['FlightSegment'];
                            $journeyDurations += $iFlightSegment['JourneyDuration'];
                            
                            if($totalStopsOutCount > 0){
                                if($i != 0){
                                    // if($iFlightSegment['DepartureAirportLocationCode'] == $flightSegment[$i-1]['FlightSegment']['ArrivalAirportLocationCode']){

                                        $timeInMin = getTimeDiffInMInutes($flightSegment[$i-1]['FlightSegment']['ArrivalDateTime'], $iFlightSegment['DepartureDateTime']);
                                        $layover[$iFlightSegment['DepartureAirportLocationCode']] = $timeInMin;
                                        $layover['place'][] = $data['airports'][$iFlightSegment['DepartureAirportLocationCode']]['City'];
                                        $layover['duration'][] = $timeInMin;    
                                    // }
                                }
                            }
                            $airlineCode = $iFlightSegment['MarketingAirlineCode'];
                            $flightCodes [] = $airlineCode;
                            $data['airlines'][$airlineCode] = isset($data['airlines'][$airlineCode]) ? ($data['airlines'][$airlineCode] + 1) : 1;

                            $originCode = $iFlightSegment['DepartureAirportLocationCode'];
                            $destinationCode = $iFlightSegment['ArrivalAirportLocationCode'];
    
                            if(!empty($airlineFilters) && in_array($airlineCode, $airlineFilters)){
                                $unsetLoops[] = $loop;
                            }
                        }

                        if($totalStopsOutCount == 0){
                            $totalDuration = $flightSegment[0]['FlightSegment']['JourneyDuration'];
                        }else{
                            $totalDuration = array_sum($layover['duration']) + $journeyDurations;
                        }


                        $layoverIn = [];
                        $journeyDurationsIn = 0;
                        $flightBaggageIn = [];
                        for($j=0; $j <= $totalStopsInCount; $j++){
                            if(isset($newOriginDestinationOptions[1])){
                                $jFlightSegment  = $flightSegment[$j]['FlightSegment'];

                                $journeyDurationsIn += $newOriginDestinationOptions[1]['OriginDestinationOption'][$j]['FlightSegment']['JourneyDuration'];
                                $flightSegment = $newOriginDestinationOptions[1]['OriginDestinationOption'];
                                if($totalStopsInCount > 0){
                                    if($j != 0){
                                        // if($jFlightSegment['DepartureAirportLocationCode'] == $flightSegment[$j-1]['FlightSegment']['ArrivalAirportLocationCode']){

                                            $timeInMin = getTimeDiffInMInutes($flightSegment[$j-1]['FlightSegment']['ArrivalDateTime'], $jFlightSegment['DepartureDateTime']);
                                            $layoverIn[$jFlightSegment['DepartureAirportLocationCode']] = $timeInMin;
                                            $layoverIn['place'][] = $data['airports'][$jFlightSegment['DepartureAirportLocationCode']]['City'];
                                            $layoverIn['duration'][] = $timeInMin;                               
                                        // }
                                    }
                                }
                                $airlineCode = $jFlightSegment['MarketingAirlineCode'];
                                $flightCodes [] = $airlineCode;
                                $data['airlines'][$airlineCode] = isset($data['airlines'][$airlineCode]) ? ($data['airlines'][$airlineCode] + 1) : 1;

                                $originCode = $jFlightSegment['DepartureAirportLocationCode'];
                                $destinationCode = $jFlightSegment['ArrivalAirportLocationCode'];
                                
                                if(!empty($airlineFilters) && in_array($airlineCode, $airlineFilters)){
                                    $unsetLoops[] = $loop;
                                }
                            }
                        }

                        if($totalStopsInCount == 0){
                            $totalDurationIn = isset($newOriginDestinationOptions[1]) ?  $newOriginDestinationOptions[1]['OriginDestinationOption'][0]['FlightSegment']['JourneyDuration'] : 0;
                        }else{
                            $totalDurationIn = isset($layoverIn['duration']) ? (array_sum($layoverIn['duration']) + $journeyDurationsIn) : $journeyDurationsIn;
                        }
        
                        $flights[$loop]['totalDurationIn'] = $totalDurationIn;
                        $flights[$loop]['layoversIn'] = $layoverIn;
                       
                        $flights[$loop]['totalDuration'] = $totalDuration;
                        $flights[$loop]['layovers'] = $layover;
                        
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

        $data['margins'] = (Auth::check()) ? getAgentMarginData(Auth::user()->id) : getUserMarginData(); 
        if($request->search_type == 'Return' && isset($result['AirSearchResponse']['AirSearchResultInbound'])){
            $data['totalCount'] = count($flights) + count($flightsIn);
            $data['flightDetails'] = $flights;
            $data['flightDetailsInbound'] = $flightsIn;
            return  view('web.search_results_domestic',compact('data'));
        }else{
            $data['totalCount'] = count($flights);
            $data['flightDetails'] = $flights;
            return  view('web.search_results',compact('data'));
        }
       
    }

    public function booking(Request $request){
        $data = [];
        // echo '<pre>';
        // print_r($request->all());
        // die;
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
        $data['margins'] = (Auth::check()) ? getAgentMarginData(Auth::user()->id) : getUserMarginData(); 
        
        $data['session_id'] = $request->session_id;
        $data['fare_sourceCode'] = $request->FareSourceCode;
        $data['fare_sourceCode_inbound'] = isset($request->FareSourceCodeIn) ? $request->FareSourceCodeIn : '';
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
        $bagCount =$bagCountIn = 0;

        if(!isset($result['AirRevalidateResponse']['AirRevalidateResultInbound'])){
            $IsValid = $result['AirRevalidateResponse']['AirRevalidateResult']['IsValid'];
            if($IsValid == 1 || $IsValid == 'true'){
                $FareItineraries = $result['AirRevalidateResponse']['AirRevalidateResult']['FareItineraries'];
                $ExtraServices = $result['AirRevalidateResponse']['AirRevalidateResult']['ExtraServices'];
                if(isset($FareItineraries['FareItinerary'])){
                    $FareItinerary = $FareItineraries['FareItinerary'];
                    $AirItineraryFareInfo = $FareItinerary['AirItineraryFareInfo'];
                    $ItinTotalFares = $AirItineraryFareInfo['ItinTotalFares'];

                    $data['FareSourceCode'] = $AirItineraryFareInfo['FareSourceCode'];
                    $data['FareType'] =  $AirItineraryFareInfo['FareType'];
                    $data['IsRefundable'] = $AirItineraryFareInfo['IsRefundable'];
                    $data['totalBaseFare'] = $ItinTotalFares['BaseFare'];
                    $data['totalTax'] = $ItinTotalFares['TotalTax'];
                    $data['totalFare'] = $ItinTotalFares['TotalFare'];
                    $data['ItinTotalFares'] = $ItinTotalFares;
                    $data['IsPassportMandatory'] =$FareItinerary['IsPassportMandatory'];
                    $data['DirectionInd'] =$FareItinerary['DirectionInd'];
                    $baggage = [];
                    $passengers = [];
                    $adultCount = $childCount = $infantCount = 0;
                    
                    foreach($AirItineraryFareInfo['FareBreakdown'] as $fareBreak){
                        $passengerCode = $fareBreak['PassengerTypeQuantity']['Code'];
                        $passengerQuantity = $fareBreak['PassengerTypeQuantity']['Quantity'];
                        if($passengerCode == "ADT"){
                            $adultCount = $passengerQuantity;
                        }elseif($passengerCode == "CHD"){
                            $childCount = $passengerQuantity;
                        }elseif($passengerCode == "INF"){
                            $infantCount = $passengerQuantity;
                        }
                        $PassengerFare = $fareBreak['PassengerFare'];
                        $baggage[$passengerCode]['Baggage'] = $fareBreak['Baggage'];
                        $baggage[$passengerCode]['CabinBaggage'] = $fareBreak['CabinBaggage'];
                        $baggage[$passengerCode]['Quantity'] = $passengerQuantity;
                        $baggage[$passengerCode]['CabinBaggage'] = $fareBreak['CabinBaggage'];
                        $baggage[$passengerCode]['BaseFare'] = $PassengerFare['BaseFare'];
                        $baggage[$passengerCode]['ServiceTax'] = $PassengerFare['ServiceTax'];
                        $baggage[$passengerCode]['TotalFare'] = $PassengerFare['TotalFare'];

                        $passengers[$passengerCode] = $passengerQuantity;
                    }
                    $data['adultCount'] = $adultCount;
                    $data['childCount'] = $childCount;
                    $data['infantCount'] = $infantCount;
                    $data['FareBreakdown'] = $baggage;
                    $data['passengers'] = $passengers;

                    if($request->search_type != 'Circle'){
                        $flightOutgoing = isset($FareItineraries['FareItinerary']['OriginDestinationOptions'][0]) ? $FareItineraries['FareItinerary']['OriginDestinationOptions'][0] : [];
                        if(!empty($flightOutgoing)){
                            $totalStopsCountOut = $flightOutgoing['TotalStops'];
                            $data['flightsOutgoing'] = $flightSegment = $flightOutgoing['OriginDestinationOption'];
                            for($i=0; $i <= $totalStopsCountOut; $i++){
                                $i_FlightSegment = $flightSegment[$i]['FlightSegment'];
                                $i_DepartureAirportCode = $i_FlightSegment['DepartureAirportLocationCode'];
                                $journeyDurations += $i_FlightSegment['JourneyDuration'];
                                if($totalStopsCountOut > 0){
                                    if($i != 0){
                                        // if($i_DepartureAirportCode == $flightSegment[$i-1]['FlightSegment']['ArrivalAirportLocationCode']){
                                            $timeInMin = getTimeDiffInMInutes($flightSegment[$i-1]['FlightSegment']['ArrivalDateTime'], $i_FlightSegment['DepartureDateTime']);
                                            $layover[$i_DepartureAirportCode] = $timeInMin;
                                            $layover['place'][] = $data['airports'][$i_DepartureAirportCode]['City'];
                                            $layover['duration'][] = $timeInMin;                                
                                        // }
                                    }
                                }
                                $airlineCode = $i_FlightSegment['MarketingAirlineCode'];
                                
                                $originCode = $i_DepartureAirportCode;
                                $destinationCode = $i_FlightSegment['ArrivalAirportLocationCode'];
                            
                                foreach($baggage as $key=>$value){
                                    $flightBaggage[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['baggage'] = (isset($value['Baggage'][$bagCount])) ? $value['Baggage'][$bagCount] : '';
                                    $flightBaggage[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['cabin_baggage'] = (isset($value['CabinBaggage'][$bagCount])) ? $value['CabinBaggage'][$bagCount] : '';
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
                                $in_FlightSegment = $flightSegmentIn[$in]['FlightSegment'];
                                $journeyDurationsIn += $in_FlightSegment['JourneyDuration'];
                                $in_DepartureAirportCode = $in_FlightSegment['DepartureAirportLocationCode'];
                                if($totalStopsCountIn > 0){
                                    if($in != 0){
                                        // if($in_DepartureAirportCode == $flightSegmentIn[$in-1]['FlightSegment']['ArrivalAirportLocationCode']){
                                            $timeInMin = getTimeDiffInMInutes($flightSegmentIn[$in-1]['FlightSegment']['ArrivalDateTime'], $in_FlightSegment['DepartureDateTime']);
                                            $layoverIn[$in_DepartureAirportCode] = $timeInMin;
                                            $layoverIn['place'][] = $data['airports'][$in_DepartureAirportCode]['City'];
                                            $layoverIn['duration'][] = $timeInMin;                                
                                        // }
                                    }
                                }
                                $airlineCode = $in_FlightSegment['MarketingAirlineCode'];
                                
                                $originCode = $in_DepartureAirportCode;
                                $destinationCode = $in_FlightSegment['ArrivalAirportLocationCode'];
                            
                                foreach($baggage as $key=>$value){
                                    $flightBaggageIn[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['baggage'] = (isset($value['Baggage'][$bagCount])) ? $value['Baggage'][$bagCount] : '';
                                    $flightBaggageIn[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['cabin_baggage'] = (isset($value['CabinBaggage'][$bagCount])) ? $value['CabinBaggage'][$bagCount] : '';
                                }
                                $bagCount = $bagCount + 1;
                            }
                            $data['flightBaggageIn'] = $flightBaggageIn;
                            $data['layoversIn'] = $layoverIn;
                        }
                    }else{
                        $flightOutgoing = isset($FareItineraries['FareItinerary']['OriginDestinationOptions']) ? $FareItineraries['FareItinerary']['OriginDestinationOptions'] : [];
                        if(!empty($flightOutgoing)){
                            foreach($flightOutgoing as $fout){
                                $flightSegment = $fout['OriginDestinationOption'];
                                foreach($flightSegment as $fSegment){
                                    $data['flightsOutgoing'][] = $fSegment;
                                    $i_FlightSegment = $fSegment['FlightSegment'];
                                    $originCode = $i_FlightSegment['DepartureAirportLocationCode'];

                                    $airlineCode = $i_FlightSegment['MarketingAirlineCode'];
                                    $destinationCode = $i_FlightSegment['ArrivalAirportLocationCode'];
                                    foreach($baggage as $key=>$value){
                                        $flightBaggage[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['baggage'] = (isset($value['Baggage'][$bagCount])) ? $value['Baggage'][$bagCount] : '';
                                        $flightBaggage[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['cabin_baggage'] = (isset($value['CabinBaggage'][$bagCount])) ? $value['CabinBaggage'][$bagCount] : '';
                                    }
                                    $bagCount = $bagCount + 1;
                                }
                            }
                            
                            $data['flightBaggageOut'] = $flightBaggage;
                        }
                    }
                }
                if(isset($ExtraServices['Services'])){
                    if($data['search_type'] == 'Return' || $data['search_type'] == 'OneWay'){
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
            }
        }else{
            $IsValid = $result['AirRevalidateResponse']['AirRevalidateResult']['IsValid'];
             if($IsValid == 1 || $IsValid == 'true'){
                $FareItineraries = $result['AirRevalidateResponse']['AirRevalidateResult']['FareItineraries'];
                $ExtraServices = $result['AirRevalidateResponse']['AirRevalidateResult']['ExtraServices'];
                if(isset($FareItineraries['FareItinerary'])){
                    $FareItinerary = $FareItineraries['FareItinerary'];
                    $AirItineraryFareInfo = $FareItinerary['AirItineraryFareInfo'];
                    $ItinTotalFares = $AirItineraryFareInfo['ItinTotalFares'];

                    $data['FareSourceCode'] = $AirItineraryFareInfo['FareSourceCode'];
                    $data['FareType'] =  $AirItineraryFareInfo['FareType'];
                    $data['IsRefundable'] = $AirItineraryFareInfo['IsRefundable'];
                    $data['totalBaseFare'] = $ItinTotalFares['BaseFare'];
                    $data['totalTax'] = $ItinTotalFares['TotalTax'];
                    $data['totalFare'] = $ItinTotalFares['TotalFare'];
                    $data['ItinTotalFares'] = $ItinTotalFares;
                    $data['IsPassportMandatory'] =$FareItinerary['IsPassportMandatory'];
                    $data['DirectionInd'] =$FareItinerary['DirectionInd'];
                    $baggage = [];
                    $passengers = [];
                    $adultCount = $childCount = $infantCount = 0;
                    
                    foreach($AirItineraryFareInfo['FareBreakdown'] as $fareBreak){
                        $passengerCode = $fareBreak['PassengerTypeQuantity']['Code'];
                        $passengerQuantity = $fareBreak['PassengerTypeQuantity']['Quantity'];
                        if($passengerCode == "ADT"){
                            $adultCount = $passengerQuantity;
                        }elseif($passengerCode == "CHD"){
                            $childCount = $passengerQuantity;
                        }elseif($passengerCode == "INF"){
                            $infantCount = $passengerQuantity;
                        }
                        $PassengerFare = $fareBreak['PassengerFare'];
                        $baggage[$passengerCode]['Baggage'] = $fareBreak['Baggage'];
                        $baggage[$passengerCode]['CabinBaggage'] = $fareBreak['CabinBaggage'];
                        $baggage[$passengerCode]['Quantity'] = $passengerQuantity;
                        $baggage[$passengerCode]['CabinBaggage'] = $fareBreak['CabinBaggage'];
                        $baggage[$passengerCode]['BaseFare'] = $PassengerFare['BaseFare'];
                        $baggage[$passengerCode]['ServiceTax'] = $PassengerFare['ServiceTax'];
                        $baggage[$passengerCode]['TotalFare'] = $PassengerFare['TotalFare'];

                        $passengers[$passengerCode] = $passengerQuantity;
                    }
                    $data['adultCount'] = $adultCount;
                    $data['childCount'] = $childCount;
                    $data['infantCount'] = $infantCount;
                    $data['FareBreakdown'] = $baggage;
                    $data['passengers'] = $passengers;

                    if($request->search_type == 'Return'){
                        $flightOutgoing = isset($FareItineraries['FareItinerary']['OriginDestinationOptions'][0]) ? $FareItineraries['FareItinerary']['OriginDestinationOptions'][0] : [];
                        if(!empty($flightOutgoing)){
                            $totalStopsCountOut = $flightOutgoing['TotalStops'];
                            $data['flightsOutgoing'] = $flightSegment = $flightOutgoing['OriginDestinationOption'];
                            for($i=0; $i <= $totalStopsCountOut; $i++){
                                $i_FlightSegment = $flightSegment[$i]['FlightSegment'];
                                $i_DepartureAirportCode = $i_FlightSegment['DepartureAirportLocationCode'];
                                $journeyDurations += $i_FlightSegment['JourneyDuration'];
                                if($totalStopsCountOut > 0){
                                    if($i != 0){
                                        // if($i_DepartureAirportCode == $flightSegment[$i-1]['FlightSegment']['ArrivalAirportLocationCode']){
                                            $timeInMin = getTimeDiffInMInutes($flightSegment[$i-1]['FlightSegment']['ArrivalDateTime'], $i_FlightSegment['DepartureDateTime']);
                                            $layover[$i_DepartureAirportCode] = $timeInMin;
                                            $layover['place'][] = $data['airports'][$i_DepartureAirportCode]['City'];
                                            $layover['duration'][] = $timeInMin;                                
                                        // }
                                    }
                                }
                                $airlineCode = $i_FlightSegment['MarketingAirlineCode'];
                                
                                $originCode = $i_DepartureAirportCode;
                                $destinationCode = $i_FlightSegment['ArrivalAirportLocationCode'];
                            
                                foreach($baggage as $key=>$value){
                                    $flightBaggage[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['baggage'] = (isset($value['Baggage'][$bagCount])) ? $value['Baggage'][$bagCount] : '';
                                    $flightBaggage[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['cabin_baggage'] = (isset($value['CabinBaggage'][$bagCount])) ? $value['CabinBaggage'][$bagCount] : '';
                                }
                                $bagCount = $bagCount + 1;
                            }
                            $data['flightBaggageOut'] = $flightBaggage;
                            $data['layovers'] = $layover;
                        }
                    }
                }
                if(isset($ExtraServices['Services'])){
                    if($data['search_type'] == 'Return' || $data['search_type'] == 'OneWay'){
                        $extraServicesData = $ExtraServices['Services'];
                        foreach($extraServicesData as $extService){
                            $extraType = $extService['Service']['Type'];
                            if($extraType == "BAGGAGE"){
                                $data['extraBaggage']['outGoing'][] = $extService;
                            }
                        }
                    }
                
                }
            }

            $IsValidIn = $result['AirRevalidateResponse']['AirRevalidateResultInbound']['IsValid'];
            if($IsValidIn == 1 || $IsValidIn == 'true'){
                $FareItinerariesIn = $result['AirRevalidateResponse']['AirRevalidateResultInbound']['FareItineraries'];
                $ExtraServicesIn = $result['AirRevalidateResponse']['AirRevalidateResultInbound']['ExtraServices'];
                if(isset($FareItinerariesIn['FareItinerary'])){
                    $FareItineraryIn = $FareItinerariesIn['FareItinerary'];
                    $AirItineraryFareInfoIn = $FareItineraryIn['AirItineraryFareInfo'];
                    $ItinTotalFaresIn = $AirItineraryFareInfoIn['ItinTotalFares'];

                    $data['FareSourceCodeInbound'] = $AirItineraryFareInfoIn['FareSourceCode'];
                    $data['FareTypeIn'] =  $AirItineraryFareInfoIn['FareType'];
                    $data['IsRefundableIn'] = $AirItineraryFareInfoIn['IsRefundable'];
                    $data['totalBaseFareIn'] = $ItinTotalFaresIn['BaseFare'];
                    $data['totalTaxIn'] = $ItinTotalFaresIn['TotalTax'];
                    $data['totalFareIn'] = $ItinTotalFaresIn['TotalFare'];
                    $data['ItinTotalFaresIn'] = $ItinTotalFaresIn;
                    $data['IsPassportMandatoryIn'] =$FareItineraryIn['IsPassportMandatory'];
                    $data['DirectionIndIn'] =$FareItineraryIn['DirectionInd'];
                    $baggageIn = [];
                    $passengersIn = [];
                    $adultCountIn = $childCountIn = $infantCountIn = 0;
                    
                    foreach($AirItineraryFareInfoIn['FareBreakdown'] as $fareBreakIn){
                        $passengerCodeIn = $fareBreakIn['PassengerTypeQuantity']['Code'];
                        $passengerQuantityIn = $fareBreakIn['PassengerTypeQuantity']['Quantity'];
                        if($passengerCodeIn == "ADT"){
                            $adultCountIn = $passengerQuantityIn;
                        }elseif($passengerCodeIn == "CHD"){
                            $childCountIn = $passengerQuantityIn;
                        }elseif($passengerCodeIn == "INF"){
                            $infantCountIn = $passengerQuantityIn;
                        }
                        $PassengerFareIn = $fareBreakIn['PassengerFare'];
                        $baggageIn[$passengerCodeIn]['Baggage'] = $fareBreakIn['Baggage'];
                        $baggageIn[$passengerCodeIn]['CabinBaggage'] = $fareBreakIn['CabinBaggage'];
                        $baggageIn[$passengerCodeIn]['Quantity'] = $passengerQuantityIn;
                        $baggageIn[$passengerCodeIn]['CabinBaggage'] = $fareBreakIn['CabinBaggage'];
                        $baggageIn[$passengerCodeIn]['BaseFare'] = $PassengerFareIn['BaseFare'];
                        $baggageIn[$passengerCodeIn]['ServiceTax'] = $PassengerFareIn['ServiceTax'];
                        $baggageIn[$passengerCodeIn]['TotalFare'] = $PassengerFareIn['TotalFare'];

                        $passengersIn[$passengerCodeIn] = $passengerQuantityIn;
                    }
                    $data['adultCountIn'] = $adultCountIn;
                    $data['childCountIn'] = $childCountIn;
                    $data['infantCountIn'] = $infantCountIn;
                    $data['FareBreakdownIn'] = $baggageIn;
                    $data['passengersIn'] = $passengersIn;

                    if($request->search_type == 'Return'){
                        $flightIncoming = isset($FareItinerariesIn['FareItinerary']['OriginDestinationOptions'][0]) ? $FareItinerariesIn['FareItinerary']['OriginDestinationOptions'][0] : [];
                        if(!empty($flightIncoming)){
                            $totalStopsCountIn = $flightIncoming['TotalStops'];
                            $data['flightsIncoming'] = $flightSegmentIn = $flightIncoming['OriginDestinationOption'];
                            for($in=0; $in <= $totalStopsCountIn; $in++){
                                $in_FlightSegment = $flightSegmentIn[$in]['FlightSegment'];
                                $in_DepartureAirportCode = $in_FlightSegment['DepartureAirportLocationCode'];
                                $journeyDurationsIn += $in_FlightSegment['JourneyDuration'];
                                if($totalStopsCountIn > 0){
                                    if($in != 0){
                                        // if($in_DepartureAirportCode == $flightSegmentIn[$in-1]['FlightSegment']['ArrivalAirportLocationCode']){
                                            $timeInMinIn = getTimeDiffInMInutes($flightSegmentIn[$in-1]['FlightSegment']['ArrivalDateTime'], $in_FlightSegment['DepartureDateTime']);
                                            $layoverIn[$in_DepartureAirportCode] = $timeInMinIn;
                                            $layoverIn['place'][] = $data['airports'][$in_DepartureAirportCode]['City'];
                                            $layoverIn['duration'][] = $timeInMinIn;                                
                                        // }
                                    }
                                }
                                $airlineCodeIn = $in_FlightSegment['MarketingAirlineCode'];
                                
                                $originCodeIn = $in_DepartureAirportCode;
                                $destinationCodeIn = $in_FlightSegment['ArrivalAirportLocationCode'];
                            
                                foreach($baggageIn as $keyIn=>$valueIn){
                                    $flightBaggageIn[$airlineCodeIn.'_'.$originCodeIn.'_'.$destinationCodeIn][$keyIn]['baggage'] = (isset($valueIn['Baggage'][$bagCountIn])) ? $valueIn['Baggage'][$bagCountIn] : '';
                                    $flightBaggageIn[$airlineCodeIn.'_'.$originCodeIn.'_'.$destinationCodeIn][$keyIn]['cabin_baggage'] = (isset($valueIn['CabinBaggage'][$bagCountIn])) ? $valueIn['CabinBaggage'][$bagCountIn] : '';
                                }
                                $bagCountIn = $bagCountIn + 1;
                            }
                            $data['flightBaggageIn'] = $flightBaggageIn;
                            $data['layoversIn'] = $layoverIn;
                        }
                    }
                }
                if(isset($ExtraServicesIn['Services'])){
                    if($data['search_type'] == 'Return' || $data['search_type'] == 'OneWay'){
                        $extraServicesDataIn = $ExtraServicesIn['Services'];
                        foreach($extraServicesDataIn as $extServiceIn){
                            $extraTypeIn = $extServiceIn['Service']['Type'];
                            if($extraTypeIn == "BAGGAGE"){
                                $data['extraBaggage']['inComing'][] = $extServiceIn;   
                            }
                        }
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

    public function fightViewDetails(Request $request){
        $data = [];
        // echo '<pre>';
        // print_r($request->all());
        if(isset($request->FareSourceCodeIn)){
            $apiKeys = [ 
                "session_id" => $request->session_id,
                "fare_source_code" => $request->fareCode,
                "fare_source_code_inbound" => $request->fareCodeIn
            ];
        }else{
            $apiKeys = [ 
                "session_id" => $request->session_id,
                "fare_source_code" => $request->fareCode
            ];
        }
        $data['search_type'] = $request->search_type;
        $data['id'] = $request->id;
        $data['margins'] = (Auth::check()) ? getAgentMarginData(Auth::user()->id) : getUserMarginData(); 
       
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
        if($IsValid == 1 || $IsValid == 'true'){
            $FareItineraries = $result['AirRevalidateResponse']['AirRevalidateResult']['FareItineraries'];
            $ExtraServices = $result['AirRevalidateResponse']['AirRevalidateResult']['ExtraServices'];
            if(isset($FareItineraries['FareItinerary'])){
                $FareItinerary = $FareItineraries['FareItinerary'];
                $AirItineraryFareInfo = $FareItinerary['AirItineraryFareInfo'];
                $ItinTotalFares = $AirItineraryFareInfo['ItinTotalFares'];
               
                $baggage = [];
                $passengers = [];
                
                $data['totalFare'] = $ItinTotalFares;
                foreach($AirItineraryFareInfo['FareBreakdown'] as $fareBreak){
                    $passengerCode = $fareBreak['PassengerTypeQuantity']['Code'];
                    $passengerQuantity = $fareBreak['PassengerTypeQuantity']['Quantity'];
                    $PassengerFare = $fareBreak['PassengerFare'];
                    $baggage[$passengerCode]['Baggage'] = $fareBreak['Baggage'];
                    $baggage[$passengerCode]['CabinBaggage'] = $fareBreak['CabinBaggage'];
                    $baggage[$passengerCode]['Quantity'] = $passengerQuantity;
                    $baggage[$passengerCode]['BaseFare'] = $PassengerFare['BaseFare'];
                    $baggage[$passengerCode]['ServiceTax'] = $PassengerFare['ServiceTax'];
                    $baggage[$passengerCode]['TotalFare'] = $PassengerFare['TotalFare'];

                    $passengers[$passengerCode] = $passengerQuantity;
                }
                $data['FareBreakdown'] = $baggage;
                if($request->search_type != 'Circle'){
                    $flightOutgoing = isset($FareItineraries['FareItinerary']['OriginDestinationOptions'][0]) ? $FareItineraries['FareItinerary']['OriginDestinationOptions'][0] : [];
                    if(!empty($flightOutgoing)){
                        $totalStopsCountOut = $flightOutgoing['TotalStops'];
                        $data['flightsOutgoing'] = $flightSegment = $flightOutgoing['OriginDestinationOption'];
                        for($i=0; $i <= $totalStopsCountOut; $i++){
                            $i_FlightSegment = $flightSegment[$i]['FlightSegment'];
                            $i_DepartureAirportCode = $i_FlightSegment['DepartureAirportLocationCode'];
                            $journeyDurations += $i_FlightSegment['JourneyDuration'];
                            if($totalStopsCountOut > 0){
                                if($i != 0){
                                    // if($i_DepartureAirportCode == $flightSegment[$i-1]['FlightSegment']['ArrivalAirportLocationCode']){
                                    $timeInMin = getTimeDiffInMInutes($flightSegment[$i-1]['FlightSegment']['ArrivalDateTime'], $i_FlightSegment['DepartureDateTime']);
                                    $layover[$i_DepartureAirportCode] = $timeInMin;

                                    $deptAirportData = getAirportData($i_DepartureAirportCode);

                                    $layover['place'][] = $deptAirportData[0]['City'];
                                    $layover['duration'][] = $timeInMin;                                
                                    // }
                                }
                            }
                            $airlineCode = $i_FlightSegment['MarketingAirlineCode'];
                            
                            $originCode = $i_DepartureAirportCode;
                            $destinationCode = $i_FlightSegment['ArrivalAirportLocationCode'];
                        
                            foreach($baggage as $key=>$value){
                                $flightBaggage[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['baggage'] = (isset($value['Baggage'][$bagCount])) ? $value['Baggage'][$bagCount] : '';
                                $flightBaggage[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['cabin_baggage'] = (isset($value['CabinBaggage'][$bagCount])) ? $value['CabinBaggage'][$bagCount] : '';
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
                            $in_FlightSegment = $flightSegmentIn[$in]['FlightSegment'];
                            $journeyDurationsIn += $in_FlightSegment['JourneyDuration'];
                            $in_DepartureAirportCode = $in_FlightSegment['DepartureAirportLocationCode'];
                            if($totalStopsCountIn > 0){
                                if($in != 0){
                                    // if($in_DepartureAirportCode == $flightSegmentIn[$in-1]['FlightSegment']['ArrivalAirportLocationCode']){
                                        $timeInMin = getTimeDiffInMInutes($flightSegmentIn[$in-1]['FlightSegment']['ArrivalDateTime'], $in_FlightSegment['DepartureDateTime']);
                                        $layoverIn[$in_DepartureAirportCode] = $timeInMin;
    
                                        $deptAirportDataIn = getAirportData($in_DepartureAirportCode);
                                        $layoverIn['place'][] = $deptAirportDataIn[0]['City'];
                                        $layoverIn['duration'][] = $timeInMin;                                
                                    // }
                                }
                            }
                            $airlineCode = $in_FlightSegment['MarketingAirlineCode'];
                            
                            $originCode = $in_DepartureAirportCode;
                            $destinationCode = $in_FlightSegment['ArrivalAirportLocationCode'];
                        
                            foreach($baggage as $key=>$value){
                                $flightBaggageIn[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['baggage'] = (isset($value['Baggage'][$bagCount])) ? $value['Baggage'][$bagCount] : '';
                                $flightBaggageIn[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['cabin_baggage'] = (isset($value['CabinBaggage'][$bagCount])) ? $value['CabinBaggage'][$bagCount] : '';
                            }
                            $bagCount = $bagCount + 1;
                        }
                        $data['flightBaggageIn'] = $flightBaggageIn;
                        $data['layoversIn'] = $layoverIn;
                    }
                }else{
                    $flightOutgoing = isset($FareItineraries['FareItinerary']['OriginDestinationOptions']) ? $FareItineraries['FareItinerary']['OriginDestinationOptions'] : [];
                    if(!empty($flightOutgoing)){
                        foreach($flightOutgoing as $fout){
                            $flightSegment = $fout['OriginDestinationOption'];
                            foreach($flightSegment as $fSegment){
                                $data['flightsOutgoing'][] = $fSegment;
                                $i_FlightSegment = $fSegment['FlightSegment'];
                                $originCode = $i_FlightSegment['DepartureAirportLocationCode'];

                                $airlineCode = $i_FlightSegment['MarketingAirlineCode'];
                                $destinationCode = $i_FlightSegment['ArrivalAirportLocationCode'];
                                foreach($baggage as $key=>$value){
                                    $flightBaggage[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['baggage'] = (isset($value['Baggage'][$bagCount])) ? $value['Baggage'][$bagCount] : '';
                                    $flightBaggage[$airlineCode.'_'.$originCode.'_'.$destinationCode][$key]['cabin_baggage'] = (isset($value['CabinBaggage'][$bagCount])) ? $value['CabinBaggage'][$bagCount] : '';
                                }
                                $bagCount = $bagCount + 1;
                            }
                        }
                        
                        $data['flightBaggageOut'] = $flightBaggage;
                    }
                } 
                $viewdata = view('web.ajax_flight_data', compact('data'))->render();
                $msg = array('status' => true,'data' => $viewdata);
            }else{
                $msg = array('status' => false,'data' => []);
            }
        }else{
            $msg = array('status' => false,'data' => []);
        }
        
        // echo '<pre>';
        // print_r($data);
        // die;
        
        echo json_encode($msg);
    }

    public function createBooking(Request $request){
        
        $adultArray = $childArray = $infantArray = $adultServiceOut = $childServiceOut = $infantServiceOut = $adultServiceIn = $childServiceIn = $infantServiceIn = [];
        $details = $request->all();
        // echo '<pre>';
        // print_r($details);die;
        // print_r($request->baggageIn);
        $adultCount = $request->adultCount;
        $childCount = $request->childCount;
        $infantCount = $request->infantCount;
        $totalAddons = $request->total_addons;
        if($totalAddons != 0 && $totalAddons != ''){
            $adultExtra = $childExtra = $infantExtra = 0;
            if(isset($request->baggageOut)){
                foreach($request->baggageOut as $okey=>$obag){
                    if(isset($obag[0]) && $obag[0] != 0){
                        for($i=1; $i<= $obag[0];$i++){
                            if($adultExtra != $adultCount){
                                $adultServiceOut[] = array($okey);
                                $adultExtra++;
                            }elseif($childExtra != $childCount){
                                $childServiceOut[] = array($okey);
                                $childExtra++;
                            }elseif($infantExtra != $infantCount){
                                $infantServiceOut[] = array($okey);
                                $infantExtra++;
                            }
                        }
                    }
                }
            }
            $adultExtraIn = $childExtraIn = $infantExtraIn = 0;
            if(isset($request->baggageIn)){
                foreach($request->baggageIn as $ikey=>$ibag){
                    if(isset($ibag[0]) && $ibag[0] != 0){
                        for($i=1; $i<= $ibag[0];$i++){
                            if($adultExtraIn != $adultCount){
                                $adultServiceIn[] = array($ikey);
                                $adultExtraIn++;
                            }elseif($childExtraIn != $childCount){
                                $childServiceIn[] = array($ikey);
                                $childExtraIn++;
                            }elseif($infantExtraIn != $infantCount){
                                $infantServiceIn[] = array($ikey);
                                $infantExtraIn++;
                            }
                        }
                    }
                }
            }
        }

        // print_r($adultServiceOut);
        // print_r($childServiceOut);
        // print_r($infantServiceOut);
        // print_r($adultServiceIn);
        // print_r($childServiceIn);
        // print_r($infantServiceIn);
        // $agentMargins = [] ;
        // echo '<br>'. $details['total_amount_org'];
        
        // echo '<br>';
        // print_r($margins);
        // print_r($agentMargins);
        // die;
        $data['flightBookingInfo']['flight_session_id'] = $request->session_id;
        $data['flightBookingInfo']['fare_source_code'] = $request->fare_source_code;
        if(isset($request->fare_source_code_inbound)){
            $data['flightBookingInfo']['fare_source_code_inbound'] = $request->fare_source_code_inbound;
        }
        $data['flightBookingInfo']['IsPassportMandatory'] = $request->IsPassportMandatory;
        $data['flightBookingInfo']['fareType'] = $request->FareType;
        $data['flightBookingInfo']['countryCode'] = $request->mobile_code;
        $data['flightBookingInfo']['areaCode'] = $request->mobile_code;

        $clientRef = str_replace(':','', str_replace("-","",date('d-m-yH:i:s')));
        $details['clientRef'] = $clientRef;
        $data["paxInfo"]["clientRef"] = $clientRef;
        $data["paxInfo"]["customerEmail"] = $request->email;
        $data["paxInfo"]["customerPhone"] = $request->mobile_no;

        if($adultCount != 0){
            $adultArray["title"] =  $request->adult_title;
            $adultArray["firstName"] =  $request->adult_first_name;
            $adultArray["lastName"] =   $request->adult_last_name;
            $adultArray["dob"] =   $request->adult_dob;
            $adultArray["nationality"] =   $request->adult_nationality;
            $adultArray["passportNo"] =   $request->adult_passport;
            $adultArray["passportIssueCountry"] =   $request->adult_passport_country;
            $adultArray["passportExpiryDate"] =   $request->adult_passport_expiry;
            // if($request->FareType == 'WebFare'){
            //     if(!empty($adultServiceOut)){
            //         $adultArray["ExtraServiceOutbound"] = $adultServiceOut;
            //     }
            //     if(!empty($adultServiceIn)){
            //         $adultArray["ExtraServiceInbound"] = $adultServiceIn;
            //     }
            // }
            $adultArray["ExtraServiceOutbound"] = $adultServiceOut;
            $adultArray["ExtraServiceInbound"] = $adultServiceIn;
            $paxDetails["adult"] = $adultArray;
        }
        if($childCount != 0){
            $childArray["title"] =  $request->child_title;
            $childArray["firstName"] =  $request->child_first_name;
            $childArray["lastName"] =   $request->child_last_name;
            $childArray["dob"] =   $request->child_dob;
            $childArray["nationality"] =   $request->child_nationality;
            $childArray["passportNo"] =   $request->child_passport;
            $childArray["passportIssueCountry"] =   $request->child_passport_country;
            $childArray["passportExpiryDate"] =   $request->child_passport_expiry;
            // if($request->FareType == 'WebFare'){
            //     if(!empty($childServiceOut)){
            //         $childArray["ExtraServiceOutbound"] = $childServiceOut;
            //     }
            //     if(!empty($childServiceIn)){
            //         $childArray["ExtraServiceInbound"] = $childServiceIn;
            //     }
            // }
            $childArray["ExtraServiceOutbound"] = $childServiceOut;
            $childArray["ExtraServiceInbound"] = $childServiceIn;
        
            $paxDetails["child"] = $childArray;
        }
        if($infantCount != 0){
            $infantArray["title"] =  $request->infant_title;
            $infantArray["firstName"] =  $request->infant_first_name;
            $infantArray["lastName"] =   $request->infant_last_name;
            $infantArray["dob"] =   $request->infant_dob;
            $infantArray["nationality"] =   $request->infant_nationality;
            $infantArray["passportNo"] =   $request->infant_passport;
            $infantArray["passportIssueCountry"] =   $request->infant_passport_country;
            $infantArray["passportExpiryDate"] =   $request->infant_passport_expiry;
            $infantArray["ExtraServiceOutbound"] = $infantServiceOut;
            $infantArray["ExtraServiceInbound"] = $infantServiceIn;
            $paxDetails["infant"] = $infantArray;
        }
        $data["paxInfo"]["paxDetails"][] = $paxDetails;
        // echo json_encode($data["paxInfo"]["paxDetails"]);
        // echo '<pre>';
        // print_r($data);
        // die;
        $response = Http::timeout(300)->withOptions($this->options)->post(config('global.api_base_url').'booking', $data);

        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);
        
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
                    if($ticketOrderResSuccess == 'true' || $ticketOrderResSuccess == "1"){
                        $tripDetails = $this->getTripDetails($bookingId);
                        $tripDetails = json_decode($tripDetails, true);
                        // echo '<pre>';
                        // print_r($tripDetails);
                        // die;
                        if(isset($tripDetails['TripDetailsResponse'])){
                            $TripDetailsResponse = $tripDetails['TripDetailsResponse'];
                            if(isset($TripDetailsResponse['TripDetailsResultInbound'])){
                                $tripDetailsResult = $TripDetailsResponse['TripDetailsResult'];
                                $tripDetailsResultInbound = $TripDetailsResponse['TripDetailsResultInbound'];
                                if($tripDetailsResult['Success'] == 'true'){
                                    $bookingId = $this->saveDomesticFlightBookingData($tripDetailsResult, $tripDetailsResultInbound, $details);
                                }
                            }else{
                                $tripDetailsResult = $TripDetailsResponse['TripDetailsResult'];
                                if($tripDetailsResult['Success'] == 'true'){
                                    $bookingId = $this->saveFlightBookingData($tripDetailsResult, $details);
                                }
                            }
                        } 
                    }
                }else{
                    $tripDetails = $this->getTripDetails($bookingId);
                    $tripDetails = json_decode($tripDetails, true);
                    // echo '<pre>';
                    // print_r($tripDetails);
                    // die;
                    if(isset($tripDetails['TripDetailsResponse'])){
                        $TripDetailsResponse = $tripDetails['TripDetailsResponse'];
                        if(isset($TripDetailsResponse['TripDetailsResultInbound'])){
                            $tripDetailsResult = $TripDetailsResponse['TripDetailsResult'];
                            $tripDetailsResultInbound = $TripDetailsResponse['TripDetailsResultInbound'];
                            if($tripDetailsResult['Success'] == 'true'){
                                $bookingId = $this->saveDomesticFlightBookingData($tripDetailsResult, $tripDetailsResultInbound, $details);
                            }
                        }else{
                            $tripDetailsResult = $TripDetailsResponse['TripDetailsResult'];
                            if($tripDetailsResult['Success'] == 'true'){
                                $bookingId = $this->saveFlightBookingData($tripDetailsResult, $details);
                            }
                        }
                    } 
                }
                $msg = 'success';
                $bookings = $this->getBookingDetails($bookingId);
                $this->sendBookingMail($bookings);
                
            }else{
                // print_r($bookResult);
                $bookings= [];
                $msg =  (isset($bookResult['Errors']['Error'])) ? $bookResult['Errors']['Error']['ErrorMessage'] : ((isset($bookResult['Errors']['Errors'])) ? $bookResult['Errors']['Errors']['ErrorMessage'] : 'Something went wrong');
            }
        }else{
            $bookings = [];
            $msg =  (isset($result['status']['errors'][0])) ? $result['status']['errors'][0]['errorMessage'] : 'Something went wrong';
        }   
        return  view('web.booking_success',compact('msg','bookings'));
   }

    public function sendBookingMail($bookings){
        $name = $to_name = $bookings[0]->customer_name;
        $to_email = $bookings[0]->customer_email;
        $viewdata = view('web.booking_email', compact('name','bookings'))->render();
        $data = array('name'=> $to_name, 'body' => $viewdata);
        Mail::send('web.email.booking_email', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name) ->subject('Flight Booked!');
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });

    }

    public function sendReissueBookingMail($bookings){
        $name = $to_name = $bookings[0]->customer_name;
        $to_email = $bookings[0]->customer_email;
        $viewdata = view('web.booking_email', compact('name','bookings'))->render();
        $data = array('name'=> $to_name, 'body' => $viewdata);
        Mail::send('web.email.booking_email', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name) ->subject('Flight Booking Reissued!');
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });

    }

    public function sendCancelMail($bookings){
        $name = $to_name = $bookings[0]->customer_name;
        $to_email = $bookings[0]->customer_email;
        $viewdata = view('web.cancel_email', compact('name','bookings'))->render();
        $data = array('name'=> $to_name, 'body' => $viewdata);
        Mail::send('web.email.booking_email', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name) ->subject('Flight Booking Cancelled!');
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });

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
        // // print_r($data);
        // print_r($travelItinerary);
        $agentMargins = [];
        $totalOrgAmount = $data['total_amount_org'];
        $margins = (Auth::check()) ? getAgentMarginData(Auth::user()->id) : getUserMarginData(); 
        
        $adminMargin = $margins['admin_margin'];
        $adminMarginAmount = (($totalOrgAmount/100) * $margins['admin_margin']);
        $adminMarginAmount = number_format(floor($adminMarginAmount*100)/100, 2, '.', '');

        $agentsMarginAmount = (($totalOrgAmount/100) * ($margins['totalmargin'] - $margins['admin_margin']));
        $agentsMarginAmount = ($agentsMarginAmount != 0) ? number_format(floor($agentsMarginAmount*100)/100, 2, '.', '') : 0;

        $ItineraryInfo = $travelItinerary['ItineraryInfo'];
        $CustomerInfos = $ItineraryInfo['CustomerInfos'];
        $extraServices = (isset($ItineraryInfo['ExtraServices'])) ? $ItineraryInfo['ExtraServices'] : [];;
        $ReservationItems = $ItineraryInfo['ReservationItems'];
        $totalAmount = str_replace(',','',$data['total_amount']);     
        $currency = $data['currency'];  

        if($currency != 'USD'){
            $oneCurrency = getCurrencyValue($currency);
        }else{
            $oneCurrency=1 ;
        }
        $bookData = [
            'user_id' => Auth::user()->id, 
            'unique_booking_id' => $travelItinerary['UniqueID'], 
            'direction' => $data['direction'],
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
            'currency' => $currency,
            'adult_amount' => $data['adult_amount'], 
            'child_amount' => $data['child_amount'], 
            'infant_amount' => $data['infant_amount'], 
            'total_amount' => $totalAmount, 
            'total_tax' => $data['total_tax'], 
            'addon_amount' => $data['total_addons'],
            'created_at'=> date('Y-m-d H:i:s'),
            'total_amount_actual' => $totalOrgAmount, 
            'total_tax_actual' => $data['total_tax_org'], 
            'admin_margin' => $adminMargin, 
            'admin_amount' => number_format(($adminMarginAmount*$oneCurrency), 2, '.', ''), 
            'agents_amount' => number_format(($agentsMarginAmount*$oneCurrency), 2, '.', ''), 
        ];
       
        $flightBook = FlightBookings::create($bookData);
        $flightBookId = $flightBook->id;

        if(isset($margins['agent_margin'])){
            $currentAgentMargin = $margins['agent_margin'];
            $agentAmount = (($totalOrgAmount/100) * $currentAgentMargin);
            $agentAmount = number_format(floor($agentAmount*100)/100, 2, '.', '');

            $deductUsd = number_format(($totalAmount*$oneCurrency), 2, '.', '');

            $currentAgent = UserDetails::where('user_id',Auth::user()->id)->first();
            $currentCredit = $currentAgent->credit_balance;
            
            $currentCreditNew = $currentCredit - $deductUsd;
            $agentUSD = number_format(($agentAmount*$oneCurrency), 2, '.', '');
            $agentMargins[] = array(
                'booking_id' => $flightBookId,
                'agent_id'   => Auth::user()->id,
                'from_agent_id' => NULL,
                'margin'     => $currentAgentMargin,
                'amount'    => $totalAmount,
                'total_amount' => $totalOrgAmount,
                'currency' => $currency,
                'usd_amount' => $deductUsd,
                'usd_rate' => $oneCurrency,
                'credit_balance' => $currentCreditNew,
                'transaction_type' => 'dr',
                'created_at' => date('Y-m-d H:i:s')
            );

            $agentMargins[] = array(
                'booking_id' => $flightBookId,
                'agent_id'   => Auth::user()->id,
                'from_agent_id' => NULL,
                'margin'     => $currentAgentMargin,
                'amount'    => $agentAmount,
                'total_amount' => $totalOrgAmount,
                'currency' => $currency,
                'usd_amount' => $agentUSD,
                'usd_rate' => $oneCurrency,
                'transaction_type' => 'cr',
                'credit_balance' => $currentCreditNew + $agentUSD,
                'created_at' => date('Y-m-d H:i:s')
            );
            $currentAgent->credit_balance = ($currentCreditNew + $agentUSD);
            $currentAgent->save();
        }
        if(isset($margins['main_agents'])){
            foreach($margins['main_agents'] as $agentid => $marg){
                $agentAmount = (($totalOrgAmount/100) * $marg);
                $agentAmount = number_format(floor($agentAmount*100)/100, 2, '.', '');

                $creditAmount = $agentAmount;
                $creditUsd = number_format(($creditAmount*$oneCurrency), 2, '.', '');
                $mainAgent = UserDetails::where('user_id',$agentid)->first();
                $currentCreditMain = $mainAgent->credit_balance;
                $mainAgent->credit_balance += $creditUsd;
                $mainAgent->save();

                $agentUSDMain = number_format(($agentAmount*$oneCurrency), 2, '.', '');
                $agentMargins[] = array(
                    'booking_id' => $flightBookId,
                    'agent_id'   =>  $agentid,
                    'from_agent_id' => Auth::user()->id,
                    'margin'     => $marg,
                    'amount'    => $agentAmount,
                    'total_amount' => $totalOrgAmount,
                    'currency' => $currency,
                    'usd_amount' => $agentUSDMain,
                    'usd_rate' => $oneCurrency,
                    'transaction_type' => 'cr',
                    'credit_balance' => $currentCreditMain + $agentUSDMain,
                    'created_at' => date('Y-m-d H:i:s')
                );
                
            }
        }
        // echo '<pre>';
        // print_r($agentMargins);
        if(!empty($agentMargins)){
            FlightMarginAmounts::insert($agentMargins);
        }

        $customerName = '';
        $passengers = $extras = $itinerary = [];
        if($CustomerInfos){
            foreach($CustomerInfos as $keyP => $custInfo){
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
                if($keyP == 0){
                    $customerName = $info['PassengerFirstName'].' '.$info['PassengerLastName']; 
                }
            }
            // print_r($passengers);
            FlightPassengers::insert($passengers);
        }

        $flightBook->customer_name = $customerName;
        $flightBook->save();
       
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

        if(isset($extraServices['Services'])){
            foreach($extraServices['Services'] as $keye => $extra){
                $service = $extra['Service'];
                $serviceCost = $service['ServiceCost'];
                $extras[] = [
                    'booking_id' => $flightBookId,
                    'service_id' => $service['ServiceId'],
                    'type' => $service['Type'],
                    'behavior' => $service['Behavior'],
                    'description' => $service['Description'],
                    'checkin_type' => $service['CheckInType'],
                    'currency' => $serviceCost['CurrencyCode'],
                    'service_amount' => $serviceCost['Amount'],
                    'created_at'=> date('Y-m-d H:i:s')
                ];
            }
            // print_r($passengers);
            FlightExtraServices::insert($extras);
        }

        if($data['direction'] == 'OneWay'){
            if(Session::has("flight_search_oneway")){
                $session_data = Session::get("flight_search_oneway");
                $oneway = new FlightSearches;
                $oneway->booking_id = $flightBookId;
                $oneway->origin = isset($session_data['oFrom']) ? $session_data['oFrom'] : '';
                $oneway->destination = isset($session_data['oTo']) ? $session_data['oTo'] : '';
                $oneway->from_date = isset($session_data['oDate']) ? $session_data['oDate'] : '';
                $oneway->to_date = NULL;
                $oneway->cabin_class = isset($session_data['oClass']) ? $session_data['oClass'] : '';
                $oneway->save();
            } 
        }elseif($data['direction'] == 'Return'){
            if(Session::has("flight_search_return")){
                $session_data = Session::get("flight_search_return");
                $return = new FlightSearches;
                $return->booking_id = $flightBookId;
                $return->origin = isset($session_data['rFrom']) ? $session_data['rFrom'] : '';
                $return->destination = isset($session_data['rTo']) ? $session_data['rTo'] : '';
                $return->from_date = isset($session_data['rDate']) ? $session_data['rDate'] : '';
                $return->to_date = isset($session_data['rReturnDate']) ? $session_data['rReturnDate'] : '';
                $return->cabin_class = isset($session_data['rClass']) ? $session_data['rClass'] : '';
                $return->save();
            } 
        }elseif($data['direction'] == 'Circle'){
            if(Session::has("flight_search_multi")){
                $multiData = [];
                $session_data = Session::get("flight_search_multi");
                $mFrom = isset($session_data['mFrom']) ? $session_data['mFrom'] : [];
                $mTo = isset($session_data['mTo']) ? $session_data['mTo'] : [];
                $mDate = isset($session_data['mDate']) ? $session_data['mDate'] : [];
                $mClass = isset($session_data['mClass']) ? $session_data['mClass'] : '';
                $count = count($mFrom);
                
                if($count != 0){
                    for($i=0 ; $i<$count; $i++){
                        $multiData[] = array(
                            'booking_id' => $flightBookId,
                            'origin' => $mFrom[$i],
                            'destination' => isset($mTo[$i]) ? $mTo[$i] : '',
                            'from_date' =>  isset($mDate[$i]) ? $mDate[$i] : '',
                            'to_date' => NULL,
                            'cabin_class' =>  $mClass,
                        );
                    }
                }
                if(!empty($multiData)){
                    FlightSearches::insert($multiData);
                }
            } 
        }
        return $flightBookId;
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
        if($IsValid == 1 || $IsValid == 'true'){
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
        $uniqueBookId = $request->uniquebookId;
        $book_Id = $request->id;
        $type = $request->type;
        // echo '<pre>';
        // echo $uniqueBookId; 


        $tripDetails = $this->getTripDetails($uniqueBookId);
        $tripDetails = json_decode($tripDetails, true);
        // print_r($tripDetails);
        // die;
        if(isset($tripDetails['TripDetailsResponse'])){
            $tripDetailsResult = $tripDetails['TripDetailsResponse']['TripDetailsResult'];
            if($tripDetailsResult['Success'] == 'true'){
                $TravelItinerary  = (isset($tripDetailsResult['TravelItinerary'])) ? $tripDetailsResult['TravelItinerary'] : []; 
                if(!empty($TravelItinerary)){
                    $TicketStatus = $TravelItinerary['TicketStatus'];
                    if($TicketStatus == 'Ticketed' || $TicketStatus == 'OK'){
                        if($type == 'void'){
                            $msg = $this->voidQuoteCall($uniqueBookId,$book_Id);
                        }elseif($type == 'refund'){
                            $msg = $this->refundQuoteCall($uniqueBookId,$book_Id);
                        }
                    }else{
                        $response = Http::timeout(300)->withOptions($this->options)->post(config('global.api_base_url').'cancel', [
                            "user_id"=> config('global.api_user_id'),
                            "user_password"=> config('global.api_user_password'),
                            "access"=> config('global.api_access'),
                            "ip_address"=> config('global.api_ip_address'),
                            "UniqueID"=> $uniqueBookId
                        ]);
                        $result = $response->getBody()->getContents();
                        $result = json_decode($result, true);
                        $CancelBookingResult = $result['CancelBookingResponse']['CancelBookingResult'];
                        if( $CancelBookingResult['Success'] == 'true'){
                            FlightBookings::where('unique_booking_id', $uniqueBookId)->update(['cancel_request' => 1,'is_cancelled' => 1]);
                            $bookData = getBookingDataByUniqueId($uniqueBookId);
                            $this->sendCancelMail($bookData);
                            $msg = ['status' => true,'type' => 'cancel','msg' => 'Cancel request send successfully'];
                        }else{
                            $msg =  ['status' => false,'msg' => (isset($CancelBookingResult['Errors']['ErrorMessage'])) ? $CancelBookingResult['Errors']['ErrorMessage'] : 'Something went wrong'];
                        }
                    }
                }else{
                    $msg = array('status' => false, 'data' => array(),'msg' => 'Something went wrong');
                } 
            }else{
                $msg = array('status' => false, 'data' => array(),'msg' => 'Something went wrong');
            }
        } else{
            $msg = array('status' => false, 'data' => array(),'msg' => 'Something went wrong');
        }
        return  json_encode($msg);
    }

    public function voidQuoteCall($uniqueBookId,$id){
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
            if( $VoidQuoteResult['Success'] == 'true'){
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
                $serviceCharges = FlightBookings::where('id', $id)->first();
                $serCrg = $serviceCharges->total_amount;
                $data['voidFee'] = number_format(floor($TotalVoidingFee*100)/100, 2, '.', '');
                $data['refundAmount'] = number_format(floor($TotalRefundAmount*100)/100, 2, '.', '');
                $serCharge = $serCrg - ($data['voidFee'] + $data['refundAmount']);
                $data['serviceCharge'] = number_format(floor($serCharge*100)/100, 2, '.', '');
                $msg = array('status' => true,'type' =>'void','data' => $data);
            }else{
                $msg = array('status' => false ,'data' => array(), 'msg' => (isset($VoidQuoteResult['Errors'])) ? $VoidQuoteResult['Errors']['ErrorMessage'] : 'Something went wrong');
            }
        }else{
            $msg = array('status' => false ,'data' => array(), 'msg' => (isset($result['Errors'])) ? $result['Errors']['ErrorMessage'] : 'Something went wrong');
        }
        // print_r($data);
        // die;
        
        return $msg;
    }

    public function refundQuoteCall($uniqueBookId,$id){
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
            if( $RefundQuoteResult['Success'] == 'true'){
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
                        if( $PtrResult['Success'] == 'true'){
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
                                $serviceCharges = FlightBookings::where('id', $id)->first();
                                $serCrg = $serviceCharges->total_amount;
                                $data['refundFee'] = number_format(floor($TotalRefundFee*100)/100, 2, '.', '');
                                $data['refundAmount'] = number_format(floor($TotalRefundAmount*100)/100, 2, '.', '');
                                $serCharge = $serCrg - ($data['refundFee'] + $data['refundAmount']);
                                $data['serviceCharge'] = number_format(floor($serCharge*100)/100, 2, '.', '');
                                $msg = array('status' => true,'type' =>'refund', 'data' => $data);
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
                    $msg = array('status' => false, 'data' => array(), 'msg' => 'Something went wrong');
                }
            }else{
                $msg = array('status' => false ,'data' => array(), 'msg' => (isset($RefundQuoteResult['Errors'])) ? $RefundQuoteResult['Errors']['ErrorMessage'] : 'Something went wrong');
            }
        }else{
            $msg = array('status' => false ,'data' => array(), 'msg' => (isset($result['Errors'])) ? $result['Errors']['ErrorMessage'] : 'Something went wrong');
        }
        // print_r($data);
        // die;
        
        return $msg;
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
            if( $VoidQuoteResult['Success'] == 'true'){
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
                $serviceCharges = FlightBookings::where('id', $id)->first();
                $serCrg = $serviceCharges->total_amount;
                $data['voidFee'] = number_format(floor($TotalVoidingFee*100)/100, 2, '.', '');
                $data['refundAmount'] = number_format(floor($TotalRefundAmount*100)/100, 2, '.', '');
                $serCharge = $serCrg - ($data['voidFee'] + $data['refundAmount']);
                $data['serviceCharge'] = number_format(floor($serCharge*100)/100, 2, '.', '');
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
        $cancel_refund = $request->refund_amount;
        $cancel_fee = $request->cancel_fee ;
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
            if( $VoidQuoteResult['Success'] == 'true'){
                FlightBookings::where('unique_booking_id', $uniqueBookId)->update(['cancel_fee' => $cancel_fee,'refund_amount' => $cancel_refund,'cancel_request' => 1,'cancel_ptr' => $VoidQuoteResult['ptrUniqueID']]);
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
            if($PtrResult['Success'] == 'true'){
                if(isset($PtrResult['PtrDetails'][0])){
                    $PtrDetails = $PtrResult['PtrDetails'][0];
                    if($PtrDetails['PtrStatus'] == 'Completed'){
                        if($PtrDetails['PtrType'] == 'Void' || $PtrDetails['PtrType'] == 'Refund'){
                            FlightBookings::where('unique_booking_id', $uniqueId)->update(['is_cancelled' => 1]);
                            $bookData = getBookingDataByUniqueId($uniqueId);
                            $this->sendCancelMail($bookData);
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
            
            if($RefundQuoteResult['Success'] == 'true'){
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
                        if( $PtrResult['Success'] == 'true'){
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
                                $serviceCharges = FlightBookings::where('id', $id)->first();
                                $serCrg = $serviceCharges->total_amount;
                                $data['refundFee'] = number_format(floor($TotalRefundFee*100)/100, 2, '.', '');
                                $data['refundAmount'] = number_format(floor($TotalRefundAmount*100)/100, 2, '.', '');
                                $serCharge = $serCrg - ($data['refundFee'] + $data['refundAmount']);
                                $data['serviceCharge'] = number_format(floor($serCharge*100)/100, 2, '.', '');
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
                    $msg = array('status' => false, 'data' => array(), 'msg' => 'Something went wrong');
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
        $cancel_refund = $request->refund_amount;
        $cancel_fee = $request->cancel_fee ;
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
            if( $RefundResult['Success'] == 'true'){
                FlightBookings::where('unique_booking_id', $uniqueBookId)->update(['cancel_fee' => $cancel_fee,'refund_amount' => $cancel_refund,'cancel_request' => 1,'cancel_ptr' => $RefundResult['ptrUniqueID']]);
                $msg = ['status' => true,'msg' => (isset($RefundResult['Message']) && $RefundResult['Message'] != '') ? $RefundResult['Message'] : 'Cancel request send successfully'];
            }else{
                $msg = array('status' => false ,'msg' => (isset($RefundResult['Errors'])) ? $RefundResult['Errors']['ErrorMessage'] : 'Something went wrong');
            }
        }else{
            $msg = array('status' => false , 'msg' => (isset($result['Errors'])) ? $result['Errors']['ErrorMessage'] : 'Something went wrong');
        }
        return json_encode($msg);
    }

    public function changeDate(Request $request){
        $data['uniqueBookId'] = $request->unique_id;
        $data['id'] = $request->id;
        $type = $request->type;
        $data['search'] = FlightItineraryDetails::where('booking_id', $data['id'])->orderBy('id','ASC')->get();
        return  view('web.user.reschedule',compact('data','type'));
    }

    public function rescheduleFlight(Request $request){
        // echo '<pre>';
        // print_r($request->all());
        $origin = $request->origin;
        $destination = $request->destination;
        $date = $request->date;
        $id = $request->booking_id;
        $uniqueBookId = $request->unique_id;
       
        $OriginDestinationInfo = [];
        $itineraryDetails = FlightItineraryDetails::where('booking_id', $id)->orderBy('id','ASC')->get();
        foreach ($itineraryDetails as $item) {
            $airport = $item->departure_airport.'-'.$item->arrival_airport;
            $reDate = isset($date[$airport]) ? $date[$airport] : date('Y-m-d', strtotime($item->departure_date_time));
            $OriginDestinationInfo[] = array(
                                        "airportOriginCode" => $item->departure_airport,
                                        "airportDestinationCode"   => $item->arrival_airport,
                                        "cabinPreference" => ($item->cabin_class != '') ? $item->cabin_class : 'Y',
                                        "departureDate"   => $reDate,
                                        "flightNumber" => $item->flight_number,
                                        "airlineCode"   => $item->marketing_airline_code,
                                    );
        }
        // print_r($OriginDestinationInfo);
        // die;
        $reDate = $request->rescheduleDate;

        $bookDetails = FlightBookings::where('id', $id)->get();
       
        $passengerDetails = FlightPassengers::where('booking_id', $id)->get();
        $paxDetails = [];
        foreach ($passengerDetails as $key) {
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
        // print_r($OriginDestinationInfo);
        //    die;
        $response = Http::timeout(300)->withOptions($this->options)->post(config('global.api_base_url').'reissue_ticket_quote', [
                        "user_id"=> config('global.api_user_id'),
                        "user_password"=> config('global.api_user_password'),
                        "access"=> config('global.api_access'),
                        "ip_address"=> config('global.api_ip_address'),
                        "UniqueID"=> $uniqueBookId,
                        "paxDetails" => $paxDetails,
                        "OriginDestinationInfo" => $OriginDestinationInfo
                    ]);

        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);
        // print_r($result);
        // die;
        if(isset($result['ReissueQuoteResponse']['ReissueQuoteResult'])){
            $ReissueQuoteResult = $result['ReissueQuoteResponse']['ReissueQuoteResult'];
            if(isset($ReissueQuoteResult['Success']) && $ReissueQuoteResult['Success'] == 'true'){
                if($ReissueQuoteResult['ptrUniqueID'] != ''){
                    $ptrUniqueId = $ReissueQuoteResult['ptrUniqueID'];
                    FlightBookings::where('id', $id)->update(['reissue_quote_ptr' => $ptrUniqueId]);
                    $responseStatus = Http::timeout(300)->withOptions($this->options)->post(config('global.api_base_url').'search_post_ticket_status', [
                        "user_id"=> config('global.api_user_id'),
                        "user_password"=> config('global.api_user_password'),
                        "access"=> config('global.api_access'),
                        "ip_address"=> config('global.api_ip_address'),
                        "UniqueID"=> $uniqueBookId,
                        "ptrUniqueID" => $ptrUniqueId
                    ]);
            
                    $resultStatus = $responseStatus->getBody()->getContents();
                    $resultStatus = json_decode($resultStatus, true);
                    // print_r($resultStatus);
                    // die;
                    if(isset($resultStatus['PtrResponse']['PtrResult']['Success'])) {
                        $PtrResult = $resultStatus['PtrResponse']['PtrResult'];
                        if($PtrResult['Success'] == 'true'){
                            $PtrDetails = $resultStatus['PtrResponse']['PtrResult']['PtrDetails'][0];
                            if(isset($PtrDetails['RequestedPreferences'])){
                                $viewData = view('web.user.reschedule_data', compact('PtrDetails','uniqueBookId','ptrUniqueId'))->render();
                               
                                $msg = array('status' => true, 'data' => $viewData, 'msg' => 'success' );
                            }else{
                                $msg = array('status' => false, 'data' => '', 'msg' => 'Alternative flights not found' );
                            }
                        }else{
                            $msg = array('status' => false, 'data' => '', 'msg' => (isset($PtrResult['Errors'])) ? $PtrResult['Errors']['ErrorMessage'] : 'Alternative flights not found');
                        }
                    }else{
                        $msg = array('status' => false, 'data' => '', 'msg' => (isset($resultStatus['Errors'])) ? $resultStatus['Errors']['ErrorMessage'] : 'Alternative flights not found');
                    }
                }
            }else{
                $msg = array('status' => false, 'data' => '', 'msg' =>  (isset($ReissueQuoteResult['Errors'])) ? $ReissueQuoteResult['Errors']['ErrorMessage'] : 'Alternative flights not found');
            }
        }else{
            $reissue_quote_ptr = FlightBookings::where('id', $id)->pluck('reissue_quote_ptr');
            if($reissue_quote_ptr[0] != ''){
                $ptrUniqueId = $reissue_quote_ptr[0];
                $responseStatus = Http::timeout(300)->withOptions($this->options)->post(config('global.api_base_url').'search_post_ticket_status', [
                    "user_id"=> config('global.api_user_id'),
                    "user_password"=> config('global.api_user_password'),
                    "access"=> config('global.api_access'),
                    "ip_address"=> config('global.api_ip_address'),
                    "UniqueID"=> $uniqueBookId,
                    "ptrUniqueID" => $ptrUniqueId
                ]);
        
                $resultStatus = $responseStatus->getBody()->getContents();
                $resultStatus = json_decode($resultStatus, true);
                if(isset($resultStatus['PtrResponse']['PtrResult']['Success'])) {
                    $PtrResult = $resultStatus['PtrResponse']['PtrResult'];
                    if($PtrResult['Success'] == 'true'){
                        $PtrDetails = $resultStatus['PtrResponse']['PtrResult']['PtrDetails'][0];
                        if(isset($PtrDetails['RequestedPreferences'])){
                            $viewData = view('web.user.reschedule_data', compact('PtrDetails','uniqueBookId','ptrUniqueId'))->render();
                           
                            $msg = array('status' => true, 'data' => $viewData, 'msg' => 'success' );
                        }else{
                            $msg = array('status' => false, 'data' => '', 'msg' => 'Alternative flights not found' );
                        }
                    }else{
                        $msg = array('status' => false, 'data' => '', 'msg' => (isset($PtrResult['Errors'])) ? $PtrResult['Errors']['ErrorMessage'] : 'Alternative flights not found');
                    }
                }else{
                    $msg = array('status' => false, 'data' => '', 'msg' => (isset($resultStatus['Errors'])) ? $resultStatus['Errors']['ErrorMessage'] : 'Alternative flights not found');
                }               
            }
            $msg = array('status' => false, 'data' => '', 'msg' =>  (isset($result['Errors'])) ? $result['Errors']['ErrorMessage'] : 'Alternative flights not found');
        }
        return json_encode($msg);
    }

    public function sendRescheduleRequest(Request $request){
        $currency = $request->currency;
        $fare = $request->fare;
        $preference = $request->preference;
        $ptrUniqueID = $request->ptrUniqueID ;
        $uniqueID = $request->uniqueID ;
        // echo '<pre>';
       
        $response = Http::timeout(300)->withOptions($this->options)->post(config('global.api_base_url').'reissue_ticket', [
                        "user_id"=> config('global.api_user_id'),
                        "user_password"=> config('global.api_user_password'),
                        "access"=> config('global.api_access'),
                        "ip_address"=> config('global.api_ip_address'),
                        "UniqueID" => $uniqueID,
                        "ptrUniqueID" => $ptrUniqueID,
                        "PreferenceOption" => $preference,
                        "remark" => "Reissue request"
                    ]);

        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);
        // echo '<pre>';
        // print_r($result);
        // die;
        if(!isset($result['Errors'])){
            // $RefundResult = $result['RefundResponse']['RefundResult'];
            $ReissueResult = $result['ReissueResponse']['ReissueResult'];
            if( $ReissueResult['Success'] == 'true'){
                FlightBookings::where('unique_booking_id', $uniqueID)->update(['reissue_request' => 1,'reissue_ptr' => $ReissueResult['ptrUniqueID']]);
                $msg = ['status' => true,'msg' => (isset($ReissueResult['Message']) && $ReissueResult['Message'] != '') ? $ReissueResult['Message'] : 'Reissue request send successfully'];
            }else{
                $msg = array('status' => false ,'msg' => (isset($ReissueResult['Errors'])) ? $ReissueResult['Errors']['ErrorMessage'] : 'Something went wrong');
            }
        }else{
            $msg = array('status' => false , 'msg' => (isset($result['Errors'])) ? $result['Errors']['ErrorMessage'] : 'Something went wrong');
        }
        return json_encode($msg);
    }

    public function reissuePtrStatusCheck(Request $request){
        $id = $request->id;
        $uniqueId = $request->uniqueid;
        $ptrUniqueId = $request->ptr;
        $details['oldId'] = $id;
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
            if($PtrResult['Success'] == 'true'){
                if(isset($PtrResult['PtrDetails'][0])){
                    $PtrDetails = $PtrResult['PtrDetails'][0];
                    if($PtrDetails['PtrStatus'] == 'Completed'){
                        if($PtrDetails['PtrType'] == 'ReIssue'){
                            FlightBookings::where('unique_booking_id', $uniqueId)->update(['is_reissued' => 1]);

                            $tripDetails = $this->getTripDetails($uniqueId);
                            $tripDetails = json_decode($tripDetails, true);
                            // print_r($tripDetails);
                            if(isset($tripDetails['TripDetailsResponse'])){
                                $tripDetailsResult = $tripDetails['TripDetailsResponse']['TripDetailsResult'];
                                if($tripDetailsResult['Success'] == 'true'){
                                    $TravelItinerary = $tripDetailsResult['TravelItinerary'];
                                    $ReissueUniqueID = (isset($TravelItinerary['ReissueUniqueID'])) ? $TravelItinerary['ReissueUniqueID'] : '';
                                    // $this->saveFlightBookingData($tripDetailsResult, $details);
                                    if($ReissueUniqueID != ''){
                                        $tripDetailsReissue = $this->getTripDetails($ReissueUniqueID);
                                        $tripDetailsReissue = json_decode($tripDetailsReissue, true);
                                        // print_r($tripDetailsReissue);
                                        if(isset($tripDetailsReissue['TripDetailsResponse'])){
                                            $tripDetailsResultReissue = $tripDetailsReissue['TripDetailsResponse']['TripDetailsResult'];
                                            if($tripDetailsResultReissue['Success'] == 'true'){
                                                $newBookingId = $this->saveFlightReissueBookingData($tripDetailsResultReissue, $details);
                                                $newbooking = $this->getBookingDetails($newBookingId);
                                                $this->sendReissueBookingMail($newbooking);
                                                $msg = "Your Request for ticket Reissue is Completed.";
                                            }else{
                                                $msg = "Your Request for ticket Reissue is Not Completed.";
                                            }
                                        }else{
                                            $msg = "Your Request for ticket Reissue is Not Completed.";
                                        }
                                    }else{
                                        $msg = "Your Request for ticket Reissue is Not Completed.";
                                    }
                                }else{
                                    $msg = "Something went wrong";
                                }
                            } else{
                                $msg = "Something went wrong";
                            }
                        }else{
                            $msg = "Something went wrong";
                        }  
                    }else{
                        $msg = "Your Request for ticket Reissue is InProcess.";
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
    public function saveFlightReissueBookingData($tripDetailsResult, $data){
        $oldBookingData = FlightBookings::find($data['oldId']);
        $travelItinerary = $tripDetailsResult['TravelItinerary'];
        // echo '<pre>';
        // print_r($oldBookingData);
        // print_r($travelItinerary);
        $totalOrgAmount = $oldBookingData->total_amount_actual;
        $currency = $oldBookingData->currency;

        $ItineraryInfo = $travelItinerary['ItineraryInfo'];
        $CustomerInfos = $ItineraryInfo['CustomerInfos'];
        $ReservationItems = $ItineraryInfo['ReservationItems'];
        $extraServices = (isset($ItineraryInfo['ExtraServices'])) ? $ItineraryInfo['ExtraServices'] : [];;
        $ItineraryPricing = $ItineraryInfo['ItineraryPricing'];
        $totalItineraryPrice = $ItineraryPricing['TotalFare'];
        $totalItineraryTax = $ItineraryPricing['Tax'];
        $fareBreakdowns = $ItineraryInfo['TripDetailsPTC_FareBreakdowns'];

        $adultAmount = $childAmount = $infAmount = 0;
        foreach($fareBreakdowns as $fare){
            $farebreak = $fare['TripDetailsPTC_FareBreakdown'];
            $farePass = $farebreak['PassengerTypeQuantity'];
            $breakFares = $farebreak['TripDetailsPassengerFare'];
            $EquiFare = $breakFares['EquiFare']['Amount'];
            if($farePass['Code'] == 'ADT' || $farePass['Quantity'] == 'ADT'){
                $adultAmount = $EquiFare;
            }elseif($farePass['Code'] == 'CHD' || $farePass['Quantity'] == 'CHD'){
                $childAmount = $EquiFare;
            }elseif($farePass['Code'] == 'INF' || $farePass['Quantity'] == 'INF'){
                $infAmount = $EquiFare;
            }
        }
        $newTotal = $totalItineraryPrice['Amount'];
        $adultAmount = $adultAmount + $oldBookingData->adult_amount;
        $childAmount = $childAmount + $oldBookingData->child_amount;
        $infAmount = $infAmount + $oldBookingData->infant_amount;
        
        $totalAmount = $newTotal + $oldBookingData->total_amount;   

        $totalTax = $totalItineraryTax['Amount'] + $oldBookingData->total_tax;

        $totalOrgAmount = $newTotal + $oldBookingData->total_amount_actual; 
        $total_tax_actual = $totalItineraryTax['Amount'] + $oldBookingData->total_tax_actual;

        $bookData = [
            'parent_id' => $data['oldId'],
            'user_id' => Auth::user()->id, 
            'unique_booking_id' => $travelItinerary['UniqueID'], 
            'direction' => $oldBookingData->direction,
            'client_ref' => $oldBookingData->client_ref, 
            'fare_type' => $travelItinerary['FareType'],
            'origin' => $travelItinerary['Origin'], 
            'destination' => $travelItinerary['Destination'],
            'customer_name' => $oldBookingData->customer_name,  
            'customer_email' => $oldBookingData->customer_email, 
            'phone_code' => $oldBookingData->phone_code, 
            'customer_phone' => $oldBookingData->customer_phone, 
            'adult_count' => $oldBookingData->adult_count,  
            'child_count' => $oldBookingData->child_count, 
            'infant_count' => $oldBookingData->infant_count, 
            'booking_status' => $travelItinerary['BookingStatus'], 
            'ticket_status' => $travelItinerary['TicketStatus'], 
            'currency' => $currency,
            'adult_amount' => $adultAmount, 
            'child_amount' => $childAmount, 
            'infant_amount' => $infAmount, 
            'total_amount' => $totalAmount,
            'reschedule_fare_difference' =>  $newTotal,
            'total_tax' => $totalTax, 
            'addon_amount' => $oldBookingData->addon_amount, 
            'created_at'=> date('Y-m-d H:i:s'),
            'total_amount_actual' => $totalOrgAmount, 
            'total_tax_actual' => $total_tax_actual, 
            'admin_margin' => 0, 
            'admin_amount' => 0, 
            'agents_amount' => 0, 
        ];

        // print_r($bookData);
        $flightBook = FlightBookings::create($bookData);
        $flightBookId = $flightBook->id;

        if($currency != 'USD'){
            $oneCurrency = getCurrencyValue($currency);
        }else{
            $oneCurrency=1 ;
        }
        $deductUsd = number_format(($newTotal*$oneCurrency), 2, '.', '');
        $currentAgent = UserDetails::where('user_id',Auth::user()->id)->first();
        $currentCredit = $currentAgent->credit_balance;
        
        $currentCreditNew = $currentCredit - $deductUsd;

        $agentMargins[] = array(
            'booking_id' => $flightBookId,
            'agent_id'   => Auth::user()->id,
            'amount'    => $totalAmount,
            'total_amount' => $totalAmount,
            'currency' => $currency,
            'usd_amount' => $deductUsd,
            'usd_rate' => $oneCurrency,
            'credit_balance' => $currentCreditNew,
            'transaction_type' => 'dr',
            'created_at' => date('Y-m-d H:i:s')
        );
        $currentAgent->credit_balance = $currentCreditNew;
        $currentAgent->save();
        FlightMarginAmounts::insert($agentMargins);
        $passengers = $itinerary = $extras = [];
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

        if(isset($extraServices['Services'])){
            foreach($extraServices['Services'] as $keye => $extra){
                $service = $extra['Service'];
                $serviceCost = $service['ServiceCost'];
                $extras[] = [
                    'booking_id' => $flightBookId,
                    'service_id' => $service['ServiceId'],
                    'type' => $service['Type'],
                    'behavior' => $service['Behavior'],
                    'description' => $service['Description'],
                    'checkin_type' => $service['CheckInType'],
                    'currency' => $serviceCost['CurrencyCode'],
                    'service_amount' => $serviceCost['Amount'],
                    'created_at'=> date('Y-m-d H:i:s')
                ];
            }
            // print_r($passengers);
            FlightExtraServices::insert($extras);
        }

        // die;
        return $flightBookId;
    }

    public function getBookingDetails($id){
        $bookings = FlightBookings::where('id',$id)->get();
        if(isset($bookings[0])){
            $bookings[0]['flights'] = FlightItineraryDetails::where('booking_id',$id)->orderBy('id','ASC')->get();
            $bookings[0]['passengers'] = FlightPassengers::where('booking_id',$id)->orderBy('id','ASC')->get();
            $bookings[0]['extraServices'] = FlightExtraServices::where('booking_id',$id)->orderBy('id','ASC')->get();
        }
        return $bookings;
    }

    public function saveDomesticFlightBookingData($tripDetailsResult,$tripDetailsResultInbound, $data){
        $travelItinerary = $tripDetailsResult['TravelItinerary'];
        $travelItineraryInbound = $tripDetailsResultInbound['TravelItinerary'];
        // echo '<pre>';
        // // print_r($data);
        // print_r($travelItineraryInbound);
        // die;
        $agentMargins = [];
        $totalOrgAmount = $data['total_amount_org'];
        $margins = (Auth::check()) ? getAgentMarginData(Auth::user()->id) : getUserMarginData(); 
        
        $adminMargin = $margins['admin_margin'];
        $adminMarginAmount = (($totalOrgAmount/100) * $margins['admin_margin']);
        $adminMarginAmount = number_format(floor($adminMarginAmount*100)/100, 2, '.', '');

        $agentsMarginAmount = (($totalOrgAmount/100) * ($margins['totalmargin'] - $margins['admin_margin']));
        $agentsMarginAmount = ($agentsMarginAmount != 0) ? number_format(floor($agentsMarginAmount*100)/100, 2, '.', '') : 0;

        $ItineraryInfo = $travelItinerary['ItineraryInfo'];
        $ItineraryInfoInbound = $travelItineraryInbound['ItineraryInfo'];

        $CustomerInfos = $ItineraryInfo['CustomerInfos'];
        $extraServices = (isset($ItineraryInfo['ExtraServices'])) ? $ItineraryInfo['ExtraServices'] : [];
        $ReservationItems = $ItineraryInfo['ReservationItems'];

        $CustomerInfosInbound = $ItineraryInfoInbound['CustomerInfos'];
        $extraServicesInbound = (isset($ItineraryInfoInbound['ExtraServices'])) ? $ItineraryInfoInbound['ExtraServices'] : [];
        $ReservationItemsInbound = $ItineraryInfoInbound['ReservationItems'];

        $totalAmount = str_replace(',','',$data['total_amount']);     
        $currency = $data['currency'];  

        if($currency != 'USD'){
            $oneCurrency = getCurrencyValue($currency);
        }else{
            $oneCurrency=1 ;
        }
        $bookData = [
            'user_id' => Auth::user()->id, 
            'unique_booking_id' => $travelItinerary['UniqueID'], 
            'direction' => $data['direction'],
            'client_ref' => $data['clientRef'], 
            'fare_type' => $data['FareType'],
            'origin' => $travelItinerary['Origin'], 
            'destination' => $travelItineraryInbound['Destination'], 
            'customer_email' => $data['email'], 
            'phone_code' => $data['mobile_code'], 
            'customer_phone' => $data['mobile_no'], 
            'adult_count' => $data['adultCount'], 
            'child_count' => $data['childCount'], 
            'infant_count' => $data['infantCount'], 
            'booking_status' => $travelItinerary['BookingStatus'], 
            'ticket_status' => $travelItinerary['TicketStatus'], 
            'currency' => $currency,
            'adult_amount' => $data['adult_amount'], 
            'child_amount' => $data['child_amount'], 
            'infant_amount' => $data['infant_amount'], 
            'total_amount' => $totalAmount, 
            'total_tax' => $data['total_tax'], 
            'addon_amount' => $data['total_addons'],
            'created_at'=> date('Y-m-d H:i:s'),
            'total_amount_actual' => $totalOrgAmount, 
            'total_tax_actual' => $data['total_tax_org'], 
            'admin_margin' => $adminMargin, 
            'admin_amount' => number_format(($adminMarginAmount*$oneCurrency), 2, '.', ''), 
            'agents_amount' => number_format(($agentsMarginAmount*$oneCurrency), 2, '.', ''), 
            'is_domestic' => 1
        ];
       
        $flightBook = FlightBookings::create($bookData);
        $flightBookId = $flightBook->id;

        if(isset($margins['agent_margin'])){
            $currentAgentMargin = $margins['agent_margin'];
            $agentAmount = (($totalOrgAmount/100) * $currentAgentMargin);
            $agentAmount = number_format(floor($agentAmount*100)/100, 2, '.', '');

            $deductUsd = number_format(($totalAmount*$oneCurrency), 2, '.', '');

            $currentAgent = UserDetails::where('user_id',Auth::user()->id)->first();
            $currentCredit = $currentAgent->credit_balance;
            
            $currentCreditNew = $currentCredit - $deductUsd;
            $agentUSD = number_format(($agentAmount*$oneCurrency), 2, '.', '');
            $agentMargins[] = array(
                'booking_id' => $flightBookId,
                'agent_id'   => Auth::user()->id,
                'from_agent_id' => NULL,
                'margin'     => $currentAgentMargin,
                'amount'    => $totalAmount,
                'total_amount' => $totalOrgAmount,
                'currency' => $currency,
                'usd_amount' => $deductUsd,
                'usd_rate' => $oneCurrency,
                'credit_balance' => $currentCreditNew,
                'transaction_type' => 'dr',
                'created_at' => date('Y-m-d H:i:s')
            );

            $agentMargins[] = array(
                'booking_id' => $flightBookId,
                'agent_id'   => Auth::user()->id,
                'from_agent_id' => NULL,
                'margin'     => $currentAgentMargin,
                'amount'    => $agentAmount,
                'total_amount' => $totalOrgAmount,
                'currency' => $currency,
                'usd_amount' => $agentUSD,
                'usd_rate' => $oneCurrency,
                'transaction_type' => 'cr',
                'credit_balance' => $currentCreditNew + $agentUSD,
                'created_at' => date('Y-m-d H:i:s')
            );
            $currentAgent->credit_balance = ($currentCreditNew + $agentUSD);
            $currentAgent->save();
        }
        if(isset($margins['main_agents'])){
            foreach($margins['main_agents'] as $agentid => $marg){
                $agentAmount = (($totalOrgAmount/100) * $marg);
                $agentAmount = number_format(floor($agentAmount*100)/100, 2, '.', '');

                $creditAmount = $agentAmount;
                $creditUsd = number_format(($creditAmount*$oneCurrency), 2, '.', '');
                $mainAgent = UserDetails::where('user_id',$agentid)->first();
                $currentCreditMain = $mainAgent->credit_balance;
                $mainAgent->credit_balance += $creditUsd;
                $mainAgent->save();

                $agentUSDMain = number_format(($agentAmount*$oneCurrency), 2, '.', '');
                $agentMargins[] = array(
                    'booking_id' => $flightBookId,
                    'agent_id'   =>  $agentid,
                    'from_agent_id' => Auth::user()->id,
                    'margin'     => $marg,
                    'amount'    => $agentAmount,
                    'total_amount' => $totalOrgAmount,
                    'currency' => $currency,
                    'usd_amount' => $agentUSDMain,
                    'usd_rate' => $oneCurrency,
                    'transaction_type' => 'cr',
                    'credit_balance' => $currentCreditMain + $agentUSDMain,
                    'created_at' => date('Y-m-d H:i:s')
                );
                
            }
        }
        // echo '<pre>';
        // print_r($agentMargins);
        if(!empty($agentMargins)){
            FlightMarginAmounts::insert($agentMargins);
        }

        $customerName = '';
        $passengers = $extras = $itinerary = [];
        
        if($CustomerInfos){
            foreach($CustomerInfos as $keyP => $custInfo){
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
                    'is_return' => 0,
                    'created_at'=> date('Y-m-d H:i:s')
                ];
                if($keyP == 0){
                    $customerName = $info['PassengerFirstName'].' '.$info['PassengerLastName']; 
                }
            }
            // print_r($passengers);
        }

        if($CustomerInfosInbound){
            foreach($CustomerInfosInbound as $keyP => $custInfo){
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
                    'is_return' => 1,
                    'created_at'=> date('Y-m-d H:i:s')
                ];
                if($keyP == 0){
                    $customerName = $info['PassengerFirstName'].' '.$info['PassengerLastName']; 
                }
            }
            // print_r($passengers);
        }
        if(!empty($passengers)){
            FlightPassengers::insert($passengers);
        }
        $flightBook->customer_name = $customerName;
        $flightBook->save();
       
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
                    'is_return' => 0,
                    'created_at'=> date('Y-m-d H:i:s')
                ];
            }
            // print_r($itinerary);
            
        }

        if($ReservationItemsInbound){
            foreach($ReservationItemsInbound as $resItem){
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
                    'is_return' => 1,
                    'created_at'=> date('Y-m-d H:i:s')
                ];
            }
        }

        if(!empty($itinerary)){
            FlightItineraryDetails::insert($itinerary);
        }

        if(isset($extraServices['Services'])){
            $serviceOut = $extraServices['Services'];
            foreach($serviceOut as $keye => $extra){
                $service = $extra['Service'];
                $serviceCost = $service['ServiceCost'];
                $extras[] = [
                    'booking_id' => $flightBookId,
                    'service_id' => $service['ServiceId'],
                    'type' => $service['Type'],
                    'behavior' => $service['Behavior'],
                    'description' => $service['Description'],
                    'checkin_type' => $service['CheckInType'],
                    'currency' => $serviceCost['CurrencyCode'],
                    'service_amount' => $serviceCost['Amount'],
                    'created_at'=> date('Y-m-d H:i:s')
                ];
            }
        }

        if(isset($extraServicesInbound['Services'])){
            $serviceInbound = $extraServicesInbound['Services'];
            foreach($serviceInbound as $keye => $extra){
                $service = $extra['Service'];
                $serviceCost = $service['ServiceCost'];
                $extras[] = [
                    'booking_id' => $flightBookId,
                    'service_id' => $service['ServiceId'],
                    'type' => $service['Type'],
                    'behavior' => $service['Behavior'],
                    'description' => $service['Description'],
                    'checkin_type' => $service['CheckInType'],
                    'currency' => $serviceCost['CurrencyCode'],
                    'service_amount' => $serviceCost['Amount'],
                    'created_at'=> date('Y-m-d H:i:s')
                ];
            }
        }

        if(!empty($extras)){
            FlightExtraServices::insert($extras);
        }
        if($data['direction'] == 'OneWay'){
            if(Session::has("flight_search_oneway")){
                $session_data = Session::get("flight_search_oneway");
                $oneway = new FlightSearches;
                $oneway->booking_id = $flightBookId;
                $oneway->origin = isset($session_data['oFrom']) ? $session_data['oFrom'] : '';
                $oneway->destination = isset($session_data['oTo']) ? $session_data['oTo'] : '';
                $oneway->from_date = isset($session_data['oDate']) ? $session_data['oDate'] : '';
                $oneway->to_date = NULL;
                $oneway->cabin_class = isset($session_data['oClass']) ? $session_data['oClass'] : '';
                $oneway->save();
            } 
        }elseif($data['direction'] == 'Return'){
            if(Session::has("flight_search_return")){
                $session_data = Session::get("flight_search_return");
                $return = new FlightSearches;
                $return->booking_id = $flightBookId;
                $return->origin = isset($session_data['rFrom']) ? $session_data['rFrom'] : '';
                $return->destination = isset($session_data['rTo']) ? $session_data['rTo'] : '';
                $return->from_date = isset($session_data['rDate']) ? $session_data['rDate'] : '';
                $return->to_date = isset($session_data['rReturnDate']) ? $session_data['rReturnDate'] : '';
                $return->cabin_class = isset($session_data['rClass']) ? $session_data['rClass'] : '';
                $return->save();
            } 
        }elseif($data['direction'] == 'Circle'){
            if(Session::has("flight_search_multi")){
                $multiData = [];
                $session_data = Session::get("flight_search_multi");
                $mFrom = isset($session_data['mFrom']) ? $session_data['mFrom'] : [];
                $mTo = isset($session_data['mTo']) ? $session_data['mTo'] : [];
                $mDate = isset($session_data['mDate']) ? $session_data['mDate'] : [];
                $mClass = isset($session_data['mClass']) ? $session_data['mClass'] : '';
                $count = count($mFrom);
                
                if($count != 0){
                    for($i=0 ; $i<$count; $i++){
                        $multiData[] = array(
                            'booking_id' => $flightBookId,
                            'origin' => $mFrom[$i],
                            'destination' => isset($mTo[$i]) ? $mTo[$i] : '',
                            'from_date' =>  isset($mDate[$i]) ? $mDate[$i] : '',
                            'to_date' => NULL,
                            'cabin_class' =>  $mClass,
                        );
                    }
                }
                if(!empty($multiData)){
                    FlightSearches::insert($multiData);
                }
            } 
        }
        return $flightBookId;
        // die;
    }
}






