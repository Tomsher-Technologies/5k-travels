<?php

namespace App\Http\Controllers\Providers;

use App\Http\Controllers\Controller;
use App\Models\Airports;
use App\Models\Countries;
use App\Models\FlightBookings;
use App\Models\FlightPassengers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Services\FlyDubaiService;
use Exception;
use Illuminate\Support\Facades\Auth;
use stdClass;

use function PHPUnit\Framework\isEmpty;

class FlyDubaiController extends Controller
{

    private $flightBookingService;


    protected  $options = [];
    protected  $logger = [];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->flightBookingService = new FlyDubaiService();
        if (App::environment('local')) {
            $this->options = ['verify' => false];
        }
    }


    public function search(Request $request)
    {

        // Cache::clear();
        generateApiToken();
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
                "PartyConfig" => "",
                'UseAirportsNotMetroGroups' => true,
                'UseAirportsNotMetroGroupsAsRule' => true,
                'UseAirportsNotMetroGroupsForFrom' => true,
                'UseAirportsNotMetroGroupsForTo' => true,
                'DateOfDepartureStart' =>  $start_date->copy()->startOfDay()->format("Y-m-d\TH:i:s"),
                'DateOfDepartureEnd' =>  $start_date->copy()->endOfDay()->format("Y-m-d\TH:i:s"),
                'FareQuoteRequestInfos' => [
                    'FareQuoteRequestInfo' => $passengers
                ],
                "FareTypeCategory" => "1"
            ];
            $retrieveFareQuote['FareQuoteDetails']['FareQuoteDetailDateRange'][] = [
                "Origin" => $request->rTo,
                "Destination" => $request->rFrom,
                "PartyConfig" => "",
                'UseAirportsNotMetroGroups' => true,
                'UseAirportsNotMetroGroupsAsRule' => true,
                'UseAirportsNotMetroGroupsForFrom' => true,
                'UseAirportsNotMetroGroupsForTo' => true,
                'DateOfDepartureStart' =>  $end_date->copy()->startOfDay()->format("Y-m-d\TH:i:s"),
                'DateOfDepartureEnd' =>  $end_date->copy()->endOfDay()->format("Y-m-d\TH:i:s"),
                'FareQuoteRequestInfos' => [
                    'FareQuoteRequestInfo' => $passengers
                ],
                "FareTypeCategory" => "1"
            ];
        } elseif ($request->search_type == 'Circle') {

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
            'path' => storage_path('logs/se/' . $search_id . '/fare_req.json'),
        ]);
        $logger->debug(json_encode($data));

        // dd(json_encode($data));

        $resultData = $this->flightBookingService->callAPI('pricing/flightswithfares', $data);


        // dd($resultData['RetrieveFareQuoteDateRangeResponse']['RetrieveFareQuoteDateRangeResult']['FlightSegments']);

        // echo "<pre>";
        // print_r( $resultData);
        // echo "</pre>";
        // die();

        $flights = [];
        $one_stop = $two_stop = $three_stop = $non_stop = $three_plus_stop = $refund = $no_refund = 0;
        $airlines = [];


        if (Cache::has('fd_search_result_' . $search_id)) {
            Cache::delete('fd_search_result_' . $search_id);
        }
        if (Cache::has('fd_search_ancillary_' . $search_id)) {
            Cache::delete('fd_search_ancillary_' . $search_id);
        }

        if ($resultData) {

            $logger =  Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/se/' . $search_id . '/fare_res.json'),
            ]);
            $logger->debug(json_encode($resultData));

            $flightSegments = isset($resultData['RetrieveFareQuoteDateRangeResponse']['RetrieveFareQuoteDateRangeResult']['FlightSegments']['FlightSegment']) ? $resultData['RetrieveFareQuoteDateRangeResponse']['RetrieveFareQuoteDateRangeResult']['FlightSegments']['FlightSegment'] : array();
            $segmentDetails = $legDetails = $serviceDetails = $taxDetails = [];

            if ($flightSegments && isset($flightSegments[0]) && $flightSegments[0]['LFID'] !== 0) {

                $segmentDetails = $resultData['RetrieveFareQuoteDateRangeResponse']['RetrieveFareQuoteDateRangeResult']['SegmentDetails']['SegmentDetail'];

                $legDetails =  $resultData['RetrieveFareQuoteDateRangeResponse']['RetrieveFareQuoteDateRangeResult']['LegDetails']['LegDetail'];

                $serviceDetails = $resultData['RetrieveFareQuoteDateRangeResponse']['RetrieveFareQuoteDateRangeResult']['ServiceDetails']['ServiceDetail'];

                $taxDetails = $resultData['RetrieveFareQuoteDateRangeResponse']['RetrieveFareQuoteDateRangeResult']['TaxDetails']['TaxDetail'];

                if ($request->search_type == 'OneWay') {
                    foreach ($flightSegments as $flightSegment) {
                        if ((int)$flightSegment['LFID'] !== 0) {
                            $flight = [];
                            $flight['LFID'] = $flightSegment['LFID'];

                            $segment = [];

                            foreach ($segmentDetails as $segmentDetail) {
                                if ($segmentDetail['LFID'] == $flightSegment['LFID']) {
                                    $segment = $segmentDetail;
                                }
                            }

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
                            // $segment = $segmentDetails[$flightSegment['LFID']];

                            $segment = [];

                            foreach ($segmentDetails as $segmentDetail) {
                                if ($segmentDetail['LFID'] == $flightSegment['LFID']) {
                                    $segment = $segmentDetail;
                                }
                            }

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
            'segmentDetails' => $segmentDetails,
            'combinability' => $resultData['RetrieveFareQuoteDateRangeResponse']['RetrieveFareQuoteDateRangeResult']['Combinability']['BS'],
            'search_type' => $request->search_type
        ];

        // dd($flights);

        // dd($resultData['RetrieveFareQuoteDateRangeResponse']['RetrieveFareQuoteDateRangeResult']['Combinability']['BS']);

        return Cache::remember('fd_search_result_' . $search_id, now()->addHour(), function () use ($result) {
            return $result;
        });
    }


    public function booking(Request $request)
    {
        $data = [];

        $search_result = Cache::get('fd_search_result_' . $request->search_id, null);

        if ($search_result) {
            if ($search_result['search_type'] == 'OneWay') {
                $data = $this->constructOneWayBookingData($search_result, $request);
            } elseif ($search_result['search_type'] == 'Return') {
                $data = $this->constructReturnBookingData($search_result, $request);
            }

            $logger =  Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/se/' . $request->search_id . '/cart_req.json'),
            ]);
            $logger->info(json_encode($data));

            $resultData = $this->flightBookingService->callAPI('order/cart', $data);

            $logger =  Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/se/' . $request->search_id . '/cart_res.json'),
            ]);
            $logger->info(json_encode($resultData));

            if (Cache::has('fd_add_cart_res_' . $request->search_id)) {
                Cache::forget('fd_add_cart_res_' . $request->search_id);
            }

            if ($resultData['Exceptions'][0]['ExceptionCode'] == 0) {
                // dd($resultData);
                Cache::set('fd_add_cart_res_' . $request->search_id, $resultData);
                $msg = array(
                    'status' => true,
                    'data' => $request->all(),
                    'res' => $resultData
                );
                echo json_encode($msg);
                exit();
            } else {
                $msg = array('status' => false, 'data' => ['Error']);
                echo json_encode($resultData);
                exit();
            }
        }
        $msg = array('status' => false, 'data' => []);
        echo json_encode($msg);
        exit();
    }

    private function constructOneWayBookingData($search_result, $request)
    {
        $flights =  $search_result['flights'];
        $flights = array_combine(array_column($flights, 'LFID'), $flights);
        $search_params  = getOrginDestinationSession('OneWay');

        if (!isset($flights[$request->LFID])) {
            $msg = array('status' => false, 'data' => ['111']);
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

        $paxFareInfos = $segmentDetails = $bookingCodes = [];

        foreach ($fare['FareInfos']['FareInfo'] as $paxInfo) {
            $pax = $paxInfo['Pax'][0];

            $taxDetails = [];
            foreach ($pax['ApplicableTaxDetails']['ApplicableTaxDetail'] as $tax) {

                $c_tax = null;

                foreach ($search_result['taxDetails'] as $taxDetail) {
                    if ($taxDetail['TaxID'] == $tax['TaxID']) {
                        $c_tax = $taxDetail;
                    }
                }

                $taxDetails[] = [
                    "amt" => $tax['Amt'],
                    "taxCode" => $c_tax['TaxCode'],
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
                "infantAvailability" => $pax['InfantSeatsAvailable'],
                "applicableTaxDetails" => $taxDetails,
                "fareClass" => $pax['FCCode'],
            );


            $bookingCodes['fareClass'] = $pax['FCCode'];
            $bookingCodes['cabin'] = $pax['Cabin'];

            if (isset($bookingCodes['paxID'])) {
                if (!in_array((string)$pax['ID'], $bookingCodes['paxID'])) {
                    $bookingCodes['paxID'][] = (string)$pax['ID'];
                }
            } else {
                $bookingCodes['paxID'][] = (int)$pax['ID'];
            }
        }

        foreach ($flight['flightLegs'] as $flightLeg) {
            foreach ($search_result['legDetails'] as $c_leg) {
                if (
                    $flightLeg['PFID'] == $c_leg['PFID'] &&
                    $flightLeg['DepartureDate'] == $c_leg['DepartureDate']
                ) {
                    $leg = $c_leg;
                }
            }

            // $leg = $search_result['legDetails'][$flightLeg['PFID']];
            $segmentDetails[] = [
                "segmentID" => $leg['PFID'],
                "OAFlight" => false,
                "origin" => $leg['Origin'],
                "destination" => $leg['Destination'],
                "depDate" => $leg['DepartureDate'],
                "arrDate" => $leg['ArrivalDate'],
                "mrktCarrier" => $leg['MarketingCarrier'],
                "mrktFlightNum" => $leg['FlightNum'],
                "operCarrier" => $leg['OperatingCarrier'],
                "operFlightNum" => $leg['MarketingFlightNum'],
                "arrTerminal" => $leg['FromTerminal'],
                "depTerminal" => $leg['ToTerminal'],
                "bookingCodes" => array($bookingCodes)
            ];
        }

        $data = [
            "currency" => "AED",
            "IATA" => env('FLY_DUBAI_IATA'),
            "inventoryFilterMethod" => 0,
            "securityGUID" => "",
            "originDestinations" => [
                [
                    "odID" => $flight['LFID'],
                    "origin" => $search_params['origin'],
                    "destination" => $search_params['destination'],
                    "flightNum" => str_replace(' ', '', str_replace('FZ ', '', $flight['flightNum'])),
                    "depDate" => $flight['dep_time'],
                    "arrDate" => $flight['arv_time'],
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
                    "segmentDetails" => $segmentDetails
                ]
            ]
        ];

        return $data;
    }

    // private function constructReturnBookingData($search_result, $request)
    // {
    //     $flights =  $search_result['flights'];
    //     $flights = array_combine(array_column($flights, 'LFID'), $flights);
    //     $search_params  = getOrginDestinationSession('Return');

    //     $combinability = false;
    //     $originDestinations = [];

    //     foreach ($search_result['combinability'] as $combinability) {
    //         if (
    //             in_array($request->dep_solnid, $combinability['SolnRef']) &&
    //             in_array($request->rtn_solnid, $combinability['SolnRef'])
    //         ) {
    //             $combinability = true;
    //         }
    //     }

    //     if (!$combinability) {
    //         $msg = array('status' => false, 'data' => ['Not combinability']);
    //         echo json_encode($msg);
    //         exit();
    //     }

    //     if (!isset($flights[$request->dep_LFID]) || !isset($flights[$request->rtn_LFID])) {
    //         $msg = array('status' => false, 'data' => ['abc']);
    //         echo json_encode($msg);
    //         exit();
    //     }

    //     // Out bound
    //     $outBoundFlight = $flights[$request->dep_LFID];
    //     $outBoundFares = $outBoundFlight['fares'];

    //     // In Bound
    //     $inBoundFlight = $flights[$request->rtn_LFID];
    //     $inBoundFares = $inBoundFlight['fares'];

    //     $outBoundFare = $inBoundFare = [];

    //     foreach ($outBoundFares  as $fares) {
    //         if (
    //             $fares['FareTypeID'] == $request->dep_FareTypeID &&
    //             $fares['SolnId'] == $request->dep_solnid
    //         ) {
    //             $outBoundFare = $fares;
    //         }
    //     }

    //     foreach ($inBoundFares  as $fares) {
    //         if (
    //             $fares['FareTypeID'] == $request->rtn_FareTypeID &&
    //             $fares['SolnId'] == $request->rtn_solnid
    //         ) {
    //             $inBoundFare = $fares;
    //         }
    //     }


    //     if (
    //         empty($inBoundFare) ||
    //         empty($outBoundFare)
    //     ) {
    //         $msg = array('status' => false, 'data' => ['123']);
    //         echo json_encode($msg);
    //         exit();
    //     }

    //     // Out bound array
    //     $FCCode = $Cabin = '';
    //     $paxID= [];
    //     $bookingCodes = [];
    //     foreach ($inBoundFare['FareInfos']['FareInfo'] as $FareInfo) {
    //         foreach ($FareInfo['Pax'] as $pax) {
    //             $taxDetails = [];
    //             foreach ($pax['ApplicableTaxDetails']['ApplicableTaxDetail'] as $tax) {

    //                 $c_tax = null;

    //                 foreach ($search_result['taxDetails'] as $taxDetail) {
    //                     if ($taxDetail['TaxID'] == $tax['TaxID']) {
    //                         $c_tax = $taxDetail;
    //                     }
    //                 }

    //                 $taxDetails[] = [
    //                     "amt" => $tax['Amt'],
    //                     "taxCode" => $c_tax['TaxCode'],
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

    //             $FCCode = $pax['FCCode'];
    //             $Cabin = $pax['Cabin'];
    //             $paxID[] = (string)$pax['FareID'];
    //         }
    //     }

    //     $bookingCodes[] = array(
    //         "fareClass" => $FCCode,
    //         "cabin" => $Cabin,
    //         "paxID" => $paxID
    //     );

    //     // dd( $bookingCodes);

    //     foreach ($outBoundFlight['flightLegs'] as $flightLeg) {
    //         foreach ($search_result['legDetails'] as $c_leg) {
    //             if (
    //                 $flightLeg['PFID'] == $c_leg['PFID'] &&
    //                 $flightLeg['DepartureDate'] == $c_leg['DepartureDate']
    //             ) {
    //                 $leg = $c_leg;
    //             }
    //         }

    //         // $leg = $search_result['legDetails'][$flightLeg['PFID']];
    //         $segmentDetails[] = [
    //             "segmentID" => $leg['PFID'],
    //             "OAFlight" => false,
    //             "origin" => $leg['Origin'],
    //             "destination" => $leg['Destination'],
    //             "depDate" => $leg['DepartureDate'],
    //             "arrDate" => $leg['ArrivalDate'],
    //             "mrktCarrier" => $leg['MarketingCarrier'],
    //             "mrktFlightNum" => $leg['FlightNum'],
    //             "operCarrier" => $leg['OperatingCarrier'],
    //             "operFlightNum" => $leg['MarketingFlightNum'],
    //             "arrTerminal" => $leg['FromTerminal'],
    //             "depTerminal" => $leg['ToTerminal'],
    //             "bookingCodes" => $bookingCodes
    //         ];
    //     }
    //     $originDestinations[] = [
    //         "odID" => $outBoundFlight['LFID'],
    //         "origin" => $search_params['origin'],
    //         "destination" => $search_params['destination'],
    //         "flightNum" => $leg['FlightNum'],
    //         "depDate" => $outBoundFlight['dep_time'],
    //         "arrDate" => $outBoundFlight['arv_time'],
    //         "isPromoApplied" => false,
    //         "fareBrand" => [
    //             [
    //                 "fareBrandID" => $outBoundFare['FareTypeID'],
    //                 "fareBrand" => $outBoundFare['FareTypeName'],
    //                 "fareInfos" => array([
    //                     'paxFareInfos' => $paxFareInfos
    //                 ])
    //             ]
    //         ],
    //         "segmentDetails" => $segmentDetails
    //     ];

    //     $segmentDetails = [];
    //     $paxFareInfos2 = [];
    //     // In bound array

    //     $FCCode = $Cabin = '';
    //     $paxID= [];
    //     $bookingCodes2 = [];
    //     foreach ($inBoundFare['FareInfos']['FareInfo'] as $FareInfo) {
    //         foreach ($FareInfo['Pax'] as $pax) {
    //             $taxDetails = [];
    //             foreach ($pax['ApplicableTaxDetails']['ApplicableTaxDetail'] as $tax) {

    //                 $c_tax = null;

    //                 foreach ($search_result['taxDetails'] as $taxDetail) {
    //                     if ($taxDetail['TaxID'] == $tax['TaxID']) {
    //                         $c_tax = $taxDetail;
    //                     }
    //                 }

    //                 $taxDetails[] = [
    //                     "amt" => $tax['Amt'],
    //                     "taxCode" => $c_tax['TaxCode'],
    //                     "taxID" => $tax['TaxID']
    //                 ];
    //             }

    //             $paxFareInfos2[] = array(
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

    //             $FCCode = $pax['FCCode'];
    //             $Cabin = $pax['Cabin'];
    //             $paxID[] =  (string)$pax['ID'];

    //         }
    //     }

    //     $bookingCodes2[] = array(
    //         "fareClass" => $FCCode,
    //         "cabin" => $Cabin,
    //         "paxID" => $paxID
    //     );

    //     foreach ($inBoundFlight['flightLegs'] as $flightLeg) {

    //         foreach ($search_result['legDetails'] as $c_leg) {
    //             if (
    //                 $flightLeg['PFID'] == $c_leg['PFID'] &&
    //                 $flightLeg['DepartureDate'] == $c_leg['DepartureDate']
    //             ) {
    //                 $leg = $c_leg;
    //             }
    //         }

    //         // $leg = $search_result['legDetails'][$flightLeg['PFID']];
    //         $segmentDetails[] = [
    //             "segmentID" => $leg['PFID'],
    //             "OAFlight" => false,
    //             "origin" => $leg['Origin'],
    //             "destination" => $leg['Destination'],
    //             "depDate" => $leg['DepartureDate'],
    //             "arrDate" => $leg['ArrivalDate'],
    //             "mrktCarrier" => $leg['MarketingCarrier'],
    //             "mrktFlightNum" => $leg['FlightNum'],
    //             "operCarrier" => $leg['OperatingCarrier'],
    //             "operFlightNum" => $leg['MarketingFlightNum'],
    //             "arrTerminal" => $leg['FromTerminal'],
    //             "depTerminal" => $leg['ToTerminal'],
    //             "bookingCodes" => $bookingCodes2
    //         ];
    //     }

    //     $originDestinations[] = [
    //         "odID" => $inBoundFlight['LFID'],
    //         "origin" => $search_params['destination'],
    //         "destination" => $search_params['origin'],
    //         "flightNum" => $leg['FlightNum'],
    //         "depDate" => $inBoundFlight['dep_time'],
    //         "arrDate" => $inBoundFlight['arv_time'],
    //         "isPromoApplied" => false,
    //         "fareBrand" => [
    //             [
    //                 "fareBrandID" => $inBoundFare['FareTypeID'],
    //                 "fareBrand" => $inBoundFare['FareTypeName'],
    //                 "fareInfos" => array([
    //                     'paxFareInfos' => $paxFareInfos2
    //                 ])
    //             ]
    //         ],
    //         "segmentDetails" => $segmentDetails
    //     ];

    //     $data = [
    //         "currency" => "AED",
    //         "IATA" => env('FLY_DUBAI_IATA'),
    //         "inventoryFilterMethod" => 0,
    //         "securityGUID" => "",
    //         "originDestinations" => $originDestinations
    //     ];

    //     // dd(json_encode($paxFareInfos));

    //     return $data;
    // }

    private function constructReturnBookingData($search_result, $request)
    {
        $flights =  $search_result['flights'];
        $flights = array_combine(array_column($flights, 'LFID'), $flights);
        $search_params  = getOrginDestinationSession('Return');

        $combinability = false;
        $originDestinations = [];

        foreach ($search_result['combinability'] as $combinability) {
            if (
                in_array($request->dep_solnid, $combinability['SolnRef']) &&
                in_array($request->rtn_solnid, $combinability['SolnRef'])
            ) {
                $combinability = true;
            }
        }

        if (!$combinability) {
            $msg = array('status' => false, 'data' => ['Not combinability']);
            echo json_encode($msg);
            exit();
        }

        if (!isset($flights[$request->dep_LFID]) || !isset($flights[$request->rtn_LFID])) {
            $msg = array('status' => false, 'data' => ['abc']);
            echo json_encode($msg);
            exit();
        }

        // Out bound
        $outBoundFlight = $flights[$request->dep_LFID];
        $outBoundFares = $outBoundFlight['fares'];



        $outBoundFare = $inBoundFare = [];

        foreach ($outBoundFares  as $fares) {
            if (
                $fares['FareTypeID'] == $request->dep_FareTypeID &&
                $fares['SolnId'] == $request->dep_solnid
            ) {
                $outBoundFare = $fares;
            }
        }


        // In Bound
        $inBoundFlight = $flights[$request->rtn_LFID];
        $inBoundFares = $inBoundFlight['fares'];
        foreach ($inBoundFares  as $fares) {
            if (
                $fares['FareTypeID'] == $request->rtn_FareTypeID &&
                $fares['SolnId'] == $request->rtn_solnid
            ) {
                $inBoundFare = $fares;
            }
        }


        if (
            empty($inBoundFare) ||
            empty($outBoundFare)
        ) {
            $msg = array('status' => false, 'data' => ['123']);
            echo json_encode($msg);
            exit();
        }

        // Out bound array
        $FCCode = $Cabin = '';
        $paxID = [];
        $bookingCodes = [];
        foreach ($outBoundFare['FareInfos']['FareInfo'] as $FareInfo) {
            foreach ($FareInfo['Pax'] as $pax) {
                $taxDetails = [];
                foreach ($pax['ApplicableTaxDetails']['ApplicableTaxDetail'] as $tax) {

                    $c_tax = null;

                    foreach ($search_result['taxDetails'] as $taxDetail) {
                        if ($taxDetail['TaxID'] == $tax['TaxID']) {
                            $c_tax = $taxDetail;
                        }
                    }

                    $taxDetails[] = [
                        "amt" => $tax['Amt'],
                        "taxCode" => $c_tax['TaxCode'],
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

                $FCCode = $pax['FCCode'];
                $Cabin = $pax['Cabin'];
                $paxID[] = (string)$pax['ID'];
            }
        }

        $bookingCodes[] = array(
            "fareClass" => $FCCode,
            "cabin" => $Cabin,
            "paxID" => $paxID
        );

        // dd( $bookingCodes);

        foreach ($outBoundFlight['flightLegs'] as $flightLeg) {
            foreach ($search_result['legDetails'] as $c_leg) {
                if (
                    $flightLeg['PFID'] == $c_leg['PFID'] &&
                    $flightLeg['DepartureDate'] == $c_leg['DepartureDate']
                ) {
                    $leg = $c_leg;
                }
            }

            // $leg = $search_result['legDetails'][$flightLeg['PFID']];
            $segmentDetails[] = [
                "segmentID" => $leg['PFID'],
                "OAFlight" => false,
                "origin" => $leg['Origin'],
                "destination" => $leg['Destination'],
                "depDate" => $leg['DepartureDate'],
                // "arrDate" => $leg['ArrivalDate'],
                "mrktCarrier" => $leg['MarketingCarrier'],
                "mrktFlightNum" => $leg['FlightNum'],
                "operCarrier" => $leg['OperatingCarrier'],
                "operFlightNum" => $leg['MarketingFlightNum'],
                "arrTerminal" => $leg['FromTerminal'],
                "depTerminal" => $leg['ToTerminal'],
                "bookingCodes" => $bookingCodes
            ];
        }
        $originDestinations[] = [
            "odID" => $outBoundFlight['LFID'],
            "origin" => $search_params['origin'],
            "destination" => $search_params['destination'],
            "flightNum" => $leg['FlightNum'],
            "depDate" => $outBoundFlight['dep_time'],
            "arrDate" => $outBoundFlight['arv_time'],
            "isPromoApplied" => false,
            "fareBrand" => [
                [
                    "fareBrandID" => $outBoundFare['FareTypeID'],
                    "fareBrand" => $outBoundFare['FareTypeName'],
                    "fareInfos" => array([
                        'paxFareInfos' => $paxFareInfos
                    ])
                ]
            ],
            "segmentDetails" => $segmentDetails
        ];

        // In bound array
        $segmentDetails = [];
        $paxFareInfos2 = [];

        $FCCode = $Cabin = '';
        $paxID = [];
        $bookingCodes2 = [];
        foreach ($inBoundFare['FareInfos']['FareInfo'] as $FareInfo) {
            foreach ($FareInfo['Pax'] as $pax) {
                $taxDetails = [];
                foreach ($pax['ApplicableTaxDetails']['ApplicableTaxDetail'] as $tax) {

                    $c_tax = null;

                    foreach ($search_result['taxDetails'] as $taxDetail) {
                        if ($taxDetail['TaxID'] == $tax['TaxID']) {
                            $c_tax = $taxDetail;
                        }
                    }

                    $taxDetails[] = [
                        "amt" => $tax['Amt'],
                        "taxCode" => $c_tax['TaxCode'],
                        "taxID" => $tax['TaxID']
                    ];
                }

                $paxFareInfos2[] = array(
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

                $FCCode = $pax['FCCode'];
                $Cabin = $pax['Cabin'];
                $paxID[] =  (string)$pax['ID'];
            }
        }

        $bookingCodes2[] = array(
            "fareClass" => $FCCode,
            "cabin" => $Cabin,
            "paxID" => $paxID
        );

        foreach ($inBoundFlight['flightLegs'] as $flightLeg) {

            foreach ($search_result['legDetails'] as $c_leg) {
                if (
                    $flightLeg['PFID'] == $c_leg['PFID'] &&
                    $flightLeg['DepartureDate'] == $c_leg['DepartureDate']
                ) {
                    $leg = $c_leg;
                }
            }

            // $leg = $search_result['legDetails'][$flightLeg['PFID']];
            $segmentDetails[] = [
                "segmentID" => $leg['PFID'],
                "OAFlight" => false,
                "origin" => $leg['Origin'],
                "destination" => $leg['Destination'],
                "depDate" => $leg['DepartureDate'],
                // "arrDate" => $leg['ArrivalDate'],
                "mrktCarrier" => $leg['MarketingCarrier'],
                "mrktFlightNum" => $leg['FlightNum'],
                "operCarrier" => $leg['OperatingCarrier'],
                "operFlightNum" => $leg['MarketingFlightNum'],
                "arrTerminal" => $leg['FromTerminal'],
                "depTerminal" => $leg['ToTerminal'],
                "bookingCodes" => $bookingCodes2
            ];
        }

        $originDestinations[] = [
            "odID" => $inBoundFlight['LFID'],
            "origin" => $search_params['destination'],
            "destination" => $search_params['origin'],
            "flightNum" => $leg['FlightNum'],
            "depDate" => $inBoundFlight['dep_time'],
            "arrDate" => $inBoundFlight['arv_time'],
            "isPromoApplied" => false,
            "fareBrand" => [
                [
                    "fareBrandID" => $inBoundFare['FareTypeID'],
                    "fareBrand" => $inBoundFare['FareTypeName'],
                    "fareInfos" => array([
                        'paxFareInfos' => $paxFareInfos2
                    ])
                ]
            ],
            "segmentDetails" => $segmentDetails
        ];

        $data = [
            "currency" => "AED",
            "IATA" => env('FLY_DUBAI_IATA'),
            "inventoryFilterMethod" => 0,
            "securityGUID" => "",
            "originDestinations" => $originDestinations
        ];

        // dd(json_encode($paxFareInfos));

        return $data;
    }

    public function getAncillaryOffers(Request $request)
    {
        $data = [];

        try {
            $search_result = Cache::get('fd_search_result_' . $request->search_id, null);

            if ($search_result == null) {
                return redirect()->back()->with([
                    'ancillary_status' => 'fd_search_result_'
                ]);
            }

            $seat_response = $acc_response = null;

            $flights = array_combine(array_column($search_result['flights'], 'LFID'), $search_result['flights']);

            $search_params = getOrginDestinationSession($search_result['search_type']);

            if ($search_result['search_type'] == 'OneWay') {

                $flight = $flights[$request->LFID] ?? null;

                if ($flight) {
                    $res_data['flight'] = $flight;
                    $data['flights'][] = [
                        "lfID" => $request->LFID,
                        "flightNum" => str_replace(' ', '', str_replace('FZ', '', $flight['flightNum'])),
                        "depDate" => $flight['dep_time'],
                        "origin" => $flight['origin'],
                        "category" => null,
                        "services" => null,
                        "currency" => "AED",
                        "UTCOffset" => 0,
                        "operatingCarrierCode" => "FZ",
                        "marketingCarrierCode" => "FZ",
                        "channel" => "TPAPI"
                    ];
                }
            } elseif ($search_result['search_type'] == 'Return') {

                $depFlight = $flights[$request->dep_LFID] ?? null;
                $rtnFlight = $flights[$request->rtn_LFID] ?? null;

                $res_data['depFlight'] = $depFlight;
                $res_data['rtnFlight'] = $rtnFlight;

                if ($depFlight && $rtnFlight) {
                    $data['flights'][] = [
                        "lfID" => $request->dep_LFID,
                        "flightNum" => str_replace(' ', '', str_replace('FZ', '', $depFlight['flightNum'])),
                        "depDate" => $depFlight['dep_time'],
                        "origin" => $depFlight['origin'],
                        "category" => null,
                        "services" => null,
                        "currency" => "AED",
                        "UTCOffset" => 0,
                        "operatingCarrierCode" => "FZ",
                        "marketingCarrierCode" => "FZ",
                        "channel" => "TPAPI"
                    ];
                    $data['flights'][] = [
                        "lfID" => $request->rtn_LFID,
                        "flightNum" => str_replace(' ', '', str_replace('FZ', '', $rtnFlight['flightNum'])),
                        "depDate" => $rtnFlight['dep_time'],
                        "origin" => $rtnFlight['origin'],
                        "category" => null,
                        "services" => null,
                        "currency" => "AED",
                        "UTCOffset" => 0,
                        "operatingCarrierCode" => "FZ",
                        "marketingCarrierCode" => "FZ",
                        "channel" => "TPAPI"
                    ];
                }
            }

            if (!empty($data)) {
                $acc_response = $this->flightBookingService->callAPI('pricing/ancillary', $data);
                $seat_response = $this->flightBookingService->callAPI('pricing/seats', $data);

                // if (Cache::has('fd_search_ancillary_' . $request->search_id)) {
                //     Cache::forget('fd_search_ancillary_' . $request->search_id);
                // }
                // if (Cache::has('fd_seat_req_' . $request->search_id)) {
                //     Cache::forget('fd_seat_req_s' . $request->search_id);
                // }
                // if (Cache::has('fd_seat_res_data_' . $request->search_id)) {
                //     Cache::forget('fd_seat_res_data_' . $request->search_id);
                // }

                $logger =  Log::build([
                    'driver' => 'single',
                    'path' => storage_path('logs/se/' . $request->search_id . '/anc_req.json'),
                ]);
                $logger->info(json_encode($acc_response));

                // Cache::set('fd_search_ancillary_' . $request->search_id, $acc_response);
                // Cache::set('fd_seat_req_' . $request->search_id, $data);

                $res_data = array_merge($res_data, array(
                    'search_type' => $search_result['search_type'],
                    'search_result' => $search_result,
                    'search_params' => $search_params,
                    'countries' => Countries::all()
                ));

                // Cache::set('fd_seat_res_data_' . $request->search_id, $res_data);

                return view('web.provides.flydubai.ancillary', compact('acc_response', 'seat_response', 'res_data'));
            }

            return redirect()->back()->with([
                'ancillary_status' => "data empty"
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with([
                'ancillary_status' => "try catch"
            ]);
        }
    }

    function createPassengerArray($passCount, $request, $key, $passengerType)
    {
        $pass = [];
        $age = Carbon::parse($request->{$passengerType . '_dob'}[$key])->age;

        switch ($passengerType) {
            case 'child':
                $PTCID = 6;
                break;
            case 'infant':
                $PTCID = 5;
                break;
            default:
                $PTCID = 1;
                break;
        }


        $pass['PersonOrgID'] = $passCount;
        $pass['FirstName'] = $request->{$passengerType . '_first_name'}[$key];
        $pass['LastName'] = $request->{$passengerType . '_last_name'}[$key];
        $pass['MiddleName'] = '';
        $pass['Age'] = $age;
        $pass['DOB'] = $request->{$passengerType . '_dob'}[$key];
        $pass['Gender'] = Str::upper($request->{$passengerType . '_gender'}[$key]);
        $pass['Title'] = $request->{$passengerType . '_title'}[$key];
        $pass['NationalityLaguageID'] = 1;
        $pass['RelationType'] = 'Self';
        $pass['WBCID'] = 1;
        $pass['PTCID'] = $PTCID;
        $pass['TravelsWithPersonOrgID'] = -1;
        $pass['MarketingOptIn'] = true;
        $pass['UseInventory'] = false;
        $pass['Address'] = [
            "Address1" => "",
            "Address2" => "",
            "City" => "",
            "State" => "",
            "Postal" => "",
            "Country" => "",
            "CountryCode" => "",
            "AreaCode" => "",
            "PhoneNumber" => "",
            "Display" => ""
        ];
        $pass['Nationality'] = $request->{$passengerType . '_nationality'}[$key];
        $pass['ProfileId'] = -2147483648;
        $pass['IsPrimaryPassenger'] = $passCount == -1;
        $pass['ContactInfos'] = [
            [
                "Key" => null,
                "ContactID" => 0,
                "PersonOrgID" => $passCount,
                "ContactField" => $request->mobile_no,
                "ContactType" => 1,
                "Extension" => "",
                "CountryCode" => $request->mobile_code,
                "PhoneNumber" => $request->mobile_no,
                "Display" => "",
                "PreferredContactMethod" => false,
                "ValidatedContact" => false
            ],
            [
                "Key" => null,
                "ContactID" => 0,
                "PersonOrgID" => $passCount,
                "ContactField" => $request->email,
                "ContactType" => 4,
                "Extension" => "",
                "CountryCode" => "",
                "PhoneNumber" => "",
                "Display" => "",
                "PreferredContactMethod" => true,
                "ValidatedContact" => false
            ]
        ];
        $pass['DocumentInfos'] = [
            [
                "DocType" => "1",
                "DocNumber" => $request->{$passengerType . '_passport'}[$key],
                "IssuingCountry" => $request->{$passengerType . '_passport_country'}[$key],
                "IssueDate" => Carbon::parse($request->{$passengerType . '_passport_issue'}[$key])->format('Y-m-d\T00:00:00'),
                "ExpiryDate" => Carbon::parse($request->{$passengerType . '_passport_expiry'}[$key])->format('Y-m-d\T00:00:00'),
            ]
        ];

        return $pass;
    }

    public function generateSpecialServices(Request $request, $paxCount, $p_type)
    {
        // return [];
        $acc_result = Cache::get('fd_search_ancillary_' . $request->search_id, null);
        $services = [];
        if (!$acc_result) {
            return [];
        }
        // Bag
        if (isset($request['bag'][$p_type][$paxCount])) {
            $arr_key = key($request['bag'][$p_type][$paxCount]);
            $arr_value = $request['bag'][$p_type][$paxCount][$arr_key];
            $bagDetails = getBaggaeDetails($arr_key, $arr_value, $acc_result);
            $bag = [];
            $bag["ServiceID"] = 0;
            $bag["CodeType"] = $arr_value;
            $bag["SSRCategory"] = 0;
            $bag["LogicalFlightID"] = $arr_key;
            $bag["DepartureDate"] = $bagDetails['depDate'];
            $bag["Amount"] = $bagDetails['bag']['amount'];
            $bag["OverrideAmount"] = false;
            $bag["CurrencyCode"] = $bagDetails['bag']['currency'];
            $bag["Commissionable"] = false;
            $bag["Refundable"] = false;
            $bag["ChargeComment"] = $bagDetails['bag']['ruleID'];
            $bag["PersonOrgID"] = -$paxCount;
            $bag["AlreadyAdded"] = false;
            $bag["PhysicalFlightID"] = 0;
            $bag["secureHash"] = "";
            $services[] = $bag;
        }

        // Meal
        if (isset($request['meal'][$p_type][$paxCount])) {
            foreach ($request['meal'][$p_type][$paxCount] as $key => $meal) {
                $mealDetails = getMealDetails($key, $meal, $acc_result);

                $meal_arr = [];
                $meal_arr["ServiceID"] = 0;
                $meal_arr["CodeType"] = $meal;
                $meal_arr["SSRCategory"] = 0;
                $meal_arr["LogicalFlightID"] = $mealDetails['lfID'];
                $meal_arr["DepartureDate"] = $mealDetails['depDate'];
                $meal_arr["Amount"] = $mealDetails['meal']['amount'];
                $meal_arr["OverrideAmount"] = false;
                $meal_arr["CurrencyCode"] = $mealDetails['meal']['currency'];
                $meal_arr["Commissionable"] = false;
                $meal_arr["Refundable"] = false;
                $meal_arr["ChargeComment"] = $mealDetails['meal']['ruleID'];
                $meal_arr["PersonOrgID"] = -$paxCount;
                $meal_arr["AlreadyAdded"] = false;
                $meal_arr["PhysicalFlightID"] = $key;
                $meal_arr["secureHash"] = "";

                $services[] = $meal_arr;
            }
        }

        return $services;
    }

    public function generateSeatArray(Request $request, $paxCount, $p_id, $poid, $LFID)
    {
        $p_type = "ADT";
        if ($p_id == 6) {
            $p_type = "CHD";
        } else if ($p_id == 5) {
            $p_type = "INF";
        }

        $seatsArray = [];
        // return $seats;

        $LP_Array = getFDLfidPfid($request->search_id);

        if (isset($request['seat'])) {
            foreach ($request['seat'] as $key => $seats) {
                if ($key == $p_type) {
                    foreach ($seats[$paxCount + 1] as $key_2 => $seat) {
                        $se = explode('_', $seat);
                        if (isset($LP_Array[$LFID])) {
                            $seatiner = [];
                            $seatiner["PersonOrgID"] = (string)$poid;
                            $seatiner["LogicalFlightID"] = (string)$LFID;
                            $seatiner["PhysicalFlightID"] = (string)$key_2;
                            $seatiner["DepartureDate"] = $LP_Array[$LFID][$key_2];
                            $seatiner["SeatSelected"] = (string)$se[2];
                            $seatiner["RowNumber"] = (string)$se[1];

                            $seatsArray[] = $seatiner;
                        }
                    }
                }
            }
        }
        return $seatsArray;
    }

    public function submitPnr(Request $request)
    {
        // dd($request);
        $passCount = -1;
        $passengers = [];
        $segments = [];

        $search_result = Cache::get('fd_search_result_' . $request->search_id, null);
        $cart_res = Cache::get('fd_add_cart_res_' . $request->search_id, null);

        if (!$search_result || !$cart_res) {
            return $this->redirectFail();
        }

        $fareID = [];

        foreach ($cart_res['flightGroups'] as $flightGroup) {
            foreach ($flightGroup['fareBrands'] as $fareBrand) {
                foreach ($fareBrand['fareInfos'] as $fareInfo) {
                    foreach ($fareInfo['paxFareInfos'] as $paxFareInfo) {
                        $fareID[$flightGroup['ID']][$paxFareInfo['PTC']] = $paxFareInfo['fareID'];
                    }
                }
            }
        }

        $segmentsArray = [];

        if ($search_result['search_type'] == 'OneWay') {
            $search_lfdi = $request->LFID;
            $search_FareTypeID = $request->FareTypeID;
            foreach ($search_result['flights'] as $flight) {
                if ($flight['LFID'] == $search_lfdi) {
                    $segmentsArray[] = $flight;
                }
            }
        } else if ($search_result['search_type'] == 'Return') {
            $dep_LFID = $request->dep_LFID;
            $rtn_LFID = $request->rtn_LFID;
            $dep_FareTypeID = $request->dep_FareTypeID;
            $rtn_FareTypeID = $request->rtn_FareTypeID;
            foreach ($search_result['flights'] as $flight) {
                if ($flight['LFID'] == $dep_LFID || $flight['LFID'] == $rtn_LFID) {
                    $segmentsArray[] = $flight;
                }
            }
        }

        foreach ($request->adult_title as $key => $adult) {
            $passengers[] = $this->createPassengerArray($passCount--, $request, $key, 'adult');
        }

        if (isset($request->child_title)) {
            foreach ($request->child_title as $key => $child) {
                $passengers[] = $this->createPassengerArray($passCount--, $request, $key, 'child');
            }
        }
        if (isset($request->infant_title)) {
            foreach ($request->infant_title as $key => $infant) {
                $passengers[] = $this->createPassengerArray($passCount--, $request, $key, 'infant');
            }
        }

        foreach ($segmentsArray as $segment) {
            foreach ($passengers as $key => $passenger) {
                $seg = [];
                $seg['PersonOrgID'] = $passenger['PersonOrgID'];
                $seg['FareInformationID'] = $fareID[$segment['LFID']][$passenger['PTCID']];
                $seg['SpecialServices'] = [];
                $seg['Seats'] = $this->generateSeatArray($request, $key, $passenger['PTCID'], $passenger['PersonOrgID'], $segment['LFID']);
                $segments[] = $seg;
            }
        }

        $data = [];
        $data['ActionType'] =  'GetSummary';
        $data['ReservationInfo'] =  [
            "SeriesNumber" => "299",
            "ConfirmationNumber" => ""
        ];
        $data['CarrierCodes'] =  [[
            "AccessibleCarrierCode" => "FZ"
        ]];

        $data['ClientIPAddress'] =  "";
        $data['SecurityToken'] = '';
        $data['SecurityGUID'] = '';
        $data['HistoricUserName'] = env('FLY_DUBAI_USERNAME');
        $data['CarrierCurrency'] = 'AED';
        $data['DisplayCurrency'] = 'AED';
        $data['IATANum'] = env('FLY_DUBAI_IATA');
        $data['User'] = env('FLY_DUBAI_USERNAME');
        $data['ReceiptLanguageID'] = "-1";
        $data['Address'] = [
            "Address1" => "",
            "Address2" => "",
            "City" => "",
            "State" => "",
            "Postal" => "",
            "Country" => "",
            "CountryCode" => "",
            "AreaCode" => "",
            "PhoneNumber" => "",
            "Display" => ""
        ];
        $data['ContactInfos'] = [];
        $data['Passengers'] = $passengers;
        $data['Segments'] =  $segments;
        $data['Payments'] = [];

        // dd(json_encode($data));

        $logger =  Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/se/' . $request->search_id . '/submit_req.json'),
        ]);
        $logger->info(json_encode($data));


        $submit_response = $this->flightBookingService->callAPI('cp/summaryPNR?accural=true', $data);

        $logger =  Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/se/' . $request->search_id . '/submit_res.json'),
        ]);
        $logger->info(json_encode($submit_response));

        if ($submit_response && isset($submit_response['Exceptions']) && $submit_response['Exceptions'][0]['ExceptionCode'] == 0) {
            $commit_data = [
                "ActionType" => "CommitSummary",
                "ReservationInfo" => [
                    "SeriesNumber" => "299",
                    "ConfirmationNumber" => null
                ],
                "SecurityGUID" => "",
                "CarrierCodes" => [[
                    "AccessibleCarrierCode" => "FZ"
                ]],
                "ClientIPAddress" => "",
                "HistoricUserName" => env('FLY_DUBAI_USERNAME')
            ];

            $logger =  Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/se/' . $request->search_id . '/commit_req.json'),
            ]);
            $logger->info(json_encode($commit_data));

            $commit_response = $this->flightBookingService->callAPI('cp/commitPNR?accrual=true', $commit_data);

            $logger =  Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/se/' . $request->search_id . '/commit_res.json'),
            ]);
            $logger->info(json_encode($commit_response));

            if ($commit_response && isset($commit_response['Exceptions']) && $commit_response['Exceptions'][0]['ExceptionCode'] == 0) {

                // Payment
                $this->makePayment($request->search_id, $commit_response);

                $search_details =  getOrginDestinationSession($search_result['search_type']);

                $flight_booking = FlightBookings::create([
                    'api_provider' => 'flydubai',
                    'user_id' => Auth::user()->id,
                    'fare_type' => "0",
                    'client_ref' => $commit_response['ConfirmationNumber'],
                    'unique_booking_id' => $commit_response['ConfirmationNumber'],
                    'direction' =>  $search_result['search_type'],
                    'origin' => $search_details['origin'],
                    'destination' =>  $search_details['destination'],
                    'adult_count' =>  $search_details['adult'],
                    'child_count' =>  $search_details['child'],
                    'infant_count' =>  $search_details['infant'],
                    'booking_status' =>  "Booked",
                    'ticket_status' =>  "Ticketed",
                    'cancel_request' =>  0,
                    'is_cancelled' => 0,
                    'currency' =>  getActiveCurrency(),
                    'customer_name' =>  $request->adult_first_name[0] . ' '  . $request->adult_last_name[0],
                    'customer_email' =>  $request->email,
                    'phone_code' =>  $request->mobile_code,
                    'customer_phone' =>  $request->mobile_no,
                ]);

                $this->savePassengerDetails($request, $flight_booking->id);

                dd([
                    'ok',
                    $commit_response
                ]);

                generateApiToken();
            } else {
                // dd([
                //     'commit error',
                //     $commit_response
                // ]);
                return $this->redirectFail();
            }
        } else {
            // dd([
            //     'Submit error',
            //     $submit_response
            // ]);
            return $this->redirectFail();
        }
    }

    public function redirectFail()
    {
        return redirect()->route('flight.booking.fail');
    }

    public function savePassengerDetails(Request $request, $flight_booking_id)
    {
        foreach ($request->adult_title as $key => $adult) {
            FlightPassengers::create([
                'booking_id' => $flight_booking_id,
                'passenger_type' => "ADT",
                'passenger_first_name' => $request->adult_first_name[$key],
                'passenger_last_name' => $request->adult_last_name[$key],
                'passenger_title' => $request->adult_title[$key],
                'gender' => $request->adult_gender[$key],
                'date_of_birth' => $request->adult_dob[$key],
                'passenger_nationality' => $request->adult_nationality[$key],
                'passport_number' => $request->adult_passport[$key],
                'passport_issue_country' => $request->adult_passport_country[$key],
                'passport_issue_date' => $request->adult_passport_issue[$key],
                'passport_expiry_date' => $request->adult_passport_expiry[$key],
            ]);
        }

        if (isset($request->child_title)) {
            foreach ($request->child_title as $key => $child) {
                FlightPassengers::create([
                    'booking_id' => $flight_booking_id,
                    'passenger_type' => "ADT",
                    'passenger_first_name' => $request->child_first_name[$key],
                    'passenger_last_name' => $request->child_last_name[$key],
                    'passenger_title' => $request->child_title[$key],
                    'gender' => $request->child_gender[$key],
                    'date_of_birth' => $request->child_dob[$key],
                    'passenger_nationality' => $request->child_nationality[$key],
                    'passport_number' => $request->child_passport[$key],
                    'passport_issue_country' => $request->child_passport_country[$key],
                    'passport_issue_date' => $request->child_passport_issue[$key],
                    'passport_expiry_date' => $request->child_passport_expiry[$key],
                ]);
            }
        }
        if (isset($request->infant_title)) {
            foreach ($request->infant_title as $key => $infant) {
                FlightPassengers::create([
                    'booking_id' => $flight_booking_id,
                    'passenger_type' => "ADT",
                    'passenger_first_name' => $request->infant_first_name[$key],
                    'passenger_last_name' => $request->infant_last_name[$key],
                    'passenger_title' => $request->infant_title[$key],
                    'gender' => $request->infant_gender[$key],
                    'date_of_birth' => $request->infant_dob[$key],
                    'passenger_nationality' => $request->infant_nationality[$key],
                    'passport_number' => $request->infant_passport[$key],
                    'passport_issue_country' => $request->infant_passport_country[$key],
                    'passport_issue_date' => $request->infant_passport_issue[$key],
                    'passport_expiry_date' => $request->infant_passport_expiry[$key],
                ]);
            }
        }
    }

    public function loadSeatHTML(Request $request)
    {

        $seat_request = Cache::get('fd_seat_req_' . $request->search_id);
        $res_data = Cache::get('fd_seat_res_data_' . $request->search_id);

        if (Cache::has('fd_search_seat_' . $request->search_id)) {
            Cache::forget('fd_search_seat_' . $request->search_id);
        }

        $seat_response = $this->flightBookingService->callAPI('pricing/seats', $seat_request);

        Cache::set('fd_search_seat_' . $request->search_id, $seat_response);

        $logger =  Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/se/' . $request->search_id . '/seat_req.json'),
        ]);
        $logger->info(json_encode($seat_response));


        // return response()->json(array('success' => true, 'seat_response' => $seat_response, 'res_data' => $res_data));

        $returnHTML = view('web.provides.flydubai.seats_html', compact('seat_response', 'res_data'))->render();

        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function makePayment($search_id, $commit_response)
    {
        $date = Carbon::now()->format('Y-d-m\TH:i:s');

        $data = [
            "CheckPNRStatus" => false,
            "ApplyDiscounts" => true,
            "TransactionInfo" => [
                "SecurityGUID" => "",
                "CarrierCodes" => [
                    [
                        "AccessibleCarrierCode" => "FZ"
                    ]
                ],
                "ClientIPAddress" => request()->ip(),
                "HistoricUserName" => env('FLY_DUBAI_USERNAME')
            ],
            "ReservationInfo" => [
                "SeriesNumber" => "299",
                "ConfirmationNumber" => $commit_response['ConfirmationNumber']
            ],
            "PNRPayments" => [
                [
                    "AccountNumber" => "",
                    "AccountPin" => "",
                    "CardHolder" => "",
                    "CurrencyPaid" => "AED",
                    "CVCode" => "",
                    "DatePaid" => $date,
                    "ExpirationDate" => $date,
                    "ExchangeRate" => 0,
                    "ExchangeRateDate" => $date,
                    "OriginalAmount" => $commit_response['ReservationBalance'],
                    "PaymentAmount" => $commit_response['ReservationBalance'],
                    "BalanceAmount" => 0,
                    "PaymentMethod" => "INVC",
                    "UserID" => env('FLY_DUBAI_USERNAME'),
                    "IataNumber" => env('FLY_DUBAI_IATA'),
                    "ReservationCurrency" => "AED",
                    "ReservationAmount" => $commit_response['ReservationBalance'],
                    "TransactionStatus" => "NOTYETPROCESSED",
                    "BaseAmount" => $commit_response['ReservationBalance'],
                    "PaymentComment" => "",
                    "AuthorizationCode" => "",
                    "PaymentReference" => "",
                    "CardCurrency" => "",
                    "MerchantID" => "",
                    "ProcessorID" => "",
                    "ProcessorName" => "",
                    "FingerPrintingSessionID" => "",
                    "GcxID" => "1",
                    "GcxOptOption" => "1",
                    "TerminalID" => 0,
                    "ResponseMessage" => "",
                    "Payor" => new stdClass()
                ]
            ]
        ];

        $logger =  Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/se/' . $search_id . '/payment_req.json'),
        ]);
        $logger->info(json_encode($data));

        $payment_response = $this->flightBookingService->callAPI('order/payment/processFOP', $data);

        $logger =  Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/se/' . $search_id . '/payment_res.json'),
        ]);
        $logger->info(json_encode($payment_response));

        if ($payment_response && isset($payment_response['Exceptions']) && $payment_response['Exceptions'][0]['ExceptionCode'] == 0) {
            return true;
        }

        return false;
    }

    public function cancelPNR(Request $request)
    {
        generateApiToken();
        $booking = FlightBookings::find($request->bookid);
        $action = "cancelBooking";
        if ($booking->created_at > Carbon::parse('-24 hours') && $booking->created_at < Carbon::now()) {
            $action = "voidBooking";
        }

        $data = [
            "channel" => "OTA",
            "subChannel" => "",
            "securityGUID" => "",
            "pointOfSale" => "AE",
            "currency" => "AED",
            "carrier" => "FZ",
            "PNR" => $request->id,
            "modifyDetails" => [
                "action" =>  $action
            ]
        ];

        $logger =  Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/se/cancell_res.json'),
        ]);
        $logger->info(json_encode($data));

        $response = $this->flightBookingService->callAPI('order/cancelPNR', $data);

        $logger =  Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/se/cancell_res.json'),
        ]);
        $logger->info($response);

        return true;
    }
}
