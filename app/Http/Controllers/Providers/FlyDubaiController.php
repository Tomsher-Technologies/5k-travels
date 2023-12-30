<?php

namespace App\Http\Controllers\Providers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class FlyDubaiController extends Controller
{
    protected  $options = [];
    protected  $logger = [];
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


    // public function getToken()
    // {
    //     $data = [
    //         "client_id" => env('FLY_DUBAI_CLIENT_ID'),
    //         "client_secret" => env('FLY_DUBAI_CLIENT_SECRET'),
    //         "grant_type" => 'password',
    //         "password" => env('FLY_DUBAI_PASSWORD'),
    //         "scope" => 'res',
    //         "username" =>  env('FLY_DUBAI_USERNAME'),
    //     ];

    //     $response = Http::timeout(300)->withOptions($this->options)->asForm()->post(env('FLY_DUBAI_API_URL') . 'authenticate', $data);
    //     $result = $response->getBody()->getContents();
    //     return json_decode($result);
    // }

    public function search(Request $request)
    {
        $apiToken = getToken();

        $retrieveFareQuote = [];
        $retrieveFareQuote['CarrierCodes']['CarrierCode'][]['AccessibleCarrierCode'] = "FZ";
        $retrieveFareQuote['SecutiryGUID'] = "";
        $retrieveFareQuote['ChannelID'] = "OTA";
        $retrieveFareQuote['CountryCode'] = "AE";
        $retrieveFareQuote['ClientIPAddress'] = $request->ip();
        $retrieveFareQuote['HistoricUserName'] = env('FLY_DUBAI_USERNAME');
        $retrieveFareQuote['CurrencyOfFareQuote'] = "AED";
        $retrieveFareQuote['IataNumberOfRequestor'] = env('FLY_DUBAI_IATA');
        $retrieveFareQuote['CorporationID'] = -2147483648;
        $retrieveFareQuote['FareFilterMethod'] = "NoCombinabilityRoundtripLowestFarePerFareType";
        $retrieveFareQuote['FareGroupMethod'] = "WebFareTypes";
        $retrieveFareQuote['InventoryFilterMethod'] = "Available";

        $passengers  = createFDPassengerArray($request);

        if ($request->search_type == 'OneWay') {
            $date = Carbon::parse($request->oDate);
            $retrieveFareQuote['FullInBoundDate'] =  $date->copy()->format('d/m/Y');
            $retrieveFareQuote['FullOutBoundDate'] =  $date->copy()->format('d/m/Y');

            $retrieveFareQuote['FareQuoteDetails']['FareQuoteDetailDateRange'][] = [
                "Origin" => $request->oFrom,
                "Destination" => $request->oTo,
                'UseAirportsNotMetroGroups' => true,
                'UseAirportsNotMetroGroupsAsRule' => true,
                'UseAirportsNotMetroGroupsForFrom' => true,
                'UseAirportsNotMetroGroupsForTo' => true,
                'DateOfDepartureStart' =>  $date->copy()->startOfDay()->format("Y-m-d\TH:i:s"),
                'DateOfDepartureEnd' =>  $date->copy()->endOfDay()->format("Y-m-d\TH:i:s"),
                'FareQuoteRequestInfos' => [
                    'FareQuoteRequestInfo' => $passengers
                ],
            ];
        } elseif ($request->search_type == 'Return') {
            $start_date = Carbon::parse($request->rDate);
            $end_date = Carbon::parse($request->rReturnDate);

            $retrieveFareQuote['FullInBoundDate'] =  $end_date->copy()->format('d/m/Y');
            $retrieveFareQuote['FullOutBoundDate'] =  $start_date->copy()->format('d/m/Y');

            $retrieveFareQuote['FareQuoteDetails']['FareQuoteDetailDateRange'][] = [
                "Origin" => $request->rFrom,
                "Destination" => $request->rTo,
                'UseAirportsNotMetroGroups' => true,
                'UseAirportsNotMetroGroupsAsRule' => true,
                'UseAirportsNotMetroGroupsForFrom' => true,
                'UseAirportsNotMetroGroupsForTo' => true,
                'DateOfDepartureStart' =>  $start_date->copy()->startOfDay()->format("Y-m-d\TH:i:s"),
                'DateOfDepartureEnd' =>  $start_date->copy()->endOfDay()->format("Y-m-d\TH:i:s"),
                'FareQuoteRequestInfos' => [
                    'FareQuoteRequestInfo' => $passengers
                ],
            ];
            $retrieveFareQuote['FareQuoteDetails']['FareQuoteDetailDateRange'][] = [
                "Origin" => $request->rTo,
                "Destination" => $request->rFrom,
                'UseAirportsNotMetroGroups' => true,
                'UseAirportsNotMetroGroupsAsRule' => true,
                'UseAirportsNotMetroGroupsForFrom' => true,
                'UseAirportsNotMetroGroupsForTo' => true,
                'DateOfDepartureStart' =>  $end_date->copy()->startOfDay()->format("Y-m-d\TH:i:s"),
                'DateOfDepartureEnd' =>  $end_date->copy()->endOfDay()->format("Y-m-d\TH:i:s"),
                'FareQuoteRequestInfos' => [
                    'FareQuoteRequestInfo' => $passengers
                ],
            ];
        } elseif ($request->search_type == 'Circle') {

            dd($request);

            $date = Carbon::parse($request->oDate);
            $retrieveFareQuote['FullInBoundDate'] =  $date->copy()->format('d/m/Y');
            $retrieveFareQuote['FullOutBoundDate'] =  $date->copy()->format('d/m/Y');

            $retrieveFareQuote['FareQuoteDetails']['FareQuoteDetailDateRange'][] = [
                "Origin" => $request->oFrom,
                "Destination" => $request->oTo,
                'UseAirportsNotMetroGroups' => true,
                'UseAirportsNotMetroGroupsAsRule' => true,
                'UseAirportsNotMetroGroupsForFrom' => true,
                'UseAirportsNotMetroGroupsForTo' => true,
                'DateOfDepartureStart' =>  $date->copy()->startOfDay()->format("Y-m-d\TH:i:s"),
                'DateOfDepartureEnd' =>  $date->copy()->endOfDay()->format("Y-m-d\TH:i:s"),
                'FareQuoteRequestInfos' => [
                    'FareQuoteRequestInfo' => $passengers
                ],
            ];
        }

        $data['RetrieveFareQuoteDateRange']['RetrieveFareQuoteDateRangeRequest'] = $retrieveFareQuote;

        $search_id = Str::random(10);

        $logger =  Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/req_res_' . time() . '_.log'),
        ]);

        $logger->debug('Search request -- token -- ' . $apiToken);
        $logger->debug('Search request -- ' . $search_id);
        $logger->debug(json_encode($data));

        $response = Http::timeout(300)->withOptions($this->options)->withHeaders([
            'Accept-Encoding' => 'gzip, deflate',
            'Authorization' => 'Bearer ' . $apiToken
        ])->post(env('FLY_DUBAI_API_URL') . 'pricing/flightswithfares', $data);


        $flights = [];
        $one_stop = $two_stop = $three_stop = $non_stop = $three_plus_stop = $refund = $no_refund = 0;
        $airlines = [];



        if (Cache::has('fd_search_result_' . $search_id)) {
            Cache::delete('fd_search_result_' . $search_id);
        }

        if ($response->status() == 200) {
            $apiResult = $response->getBody()->getContents();
            $resultData = json_decode($apiResult, true);

            

            $logger->debug('Search result - Oneway -- ' . $search_id);
            $logger->debug($apiResult);

            $flightSegments = isset($resultData['RetrieveFareQuoteDateRangeResponse']['RetrieveFareQuoteDateRangeResult']['FlightSegments']['FlightSegment']) ? $resultData['RetrieveFareQuoteDateRangeResponse']['RetrieveFareQuoteDateRangeResult']['FlightSegments']['FlightSegment'] : array();
            $segmentDetails = $legDetails = $serviceDetails = $taxDetails = [];

            if ($flightSegments && isset($flightSegments[0]) && $flightSegments[0]['LFID'] !== 0) {

                $segmentDetailsArray = $resultData['RetrieveFareQuoteDateRangeResponse']['RetrieveFareQuoteDateRangeResult']['SegmentDetails']['SegmentDetail'];
                $segmentDetails = array_combine(array_column($segmentDetailsArray, 'LFID'), $segmentDetailsArray);

                $legDetailsArray = $resultData['RetrieveFareQuoteDateRangeResponse']['RetrieveFareQuoteDateRangeResult']['LegDetails']['LegDetail'];
                $legDetails = array_combine(array_column($legDetailsArray, 'PFID'), $legDetailsArray);

                $serviceDetailsArray = $resultData['RetrieveFareQuoteDateRangeResponse']['RetrieveFareQuoteDateRangeResult']['ServiceDetails']['ServiceDetail'];
                $serviceDetails = array_combine(array_column($serviceDetailsArray, 'ID'), $serviceDetailsArray);

                $taxDetailsArray = $resultData['RetrieveFareQuoteDateRangeResponse']['RetrieveFareQuoteDateRangeResult']['TaxDetails']['TaxDetail'];
                $taxDetails = array_combine(array_column($taxDetailsArray, 'TaxID'), $taxDetailsArray);

                if ($request->search_type == 'OneWay') {
                    foreach ($flightSegments as $flightSegment) {
                        if ((int)$flightSegment['LFID'] !== 0) {
                            $flight = [];
                            $flight['LFID'] = $flightSegment['LFID'];
                            $segment = $segmentDetails[$flightSegment['LFID']];

                            $flight['origin'] = $segment['Origin'];
                            $flight['destination'] = $segment['Destination'];
                            $flight['dep_time'] = $segment['DepartureDate'];
                            $flight['arv_time'] = $segment['ArrivalDate'];
                            $flight['stops'] = $segment['Stops'];
                            $flight['leg_count'] = $flightSegment['LegCount'];
                            $flight['flightTime'] = convertMinsToHours($segment['FlightTime']);
                            $flight['airline'] = isset($segment['SellingCarrier']) ? $segment['SellingCarrier'] : 'FZ';
                            $flight['flightNum'] = getFDFlightNum($flight['airline'], $segment['FlightNum']);
                            $flight['aircraftType'] = isset($segment['AircraftType']) ? $segment['AircraftType'] : '';
                            $flight['flightLegs'] = isset($flightSegment['FlightLegDetails']['FlightLegDetail']) ? $flightSegment['FlightLegDetails']['FlightLegDetail'] : array();

                            switch ($flight['stops']) {
                                case 0:
                                    $non_stop++;
                                    break;
                                case 1:
                                    $one_stop++;
                                    break;
                                case 2:
                                    $two_stop++;
                                    break;
                                case 3:
                                    $three_stop++;
                                    break;
                                default:
                                    $three_plus_stop++;
                                    break;
                            }

                            $combinedData = getFDCombinedData($flightSegment['FareTypes']['FareType'], $serviceDetails);

                            $flight['lowest_fare'] = $combinedData['lowestFare'];
                            $flight['fares'] = $combinedData['FareTypes'];
                            $refund += $combinedData['refund'];
                            $no_refund += $combinedData['no_refund'];
                            $flight['api_provider'] = "flydubai";

                            $flights[] = $flight;
                        }
                    }
                } else if ($request->search_type == 'Return') {
                    foreach ($flightSegments as $flightSegment) {
                        if ((int)$flightSegment['LFID'] !== 0) {
                            $flight = [];
                            $flight['LFID'] = $flightSegment['LFID'];
                            $segment = $segmentDetails[$flightSegment['LFID']];

                            $flight['origin'] = $segment['Origin'];
                            $flight['destination'] = $segment['Destination'];
                            $flight['dep_time'] = $segment['DepartureDate'];
                            $flight['arv_time'] = $segment['ArrivalDate'];
                            $flight['stops'] = $segment['Stops'];
                            $flight['leg_count'] = $flightSegment['LegCount'];
                            $flight['flightTime'] = convertMinsToHours($segment['FlightTime']);
                            $flight['airline'] = isset($segment['SellingCarrier']) ? $segment['SellingCarrier'] : 'FZ';
                            $flight['flightNum'] = getFDFlightNum($flight['airline'], $segment['FlightNum']);
                            $flight['aircraftType'] = isset($segment['AircraftType']) ? $segment['AircraftType'] : '';
                            $flight['flightLegs'] = isset($flightSegment['FlightLegDetails']['FlightLegDetail']) ? $flightSegment['FlightLegDetails']['FlightLegDetail'] : array();

                            switch ($flight['stops']) {
                                case 0:
                                    $non_stop++;
                                    break;
                                case 1:
                                    $one_stop++;
                                    break;
                                case 2:
                                    $two_stop++;
                                    break;
                                case 3:
                                    $three_stop++;
                                    break;
                                default:
                                    $three_plus_stop++;
                                    break;
                            }

                            $combinedData = getFDCombinedData($flightSegment['FareTypes']['FareType'], $serviceDetails);

                            $flight['lowest_fare'] = $combinedData['lowestFare'];
                            $flight['fares'] = $combinedData['FareTypes'];
                            $refund += $combinedData['refund'];
                            $no_refund += $combinedData['no_refund'];
                            $flight['api_provider'] = "flydubai";

                            $flights[] = $flight;
                        }
                    }
                }
            } else {
                return $result = [
                    'currency' => "AED",
                    'one_stop' => $one_stop,
                    'two_stop' => $two_stop,
                    'three_stop' => $three_stop,
                    'non_stop' => $non_stop,
                    'three_plus_stop' => $three_plus_stop,
                    'refund' => $refund,
                    'no_refund' => $no_refund,
                    'airlines' => $airlines,
                    'taxDetails' => [],
                    'serviceDetails' => [],
                    'combinability' => [],
                    'legDetails' => [],
                    'flights' => $flights,
                    'search_id' => $search_id,
                ];
            }
        } else {
            return $result = [
                'currency' => "AED",
                'one_stop' => $one_stop,
                'two_stop' => $two_stop,
                'three_stop' => $three_stop,
                'non_stop' => $non_stop,
                'three_plus_stop' => $three_plus_stop,
                'refund' => $refund,
                'no_refund' => $no_refund,
                'airlines' => $airlines,
                'flights' => $flights,
                'taxDetails' => [],
                'serviceDetails' => [],
                'legDetails' => [],
                'combinability' => [],
                'search_id' => $search_id,
            ];
        }

        $airlines = getFDAirLines($flights);

        $result = [
            'currency' => "AED",
            'one_stop' => $one_stop,
            'two_stop' => $two_stop,
            'three_stop' => $three_stop,
            'non_stop' => $non_stop,
            'three_plus_stop' => $three_plus_stop,
            'refund' => $refund,
            'no_refund' => $no_refund,
            'airlines' => $airlines,
            'flights' => $flights,
            'search_id' => $search_id,
            'taxDetails' => $taxDetails,
            'serviceDetails' => $serviceDetails,
            'legDetails' => $legDetails,
            'segmentDetails' => $segmentDetailsArray,
            'combinability' => $resultData['RetrieveFareQuoteDateRangeResponse']['RetrieveFareQuoteDateRangeResult']['Combinability']['BS'],
            'search_type' => $request->search_type
        ];

        // dd($resultData['RetrieveFareQuoteDateRangeResponse']['RetrieveFareQuoteDateRangeResult']['Combinability']['BS']);

        return Cache::remember('fd_search_result_' . $search_id, now()->addHour(), function () use ($result) {
            return $result;
        });
    }

    public function booking(Request $request)
    {
        $apiToken = getToken();
        $data = [];

        $search_result = Cache::get('fd_search_result_' . $request->search_id, null);

        if ($search_result == null) {
            $msg = array('status' => false, 'data' => []);
            echo json_encode($msg);
            exit();
        }

        $flights =  $search_result['flights'];
        $flights = array_combine(array_column($flights, 'LFID'), $flights);

        if (!isset($flights[$request->LFID])) {
            $msg = array('status' => false, 'data' => []);
            echo json_encode($msg);
            exit();
        }
        $flight = $flights[$request->LFID];
        $fares = $flight['fares'];
        $fares = array_combine(array_column($fares, 'FareTypeID'), $fares);

        if (!isset($fares[$request->FareTypeID])) {
            $msg = array('status' => false, 'data' => []);
            echo json_encode($msg);
            exit();
        }

        $fare = $fares[$request->FareTypeID];

        // dd([
        //     $search_result,
        //     $flight,
        //     $fare,
        //     $request,
        // ]);

        if ($search_result['search_type'] == 'OneWay') {

            $paxFareInfos = [];
            $segmentDetails = [];
            $bookingCodes = [];

            foreach ($search_result['segmentDetails'] as $segmentDetail) {
                if ($segmentDetail['LFID'] == $flight['LFID']) {
                    $segmentDetails = $segmentDetail;
                }
            }

           

            foreach ($fare['FareInfos']['FareInfo'][0]['Pax'] as $pax) {
                $taxDetails = [];
                foreach ($pax['ApplicableTaxDetails']['ApplicableTaxDetail'] as $tax) {
                    $taxDetails[] = [
                        "amt" => $tax['Amt'],
                        "taxCode" => $search_result['taxDetails'][$tax['TaxID']]['TaxCode'],
                        "taxID" => $tax['TaxID']
                    ];
                }

                $paxFareInfos[] = array(
                    "fareID" => $pax['FareID'],
                    "ID" => $pax['ID'],
                    "FBC" => $pax['FBCode'],
                    "baseFare" => $pax['BaseFareAmtNoTaxes'],
                    "originalFare" => $pax['OriginalFare'],
                    "ruleID" => $pax['RuleId'],
                    "totalFare" => $pax['FareAmtInclTax'],
                    "PTC" => $pax['PTCID'],
                    "secureHash" => $pax['hashcode'],
                    "secureData" => "",
                    "fareCarrier" => $pax['FareCarrier'],
                    "seatAvailability" => $pax['SeatsAvailable'],
                    "infantAvailability" => 0,
                    "applicableTaxDetails" => $taxDetails,
                    "fareClass" => $pax['FCCode'],
                );
                $bookingCodes[] = array(
                    "fareClass" => $pax['FCCode'],
                    "cabin" => $pax['Cabin'],
                    "paxID" => [
                        $pax['ID']
                    ]

                );
            }

            $originDestinations = [];

            $segmentDetail = [
                [
                    "segmentID" => $flight['LFID'],
                    "OAFlight" => false,
                    "origin" => $segmentDetails['Origin'],
                    "destination" => $segmentDetails['Destination'],
                    "depDate" => $segmentDetails['DepartureDate'],
                    "arrDate" => $segmentDetails['ArrivalDate'],
                    "mrktCarrier" => $segmentDetails['CarrierCode'],
                    "mrktFlightNum" => $segmentDetails['FlightNum'],
                    "operCarrier" => $segmentDetails['CarrierCode'],
                    "operFlightNum" => $segmentDetails['FlightNum'],
                    "arrTerminal" => "",
                    "depTerminal" => "",
                    "bookingCodes" => $bookingCodes
                ]
            ];

            foreach ($flight['flightLegs'] as $flightLeg) {

                $flightLegs = $search_result['legDetails'][$flightLeg['PFID']];
// dd($flightLegs);
                $originDestinations[] = [
                    "odID" => $flight['LFID'],
                    "origin" => $flightLegs['Origin'],
                    "destination" => $flightLegs['Destination'],
                    "flightNum" => $flightLegs['FlightNum'],
                    "depDate" => $flightLegs['DepartureDate'],
                    "arrDate" => $flightLegs['ArrivalDate'],
                    "isPromoApplied" => false,
                    "fareBrand" => [
                        [
                            "fareBrandID" => $fare['FareTypeID'],
                            "fareBrand" => $fare['FareTypeName'],
                            "fareInfos" => array([
                                'paxFareInfos' => $paxFareInfos
                            ])
                        ]
                    ],
                    "segmentDetails" => $segmentDetail
                ];
            }

            $data = [
                "currency" => "AED",
                "IATA" => env('FLY_DUBAI_IATA'),
                "inventoryFilterMethod" => 0,
                "securityGUID" => "",
                "originDestinations" => $originDestinations
            ];
        }

        $logger =  Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/booking/booking_' . time() . '_.log'),
        ]);

        $logger->debug('Booking request -- token -- ' . $apiToken);
        $logger->debug('Booking req - Oneway -- ' . $search_result['search_id']);
        $logger->debug(json_encode($data));

        dd(json_encode($data) );

        $response = Http::timeout(300)->withOptions($this->options)->withHeaders([
            'Accept-Encoding' => 'gzip, deflate',
            'Authorization' => 'Bearer ' . $apiToken
        ])->post(env('FLY_DUBAI_API_URL') . 'order/cart', $data);
        $apiResult = $response->getBody()->getContents();
        $resultData = json_decode($apiResult, true);

        $logger->debug('Booking req - Oneway -- ' . $search_result['search_id']);
        $logger->debug($apiResult);

        dd($resultData);
    }
    // public function booking(Request $request)
    // {
    //     $apiToken = getToken();
    //     $data = [];

    //     $search_result = Cache::get('fd_search_result_' . $request->search_id, null);

    //     if ($search_result == null) {
    //         $msg = array('status' => false, 'data' => []);
    //         echo json_encode($msg);
    //         exit();
    //     }

    //     $flights =  $search_result['flights'];
    //     $flights = array_combine(array_column($flights, 'LFID'), $flights);

    //     if (!isset($flights[$request->LFID])) {
    //         $msg = array('status' => false, 'data' => []);
    //         echo json_encode($msg);
    //         exit();
    //     }
    //     $flight = $flights[$request->LFID];
    //     $fares = $flight['fares'];
    //     $fares = array_combine(array_column($fares, 'FareTypeID'), $fares);

    //     if (!isset($fares[$request->FareTypeID])) {
    //         $msg = array('status' => false, 'data' => []);
    //         echo json_encode($msg);
    //         exit();
    //     }

    //     $fare = $fares[$request->FareTypeID];

    //     // dd([
    //     //     $search_result,
    //     //     $flight,
    //     //     $fare,
    //     //     $request,
    //     // ]);

    //     if ($search_result['search_type'] == 'OneWay') {

    //         $paxFareInfos = [];
    //         $segmentDetails = [];
    //         $bookingCodes = [];

    //         foreach ($search_result['segmentDetails'] as $segmentDetail) {
    //             if ($segmentDetail['LFID'] == $flight['LFID']) {
    //                 $segmentDetails = $segmentDetail;
    //             }
    //         }

    //         foreach ($fare['FareInfos']['FareInfo'][0]['Pax'] as $pax) {
    //             $taxDetails = [];
    //             foreach ($pax['ApplicableTaxDetails']['ApplicableTaxDetail'] as $tax) {
    //                 $taxDetails[] = [
    //                     "amt" => $tax['Amt'],
    //                     "taxCode" => $search_result['taxDetails'][$tax['TaxID']]['TaxCode'],
    //                     "taxID" => $tax['TaxID']
    //                 ];
    //             }

    //             $paxFareInfos[] = array(
    //                 "fareID" => $pax['FareID'],
    //                 "ID" => $pax['ID'],
    //                 "FBC" => $pax['FBCode'],
    //                 "baseFare" => $pax['BaseFareAmtNoTaxes'],
    //                 "originalFare" => $pax['OriginalFare'],
    //                 "ruleID" => $pax['RuleId'],
    //                 "totalFare" => $pax['FareAmtInclTax'],
    //                 "PTC" => $pax['PTCID'],
    //                 "secureHash" => $pax['hashcode'],
    //                 "secureData" => "",
    //                 "fareCarrier" => $pax['FareCarrier'],
    //                 "seatAvailability" => $pax['SeatsAvailable'],
    //                 "infantAvailability" => 0,
    //                 "applicableTaxDetails" => $taxDetails,
    //                 "fareClass" => $pax['FCCode'],
    //             );
    //             $bookingCodes[] = array(
    //                 "fareClass" => $pax['FCCode'],
    //                 "cabin" => $pax['Cabin'],
    //                 "paxID" => [
    //                     $pax['ID']
    //                 ]

    //             );
    //         }

    //         $data = [
    //             "currency" => "AED",
    //             "IATA" => env('FLY_DUBAI_IATA'),
    //             "inventoryFilterMethod" => 0,
    //             "securityGUID" => "",
    //             "originDestinations" => [
    //                 [
    //                     "odID" => $flight['LFID'],
    //                     "origin" => $flight['origin'],
    //                     "destination" => $flight['destination'],
    //                     "flightNum" => $segmentDetails['FlightNum'],
    //                     "depDate" => $flight['dep_time'],
    //                     "arrDate" => $flight['arv_time'],
    //                     "isPromoApplied" => false,
    //                     "fareBrand" => [
    //                         [
    //                             "fareBrandID" => $fare['FareTypeID'],
    //                             "fareBrand" => $fare['FareTypeName'],
    //                             "fareInfos" => array([
    //                                 'paxFareInfos' => $paxFareInfos
    //                             ])
    //                         ]
    //                     ],
    //                     "segmentDetails" => [
    //                         [
    //                             "segmentID" => $flight['LFID'],
    //                             "OAFlight" => false,
    //                             "origin" => $segmentDetails['Origin'],
    //                             "destination" => $segmentDetails['Destination'],
    //                             "depDate" => $segmentDetails['DepartureDate'],
    //                             "arrDate" => $segmentDetails['ArrivalDate'],
    //                             "mrktCarrier" => $segmentDetails['CarrierCode'],
    //                             "mrktFlightNum" => $segmentDetails['FlightNum'],
    //                             "operCarrier" => $segmentDetails['CarrierCode'],
    //                             "operFlightNum" => $segmentDetails['FlightNum'],
    //                             "arrTerminal" => "",
    //                             "depTerminal" => "",
    //                             "bookingCodes" => $bookingCodes
    //                         ]
    //                     ]
    //                 ]
    //             ]
    //         ];
    //     }

    //     $logger =  Log::build([
    //         'driver' => 'single',
    //         'path' => storage_path('logs/booking/booking_' . time() . '_.log'),
    //     ]);

    //     $logger->debug('Booking request -- token -- ' . $apiToken);
    //     $logger->debug('Booking req - Oneway -- ' . $search_result['search_id']);
    //     $logger->debug(json_encode($data));

    //     // dd( json_encode($data) );

    //     $response = Http::timeout(300)->withOptions($this->options)->withHeaders([
    //         'Accept-Encoding' => 'gzip, deflate',
    //         'Authorization' => 'Bearer ' . $apiToken
    //     ])->post(env('FLY_DUBAI_API_URL') . 'order/cart', $data);
    //     $apiResult = $response->getBody()->getContents();
    //     $resultData = json_decode($apiResult, true);

    //     $logger->debug('Booking req - Oneway -- ' . $search_result['search_id']);
    //     $logger->debug($apiResult);

    //     dd($resultData);
    // }
}
