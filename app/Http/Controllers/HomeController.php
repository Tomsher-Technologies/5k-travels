<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Airports;
use App\Models\Airlines;
use App\Models\FlightBookings;
use App;

class HomeController extends Controller
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
        $airports = $this->allAirports();
        return  view('web.index',compact('airports'));
    }

    public function dashboard(){
        $bookings = FlightBookings::where('user_id',5)->orderBy('id','desc')->paginate(10);
        return  view('web.user.dashboard',compact('bookings'));
    }

    public function bookingDetails(){
        $bookings = [];
        return  view('web.user.booking_details',compact('bookings'));
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

    public function searchAirports(Request $request){
        $airports = [];
            
        if($request->has('term')){
            $search = $request->term;
            $query = Airports::select('id', 'AirportCode', 'AirportName', 'City', 'Country');
            if($search){  
                $query->Where(function ($query) use ($search) {
                    $query->orWhere('AirportCode', 'LIKE', "%$search%")
                    ->orWhere('AirportName', 'LIKE', "$search%")
                    ->orWhere('City', 'LIKE', "$search%")
                    ->orWhere('Country', 'LIKE', "$search%");
                });                    
            }
            $airports = $query->orderBy('City','ASC')
                            ->get();
        }else{
            $airports = Airports::select('id', 'AirportCode', 'AirportName', 'City', 'Country')
                                    ->orderBy('City','ASC')
                                    ->get();
        }
        return response()->json($airports);
    }

    public function allAirports(){
        $airports = Airports::select('id', 'AirportCode', 'AirportName', 'City', 'Country')
                            ->orderBy('City','ASC')
                            ->get();
        return $airports;
    }

   
}
