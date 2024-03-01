<?php

namespace App\Http\Controllers\Providers\Yasin;

use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Models\FlightBookings;
use App\Models\FlightPassengers;
use App\Services\YasinService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\FlightMarginAmounts;
use App\Models\UserDetails;

class YasinBookingController extends Controller
{
    private $flightBookingService;

    public function __construct()
    {
        $this->flightBookingService = new YasinService();
    }

    public function search(Request $request, $search_id)
    {
        $flights = [];
        $one_stop = $two_stop = $three_stop = $non_stop = $three_plus_stop = $refund = $no_refund = 0;
        $airlines = [];
        // dd($request);

        $cabinClass = '';

        if ($request->search_type == 'OneWay') {
            $date = Carbon::parse($request->oDate);
            $startDate = $date->copy()->format("Y/m/d");

            $adultCount = $request->oAdult;
            $childCount = $request->oChild;
            $infantCount = $request->oInfant;

            $route = $request->oFrom . $request->oTo;

            $cabinClass = $request->oClass == 'Business' ? 'C' : 'Y';

            $result = $this->flightBookingService->get('Flight/GetFlightAvail', array(
                'Dates' => $startDate,
                'AdultCount' => $adultCount,
                'ChildCount' => $childCount,
                'InfantCount' => $infantCount,
                'Routes' => $route,
                'Username' => env('YASEIN_USERNAME'),
                'Password' => env('YASIN_PASSWORD'),
            ));

            // if ($result && $result['Error'] == '' && isset($result['Items']) && count($result['Items']) > 0) {
            //     if (Cache::has('yas_search_result_' . $search_id)) {
            //         Cache::delete('yas_search_result_' . $search_id);
            //     }

            //     foreach ($result['Items'] as $flight) {
            //         if ($flight['Avail']) {

            //             $flight['api_provider'] = "yasin";

            //             $route = str_split($flight['Route'], 3);

            //             $flight['origin'] = $route[0];
            //             $flight['destination'] = $route[1];

            //             $flight['rph'] = $flight['RPH'];
            //             $flight['rbd'] = $flight['RBD'];
            //             $flight['cabin'] = $flight['Cabin'];
            //             $flight['route'] = $flight['Route'];
            //             $flight['depature_date'] = $flight['FlightDate'] . ' ' . $flight['DepatureTime'];
            //             $flight['arrival_time'] = $flight['ArrivalDate'] . ' ' . $flight['ArrivalTime'];
            //             $flight['flight_duration'] = getYasinFlightTime($flight);
            //             $flight['stops'] = $flight['Stop'];
            //             $flight['airline'] = $flight['AirLine'];
            //             $flight['flight_no'] = $flight['FlightNo'];
            //             $flight['aircraft'] = $flight['Aircraft'];

            //             $flight['adult_fare'] = $flight['FlightFare'];
            //             $flight['child_fare'] = $flight['FlightChildFare'];
            //             $flight['infant_fare'] = $flight['FlightInfantFare'];

            //             $flight['total_price'] = 0;

            //             for ($i = 0; $i < $adultCount; $i++) {
            //                 $flight['total_price'] += $flight['adult_fare'];
            //             }
            //             for ($i = 0; $i < $childCount; $i++) {
            //                 $flight['total_price'] += $flight['child_fare'];
            //             }
            //             for ($i = 0; $i < $infantCount; $i++) {
            //                 $flight['total_price'] += $flight['infant_fare'];
            //             }

            //             // dd($flight['total_price']);

            //             switch ($flight['Stop']) {
            //                 case 0:
            //                     $non_stop++;
            //                     break;
            //                 case 1:
            //                     $one_stop++;
            //                     break;
            //                 case 2:
            //                     $two_stop++;
            //                     break;
            //                 case 3:
            //                     $three_stop++;
            //                     break;
            //                 default:
            //                     $three_plus_stop++;
            //                     break;
            //             }

            //             if ($flight['Refundable']) {
            //                 $refund++;
            //             } else {
            //                 $no_refund++;
            //             }

            //             $flights[] = $flight;
            //         }
            //     }

            //     $airlines = getYasinAirLines($flights);
            // }
        } else if ($request->search_type == 'Return') {
            $startDate = Carbon::parse($request->rDate)->format("Y/m/d");
            $endDate = Carbon::parse($request->rReturnDate)->format("Y/m/d");

            $adultCount = $request->rAdult;
            $childCount = $request->rChild;
            $infantCount = $request->rInfant;

            $startRoute = $request->rFrom . $request->rTo;
            $endRoute =  $request->rTo . $request->rFrom;

            $cabinClass = $request->rClass == 'Business' ? 'C' : 'Y';

            $dataArray = array(
                'Username' => env('YASEIN_USERNAME'),
                'Password' => env('YASIN_PASSWORD'),
                'AdultCount' => $adultCount,
                'ChildCount' => $childCount,
                'InfantCount' => $infantCount,
                'Routes' => $startRoute,
                'Dates' => $startDate,
            );

            $data = urldecode(http_build_query($dataArray));

            $data .= '&Routes=' . $endRoute . '&Dates=' . $endDate;

            $result = $this->flightBookingService->get('Flight/GetFlightAvail', $data);
        }

        // dd($result);

        if ($result && $result['Error'] == '' && isset($result['Items']) && count($result['Items']) > 0) {
            if (Cache::has('yas_search_result_' . $search_id)) {
                Cache::delete('yas_search_result_' . $search_id);
            }

            foreach ($result['Items'] as $flight) {
                if (
                    $flight['Avail'] &&
                    $cabinClass == $flight['Cabin']
                    // && (($request->search_type == 'OneWay' && ) ||
                    //     $request->search_type == 'Return')
                ) {
                    $flight['api_provider'] = "yasin";

                    $route = str_split($flight['Route'], 3);

                    $flight['origin'] = $route[0];
                    $flight['destination'] = $route[1];

                    $flight['rph'] = $flight['RPH'];
                    $flight['rbd'] = $flight['RBD'];
                    $flight['cabin'] = $flight['Cabin'];
                    $flight['route'] = $flight['Route'];
                    $flight['depature_date'] = $flight['FlightDate'] . ' ' . $flight['DepatureTime'];
                    $flight['arrival_time'] = $flight['ArrivalDate'] . ' ' . $flight['ArrivalTime'];
                    $flight['flight_duration'] = getYasinFlightTime($flight);
                    $flight['stops'] = $flight['Stop'];
                    $flight['airline'] = $flight['AirLine'];
                    $flight['flight_no'] = $flight['FlightNo'];
                    $flight['aircraft'] = $flight['Aircraft'];

                    $flight['adult_fare'] = $flight['FlightFare'];
                    $flight['child_fare'] = $flight['FlightChildFare'];
                    $flight['infant_fare'] = $flight['FlightInfantFare'];

                    $flight['total_price'] = 0;

                    for ($i = 0; $i < $adultCount; $i++) {
                        $flight['total_price'] += $flight['adult_fare'];
                    }
                    for ($i = 0; $i < $childCount; $i++) {
                        $flight['total_price'] += $flight['child_fare'];
                    }
                    for ($i = 0; $i < $infantCount; $i++) {
                        $flight['total_price'] += $flight['infant_fare'];
                    }

                    // dd($flight['total_price']);

                    switch ($flight['Stop']) {
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

                    if ($flight['Refundable']) {
                        $refund++;
                    } else {
                        $no_refund++;
                    }

                    $flights[] = $flight;
                }
            }

            $airlines = getYasinAirLines($flights);
        }

        // dd($flights);

        $result = [
            'currency' => "USD",
            'one_stop' => $one_stop,
            'two_stop' => $two_stop,
            'three_stop' => $three_stop,
            'non_stop' => $non_stop,
            'three_plus_stop' => $three_plus_stop,
            'refund' => $refund,
            'no_refund' => $no_refund,
            'airlines' => $airlines,
            'flights' => $flights,
        ];

        Cache::set('yas_search_result_' . $search_id, $result);

        return $result;
    }

    public function bookingPage(Request $request)
    {

        $search_type = Session::get('current_search_type', null);

        $res_data = [];

        if ('OneWay' == $search_type) {
            $search_result = Session::get('flight_search_oneway', null);
        } else if ('Return' == $search_type) {
            $search_result = Session::get('flight_search_return', null);
        }
        $search_params = getOrginDestinationSession($search_result['search_type']);

        $res_data['search_type'] = $search_result['search_type'];
        $res_data['search_params'] = $search_params;
        $res_data['search_result'] = $search_result;
        $res_data['flight_details'] = $request->all();
        $res_data['countries'] = Countries::all();

        // dd( $res_data['flight_details']);

        return view('web.provides.yasein.ancillary', compact('res_data'));
    }

    public function bookingConfirm(Request $request)
    {
        $search_type = Session::get('current_search_type', null);

        $mobile_number = str_replace(' ', '', $request->mobile_no);

        if ($request->mobile_code == '98') {
            $mobile_number = '0' . $mobile_number;
        } else {
            $mobile_number = '00' . $mobile_number;
        }

        if ($search_type == 'OneWay') {
            $data = array(
                'Airline' => $request->Airline,
                'FlightRoute' => $request->FlightRoute,
                'FlightDateTime' => $request->FlightDateTime,
                'FlightNo' => $request->FlightNo,
                'RBD' => $request->RBD,
                'RPH' => $request->RPH,
                'Email' => $request->email,
                'Mobile' =>  $mobile_number,
                'Username' => env('YASEIN_USERNAME'),
                'Password' => env('YASIN_PASSWORD'),
            );

            $query = urldecode(http_build_query($data));
        } else {
            $data = array(
                'Airline' => $request->dep_Airline,
                'FlightRoute' => $request->dep_FlightRoute,
                'FlightDateTime' => $request->dep_FlightDateTime,
                'FlightNo' => $request->dep_FlightNo,
                'RBD' => $request->dep_RBD,
                'RPH' => $request->dep_RPH,
            );
            $query = urldecode(http_build_query($data));

            $data = array(
                'Airline' => $request->rtn_Airline,
                'FlightRoute' => $request->rtn_FlightRoute,
                'FlightDateTime' => $request->rtn_FlightDateTime,
                'FlightNo' => $request->rtn_FlightNo,
                'RBD' => $request->rtn_RBD,
                'RPH' => $request->rtn_RPH,
            );
            $query .= '&' . urldecode(http_build_query($data));

            $data = array(
                'Email' => $request->email,
                'Mobile' =>  $mobile_number,
                'Username' => env('YASEIN_USERNAME'),
                'Password' => env('YASIN_PASSWORD'),
            );
            $query .= '&' . urldecode(http_build_query($data));
        }

        foreach ($request->adult_title as $key => $title) {
            $pax = [];
            $pax[] = $request->adult_first_name[$key] . '/' . $request->adult_last_name[$key];
            $pax[] = $request->adult_first_name[$key] . '/' . $request->adult_last_name[$key];
            $pax[] = $request->adult_title[$key];
            $pax[] = str_replace('-', '/', $request->adult_dob[$key]);
            $pax[] = 'Adult';
            $pax[] = 'P' . $request->adult_passport[$key];
            $pax[] = $request->adult_nationality[$key];
            $pax[] = str_replace('-', '/', $request->adult_passport_expiry[$key]);
            $query .= '&PAXinfo=' . implode(',', $pax);
        }

        if (isset($request->child_title)) {
            foreach ($request->child_title as $key => $title) {
                $pax = [];
                $pax[] = $request->child_first_name[$key] . '/' . $request->child_last_name[$key];
                $pax[] = $request->child_first_name[$key] . '/' . $request->child_last_name[$key];
                $pax[] = $request->child_title[$key];
                $pax[] = str_replace('-', '/', $request->child_dob[$key]);
                $pax[] = 'Child';
                $pax[] = 'P' . $request->child_passport[$key];
                $pax[] = $request->child_nationality[$key];
                $pax[] = str_replace('-', '/', $request->child_passport_expiry[$key]);
                $query .= '&PAXinfo=' . implode(',', $pax);
            }
        }
        if (isset($request->infant_title)) {
            foreach ($request->infant_title as $key => $title) {
                $pax = [];
                $pax[] = $request->infant_first_name[$key] . '/' . $request->infant_last_name[$key];
                $pax[] = $request->infant_first_name[$key] . '/' . $request->infant_last_name[$key];
                $pax[] = $request->infant_title[$key];
                $pax[] = str_replace('-', '/', $request->infant_dob[$key]);
                $pax[] = 'Infant';
                $pax[] = 'P' . $request->infant_passport[$key];
                $pax[] = $request->infant_nationality[$key];
                $pax[] = str_replace('-', '/', $request->infant_passport_expiry[$key]);
                $query .= '&PAXinfo=' . implode(',', $pax);
            }
        }

        $logger =  Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/yasin/' . $request->search_id . '/booking_request.json'),
        ]);
        $logger->info(json_encode($query));

        $result = $this->flightBookingService->get('Reserve/FlightCheck', $query);
        $logger =  Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/yasin/' . $request->search_id . '/booking_res.json'),
        ]);
        $logger->info($result);

        if (
            $result &&
            $result['Error'] == null &&
            isset($result['ResNumber'])
        ) {
            $search_params = getOrginDestinationSession($search_type);
            $flight_booking = FlightBookings::create([
                'api_provider' => 'yasin',
                'user_id' => Auth::user()->id,
                'fare_type' => "0",
                'client_ref' => $result['ResNumber'],
                'unique_booking_id' => $result['ResNumber'],
                'direction' =>  $search_type,
                'origin' => $search_params['origin'],
                'destination' =>  $search_params['destination'],
                'adult_count' =>  $search_params['adult'],
                'child_count' =>  $search_params['child'],
                'infant_count' =>  $search_params['infant'],
                'booking_status' =>  "Created",
                'ticket_status' =>  "Created",
                'cancel_request' =>  0,
                'is_cancelled' => 0,
                'payment_status' => config('app.payment_status.pending'),
                'currency' =>  getActiveCurrency(),
                'customer_name' =>  $request->adult_first_name[0] . ' '  . $request->adult_last_name[0],
                'customer_email' =>  $request->email,
                'phone_code' =>  $request->mobile_code,
                'customer_phone' =>  $request->mobile_no,
            ]);

            $this->savePrices($request, $flight_booking->id, $result);

            $this->savePassengerDetails($request, $flight_booking->id, $result['ResNumber']);

            if (Auth::user()->user_type == 'user') {
                $margin = getMargin();


                $totaFare = 0;

                $adultFare = $result['TotalFare'];
                $INTotalFare = $result['INTotalFare'];
                $CHTotalFare = $result['CHTotalFare'];

                foreach ($request->adult_title as $title) {
                    $totaFare += $adultFare;
                }
                if (isset($request->child_title)) {
                    foreach ($request->child_title as $title) {
                        $totaFare += $CHTotalFare;
                    }
                }
                if (isset($request->infant_title)) {
                    foreach ($request->infant_title as $title) {
                        $totaFare += $INTotalFare;
                    }
                }

                $paymentAmount = ($margin['totalmargin'] > 0) ? (($totaFare / 100) * $margin['totalmargin']) * 100 : $totaFare * 100;
                $paymentAmount = convertCurrency($paymentAmount, 'USD', 'AED', false);

                $paymentForm = [
                    'pnr' => $result['ResNumber'],
                    'search_id' => $request->search_id,
                    'amt' => $paymentAmount,
                    'amtReal' => $totaFare,
                ];

                $order = ngCreateOrder($paymentForm);

                if ($order) {
                    return redirect($order);
                } else {
                    return redirect()->route('flight.booking.fail', [
                        'status' => 'ngCreateOrder fail'
                    ]);
                }
            } else {
                $this->confirmFlight($result['ResNumber']);
            }
        } else {
            return redirect()->route('flight.booking.fail', [
                'status' => 'FlightCheck fail'
            ]);
        }
    }

    public function savePrices(Request $request, $flight_booking_id, $result)
    {
        $margins = getMargin();

        $adult_price = 0;
        $adult_tax = 0;
        $child_price = 0;
        $child_tax = 0;
        $infant_price = 0;
        $infant_tax = 0;

        foreach ($request->adult_title as $title) {
            $adult_price += $result['FareBase'];
            $adult_tax += ($result['TotalFare'] - $result['FareBase']);
        }
        if (isset($request->child_title)) {
            foreach ($request->child_title as $title) {
                $child_price += $result['CHFareBase'];
                $child_tax += ($result['CHTotalFare'] - $result['CHFareBase']);
            }
        }
        if (isset($request->infant_title)) {
            foreach ($request->infant_title as $title) {
                $infant_tax += $result['FareBase'];
                $infant_tax += ($result['INFareBase'] - $result['FareBase']);
            }
        }

        $total_amt = $adult_price +  $infant_price + $child_price;
        $total_tax = $adult_tax + $infant_tax + $child_tax;
        $grand_total = $total_amt + $total_tax;


        $adminMargin = $margins['admin_margin'];
        $adminMarginAmount = (($grand_total / 100) * $margins['admin_margin']);
        $adminMarginAmount = number_format(floor($adminMarginAmount * 100) / 100, 2, '.', '');

        $agentsMarginAmount = (($grand_total / 100) * ($margins['totalmargin'] - $margins['admin_margin']));
        $agentsMarginAmount = ($agentsMarginAmount != 0) ? number_format(floor($agentsMarginAmount * 100) / 100, 2, '.', '') : 0;

        $total_amount = convertCurrency($grand_total + $adminMarginAmount + $agentsMarginAmount, 'USD');


        FlightBookings::where('id', $flight_booking_id)
            ->update([
                'adult_amount' => convertCurrency((($adult_price / 100) * $margins['totalmargin']) + $adult_price, 'USD'),
                'child_amount' => convertCurrency((($child_price / 100) * $margins['totalmargin']) + $child_price, 'USD'),
                'infant_amount' => convertCurrency((($infant_price / 100) * $margins['totalmargin']) + $infant_price, 'USD'),
                'total_amount' => $total_amount,
                'total_tax' => convertCurrency((($total_tax / 100) * $margins['totalmargin']) + $total_tax, 'USD'),

                'total_amount_actual' => convertCurrency($total_amt, 'USD'),
                'total_tax_actual' => convertCurrency($total_tax, 'USD'),

                'admin_margin' => convertCurrency($adminMargin, 'USD'),
                'admin_amount' => number_format((convertCurrency($adminMarginAmount, 'USD')), 2, '.', ''),
                'agents_amount' => number_format((convertCurrency($agentsMarginAmount, 'USD')), 2, '.', ''),
            ]);

        $oneCurrency = convertRate('USD', "USD");

        if (isset($margins['agent_margin'])) {
            $currentAgentMargin = $margins['agent_margin'];
            $agentAmount = (($grand_total / 100) * $currentAgentMargin);
            $agentAmount = number_format(floor($agentAmount * 100) / 100, 2, '.', '');

            $deductUsd = convertCurrency($total_amount, 'USD', 'USD');

            $currentAgent = UserDetails::where('user_id', Auth::user()->id)->first();
            $currentCredit = $currentAgent->credit_balance;

            $currentCreditNew = $currentCredit - $deductUsd;
            $agentUSD = convertCurrency($agentAmount, 'USD', 'USD');
            $agentMargins[] = array(
                'booking_id' => $flight_booking_id,
                'agent_id'   => Auth::user()->id,
                'from_agent_id' => NULL,
                'margin'     => $currentAgentMargin,
                'amount'    => $total_amount,
                'total_amount' => $grand_total,
                'currency' => getActiveCurrency(),
                'usd_amount' => $deductUsd,
                'usd_rate' => $oneCurrency,
                'credit_balance' => $currentCreditNew,
                'transaction_type' => 'dr',
                'created_at' => date('Y-m-d H:i:s')
            );

            $agentMargins[] = array(
                'booking_id' => $flight_booking_id,
                'agent_id'   => Auth::user()->id,
                'from_agent_id' => NULL,
                'margin'     => $currentAgentMargin,
                'amount'    => $agentAmount,
                'total_amount' => $grand_total,
                'currency' => getActiveCurrency(),
                'usd_amount' => $agentUSD,
                'usd_rate' => $oneCurrency,
                'transaction_type' => 'cr',
                'credit_balance' => $currentCreditNew + $agentUSD,
                'created_at' => date('Y-m-d H:i:s')
            );
            $currentAgent->credit_balance = ($currentCreditNew + $agentUSD);
            $currentAgent->save();
        }
        if (isset($margins['main_agents'])) {
            foreach ($margins['main_agents'] as $agentid => $marg) {
                $agentAmount = (($grand_total / 100) * $marg);
                $agentAmount = number_format(floor($agentAmount * 100) / 100, 2, '.', '');

                $creditAmount = $agentAmount;
                $creditUsd = number_format(($creditAmount * $oneCurrency), 2, '.', '');
                $mainAgent = UserDetails::where('user_id', $agentid)->first();
                $currentCreditMain = $mainAgent->credit_balance;
                $mainAgent->credit_balance += $creditUsd;
                $mainAgent->save();

                $agentUSDMain = number_format(($agentAmount * $oneCurrency), 2, '.', '');
                $agentMargins[] = array(
                    'booking_id' => $flight_booking_id,
                    'agent_id'   =>  $agentid,
                    'from_agent_id' => Auth::user()->id,
                    'margin'     => $marg,
                    'amount'    => $agentAmount,
                    'total_amount' => $grand_total,
                    'currency' => getActiveCurrency(),
                    'usd_amount' => $agentUSDMain,
                    'usd_rate' => $oneCurrency,
                    'transaction_type' => 'cr',
                    'credit_balance' => $currentCreditMain + $agentUSDMain,
                    'created_at' => date('Y-m-d H:i:s')
                );
            }
        }


        if (!empty($agentMargins)) {
            FlightMarginAmounts::insert($agentMargins);
        }
    }

    public function savePassengerDetails(Request $request, $flight_booking_id, $pnr)
    {
        foreach ($request->adult_title as $key => $adult) {
            FlightPassengers::create([
                'booking_id' => $flight_booking_id,
                'passenger_type' => "ADT",
                'eticket_number' => $pnr,
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
                    'eticket_number' => $pnr,
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
                    'eticket_number' => $pnr,
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

    function confirmFlight($ResNumber)
    {
        $com_data = array(
            'ResNum' => $ResNumber,
            'Username' => env('YASEIN_USERNAME'),
            'Password' => env('YASIN_PASSWORD'),
        );
        $com_result = $this->flightBookingService->get('Reserve/AirlinesReserve', $com_data);

        $booking = FlightBookings::where('unique_booking_id', $ResNumber)->firstOrFail();

        if ($com_result && $com_result['Error'] == null) {
            $booking->unique_booking_id = $com_result['Reference'];
            $booking->booking_status =  "Booked";
            $booking->ticket_status =  "Ticketed";
            $booking->save();
            sendBookingMail($com_result['Reference']);
            return redirect()->route('flight.booking.success', [
                'pnr' => $com_result['Reference']
            ]);
        } else {
            $booking->booking_status =  "Failed";
            $booking->ticket_status =  "Failed";
            $booking->save();
            return redirect()->route('flight.booking.fail');
        }
    }
}
