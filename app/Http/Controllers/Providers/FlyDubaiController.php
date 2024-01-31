<?php

namespace App\Http\Controllers\Providers;

use App\Http\Controllers\Controller;
use App\Models\Airports;
use App\Models\Countries;
use App\Models\FlightBookings;
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

        // $logger =  Log::build([
        //     'driver' => 'single',
        //     'path' => storage_path('logs/se/' . $search_id . '/fare_req.json'),
        // ]);
        // $logger->debug(json_encode($data));


        $resultData = $this->flightBookingService->callAPI('pricing/flightswithfares', $data);

        // dd( $resultData);

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

            // $logger =  Log::build([
            //     'driver' => 'single',
            //     'path' => storage_path('logs/se/' . $search_id . '/fare_res.json'),
            // ]);
            // $logger->debug(json_encode($resultData));

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

            // $logger =  Log::build([
            //     'driver' => 'single',
            //     'path' => storage_path('logs/se/' . $request->search_id . '/cart_req.json'),
            // ]);
            // $logger->info(json_encode($data));

            $resultData = $this->flightBookingService->callAPI('order/cart', $data);

            // $logger =  Log::build([
            //     'driver' => 'single',
            //     'path' => storage_path('logs/se/' . $request->search_id . '/cart_res.json'),
            // ]);
            // $logger->info(json_encode($resultData));

            if ($resultData['Exceptions'][0]['ExceptionCode'] == 0) {
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
                $bookingCodes['paxID'][] = (string)$pax['ID'];
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

        // In Bound
        $inBoundFlight = $flights[$request->rtn_LFID];
        $inBoundFares = $inBoundFlight['fares'];

        $outBoundFare = $inBoundFare = [];

        foreach ($outBoundFares  as $fares) {
            if (
                $fares['FareTypeID'] == $request->dep_FareTypeID &&
                $fares['SolnId'] == $request->dep_solnid
            ) {
                $outBoundFare = $fares;
            }
        }

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
        foreach ($outBoundFare['FareInfos']['FareInfo'][0]['Pax'] as $pax) {
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
            $bookingCodes[] = array(
                "fareClass" => $pax['FCCode'],
                "cabin" => $pax['Cabin'],
                "paxID" => [
                    (string)$pax['ID']
                ]

            );
        }
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
                "arrDate" => $leg['ArrivalDate'],
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

        $segmentDetails = [];
        $paxFareInfos = [];
        // In bound array
        foreach ($inBoundFare['FareInfos']['FareInfo'][0]['Pax'] as $pax) {
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
            $bookingCodes[] = array(
                "fareClass" => $pax['FCCode'],
                "cabin" => $pax['Cabin'],
                "paxID" => [
                    (string)$pax['ID']
                ]

            );
        }
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
                "arrDate" => $leg['ArrivalDate'],
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
                        'paxFareInfos' => $paxFareInfos
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

                if (Cache::has('fd_search_ancillary_' . $request->search_id)) {
                    Cache::forget('fd_search_ancillary_' . $request->search_id);
                }
                if (Cache::has('fd_search_seat_' . $request->search_id)) {
                    Cache::forget('fd_search_seat_' . $request->search_id);
                }

                $logger =  Log::build([
                    'driver' => 'single',
                    'path' => storage_path('logs/se/' . $request->search_id . '/anc_req.json'),
                ]);
                $logger->info(json_encode($acc_response));

                $logger =  Log::build([
                    'driver' => 'single',
                    'path' => storage_path('logs/se/' . $request->search_id . '/sear_req.json'),
                ]);
                $logger->info(json_encode($seat_response));


                Cache::set('fd_search_ancillary_' . $request->search_id, $acc_response);
                Cache::set('fd_search_seat_' . $request->search_id, $seat_response);

                $res_data = array_merge($res_data, array(
                    'search_type' => $search_result['search_type'],
                    'search_result' => $search_result,
                    'search_params' => $search_params,
                    'countries' => Countries::all()
                ));

                // dd($seat_response);

                return view('web.provides.flydubai.ancillary', compact('acc_response', 'seat_response', 'res_data'));
            }

            return redirect()->back()->with([
                'ancillary_status' => "data empty"
            ]);
        } catch (Exception $e) {
            dd($e);
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
                $PTCID = 5;
                break;
            case 'infant':
                $PTCID = 6;
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
                "PersonOrgID" => -1,
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
                "PersonOrgID" => -1,
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

    public function submitPnr(Request $request)
    {
        $passCount = -1;
        $passengers = [];
        $segments = [];
        // dd($request);

        $search_result = Cache::get('fd_search_result_' . $request->search_id, null);

        // dd($search_result );

        foreach ($request->adult_title as $key => $adult) {
            $segments[] = [
                'PersonOrgID' => $passCount,
                'FareInformationID' => 1,
                // 'FareInformationID' => (int)abs($passCount),
                'SpecialServices' => $this->generateSpecialServices($request, (int)abs($passCount), 'ADT'),
                'Seats' => [],
            ];
            $passengers[] = $this->createPassengerArray($passCount--, $request, $key, 'adult');
        }

        if (isset($request->child_title)) {
            foreach ($request->child_title as $key => $child) {
                $segments[] = [
                    'PersonOrgID' => $passCount,
                    'FareInformationID' =>  (int)abs($passCount),
                    'SpecialServices' => $this->generateSpecialServices($request, (int)abs($passCount), 'CHD'),
                    'Seats' => [],
                ];
                $passengers[] = $this->createPassengerArray($passCount--, $request, $key, 'child');
            }
        }
        if (isset($request->infant_title)) {
            foreach ($request->infant_title as $key => $infant) {
                $segments[] = [
                    'PersonOrgID' => $passCount,
                    'FareInformationID' =>  (int)abs($passCount),
                    'SpecialServices' => [],
                    'Seats' => [],
                ];
                $passengers[] = $this->createPassengerArray($passCount--, $request, $key, 'infant');
            }
        }
        // dd($segments);

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

        dd(json_encode($data));

        $submit_response = $this->flightBookingService->callAPI('cp/summaryPNR?accural=true', $data);

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

            $commit_response = $this->flightBookingService->callAPI('cp/commitPNR?accrual=true', $commit_data);

            if ($commit_response && isset($commit_response['Exceptions']) && $commit_response['Exceptions'][0]['ExceptionCode'] == 0) {
                // dd([
                //     'ok',
                //     $commit_response
                // ]);

                $search_details =  getOrginDestinationSession($search_result->search_type);

                FlightBookings::create([
                    'unique_booking_id' => $commit_response['ConfirmationNumber'],
                    'direction' =>  $search_result->search_type,
                    'origin' => $search_details['origin'],
                    'destination' =>  $search_details['destination'],
                    'adult_count' =>  $search_details['adult'],
                    'child_count' =>  $search_details['child'],
                    'infant_count' =>  $search_details['infant'],
                    'booking_status' =>  "Booked",
                    'ticket_status' =>  "Ticketed",
                    'cancel_request' =>  0,
                    'currency' =>  getActiveCurrency(),
                    'customer_name' =>  $request->adult_first_name[0] . ' '  . $request->adult_last_name[0],
                    'customer_email' =>  $request->email,
                    'phone_code' =>  $request->mobile_code,
                    'customer_phone' =>  $request->mobile_no,
                ]);

                generateApiToken();
            } else {
                dd([
                    'commit error',
                    $commit_response
                ]);
                return $this->redirectFail();
            }
        } else {
            dd([
                'aa',
                $submit_response
            ]);
            return $this->redirectFail();
        }
    }

    public function redirectFail()
    {
        return redirect()->route('flight.booking.fail');
    }
    // public function submitPnr(Request $request)
    // {
    //     $passCount = -1;
    //     $passengers = [];
    //     foreach ($request->adult_title as $key => $adult) {
    //         $pass = [];

    //         $age = Carbon::parse($request->adult_dob[$key])->age;

    //         $pass['PersonOrgID'] = $passCount;
    //         $pass['FirstName'] = $request->adult_first_name[$key];
    //         $pass['LastName'] = $request->adult_last_name[$key];
    //         $pass['MiddleName'] = '';
    //         $pass['Age'] = $age;
    //         $pass['DOB'] = $request->adult_dob[$key];
    //         $pass['Gender'] = $request->adult_gender[$key];
    //         $pass['Title'] = $request->adult_title[$key];
    //         $pass['NationalityLaguageID'] = 1;
    //         $pass['RelationType'] = 'Self';
    //         $pass['WBCID'] = 1;
    //         $pass['PTCID'] = 1;
    //         $pass['TravelsWithPersonOrgID'] = -1;
    //         $pass['MarketingOptIn'] = true;
    //         $pass['UseInventory'] = false;
    //         $pass['UseInventory'] = false;
    //         $pass['Address'] = [
    //             "Address1" => "",
    //             "Address2" => "",
    //             "City" => "",
    //             "State" => "",
    //             "Postal" => "",
    //             "Country" => "",
    //             "CountryCode" => "",
    //             "AreaCode" => "",
    //             "PhoneNumber" => "",
    //             "Display" => ""
    //         ];
    //         $pass['Nationality'] = $request->adult_nationality[$key];
    //         $pass['ProfileId'] = -2147483648;
    //         $pass['IsPrimaryPassenger'] = $key == 0;
    //         $pass['ContactInfos'] = [
    //             [
    //                 "Key" => null,
    //                 "ContactID" => 0,
    //                 "PersonOrgID" => -1,
    //                 "ContactField" => $request->mobile_no,
    //                 "ContactType" => 1,
    //                 "Extension" => "",
    //                 "CountryCode" => $request->mobile_code,
    //                 "PhoneNumber" => $request->mobile_no,
    //                 "Display" => "",
    //                 "PreferredContactMethod" => false,
    //                 "ValidatedContact" => false
    //             ],
    //             [
    //                 "Key" => null,
    //                 "ContactID" => 0,
    //                 "PersonOrgID" => -1,
    //                 "ContactField" => $request->email,
    //                 "ContactType" => 4,
    //                 "Extension" => "",
    //                 "CountryCode" => "",
    //                 "PhoneNumber" => "",
    //                 "Display" => "",
    //                 "PreferredContactMethod" => true,
    //                 "ValidatedContact" => false
    //             ]
    //         ];
    //         $pass['DocumentInfos'] = [
    //             [
    //                 "DocType" => "1",
    //                 "DocNumber" => $request->adult_passport[$key],
    //                 "IssuingCountry" => $request->adult_passport_country[$key],
    //                 "IssueDate" => Carbon::parse($request->adult_passport_issue[$key])->format('Y-m-d\T00:00:00'),
    //                 "ExpiryDate" => Carbon::parse($request->adult_passport_expiry[$key])->format('Y-m-d\T00:00:00'),
    //             ]
    //         ];

    //         $passCount--;
    //         $passengers[] = $pass;
    //     }

    //     foreach ($request->child_title as $key => $adult) {
    //         $pass = [];

    //         $age = Carbon::parse($request->child_dob[$key])->age;

    //         $pass['PersonOrgID'] = $passCount;
    //         $pass['FirstName'] = $request->child_first_name[$key];
    //         $pass['LastName'] = $request->child_last_name[$key];
    //         $pass['MiddleName'] = '';
    //         $pass['Age'] = $age;
    //         $pass['DOB'] = $request->child_dob[$key];
    //         $pass['Gender'] = $request->child_gender[$key];
    //         $pass['Title'] = $request->child_title[$key];
    //         $pass['NationalityLaguageID'] = 1;
    //         $pass['RelationType'] = 'Self';
    //         $pass['WBCID'] = 1;
    //         $pass['PTCID'] = 6;
    //         $pass['TravelsWithPersonOrgID'] = -1;
    //         $pass['MarketingOptIn'] = true;
    //         $pass['UseInventory'] = false;
    //         $pass['UseInventory'] = false;
    //         $pass['Address'] = [
    //             "Address1" => "",
    //             "Address2" => "",
    //             "City" => "",
    //             "State" => "",
    //             "Postal" => "",
    //             "Country" => "",
    //             "CountryCode" => "",
    //             "AreaCode" => "",
    //             "PhoneNumber" => "",
    //             "Display" => ""
    //         ];
    //         $pass['Nationality'] = $request->child_nationality[$key];
    //         $pass['ProfileId'] = -2147483648;
    //         $pass['IsPrimaryPassenger'] = $key == 0;
    //         $pass['ContactInfos'] = [
    //             [
    //                 "Key" => null,
    //                 "ContactID" => 0,
    //                 "PersonOrgID" => -1,
    //                 "ContactField" => $request->mobile_no,
    //                 "ContactType" => 1,
    //                 "Extension" => "",
    //                 "CountryCode" => $request->mobile_code,
    //                 "PhoneNumber" => $request->mobile_no,
    //                 "Display" => "",
    //                 "PreferredContactMethod" => false,
    //                 "ValidatedContact" => false
    //             ],
    //             [
    //                 "Key" => null,
    //                 "ContactID" => 0,
    //                 "PersonOrgID" => -1,
    //                 "ContactField" => $request->email,
    //                 "ContactType" => 4,
    //                 "Extension" => "",
    //                 "CountryCode" => "",
    //                 "PhoneNumber" => "",
    //                 "Display" => "",
    //                 "PreferredContactMethod" => true,
    //                 "ValidatedContact" => false
    //             ]
    //         ];
    //         $pass['DocumentInfos'] = [
    //             [
    //                 "DocType" => "1",
    //                 "DocNumber" => $request->child_passport[$key],
    //                 "IssuingCountry" => $request->child_passport_country[$key],
    //                 "IssueDate" => Carbon::parse($request->child_passport_issue[$key])->format('Y-m-d\T00:00:00'),
    //                 "ExpiryDate" =>  Carbon::parse($request->child_passport_expiry[$key])->format('Y-m-d\T00:00:00'),
    //             ]
    //         ];

    //         $passCount--;
    //         $passengers[] = $pass;
    //     }
    //     foreach ($request->child_title as $key => $adult) {
    //         $pass = [];

    //         $age = Carbon::parse($request->infant_dob[$key])->age;

    //         $pass['PersonOrgID'] = $passCount;
    //         $pass['FirstName'] = $request->infant_first_name[$key];
    //         $pass['LastName'] = $request->infant_last_name[$key];
    //         $pass['MiddleName'] = '';
    //         $pass['Age'] = $age;
    //         $pass['DOB'] = $request->infant_dob[$key];
    //         $pass['Gender'] = $request->infant_gender[$key];
    //         $pass['Title'] = $request->infant_title[$key];
    //         $pass['NationalityLaguageID'] = 1;
    //         $pass['RelationType'] = 'Self';
    //         $pass['WBCID'] = 1;
    //         $pass['PTCID'] = 5;
    //         $pass['TravelsWithPersonOrgID'] = -1;
    //         $pass['MarketingOptIn'] = true;
    //         $pass['UseInventory'] = false;
    //         $pass['UseInventory'] = false;
    //         $pass['Address'] = [
    //             "Address1" => "",
    //             "Address2" => "",
    //             "City" => "",
    //             "State" => "",
    //             "Postal" => "",
    //             "Country" => "",
    //             "CountryCode" => "",
    //             "AreaCode" => "",
    //             "PhoneNumber" => "",
    //             "Display" => ""
    //         ];
    //         $pass['Nationality'] = $request->infant_nationality[$key];
    //         $pass['ProfileId'] = -2147483648;
    //         $pass['IsPrimaryPassenger'] = $key == 0;
    //         $pass['ContactInfos'] = [
    //             [
    //                 "Key" => null,
    //                 "ContactID" => 0,
    //                 "PersonOrgID" => -1,
    //                 "ContactField" => $request->mobile_no,
    //                 "ContactType" => 1,
    //                 "Extension" => "",
    //                 "CountryCode" => $request->mobile_code,
    //                 "PhoneNumber" => $request->mobile_no,
    //                 "Display" => "",
    //                 "PreferredContactMethod" => false,
    //                 "ValidatedContact" => false
    //             ],
    //             [
    //                 "Key" => null,
    //                 "ContactID" => 0,
    //                 "PersonOrgID" => -1,
    //                 "ContactField" => $request->email,
    //                 "ContactType" => 4,
    //                 "Extension" => "",
    //                 "CountryCode" => "",
    //                 "PhoneNumber" => "",
    //                 "Display" => "",
    //                 "PreferredContactMethod" => true,
    //                 "ValidatedContact" => false
    //             ]
    //         ];
    //         $pass['DocumentInfos'] = [
    //             [
    //                 "DocType" => "1",
    //                 "DocNumber" => $request->infant_passport[$key],
    //                 "IssuingCountry" => $request->infant_passport_country[$key],
    //                 "IssueDate" =>  Carbon::parse($request->infant_passport_issue[$key])->format('Y-m-d\T00:00:00'),
    //                 "ExpiryDate" => Carbon::parse($request->infant_passport_expiry[$key])->format('Y-m-d\T00:00:00'),
    //             ]
    //         ];


    //         $passCount--;
    //         $passengers[] = $pass;
    //     }



    //     // $passengers = [
    //     //     [
    //     //         "PersonOrgID" => -1,
    //     //         "FirstName" => "TEST FIRSTNAME",
    //     //         "LastName" => "TEST",
    //     //         "MiddleName" => "",
    //     //         "Age" => 25,
    //     //         "DOB" => "1994-01-01T00:00:00",
    //     //         "Gender" => "Male",
    //     //         "Title" => "Mr",
    //     //         "NationalityLaguageID" => 1,
    //     //         "RelationType" => "Self",
    //     //         "WBCID" => 1,
    //     //         "PTCID" => 1,
    //     //         "TravelsWithPersonOrgID" => -1,
    //     //         "MarketingOptIn" => true,
    //     //         "UseInventory" => false,
    //     //         "Address" => [
    //     //             "Address1" => "asdad",
    //     //             "Address2" => "asdasd",
    //     //             "City" => "asdasd",
    //     //             "State" => "asdasd",
    //     //             "Postal" => 12123233,
    //     //             "Country" => "",
    //     //             "CountryCode" => "",
    //     //             "AreaCode" => "",
    //     //             "PhoneNumber" => "",
    //     //             "Display" => ""
    //     //         ],
    //     //         "Nationality" => "AE",
    //     //         "ProfileId" => -2147483648,
    //     //         "IsPrimaryPassenger" => true,
    //     //         "ContactInfos" => [
    //     //             [
    //     //                 "Key" => null,
    //     //                 "ContactID" => 0,
    //     //                 "PersonOrgID" => -1,
    //     //                 "ContactField" => "8882223741",
    //     //                 "ContactType" => 2,
    //     //                 "Extension" => "",
    //     //                 "CountryCode" => "91",
    //     //                 "PhoneNumber" => "8882223741",
    //     //                 "Display" => "",
    //     //                 "PreferredContactMethod" => false,
    //     //                 "ValidatedContact" => false
    //     //             ],
    //     //             [
    //     //                 "Key" => null,
    //     //                 "ContactID" => 0,
    //     //                 "PersonOrgID" => -1,
    //     //                 "ContactField" => "8882223741",
    //     //                 "ContactType" => 0,
    //     //                 "Extension" => "",
    //     //                 "CountryCode" => "011",
    //     //                 "PhoneNumber" => "8882223741",
    //     //                 "Display" => "",
    //     //                 "PreferredContactMethod" => false,
    //     //                 "ValidatedContact" => false
    //     //             ],
    //     //             [
    //     //                 "Key" => null,
    //     //                 "ContactID" => 0,
    //     //                 "PersonOrgID" => -1,
    //     //                 "ContactField" => "asasdds@asdasd.com",
    //     //                 "ContactType" => 4,
    //     //                 "Extension" => "",
    //     //                 "CountryCode" => "91",
    //     //                 "PhoneNumber" => "123456789",
    //     //                 "Display" => "",
    //     //                 "PreferredContactMethod" => true,
    //     //                 "ValidatedContact" => false
    //     //             ]
    //     //         ],
    //     //         "DocumentInfos" => [
    //     //             [
    //     //                 "DocType" => "1",
    //     //                 "DocNumber" => "J4868UT",
    //     //                 "IssuingCountry" => "AE",
    //     //                 "IssueDate" => "1980-01-01T00:00:00",
    //     //                 "ExpiryDate" => "2025-01-01T00:00:00"
    //     //             ]
    //     //         ]
    //     //     ]
    //     // ];

    //     $data = [];
    //     $data['ActionType'] =  'GetSummary';
    //     $data['ReservationInfo'] =  [
    //         "SeriesNumber" => "299",
    //         "ConfirmationNumber" => ""
    //     ];
    //     $data['CarrierCodes'] =  [[
    //         "AccessibleCarrierCode" => "FZ"
    //     ]];

    //     $data['ClientIPAddress'] =  "";
    //     $data['SecurityToken'] = '';
    //     $data['SecurityGUID'] = '';
    //     $data['HistoricUserName'] = env('FLY_DUBAI_USERNAME');
    //     $data['CarrierCurrency'] = 'AED';
    //     $data['DisplayCurrency'] = 'AED';
    //     $data['IATANum'] = env('FLY_DUBAI_IATA');
    //     $data['User'] = env('FLY_DUBAI_USERNAME');
    //     $data['ReceiptLanguageID'] = "-1";
    //     $data['Address'] = [
    //         "Address1" => "",
    //         "Address2" => "",
    //         "City" => "",
    //         "State" => "",
    //         "Postal" => "",
    //         "Country" => "",
    //         "CountryCode" => "",
    //         "AreaCode" => "",
    //         "PhoneNumber" => "",
    //         "Display" => ""
    //     ];
    //     $data['ContactInfos'] = [];
    //     $data['Passengers'] = $passengers;
    //     $data['Segments'] = [
    //         [
    //             "PersonOrgID" => -1,
    //             "FareInformationID" => 1,
    //             "SpecialServices" => [],
    //             "Seats" => []
    //         ]
    //     ];
    //     $data['Payments'] = [];

    //     dd($data);

    //     $submit_response = $this->flightBookingService->callAPI('cp/summaryPNR?accural=true', $data);

    //     // 

    //     // try {
    //     //     $search_result = Cache::get('fd_search_result_' . $request->search_id, null);
    //     //     $acc_result = Cache::get('fd_search_ancillary_' . $request->search_id, null);

    //     //     $search_params = getOrginDestinationSession('OneWay');

    //     //     if ($search_result == null || $acc_result == null) {
    //     //         dd("fail");
    //     //     }

    //     //     $flights = array_combine(array_column($search_result['flights'], 'LFID'), $search_result['flights']);

    //     //     if ($search_result['search_type'] == 'OneWay') {

    //     //         $search_params = getOrginDestinationSession('OneWay');
    //     //         dd($search_params);
    //     //         if (empty($search_params)) {
    //     //             dd("fail");
    //     //         }
    //     //     }
    //     // } catch (Exception $e) {
    //     //     dd("fail");
    //     // }
    // }
}
