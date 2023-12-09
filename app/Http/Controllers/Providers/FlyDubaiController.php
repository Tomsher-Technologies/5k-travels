<?php

namespace App\Http\Controllers\Providers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class FlyDubaiController extends Controller
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


    public function getToken()
    {
        $data = [
            "client_id" => env('FLY_DUBAI_CLIENT_ID_TEST'),
            "client_secret" => env('FLY_DUBAI_CLIENT_SECRET_TEST'),
            "grant_type" => 'password',
            "password" => env('FLY_DUBAI_PASSWORD_TEST'),
            "scope" => 'res',
            "username" =>  env('FLY_DUBAI_USERNAME_TEST'),
        ];

        $response = Http::timeout(300)->withOptions($this->options)->asForm()->post(env('FLY_DUBAI_API_URL_TEST') . 'authenticate', $data);
        $result = $response->getBody()->getContents();
        return json_decode($result);
    }

    public function search(Request $request)
    {
        $apiToken = getToken();

        $date = Carbon::parse($request->oDate);

        dd($request->all());

        $adult = $child = $infant = 0;

        $retrieveFareQuote = [];
        $retrieveFareQuote['CarrierCodes']['CarrierCode'][]['AccessibleCarrierCode'] = "FZ";
        $retrieveFareQuote['SecutiryGUID'] = "";
        $retrieveFareQuote['ChannelID'] = "OTA";
        $retrieveFareQuote['CountryCode'] = "AE";
        $retrieveFareQuote['ClientIPAddress'] = $request->ip();
        $retrieveFareQuote['HistoricUserName'] = env('FLY_DUBAI_USERNAME_TEST');
        $retrieveFareQuote['CurrencyOfFareQuote'] = "AED";
        $retrieveFareQuote['IataNumberOfRequestor'] = env('FLY_DUBAI_IATA_TEST');
        $retrieveFareQuote['FullInBoundDate'] =  $date->copy()->format('d/m/Y');
        $retrieveFareQuote['FullOutBoundDate'] =  $date->copy()->format('d/m/Y');
        $retrieveFareQuote['CorporationID'] = -2147483648;
        $retrieveFareQuote['FareFilterMethod'] = "NoCombinabilityRoundtripLowestFarePerFareType";
        $retrieveFareQuote['FareGroupMethod'] = "WebFareTypes";
        $retrieveFareQuote['InventoryFilterMethod'] = "Available";

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
                'FareQuoteRequestInfo' => [array(
                    'PassengerTypeID' => 1,
                    'TotalSeatsRequired' => 1
                )]
            ],
        ];


        $data['RetrieveFareQuoteDateRange']['RetrieveFareQuoteDateRangeRequest'] = $retrieveFareQuote;

        // dd($details);

        $response = Http::timeout(300)->withOptions($this->options)->withHeaders([
            'Accept-Encoding' => 'gzip, deflate',
            'Authorization' => 'bearer ' . $apiToken
        ])->post(env('FLY_DUBAI_API_URL_TEST') . 'pricing/flightswithfares', $data);
        $result = $response->getBody()->getContents();

        $resultData = json_decode($result);
        dd($resultData);
    }
}
