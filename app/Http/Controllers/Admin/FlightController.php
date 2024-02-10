<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Airports;
use App\Models\Airlines;
use App;

class FlightController extends Controller
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

    public function search(){
        
        $response = Http::withOptions($this->options)->post('https://travelnext.works/api/aeroVE5/availability', [
                                "user_id"=> env('API_USER_ID'),
                                "user_password"=> env('API_USER_PASSWORD'),
                                "access"=> env('API_ACCESS'),
                                "ip_address"=> env('API_IP_ADDRESS'),
                                "requiredCurrency"=> env('API_REQUIRED_CURRENCY'),
                                "journeyType"=> "OneWay",
                                "OriginDestinationInfo"=>
                                [
                                    [
                                        "departureDate"=> "2023-07-14",
                                        "airportOriginCode"=> "DXB",
                                        "airportDestinationCode"=> "TRV"
                                    ]
                                ],
                                "class"=> "Economy",
                                // "airlineCode"=> "QR",
                                "adults"=> 1,
                                "childs"=> 0,
                                "infants"=> 0
                            ]);
        
        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);
        echo '<pre>';
        print_r($result);
        die;
    }

    public function storeAirport(){
        ini_set('max_execution_time', 400);
        $response = Http::withOptions($this->options)->post(env('API_BASE_URL').'airport_list', [
                        "user_id"=> env('API_USER_ID'),
                        "user_password"=> env('API_USER_PASSWORD'),
                        "access"=> env('API_ACCESS'),
                        "ip_address"=> env('API_IP_ADDRESS')
                    ]);
        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);
        foreach($result as $res){
            $user = Airports::updateOrCreate(['AirportCode' => $res['AirportCode']],$res);
        }
        echo 'Airports saved successfully';
    }

    public function storeAirlines(){
        ini_set('max_execution_time', 400);
        $response = Http::withOptions($this->options)->post(env('API_BASE_URL').'airline_list', [
                        "user_id"=> env('API_USER_ID'),
                        "user_password"=> env('API_USER_PASSWORD'),
                        "access"=> env('API_ACCESS'),
                        "ip_address"=> env('API_IP_ADDRESS')
                    ]);
        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);
        foreach($result as $res){
            $user = Airlines::updateOrCreate(['AirLineCode' => $res['AirLineCode']],$res);
        }
        echo 'Airlines saved successfully';
    }

    public function updateAirlineImages(){
        ini_set('max_execution_time', 400);
        $result = Airlines::where('id','>',7)->get();
        foreach($result as $res){
            $filename = $res['AirLineCode'].'.gif';
            $img = $_SERVER['DOCUMENT_ROOT'].'/assets/images/airlines/'.$filename;
            $imglink = '/assets/images/airlines/'.$filename;
            file_put_contents($img, file_get_contents($res['AirLineLogo']));
            
            $user = Airlines::where('id',$res['id'])->update(['AirLineLogo' => $imglink]);
        }
        echo 'Airlines saved successfully';
    }
   
}
