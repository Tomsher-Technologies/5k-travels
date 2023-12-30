<?php

use Carbon\Carbon;
use App\Models\UserDetails;
use App\Models\GeneralSettings;
use App\Models\FlightBookings;
use App\Models\Airlines;
use App\Models\Airports;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

/**
 * Write code on Method
 *
 * @return response()
 */
if (!function_exists('convertYmdToMdy')) {
    function convertYmdToMdy($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('m-d-Y');
    }
}

/**
 * Write code on Method
 *
 * @return response()
 */
if (!function_exists('convertMdyToYmd')) {
    function convertMdyToYmd($date)
    {
        return Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d');
    }
}

if (!function_exists('generateUniqueCode')) {
    function generateUniqueCode($type)
    {
        $characters = '0123456789';
        $charactersNumber = strlen($characters);
        $codeLength = 4;
        $code = '';
        while (strlen($code) < $codeLength) {
            $position = rand(0, $charactersNumber - 1);
            $character = $characters[$position];
            $code = $code . $character;
        }
        if ($type == "agent") {
            $code = "AG" . $code;
        } else if ($type == "sub_agent") {
            $code = "SAG" . $code;
        } else if ($type == "admin") {
            $code = "AD" . $code;
        } else {
            $code = "US" . $code;
        }
        if (UserDetails::where('code', $code)->exists()) {
            $this->generateUniqueCode();
        }
        return $code;
    }
}

if (!function_exists('getGeneralSettings')) {
    function getGeneralSettings()
    {
        $result = array();
        $settings = GeneralSettings::get();
        if ($settings) {
            foreach ($settings as $value) {
                $result[$value['type']] = array('value' => $value['value'], 'content' => $value['content']);
            }
        }
        return $result;
    }
}

if (!function_exists('getTimeDiffInMInutes')) {
    function getTimeDiffInMInutes($datetime_1, $datetime_2)
    {
        $start_datetime = new DateTime($datetime_1);
        $diff = $start_datetime->diff(new DateTime($datetime_2));

        $total_minutes = ($diff->days * 24 * 60);
        $total_minutes += ($diff->h * 60);
        $total_minutes += $diff->i;
        return $total_minutes;
    }
}

if (!function_exists('convertToHoursMins')) {
    function convertToHoursMins($time)
    {
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return $hours . ' hrs ' . $minutes . ' min';
    }
}

if (!function_exists('convertMinsToHours')) {
    function convertMinsToHours($minutes)
    {
        $hours = floor($minutes / 60);
        $min = $minutes - ($hours * 60);
        return $hours . ' hrs ' . $min . ' min';
    }
}
if (!function_exists('getAirlines')) {
    function getAirlines()
    {
        $airlines = Airlines::get()->keyBy('AirLineCode')->toArray();
        return $airlines;
    }
}

if (!function_exists('getAgentMarginData')) {
    function getAgentMarginData($userId)
    {
        $parents = User::with(['user_details'])->where('id', $userId)->first();
        // $parents->user_details();
        $allParents = $parents->getAllParents();
        // print_r($parents); die;
        $adminMargin = $parents->user_details->admin_margin;
        $agentMargin = $parents->user_details->agent_margin;
        $data['admin_margin'] = ($adminMargin != '') ? $adminMargin : 0;
        $data['agent_margin'] = ($agentMargin != '') ? $agentMargin : 0;
        // print_r($allParents); 
        $margins = 0;
        foreach ($allParents  as $prts) {
            $data['main_agents'][$prts->user_id] = $prts->agent_margin;
            $margins = $margins + $prts->agent_margin;
        }
        $data['totalmargin'] = $data['admin_margin'] + $data['agent_margin'] + $margins;
        return $data;
    }
}


if (!function_exists('getUserMarginData')) {
    function getUserMarginData()
    {
        $margin = GeneralSettings::where('type', 'admin_margin_users')->first();
        $data['admin_margin'] = $margin->value;
        $data['totalmargin'] = $margin->value;
        return $data;
    }
}

if (!function_exists('getAgentWalletBalance')) {
    function getAgentWalletBalance($userId)
    {
        $balance = User::with(['user_details'])->where('id', $userId)->first();
        return $balance->user_details->credit_balance;
    }
}

if (!function_exists('getUserDetails')) {
    function getUserDetails($userId)
    {
        $details = User::select('users.*', 'ud.*')
            ->leftJoin('user_details as ud', 'ud.user_id', '=', 'users.id')
            ->where('users.id', $userId)
            ->get();
        return $details;
    }
}

if (!function_exists('getAirlineData')) {
    function getAirlineData($code)
    {
        $details = Airlines::select('*')->where('AirLineCode', $code)
            ->get()->toArray();
        if (isset($details[0])) {
            $details = $details;
        } else {
            $details[] = array(
                "id" => "",
                "AirLineCode" => $code,
                "AirLineName" => $code,
                "AirLineLogo" => ''
            );
        }
        // echo '<pre>';
        // print_r($details);die;
        return $details;
    }
}

if (!function_exists('getAirportData')) {
    function getAirportData($code)
    {
        $airports = Cache::remember('airportdata', now()->addDay(), function () {
            return Airports::all();
        });

        $airport = $airports->where('AirportCode', $code)->first();

        return $airport ?  $airport->toArray()  : array(
            "id" => '',
            "AirportCode" => $code,
            "AirportName" => $code,
            "City" => "",
            "Country" => "",
            "CountryCode" => '',
        );

        return $airport->toArray();

        // $airports = Cache::remember('airportdata', now()->addDay(), function () {
        //     return  Airports::select('*')->get()->toArray();
        // });

        // // $details = Airports::select('*')->where('AirportCode', $code)->get()->toArray();
        // if (isset($airports[$code])) {
        //     return $airports[$code];
        // } else {
        //     return array(
        //         "id" => "",
        //         "AirportCode" => $code,
        //         "AirportName" => $code,
        //         "City" => '',
        //         "Country" => '',
        //         "CountryCode" => ''
        //     );
        // }
        // echo '<pre>';
        // print_r($details);die;
        // return $details;
    }
}

if (!function_exists('getCurrencyValue')) {
    function getCurrencyValue($currency)
    {
        $oneCurrency = 1;
        if (env('APP_ENV') != 'local') {
            $oneCurrency = Currency::convert()
                ->from($currency)
                ->to('USD')
                ->amount(1)
                ->get();
        }
        return number_format(($oneCurrency), 6, '.', '');
    }
}

function getActiveCurrency()
{
    return Session::get('user_currency', 'USD');
}

if (!function_exists('getNewReissuedBooking')) {
    function getNewReissuedBooking($id)
    {
        $details = FlightBookings::select('id')->where('parent_id', $id)
            ->pluck('id')->toArray();
        // echo '<pre>';
        // print_r($details);die;
        return $details;
    }
}

if (!function_exists('getBookingDataByUniqueId')) {
    function getBookingDataByUniqueId($uniqueid)
    {
        $details = FlightBookings::select('*')->where('unique_booking_id', $uniqueid)
            ->get();

        return $details;
    }
}

function generateApiToken()
{
    $data = [
        "client_id" => env('FLY_DUBAI_CLIENT_ID'),
        "client_secret" => env('FLY_DUBAI_CLIENT_SECRET'),
        "grant_type" => 'password',
        "password" => env('FLY_DUBAI_PASSWORD'),
        "scope" => 'res',
        "username" =>  env('FLY_DUBAI_USERNAME'),
    ];

    $response = Http::timeout(300)->withOptions(['verify' => false])->asForm()->post(env('FLY_DUBAI_API_URL') . 'authenticate', $data);
    $result = $response->getBody()->getContents();
    $res = json_decode($result);

    $nowTime = strtotime(date("Y-m-d H:i:s"));
    $expiryTime = date("Y-m-d H:i:s", strtotime('+2399 seconds', $nowTime));
    session(['api_token' => $res->access_token]);
    session(['api_token_expiry' => $expiryTime]);
    session()->save();

    return $res->access_token;
}

function getToken()
{
    if (session()->has('api_token') && session()->has('api_token_expiry')) {
        if (session('api_token_expiry') > date("Y-m-d H:i:s")) {
            return session('api_token');
        } else {
            return generateApiToken();
        }
    } else {
        return generateApiToken();
    }
}


function createFDPassengerArray(Request $request)
{
    $adult = $child = $infant = 0;

    $passengers = [];

    if ($request->search_type == 'OneWay') {
        $adult = $request->oAdult;
        $child = $request->oChild;
        $infant = $request->oInfant;
    } else if ($request->search_type == 'Return') {
        $adult = $request->rAdult;
        $child = $request->rChild;
        $infant = $request->rInfant;
    } else {
        $adult = $request->mAdult;
        $child = $request->mChild;
        $infant = $request->mInfant;
    }

    if ($adult > 0) {
        $passengers[] = array(
            'PassengerTypeID' => 1,
            'TotalSeatsRequired' => (int)$adult
        );
    }
    if ($child > 0) {
        $passengers[] = array(
            'PassengerTypeID' => 6,
            'TotalSeatsRequired' => (int)$child
        );
    }
    if ($infant > 0) {
        $passengers[] = array(
            'PassengerTypeID' => 5,
            'TotalSeatsRequired' => (int)$infant
        );
    }

    return $passengers;
}

function getFDLowestFare($FareInfos)
{
    $lowest = PHP_INT_MAX;

    if ($FareInfos) {
        foreach ($FareInfos as $FareInfo) {
            foreach ($FareInfo as $fareInfo) {
                foreach ($fareInfo['Pax'] as $pax) {
                    $lowest = min($lowest, $pax['FareAmtInclTax']);
                }
            }
        }
    }
    return $lowest;
}

function getFDPenalities($FareInfos)
{
    $pax = null;
    $changeFees = null;
    $cancellationFees = null;
    if (isset($FareInfos['FareInfo'][0]['Pax'][0])) {
        $pax = $FareInfos['FareInfo'][0]['Pax'][0];
    }

    if ($pax) {
        if (isset($pax['Penalties']['ChangeFees']['ChangeFee'])) {
            $changefees = $pax['Penalties']['ChangeFees']['ChangeFee'];

            if ($changefees) {
                foreach ($changefees as $changeFee) {
                    $string = '';
                    switch ($changeFee['Type']) {
                        case 'BEFOREDEPARTURE':
                            $string .= '<b>Before Departure: </b>';
                            break;
                        case 'NOSHOW':
                            $string .= '<b>No-Show: </b>';
                            break;
                        case 'UPTO':
                            if ($changeFee['ToTime'] > 24) {
                                $days = $changeFee['ToTime']  / 24;
                                $string .= '<b>More than ' .  $days  .  ' days before departure: </b>';
                            } else {
                                $string .= '<b>More than ' . $changeFee['ToTime'] .  ' hours before departure: </b>';
                            }
                            break;
                        case 'WITHIN':
                            if ($changeFee['FromTime'] > 24) {
                                $days = $changeFee['FromTime']  / 24;
                                $string .= '<b>Less than ' .  $days  .  ' days before departure: </b>';
                            } else {
                                $string .= '<b>Less than ' . $changeFee['FromTime'] .  ' hours before departure: </b>';
                            }
                            break;
                        case 'NOSHOWUPTO':
                            if ($changeFee['ToTime'] > 24) {
                                $days = $changeFee['ToTime']  / 24;
                                $string .= '<b>No-Show upto ' .  $days  .  ' days after departure: </b>';
                            } else {
                                $string .= '<b>No-Show upto ' . $changeFee['ToTime'] .  ' hours after departure: </b>';
                            }
                            break;
                        case 'NOSHOWAFTER':
                            if ($changeFee['FromTime'] > 24) {
                                $days = $changeFee['FromTime']  / 24;
                                $string .= '<b>No-Show more than ' .  $days  .  ' days after departure: </b>';
                            } else {
                                $string .= '<b>No-Show more than ' . $changeFee['FromTime'] .  ' hours after departure: </b>';
                            }
                            break;
                    }

                    if ($changeFee['PenaltyType'] == 'P') {
                        $string .= $changeFee['Percentage'] . '% penality';
                    } else {
                        $string .= $changeFee['Currency'] . $changeFee['Amount'] . ' penality';
                    }
                    $changeFees[] = $string;
                }
            }
        }
        if (isset($pax['Penalties']['CancellationFees']['RefundPenalty'])) {
            $cancellationfees = $pax['Penalties']['CancellationFees']['RefundPenalty'];

            if ($cancellationfees) {
                foreach ($cancellationfees as $cancellationfee) {
                    $string = '';
                    switch ($cancellationfee['Type']) {
                        case 'BEFOREDEPARTURE':
                            $string .= '<b>Before Departure: </b>';
                            break;
                        case 'NOSHOW':
                            $string .= '<b>No-Show: </b>';
                            break;
                        case 'UPTO':
                            if ($cancellationfee['ToTime'] > 24) {
                                $days = $cancellationfee['ToTime']  / 24;
                                $string .= '<b>More than ' .  $days  .  ' days before departure: </b>';
                            } else {
                                $string .= '<b>More than ' . $cancellationfee['ToTime'] .  ' hours before departure: </b>';
                            }
                            break;
                        case 'WITHIN':
                            if ($cancellationfee['FromTime'] > 24) {
                                $days = $cancellationfee['FromTime']  / 24;
                                $string .= '<b>Less than ' .  $days  .  ' days before departure: </b>';
                            } else {
                                $string .= '<b>Less than ' . $cancellationfee['FromTime'] .  ' hours before departure: </b>';
                            }
                            break;
                        case 'NOSHOWUPTO':
                            if ($cancellationfee['ToTime'] > 24) {
                                $days = $cancellationfee['ToTime']  / 24;
                                $string .= '<b>No-Show upto ' .  $days  .  ' days after departure: </b>';
                            } else {
                                $string .= '<b>No-Show upto ' . $cancellationfee['ToTime'] .  ' hours after departure: </b>';
                            }
                            break;
                        case 'NOSHOWAFTER':
                            if ($cancellationfee['FromTime'] > 24) {
                                $days = $cancellationfee['FromTime']  / 24;
                                $string .= '<b>No-Show more than ' .  $days  .  ' days after departure: </b>';
                            } else {
                                $string .= '<b>No-Show more than ' . $cancellationfee['FromTime'] .  ' hours after departure: </b>';
                            }
                            break;
                    }

                    if ($cancellationfee['PenaltyType'] == 'P') {
                        $string .= $cancellationfee['Percentage'] . '% penality ';
                    } else {
                        $string .= $cancellationfee['Currency'] . $cancellationfee['Amount'] . ' penality';
                    }
                    $cancellationFees[] = $string;
                }
            }
        }
    }

    return [
        'changeFees' => $changeFees,
        'cancellationFees' => $cancellationFees
    ];
}

// function getFDFare(&$FareTypes, $serviceDetails)
// {
//     if ($FareTypes) {
//         foreach ($FareTypes as &$FareType) {
//             $service_details = null;
//             if (count($FareType['ApplicableServices']['ServiceIDs'])) {
//                 foreach ($FareType['ApplicableServices']['ServiceIDs'] as $service) {
//                     $service_details[] = $serviceDetails[$service['ID']];
//                 }
//             }
//             $FareType = array_merge($FareType, array('service' => $service_details));
//         }
//     }

//     return $FareTypes;
// }

function getFDCombinedData(&$FareTypes, $serviceDetails)
{
    $lowest = PHP_INT_MAX;
    $refund = $no_refund = 0;

    if ($FareTypes) {
        foreach ($FareTypes as &$FareType) {
            $service_details = null;

            if (count($FareType['ApplicableServices']['ServiceIDs'])) {
                foreach ($FareType['ApplicableServices']['ServiceIDs'] as $service) {
                    $service_details[] = $serviceDetails[$service['ID']];
                }
            }

            $FareType = array_merge($FareType, array('service' => $service_details));

            if ($FareType['Refundable'] == 0) {
                $no_refund++;
            } else {
                $refund++;
            }

            foreach ($FareType['FareInfos']['FareInfo'] as $fareInfo) {
                foreach ($fareInfo['Pax'] as $pax) {
                    $lowest = min($lowest, $pax['FareAmtInclTax']);
                }
            }
        }
    }

    // Optionally, you can return additional information, such as the lowest fare.
    return array(
        'FareTypes' => $FareTypes,
        'lowestFare' => $lowest,
        'refund' => $refund,
        'no_refund' => $no_refund,
    );
}


function getFDAirLines($flights)
{
    $airlines = [];
    foreach ($flights as $flight) {
        if (isset($airlines[$flight['airline']])) {
            $airlines[$flight['airline']] =   $airlines[$flight['airline']] + 1;
        } else {
            $airlines[$flight['airline']] = 1;
        }
    }
    return $airlines;
}

function getFDFlightNum($airline, $flightNum)
{
    $flightNums = explode('/', $flightNum);
    foreach ($flightNums as $key => $fn) {
        $flightNums[$key] = $airline . ' ' . str_pad($fn, 4, 0, STR_PAD_LEFT);
    }

    return implode(' / ', $flightNums);
}

function getFDStops($fdata, $legDetails)
{
    $stops = array();

    foreach ($fdata['flightLegs'] as $legs) {
        $leg = $legDetails[$legs['PFID']];
        $stops[] = $leg['Origin'];
        $stops[] = $leg['Destination'];
    }

    $stops = array_unique($stops);

    $stops = array_diff($stops, array($fdata['origin'], $fdata['destination']));

    $stopsName = array();

    foreach ($stops as $stop) {
        $stopsName[$stop] = getAirportData($stop)['AirportName'];
    }

    return implode(', ', $stopsName);
}

function convertCurrency($amount, $fromCurrency)
{
    $activeCurreny = getActiveCurrency();

    if ($activeCurreny == $fromCurrency) {
        return $amount;
    }

    $apiToken = getToken();

    $options = [];

    if (App::environment('local')) {
        $options = ['verify' => false];
    }

    $response = Http::timeout(300)->withOptions($options)->withHeaders([
        'Accept-Encoding' => 'gzip, deflate',
        'Authorization' => 'Bearer ' . $apiToken
    ])->get(env('FLY_DUBAI_API_URL') . 'order/payment/currencies/xrates', [
        'from' => $fromCurrency,
        'to' => $activeCurreny,
        'amt' => 1
    ]);

    $result = $response->getBody()->getContents();
    $result = json_decode($result, TRUE);

    if ($result && isset($result['xRate'])) {
        return priceFormat($amount * $result['xRate']);
    } else {
        return 0;
    }
}

function priceFormat($amount, $decimals = 2, $sepperator = '.')
{
    return number_format($amount, $decimals, $sepperator);
}



function getOrginDestination($search)
{
    if (!is_array($search)) {
        $search = $search->all();
    }

    switch ($search['search_type']) {
        case 'OneWay':
            return [
                'origin' => $search['oFrom'],
                'destination' => $search['oTo'],
                'date' => $search['oDate'],
                'adult' => $search['oAdult'],
                'child' => $search['oChild'],
                'infant' => $search['oInfant'],
                'class' => $search['oClass'],
            ];
            break;
        case 'Return':
            return [
                $search['rFrom'],
                $search['rTo'],
            ];
            break;
        case 'Circle':
            return [
                $search['cFrom'],
                $search['cTo'],
            ];
            break;
    }
}

function getCombinability($combinability): array
{
    $newArray = [];
    foreach ($combinability as $item) {
        $key = $item['SolnRef'][0];
        if (isset($newArray[$key])) {
            // $newArray[$key] = array_map(function ($a, $b) {
            //     return $a + $b;
            // }, $newArray[$key], $item['SolnRef']);
            $newArray[$key][] = $item['SolnRef'][1];
        } else {
            $newArray[$key] = array();
            $newArray[$key][] = $item['SolnRef'][1];
        }
    }

    return $newArray;
}
