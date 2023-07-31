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
                                "user_id"=> config('global.api_user_id'),
                                "user_password"=> config('global.api_user_password'),
                                "access"=> config('global.api_access'),
                                "ip_address"=> config('global.api_ip_address'),
                                "requiredCurrency"=> config('global.api_requiredCurrency'),
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
        $response = Http::withOptions($this->options)->post(config('global.api_base_url').'airport_list', [
                        "user_id"=> config('global.api_user_id'),
                        "user_password"=> config('global.api_user_password'),
                        "access"=> config('global.api_access'),
                        "ip_address"=> config('global.api_ip_address')
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
        $response = Http::withOptions($this->options)->post(config('global.api_base_url').'airline_list', [
                        "user_id"=> config('global.api_user_id'),
                        "user_password"=> config('global.api_user_password'),
                        "access"=> config('global.api_access'),
                        "ip_address"=> config('global.api_ip_address')
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
