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

class FlightsApiController extends Controller
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

    public function getToken(){
        $data = [
            "client_id"=> env('FLY_DUBAI_CLIENT_ID_TEST'),
            "client_secret"=> env('FLY_DUBAI_CLIENT_SECRET_TEST'),
            "grant_type"=> 'password',
            "password"=> env('FLY_DUBAI_PASSWORD_TEST'),
            "scope"=> 'res',
            "username" =>  env('FLY_DUBAI_USERNAME_TEST'),
        ];
       
        $response = Http::timeout(300)->withOptions($this->options)->asForm()->post(env('FLY_DUBAI_API_URL_TEST').'authenticate', $data);
        $result = $response->getBody()->getContents();
        return json_decode($result);
    }

    public function searchFlights(Request $request){
        $apiToken = getToken();

        $retrieveFareQuote = [];
        $retrieveFareQuote['CarrierCodes']['CarrierCode'][]['AccessibleCarrierCode'] = "FZ";
        $retrieveFareQuote['SecutiryGUID'] = "";
        $retrieveFareQuote['ChannelID'] = "OTA";
        $retrieveFareQuote['CountryCode'] = "AE";
        $retrieveFareQuote['ClientIPAddress'] = "01.102.103.104";
        $retrieveFareQuote['HistoricUserName'] = env('FLY_DUBAI_USERNAME_TEST');
        $retrieveFareQuote['CurrencyOfFareQuote'] = "AED";
        $retrieveFareQuote['IataNumberOfRequestor'] = env('FLY_DUBAI_IATA_TEST');
        $retrieveFareQuote['FullInBoundDate'] = "25/12/2023";
        $retrieveFareQuote['FullOutBoundDate'] = "25/12/2023";
        $retrieveFareQuote['CorporationID'] = -2147483648;
        $retrieveFareQuote['FareFilterMethod'] = "NoCombinabilityRoundtripLowestFarePerFareType";
        $retrieveFareQuote['FareGroupMethod'] = "WebFareTypes";
        $retrieveFareQuote['InventoryFilterMethod'] = "Available";

        $retrieveFareQuote['FareQuoteDetails']['FareQuoteDetailDateRange'][] = [
            'Origin' => "DXB",
            'Destination' => "MCT" ,
            'UseAirportsNotMetroGroups' => true,
            'UseAirportsNotMetroGroupsAsRule' => true,
            'UseAirportsNotMetroGroupsForFrom' => true,
            'UseAirportsNotMetroGroupsForTo' => true,
            'DateOfDepartureStart' => "2023-12-25T00:00:00",
            'DateOfDepartureEnd' => "2023-12-25T23:59:59",
            'FareQuoteRequestInfos' => [
                'FareQuoteRequestInfo' => [array(
                    'PassengerTypeID' => 1,
                    'TotalSeatsRequired' => 1
                )]
            ],
        ];


        $data['RetrieveFareQuoteDateRange']['RetrieveFareQuoteDateRangeRequest'] = $retrieveFareQuote;
        $details = json_encode($data);
        // echo '<pre>';
        // print_r($data);
        // echo $details;
        // echo json_encode($request->all());
        // die;

        $response = Http::timeout(300)->withOptions($this->options)->withHeaders([
            'Accept-Encoding' => 'gzip, deflate',
            'Authorization' => 'bearer '.$apiToken
        ])->post(env('FLY_DUBAI_API_URL_TEST').'pricing/flightswithfares', $data);
        $result = $response->getBody()->getContents();

        $resultData = json_decode($result);
        // dd($result);
    }

   
}






