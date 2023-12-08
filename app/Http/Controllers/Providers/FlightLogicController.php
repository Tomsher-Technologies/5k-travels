<?php

namespace App\Http\Controllers\Providers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class FlightLogicController extends Controller
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
            $this->options = ['verify' => false];
        }
    }

    public function search(Request $request, &$data)
    {
        $mFrom = $request->mFrom;
        $mTo = $request->mTo;
        $mDate = $request->mDate;
        $adult = $child = $infant = 0;
        $cabinClass = '';

        if ($request->search_type == 'OneWay') {
            Session::put('flight_search_oneway', $request->all());
            $originDestinationInfo[] = [
                "departureDate" => $request->oDate,
                "airportOriginCode" => $request->oFrom,
                "airportDestinationCode" => $request->oTo
            ];

            $adult = $request->oAdult;
            $child = $request->oChild;
            $infant = $request->oInfant;
            $cabinClass = $request->oClass;

            $airlineFilters = ($request->oairline_filter != '') ? explode(',', rtrim($request->oairline_filter, ',')) : array();
            $stopFilters = ($request->ostop_filter != '') ? explode(',', rtrim($request->ostop_filter, ',')) : array();
            $refundFilter = ($request->orefund_filter != '') ?  explode(',', rtrim($request->orefund_filter, ',')) : array();
            $isFilter  = 0;
            if (!empty($airlineFilters) || !empty($stopFilters) || !empty($refundFilter)) {
                $isFilter = 1;
            }
        } elseif ($request->search_type == 'Return') {
            Session::put('flight_search_return', $request->all());
            $originDestinationInfo[] = [
                "departureDate" => $request->rDate,
                "returnDate" => $request->rReturnDate,
                "airportOriginCode" => $request->rFrom,
                "airportDestinationCode" => $request->rTo
            ];
            $adult = $request->rAdult;
            $child = $request->rChild;
            $infant = $request->rInfant;
            $cabinClass = $request->rClass;

            $airlineFilters = ($request->rairline_filter != '') ? explode(',', rtrim($request->rairline_filter, ',')) : array();
            $stopFilters = ($request->rstop_filter != '') ? explode(',', rtrim($request->rstop_filter, ',')) : array();
            $refundFilter = ($request->rrefund_filter != '') ?  explode(',', rtrim($request->rrefund_filter, ',')) : array();
            $isFilter  = 0;
            if (!empty($airlineFilters) || !empty($stopFilters) || !empty($refundFilter)) {
                $isFilter = 1;
            }
        } elseif ($request->search_type == 'Circle') {
            Session::put('flight_search_multi', $request->all());

            $multiCount = count($request->mFrom);
            for ($i = 0; $i < $multiCount; $i++) {
                $originDestinationInfo[] = [
                    "departureDate" => $mDate[$i],
                    "airportOriginCode" => $mFrom[$i],
                    "airportDestinationCode" => $mTo[$i]
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
            if (!empty($airlineFilters) || !empty($stopFilters) || !empty($refundFilter)) {
                $isFilter = 1;
            }
        }

        $response = Http::timeout(300)->withOptions($this->options)->post(env('API_BASE_URL') . 'availability', [
            "user_id" => env('API_USER_ID'),
            "user_password" => env('API_USER_PASSWORD'),
            "access" => env('API_ACCESS'),
            "ip_address" => env('API_IP_ADDRESS'),
            "requiredCurrency" => (Session::has('user_currency') ? Session::get('user_currency') : env('API_REQUIRED_CURRENCY')),
            "journeyType" => $request->search_type,
            "OriginDestinationInfo" => $originDestinationInfo,
            "class" => $cabinClass,
            "adults" => (int)$adult,
            "childs" => (int)$child,
            "infants" => (int)$infant,
            "directFlight" => (isset($request->direct) ? 1 : 0)
        ]);

        // dd($response);

        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);
        // dd($result);
        $data['session_id'] = isset($result['AirSearchResponse']['session_id']) ? $result['AirSearchResponse']['session_id'] : '';
        $one_stop = $two_stop = $three_stop = $non_stop = $refund = $no_refund = 0;
        $flights = $flightsIn = [];
        $flightDetails = isset($result['AirSearchResponse']['AirSearchResult']['FareItineraries']) ? $result['AirSearchResponse']['AirSearchResult']['FareItineraries'] : array();
        /*================================================  One Way =============================================================*/
        if ($request->search_type == 'OneWay' || $request->search_type == 'Circle') {
            if ($flightDetails) {
                $loop = 0;
                $unsetLoops = array();
                $airLoops = array();
                $stopsLoop = $refundLoop = array();
                foreach ($flightDetails as $fd) {
                    // echo '<br><br>Normal loop  ==== '.$loop;
                    $AirItineraryFareInfoOne = $fd['FareItinerary']['AirItineraryFareInfo'];
                    $refundStatus = $AirItineraryFareInfoOne['IsRefundable'];
                    $flights[$loop]['FareSourceCode'] = $AirItineraryFareInfoOne['FareSourceCode'];
                    $flights[$loop]['FareType'] = $AirItineraryFareInfoOne['FareType'];
                    $flights[$loop]['IsRefundable'] = $refundStatus;
                    $flights[$loop]['TotalFares'] = $AirItineraryFareInfoOne['ItinTotalFares'];
                    $flights[$loop]['DirectionInd'] = $fd['FareItinerary']['DirectionInd'];

                    if (strtolower($refundStatus) == 'no' || strtolower($refundStatus) == false) {
                        $no_refund++;
                    } else {
                        $refund++;
                    }

                    $totalStopsCount = $fd['FareItinerary']['OriginDestinationOptions'][0]['TotalStops'];
                    // print_r($stopFilters);

                    if ($totalStopsCount == 0) {
                        $non_stop++;
                    } elseif ($totalStopsCount == 1) {
                        $one_stop++;
                    } elseif ($totalStopsCount == 2) {
                        $two_stop++;
                    } elseif ($totalStopsCount == 3) {
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

                    for ($i = 0; $i <= $totalStopsCount; $i++) {
                        $journeyDurations += $flightSegment[$i]['FlightSegment']['JourneyDuration'];
                        $DepartureAirportLocationCode = $flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode'];
                        if ($totalStopsCount > 0) {
                            if ($i != 0) {
                                // if($flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode'] == $flightSegment[$i-1]['FlightSegment']['ArrivalAirportLocationCode']){
                                $timeInMin = getTimeDiffInMInutes($flightSegment[$i - 1]['FlightSegment']['ArrivalDateTime'], $flightSegment[$i]['FlightSegment']['DepartureDateTime']);
                                $layover[$DepartureAirportLocationCode] = $timeInMin;
                                $layover['place'][] = isset($data['airports'][$DepartureAirportLocationCode]) ? $data['airports'][$DepartureAirportLocationCode]['City'] : $DepartureAirportLocationCode;
                                $layover['duration'][] = $timeInMin;
                                // }
                            }
                        }
                        $airlineCode = $flightSegment[$i]['FlightSegment']['MarketingAirlineCode'];
                        $flightCodes[] = $airlineCode;
                        $data['airlines'][$airlineCode] = isset($data['airlines'][$airlineCode]) ? ($data['airlines'][$airlineCode] + 1) : 1;

                        $originCode = $DepartureAirportLocationCode;
                        $destinationCode = $flightSegment[$i]['FlightSegment']['ArrivalAirportLocationCode'];

                        if (!empty($airlineFilters) && in_array($airlineCode, $airlineFilters)) {
                            $unsetLoops[] = $loop;
                        }
                    }

                    if ($totalStopsCount == 0) {
                        $totalDuration = $flightSegment[0]['FlightSegment']['JourneyDuration'];
                    } else {
                        $totalDuration = (isset($layover['duration'])) ? array_sum($layover['duration']) + $journeyDurations : $journeyDurations;
                    }
                    $flights[$loop]['totalDuration'] = $totalDuration;
                    $flights[$loop]['layovers'] = $layover;

                    // print_r($unsetLoops);
                    if (!empty($stopFilters) && in_array($totalStopsCount, $stopFilters)) {
                        $stopsLoop[] = $loop;
                    }
                    if (!empty($refundFilter) && in_array(strtolower($refundStatus), $refundFilter)) {
                        $refundLoop[] = $loop;
                    }
                    $loop++;
                }
                $filterArrays[] = $unsetLoops;
                $filterArrays[] = $stopsLoop;
                $filterArrays[] = $refundLoop;
                $filterArrays = array_filter($filterArrays);
                $common = array();
                if (empty($airlineFilters) && empty($stopFilters) && empty($refundFilter)) {
                    $common = array();
                } elseif (!empty($airlineFilters) && !empty($stopFilters) && !empty($refundFilter)) {
                    $common = array_intersect($unsetLoops, $stopsLoop, $refundLoop);
                } elseif (!empty($airlineFilters) && !empty($stopFilters) && empty($refundFilter)) {
                    $common = array_intersect($unsetLoops, $stopsLoop);
                } elseif ((!empty($airlineFilters) && empty($stopFilters) && !empty($refundFilter))) {
                    $common = array_intersect($unsetLoops, $refundLoop);
                } elseif (empty($airlineFilters) && !empty($stopFilters) && !empty($refundFilter)) {
                    $common = array_intersect($stopsLoop, $refundLoop);
                } elseif (!empty($airlineFilters) && empty($stopFilters) && empty($refundFilter)) {
                    $common = $unsetLoops;
                } elseif (empty($airlineFilters) && !empty($stopFilters) && empty($refundFilter)) {
                    $common = $stopsLoop;
                } elseif (empty($airlineFilters) && empty($stopFilters) && !empty($refundFilter)) {
                    $common = $refundLoop;
                }

                // print_r($common);
                $flights = ($isFilter == 0) ? $flights : ((!empty($common)) ? array_intersect_key($flights, array_flip($common)) : array());
            }
        }
        /*================================================  Round/Return =============================================================*/ else if ($request->search_type == 'Return') {
            $flightDetailsInbound = isset($result['AirSearchResponse']['AirSearchResultInbound']['FareItineraries']) ? $result['AirSearchResponse']['AirSearchResultInbound']['FareItineraries'] : array();
            if (!empty($flightDetailsInbound)) {
                if ($flightDetails) {
                    $loop = 0;
                    $unsetLoops = array();
                    $airLoops = array();
                    $stopsLoop = $refundLoop = array();
                    foreach ($flightDetails as $fd) {
                        // echo '<br><br>Normal loop  ==== '.$loop;
                        $AirItineraryFareInfoRe = $fd['FareItinerary']['AirItineraryFareInfo'];
                        $refundStatus = $AirItineraryFareInfoRe['IsRefundable'];
                        $flights[$loop]['FareSourceCode'] = $AirItineraryFareInfoRe['FareSourceCode'];
                        $flights[$loop]['FareType'] = $AirItineraryFareInfoRe['FareType'];
                        $flights[$loop]['IsRefundable'] = $refundStatus;
                        $flights[$loop]['TotalFares'] = $AirItineraryFareInfoRe['ItinTotalFares'];
                        $flights[$loop]['DirectionInd'] = $fd['FareItinerary']['DirectionInd'];

                        if (strtolower($refundStatus) == 'no' || strtolower($refundStatus) == false) {
                            $no_refund++;
                        } else {
                            $refund++;
                        }

                        $totalStopsOutCount = $fd['FareItinerary']['OriginDestinationOptions'][0]['TotalStops'];
                        if ($totalStopsOutCount == 0) {
                            $non_stop++;
                        } elseif ($totalStopsOutCount == 1) {
                            $one_stop++;
                        } elseif ($totalStopsOutCount == 2) {
                            $two_stop++;
                        } elseif ($totalStopsOutCount == 3) {
                            $three_stop++;
                        }
                        $OriginDestinationOption = $fd['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'];
                        $flights[$loop]['totalOutStops'] = $totalStopsOutCount;
                        $flights[$loop]['OriginDestinationOptionsOutbound'] = $OriginDestinationOption;

                        $layover = [];
                        $journeyDurations = 0;

                        $flightBaggage = [];
                        for ($i = 0; $i <= $totalStopsOutCount; $i++) {
                            $journeyDurations += $OriginDestinationOption[$i]['FlightSegment']['JourneyDuration'];
                            $flightSegment = $OriginDestinationOption;
                            $newFlightSegment = $flightSegment[$i]['FlightSegment'];
                            $DepartureAirportLocationCode = $newFlightSegment['DepartureAirportLocationCode'];
                            if ($totalStopsOutCount > 0) {
                                if ($i != 0) {
                                    // if($flightSegment[$i]['FlightSegment']['DepartureAirportLocationCode'] == $flightSegment[$i-1]['FlightSegment']['ArrivalAirportLocationCode']){

                                    $timeInMin = getTimeDiffInMInutes($flightSegment[$i - 1]['FlightSegment']['ArrivalDateTime'], $newFlightSegment['DepartureDateTime']);
                                    $layover[$DepartureAirportLocationCode] = $timeInMin;
                                    $layover['place'][] = isset($data['airports'][$DepartureAirportLocationCode]) ? $data['airports'][$DepartureAirportLocationCode]['City'] : $DepartureAirportLocationCode;
                                    $layover['duration'][] = $timeInMin;
                                    // }
                                }
                            }
                            $airlineCode = $newFlightSegment['MarketingAirlineCode'];
                            $flightCodes[] = $airlineCode;
                            $data['airlines'][$airlineCode] = isset($data['airlines'][$airlineCode]) ? ($data['airlines'][$airlineCode] + 1) : 1;

                            $originCode = $DepartureAirportLocationCode;
                            $destinationCode = $newFlightSegment['ArrivalAirportLocationCode'];

                            if (!empty($airlineFilters) && in_array($airlineCode, $airlineFilters)) {
                                $unsetLoops[] = $loop;
                            }
                        }

                        if ($totalStopsOutCount == 0) {
                            $totalDuration = $OriginDestinationOption[0]['FlightSegment']['JourneyDuration'];
                        } else {
                            $totalDuration = array_sum($layover['duration']) + $journeyDurations;
                        }

                        $flights[$loop]['totalDuration'] = $totalDuration;
                        $flights[$loop]['layovers'] = $layover;

                        if (!empty($stopFilters) && (in_array($totalStopsOutCount, $stopFilters))) {
                            $stopsLoop[] = $loop;
                        }
                        if (!empty($refundFilter) && in_array(strtolower($refundStatus), $refundFilter)) {
                            $refundLoop[] = $loop;
                        }
                        $loop++;
                    }

                    $filterArrays[] = $unsetLoops;
                    $filterArrays[] = $stopsLoop;
                    $filterArrays[] = $refundLoop;
                    $filterArrays = array_filter($filterArrays);
                    $common = array();
                    if (empty($airlineFilters) && empty($stopFilters) && empty($refundFilter)) {
                        $common = array();
                    } elseif (!empty($airlineFilters) && !empty($stopFilters) && !empty($refundFilter)) {
                        $common = array_intersect($unsetLoops, $stopsLoop, $refundLoop);
                    } elseif (!empty($airlineFilters) && !empty($stopFilters) && empty($refundFilter)) {
                        $common = array_intersect($unsetLoops, $stopsLoop);
                    } elseif ((!empty($airlineFilters) && empty($stopFilters) && !empty($refundFilter))) {
                        $common = array_intersect($unsetLoops, $refundLoop);
                    } elseif (empty($airlineFilters) && !empty($stopFilters) && !empty($refundFilter)) {
                        $common = array_intersect($stopsLoop, $refundLoop);
                    } elseif (!empty($airlineFilters) && empty($stopFilters) && empty($refundFilter)) {
                        $common = $unsetLoops;
                    } elseif (empty($airlineFilters) && !empty($stopFilters) && empty($refundFilter)) {
                        $common = $stopsLoop;
                    } elseif (empty($airlineFilters) && empty($stopFilters) && !empty($refundFilter)) {
                        $common = $refundLoop;
                    }

                    $flights = ($isFilter == 0) ? $flights : ((!empty($common)) ? array_intersect_key($flights, array_flip($common)) : array());
                }
                if ($flightDetailsInbound) {
                    $loopIn = 0;
                    $unsetLoopsIn = array();
                    $airLoopsIn = array();
                    $stopsLoopIn = $refundLoopIn = array();
                    foreach ($flightDetailsInbound as $fdIn) {
                        // echo '<br><br>Normal loop  ==== '.$loop;
                        $inAirItineraryFareInfo = $fdIn['FareItinerary']['AirItineraryFareInfo'];
                        $refundStatusIn = $inAirItineraryFareInfo['IsRefundable'];
                        $flightsIn[$loopIn]['FareSourceCode'] = $inAirItineraryFareInfo['FareSourceCode'];
                        $flightsIn[$loopIn]['FareType'] = $inAirItineraryFareInfo['FareType'];
                        $flightsIn[$loopIn]['IsRefundable'] = $refundStatusIn;
                        $flightsIn[$loopIn]['TotalFares'] = $inAirItineraryFareInfo['ItinTotalFares'];
                        $flightsIn[$loopIn]['DirectionInd'] = $fdIn['FareItinerary']['DirectionInd'];

                        if (strtolower($refundStatusIn) == 'no' || strtolower($refundStatusIn) == false) {
                            $no_refund++;
                        } else {
                            $refund++;
                        }

                        $totalStopsInCount = $fdIn['FareItinerary']['OriginDestinationOptions'][0]['TotalStops'];
                        if ($totalStopsInCount == 0) {
                            $non_stop++;
                        } elseif ($totalStopsInCount == 1) {
                            $one_stop++;
                        } elseif ($totalStopsInCount == 2) {
                            $two_stop++;
                        } elseif ($totalStopsInCount == 3) {
                            $three_stop++;
                        }
                        $flightSegmentIn = $fdIn['FareItinerary']['OriginDestinationOptions'][0]['OriginDestinationOption'];
                        $flightsIn[$loopIn]['totalInStops'] = $totalStopsInCount;
                        $flightsIn[$loopIn]['OriginDestinationOptionsInbound'] = $flightSegmentIn;

                        $layoverIn = [];
                        $journeyDurationsIn = 0;
                        $bagCountIn = 0;
                        $flightBaggageIn = [];
                        for ($j = 0; $j <= $totalStopsInCount; $j++) {
                            $jFlightSegment  = $flightSegmentIn[$j]['FlightSegment'];
                            $journeyDurationsIn += $jFlightSegment['JourneyDuration'];

                            if ($totalStopsInCount > 0) {
                                if ($j != 0) {
                                    // if($jFlightSegment['DepartureAirportLocationCode'] == $flightSegmentIn[$j-1]['FlightSegment']['ArrivalAirportLocationCode']){

                                    $timeInMinIn = getTimeDiffInMInutes($flightSegmentIn[$j - 1]['FlightSegment']['ArrivalDateTime'], $jFlightSegment['DepartureDateTime']);
                                    $layoverIn[$jFlightSegment['DepartureAirportLocationCode']] = $timeInMinIn;
                                    $layoverIn['place'][] = isset($data['airports'][$jFlightSegment['DepartureAirportLocationCode']]) ? $data['airports'][$jFlightSegment['DepartureAirportLocationCode']]['City'] : $jFlightSegment['DepartureAirportLocationCode'];
                                    $layoverIn['duration'][] = $timeInMinIn;
                                    // }
                                }
                            }
                            $airlineCodeIn = $jFlightSegment['MarketingAirlineCode'];
                            $flightCodesIn[] = $airlineCodeIn;
                            $data['airlines'][$airlineCodeIn] = isset($data['airlines'][$airlineCodeIn]) ? ($data['airlines'][$airlineCodeIn] + 1) : 1;

                            $originCodeIn = $jFlightSegment['DepartureAirportLocationCode'];
                            $destinationCodeIn = $jFlightSegment['ArrivalAirportLocationCode'];

                            if (!empty($airlineFilters) && in_array($airlineCodeIn, $airlineFilters)) {
                                $unsetLoopsIn[] = $loopIn;
                            }
                        }

                        if ($totalStopsInCount == 0) {
                            $totalDurationIn = $flightSegmentIn[0]['FlightSegment']['JourneyDuration'];
                        } else {
                            $totalDurationIn = array_sum($layoverIn['duration']) + $journeyDurationsIn;
                        }

                        $flightsIn[$loopIn]['totalDurationIn'] = $totalDurationIn;
                        $flightsIn[$loopIn]['layoversIn'] = $layoverIn;

                        if (!empty($stopFilters) && (in_array($totalStopsInCount, $stopFilters))) {
                            $stopsLoopIn[] = $loopIn;
                        }
                        if (!empty($refundFilter) && in_array(strtolower($refundStatusIn), $refundFilter)) {
                            $refundLoopIn[] = $loopIn;
                        }

                        $loopIn++;
                    }

                    $filterArraysIn[] = $unsetLoopsIn;
                    $filterArraysIn[] = $stopsLoopIn;
                    $filterArraysIn[] = $refundLoopIn;
                    $filterArraysIn = array_filter($filterArraysIn);
                    $commonIn = array();
                    if (empty($airlineFilters) && empty($stopFilters) && empty($refundFilter)) {
                        $commonIn = array();
                    } elseif (!empty($airlineFilters) && !empty($stopFilters) && !empty($refundFilter)) {
                        $commonIn = array_intersect($unsetLoopsIn, $stopsLoopIn, $refundLoopIn);
                    } elseif (!empty($airlineFilters) && !empty($stopFilters) && empty($refundFilter)) {
                        $commonIn = array_intersect($unsetLoopsIn, $stopsLoopIn);
                    } elseif ((!empty($airlineFilters) && empty($stopFilters) && !empty($refundFilter))) {
                        $commonIn = array_intersect($unsetLoopsIn, $refundLoopIn);
                    } elseif (empty($airlineFilters) && !empty($stopFilters) && !empty($refundFilter)) {
                        $commonIn = array_intersect($stopsLoopIn, $refundLoopIn);
                    } elseif (!empty($airlineFilters) && empty($stopFilters) && empty($refundFilter)) {
                        $commonIn = $unsetLoopsIn;
                    } elseif (empty($airlineFilters) && !empty($stopFilters) && empty($refundFilter)) {
                        $commonIn = $stopsLoopIn;
                    } elseif (empty($airlineFilters) && empty($stopFilters) && !empty($refundFilter)) {
                        $commonIn = $refundLoopIn;
                    }

                    $flightsIn = ($isFilter == 0) ? $flightsIn : ((!empty($commonIn)) ? array_intersect_key($flightsIn, array_flip($commonIn)) : array());
                }
            } else {
                if ($flightDetails) {
                    $loop = 0;
                    $unsetLoops = array();
                    $airLoops = array();
                    $stopsLoop = $refundLoop = array();
                    foreach ($flightDetails as $fd) {
                        // echo '<br><br>Normal loop  ==== '.$loop;
                        $AirItineraryFareInfoReN  = $fd['FareItinerary']['AirItineraryFareInfo'];
                        $refundStatus = $AirItineraryFareInfoReN['IsRefundable'];
                        $flights[$loop]['FareSourceCode'] = $AirItineraryFareInfoReN['FareSourceCode'];
                        $flights[$loop]['FareType'] = $AirItineraryFareInfoReN['FareType'];
                        $flights[$loop]['IsRefundable'] = $refundStatus;
                        $flights[$loop]['TotalFares'] = $AirItineraryFareInfoReN['ItinTotalFares'];
                        $flights[$loop]['DirectionInd'] = $fd['FareItinerary']['DirectionInd'];

                        if (strtolower($refundStatus) == 'no' || strtolower($refundStatus) == false) {
                            $no_refund++;
                        } else {
                            $refund++;
                        }
                        $newOriginDestinationOptions  =  $fd['FareItinerary']['OriginDestinationOptions'];

                        $totalStopsOutCount = $newOriginDestinationOptions[0]['TotalStops'];
                        $totalStopsInCount = isset($newOriginDestinationOptions[1]) ? $newOriginDestinationOptions[1]['TotalStops'] : '';

                        if ($totalStopsOutCount == 0) {
                            $non_stop++;
                        } elseif ($totalStopsOutCount == 1) {
                            $one_stop++;
                        } elseif ($totalStopsOutCount == 2) {
                            $two_stop++;
                        } elseif ($totalStopsOutCount == 3) {
                            $three_stop++;
                        }

                        if ($totalStopsInCount == 0) {
                            $non_stop++;
                        } elseif ($totalStopsInCount == 1) {
                            $one_stop++;
                        } elseif ($totalStopsInCount == 2) {
                            $two_stop++;
                        } elseif ($totalStopsInCount == 3) {
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
                        for ($i = 0; $i <= $totalStopsOutCount; $i++) {
                            $iFlightSegment = $flightSegment[$i]['FlightSegment'];
                            $journeyDurations += $iFlightSegment['JourneyDuration'];

                            if ($totalStopsOutCount > 0) {
                                if ($i != 0) {
                                    // if($iFlightSegment['DepartureAirportLocationCode'] == $flightSegment[$i-1]['FlightSegment']['ArrivalAirportLocationCode']){

                                    $timeInMin = getTimeDiffInMInutes($flightSegment[$i - 1]['FlightSegment']['ArrivalDateTime'], $iFlightSegment['DepartureDateTime']);
                                    $layover[$iFlightSegment['DepartureAirportLocationCode']] = $timeInMin;
                                    $layover['place'][] = isset($data['airports'][$iFlightSegment['DepartureAirportLocationCode']]) ? $data['airports'][$iFlightSegment['DepartureAirportLocationCode']]['City'] : $iFlightSegment['DepartureAirportLocationCode'];
                                    $layover['duration'][] = $timeInMin;
                                    // }
                                }
                            }
                            $airlineCode = $iFlightSegment['MarketingAirlineCode'];
                            $flightCodes[] = $airlineCode;
                            $data['airlines'][$airlineCode] = isset($data['airlines'][$airlineCode]) ? ($data['airlines'][$airlineCode] + 1) : 1;

                            $originCode = $iFlightSegment['DepartureAirportLocationCode'];
                            $destinationCode = $iFlightSegment['ArrivalAirportLocationCode'];

                            if (!empty($airlineFilters) && in_array($airlineCode, $airlineFilters)) {
                                $unsetLoops[] = $loop;
                            }
                        }

                        if ($totalStopsOutCount == 0) {
                            $totalDuration = $flightSegment[0]['FlightSegment']['JourneyDuration'];
                        } else {
                            $totalDuration = array_sum($layover['duration']) + $journeyDurations;
                        }


                        $layoverIn = [];
                        $journeyDurationsIn = 0;
                        $flightBaggageIn = [];
                        for ($j = 0; $j <= $totalStopsInCount; $j++) {
                            if (isset($newOriginDestinationOptions[1])) {
                                $jFlightSegment  = $flightSegment[$j]['FlightSegment'];

                                $journeyDurationsIn += $newOriginDestinationOptions[1]['OriginDestinationOption'][$j]['FlightSegment']['JourneyDuration'];
                                $flightSegment = $newOriginDestinationOptions[1]['OriginDestinationOption'];
                                if ($totalStopsInCount > 0) {
                                    if ($j != 0) {
                                        // if($jFlightSegment['DepartureAirportLocationCode'] == $flightSegment[$j-1]['FlightSegment']['ArrivalAirportLocationCode']){

                                        $timeInMin = getTimeDiffInMInutes($flightSegment[$j - 1]['FlightSegment']['ArrivalDateTime'], $jFlightSegment['DepartureDateTime']);
                                        $layoverIn[$jFlightSegment['DepartureAirportLocationCode']] = $timeInMin;
                                        $layoverIn['place'][] = isset($data['airports'][$jFlightSegment['DepartureAirportLocationCode']]) ? $data['airports'][$jFlightSegment['DepartureAirportLocationCode']]['City'] : $jFlightSegment['DepartureAirportLocationCode'];
                                        $layoverIn['duration'][] = $timeInMin;
                                        // }
                                    }
                                }
                                $airlineCode = $jFlightSegment['MarketingAirlineCode'];
                                $flightCodes[] = $airlineCode;
                                $data['airlines'][$airlineCode] = isset($data['airlines'][$airlineCode]) ? ($data['airlines'][$airlineCode] + 1) : 1;

                                $originCode = $jFlightSegment['DepartureAirportLocationCode'];
                                $destinationCode = $jFlightSegment['ArrivalAirportLocationCode'];

                                if (!empty($airlineFilters) && in_array($airlineCode, $airlineFilters)) {
                                    $unsetLoops[] = $loop;
                                }
                            }
                        }

                        if ($totalStopsInCount == 0) {
                            $totalDurationIn = isset($newOriginDestinationOptions[1]) ?  $newOriginDestinationOptions[1]['OriginDestinationOption'][0]['FlightSegment']['JourneyDuration'] : 0;
                        } else {
                            $totalDurationIn = isset($layoverIn['duration']) ? (array_sum($layoverIn['duration']) + $journeyDurationsIn) : $journeyDurationsIn;
                        }

                        $flights[$loop]['totalDurationIn'] = $totalDurationIn;
                        $flights[$loop]['layoversIn'] = $layoverIn;

                        $flights[$loop]['totalDuration'] = $totalDuration;
                        $flights[$loop]['layovers'] = $layover;

                        if (!empty($stopFilters) && (in_array($totalStopsOutCount, $stopFilters) || in_array($totalStopsInCount, $stopFilters))) {
                            $stopsLoop[] = $loop;
                        }
                        if (!empty($refundFilter) && in_array(strtolower($refundStatus), $refundFilter)) {
                            $refundLoop[] = $loop;
                        }

                        $loop++;
                    }

                    $filterArrays[] = $unsetLoops;
                    $filterArrays[] = $stopsLoop;
                    $filterArrays[] = $refundLoop;
                    $filterArrays = array_filter($filterArrays);
                    $common = array();
                    if (empty($airlineFilters) && empty($stopFilters) && empty($refundFilter)) {
                        $common = array();
                    } elseif (!empty($airlineFilters) && !empty($stopFilters) && !empty($refundFilter)) {
                        $common = array_intersect($unsetLoops, $stopsLoop, $refundLoop);
                    } elseif (!empty($airlineFilters) && !empty($stopFilters) && empty($refundFilter)) {
                        $common = array_intersect($unsetLoops, $stopsLoop);
                    } elseif ((!empty($airlineFilters) && empty($stopFilters) && !empty($refundFilter))) {
                        $common = array_intersect($unsetLoops, $refundLoop);
                    } elseif (empty($airlineFilters) && !empty($stopFilters) && !empty($refundFilter)) {
                        $common = array_intersect($stopsLoop, $refundLoop);
                    } elseif (!empty($airlineFilters) && empty($stopFilters) && empty($refundFilter)) {
                        $common = $unsetLoops;
                    } elseif (empty($airlineFilters) && !empty($stopFilters) && empty($refundFilter)) {
                        $common = $stopsLoop;
                    } elseif (empty($airlineFilters) && empty($stopFilters) && !empty($refundFilter)) {
                        $common = $refundLoop;
                    }

                    $flights = ($isFilter == 0) ? $flights : ((!empty($common)) ? array_intersect_key($flights, array_flip($common)) : array());
                }
            }
        }

        return array(
            'one_stop' => $one_stop,
            'two_stop' => $two_stop,
            'three_stop' => $three_stop,
            'non_stop' => $non_stop,
            'refund' => $refund,
            'no_refund' => $no_refund,
            'flights' => $flights,
            'data' => $data,
        );
    }
}
