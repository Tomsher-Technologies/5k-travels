<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use AmrShawky\LaravelCurrency\Facade\Currency;
use Illuminate\Support\Facades\Http;
use App\Models\Airports;
use App\Models\Airlines;
use App\Models\FlightBookings;
use App\Models\FlightItineraryDetails;
use App\Models\FlightExtraServices;
use App\Models\FlightPassengers;
use App\Models\FlightMarginAmounts;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\Countries;
use App;
use Auth;
use DB;
use Validator;
use Hash;
use Storage;
use Str;
use File;
use Mail;
use Config;
use Session;

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
        // $airports = $this->allAirports();
        return  view('web.index');
    }

    public function autocompleteAirports(Request $request)
    {
        $search = $request->term;
        $query = Airports::select("AirportCode","AirportName","Country","City");
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
        $response = array();
        foreach($airports as $air){
            $label ='<div class="row" ><div class="col-sm-12"><i class="fa fa-plane"></i> &nbsp;'.
                    '<b>'.$air->City.', '.$air->Country.'</b>'.
                    '<span class="float-end">'.$air->AirportCode.'</span>'.
                    '</div><div class="col-sm-12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>'.$air->AirportName.'</small></div></div>';
            $response[] = array("value"=>$air->AirportCode,"label"=>$label,"airport" => $air->AirportName);
        }
    
        return response()->json($response); 
    }

    public function changeCurrency($currency){
        Session::put('user_currency', $currency);
        if(Auth::check()){
            User::where('id',Auth::user()->id)->update(['currency'=>$currency]);
        }
        
        return back();
    }

    public function dashboard(){
        $type = "my_bookings";
        $bookings = FlightBookings::where('user_id',Auth::user()->id)->orderBy('id','desc')->paginate(10);
        return  view('web.user.dashboard',compact('bookings','type'));
    }

    public function cancelled(){
        $type = "cancelled";
        $bookings = FlightBookings::where('user_id',Auth::user()->id)->where('is_cancelled',1)->orderBy('id','desc')->paginate(10);
        return  view('web.user.cancelled',compact('bookings','type'));
    }

    public function creditUsage(){
        $type = "credit_usage";
       
        $usage = FlightMarginAmounts::select('flight_margin_amounts.*','u.name','fb.unique_booking_id')
                                    ->leftJoin('flight_bookings as fb','fb.id','flight_margin_amounts.booking_id')
                                    ->leftJoin('users as u','u.id','flight_margin_amounts.from_agent_id')
                                    ->where('flight_margin_amounts.agent_id',Auth::user()->id)
                                    ->orderBy('flight_margin_amounts.id','desc')
                                    ->paginate(10);

        return  view('web.user.credit_usage',compact('usage','type'));
    }

    public function rescheduled(){
        $type = "rescheduled";
        $bookings = FlightBookings::where('user_id',Auth::user()->id)->where('is_reissued',1)->orderBy('id','desc')->paginate(10);
        return  view('web.user.cancelled',compact('bookings','type'));
    }
    public function completed(){
        $type = "completed";
        // DB::enableQueryLog();
        $bookings = FlightBookings::select('flight_bookings.*')->where('user_id',Auth::user()->id)
                                    ->where('is_cancelled',0)
                                    ->where('is_reissued',0)
                                    // ->leftJoin('flight_itinerary_details as fid','fid.booking_id','flight_bookings.id')
                                    ->leftJoin('flight_itinerary_details as fid', function ($join) {
                                        $join->on('fid.booking_id', '=', 'flight_bookings.id')
                                        ->on('fid.id', '=', DB::raw("(select max(`id`) from flight_itinerary_details WHERE flight_itinerary_details.booking_id = flight_bookings.id)"));
                                    })
                                    ->where('fid.arrival_date_time','<',date('Y-m-d H:i:s'))
                                    ->orderBy('flight_bookings.id','desc')->paginate(10);

                                    // dd(DB::getQueryLog());
        return  view('web.user.cancelled',compact('bookings','type'));
    }

    public function upcoming(){
        $type = "upcoming";
        // DB::enableQueryLog();
        $bookings = FlightBookings::select('flight_bookings.*')->where('user_id',Auth::user()->id)
                                    ->where('is_cancelled',0)
                                    ->where('is_reissued',0)
                                    // ->leftJoin('flight_itinerary_details as fid','fid.booking_id','flight_bookings.id')
                                    ->leftJoin('flight_itinerary_details as fid', function ($join) {
                                        $join->on('fid.booking_id', '=', 'flight_bookings.id')
                                        ->on('fid.id', '=', DB::raw("(select max(`id`) from flight_itinerary_details WHERE flight_itinerary_details.booking_id = flight_bookings.id)"));
                                    })
                                    ->where('fid.arrival_date_time','>',date('Y-m-d H:i:s'))
                                    ->orderBy('flight_bookings.id','desc')->paginate(10);

                                    // dd(DB::getQueryLog());
        return  view('web.user.dashboard',compact('bookings','type'));
    }

    public function bookingDetails(Request $request){
        $bookings = FlightBookings::where('id',$request->id)->get();
        // echo '<pre>';
        // echo '================================' . $bookings[0]['ticket_status'];
        // print_r($bookings);
        // die;
        if(isset($bookings[0])){
            $itineraries = FlightItineraryDetails::where('booking_id',$request->id)->orderBy('id','ASC')->get();
            $passengers = FlightPassengers::where('booking_id',$request->id)->orderBy('id','ASC')->get();
           
            if($bookings[0]['ticket_status'] != "Ticketed"){
                $tripDetails = $this->getTripDetails($bookings[0]['unique_booking_id']);
                $tripDetails = json_decode($tripDetails, true);
                if(isset($tripDetails['TripDetailsResponse'])){
                    $TripDetailsResponse = $tripDetails['TripDetailsResponse'];
                    if(isset($TripDetailsResponse['TripDetailsResultInbound'])){
                        $tripDetailsResult = $TripDetailsResponse['TripDetailsResult'];
                        $tripDetailsResultInbound = $TripDetailsResponse['TripDetailsResultInbound'];
                        if($tripDetailsResult['Success'] == 'true'){
                            $bookingId = $this->updateDomesticFlightBookingData($tripDetailsResult, $tripDetailsResultInbound, $bookings[0]['id']);
                        }
                    }else{
                        $tripDetailsResult = $tripDetails['TripDetailsResponse']['TripDetailsResult'];
                        if($tripDetailsResult['Success'] == 'true'){
                            $ticketStatus = $this->updateFlightBookingData($tripDetailsResult,$bookings[0]['id']);
                            $bookings[0]['ticket_status'] = $ticketStatus;
                        }
                    }
                } 
            }else{
                if(isset($itineraries[0]) && isset($passengers[0])){

                }else{
                    $tripDetails = $this->getTripDetails($bookings[0]['unique_booking_id']);
                    $tripDetails = json_decode($tripDetails, true);
                    if(isset($tripDetails['TripDetailsResponse'])){
                        $TripDetailsResponse = $tripDetails['TripDetailsResponse'];
                        if(isset($TripDetailsResponse['TripDetailsResultInbound'])){
                            $tripDetailsResult = $TripDetailsResponse['TripDetailsResult'];
                            $tripDetailsResultInbound = $TripDetailsResponse['TripDetailsResultInbound'];
                            if($tripDetailsResult['Success'] == 'true'){
                                $bookingId = $this->updateDomesticFlightBookingData($tripDetailsResult, $tripDetailsResultInbound, $bookings[0]['id']);
                            }
                        }else{
                            $tripDetailsResult = $tripDetails['TripDetailsResponse']['TripDetailsResult'];
                            if($tripDetailsResult['Success'] == 'true'){
                                $ticketStatus = $this->updateFlightBookingData($tripDetailsResult,$bookings[0]['id']);
                                $bookings[0]['ticket_status'] = $ticketStatus;
                            }
                        }
                    } 
                }
            }
            if(isset($itineraries[0]) && isset($passengers[0])){
                $bookings[0]['flights'] = $itineraries;
                $bookings[0]['passengers'] = $passengers;
            }else{
                $bookings[0]['flights'] = FlightItineraryDetails::where('booking_id',$request->id)->orderBy('id','ASC')->get();
                $bookings[0]['passengers'] = FlightPassengers::where('booking_id',$request->id)->orderBy('id','ASC')->get();
            }  
            $bookings[0]['extraServices'] = FlightExtraServices::where('booking_id',$request->id)->get();
        }
       
        $type = $request->type;
        return  view('web.user.booking_details',compact('bookings','type'));
    }

    public function updateFlightBookingData($tripDetailsResult, $flightBookId){
        $travelItinerary = $tripDetailsResult['TravelItinerary'];
        // echo '<pre>';
        // print_r($data);
        // print_r($travelItinerary);

        $ItineraryInfo = $travelItinerary['ItineraryInfo'];
        $CustomerInfos = $ItineraryInfo['CustomerInfos'];
        $ReservationItems = $ItineraryInfo['ReservationItems'];
        $extraServices = (isset($ItineraryInfo['ExtraServices'])) ? $ItineraryInfo['ExtraServices'] : [];
            
        $bookData = [
            'booking_status' => $travelItinerary['BookingStatus'], 
            'ticket_status' => $travelItinerary['TicketStatus'], 
        ];
       
        $flightBook = FlightBookings::where('id',$flightBookId)->update($bookData);
    
        $passengers = $itinerary = $extras=  [];
        if($CustomerInfos){
            FlightPassengers::where('booking_id',$flightBookId)->delete();
            foreach($CustomerInfos as $custInfo){
                $info = $custInfo['CustomerInfo'];
                $passengers[] = [
                    'booking_id' => $flightBookId,
                    'passenger_type' => $info['PassengerType'],
                    'passport_number' => $info['PassportNumber'],
                    'passenger_first_name' => $info['PassengerFirstName'],
                    'passenger_last_name' => $info['PassengerLastName'],
                    'passenger_title' => $info['PassengerTitle'],
                    'itemRPH' => $info['ItemRPH'],
                    'eticket_number' => $info['eTicketNumber'],
                    'date_of_birth' => $info['DateOfBirth'],
                    'gender' => $info['Gender'],
                    'passenger_nationality' => $info['PassengerNationality'],
                    'created_at'=> date('Y-m-d H:i:s')
                ];
            }
            // print_r($passengers);
            FlightPassengers::insert($passengers);
        }
       
        if($ReservationItems){
            FlightItineraryDetails::where('booking_id',$flightBookId)->delete();
            foreach($ReservationItems as $resItem){
                $resInfo = $resItem['ReservationItem'];
                $itinerary[] = [
                    'booking_id' => $flightBookId,
                    'airline_pnr' => $resInfo['AirlinePNR'],
                    'arrival_airport' => $resInfo['ArrivalAirportLocationCode'],
                    'arrival_date_time' => $resInfo['ArrivalDateTime'],
                    'arrival_terminal' => $resInfo['ArrivalTerminal'],
                    'baggage' => $resInfo['Baggage'],
                    'cabin_class' => $resInfo['CabinClassText'],
                    'departure_airport' => $resInfo['DepartureAirportLocationCode'],
                    'departure_date_time' => $resInfo['DepartureDateTime'],
                    'departure_terminal' => $resInfo['DepartureTerminal'],
                    'flight_number' => $resInfo['FlightNumber'],
                    'item_rph' => $resInfo['ItemRPH'],
                    'journey_duration' => $resInfo['JourneyDuration'],
                    'marketing_airline_code' => $resInfo['MarketingAirlineCode'],
                    'number_in_party' => $resInfo['NumberInParty'],
                    'operating_airline_code' => $resInfo['OperatingAirlineCode'],
                    'res_book_desig_code' => $resInfo['ResBookDesigCode'],
                    'stop_quantity' => $resInfo['StopQuantity'],
                    'created_at'=> date('Y-m-d H:i:s')
                ];
            }
            // print_r($itinerary);
            FlightItineraryDetails::insert($itinerary);
        }
        if(isset($extraServices['Services'])){
            FlightExtraServices::where('booking_id',$flightBookId)->delete();
            foreach($extraServices['Services'] as $keye => $extra){
                $service = $extra['Service'];
                $serviceCost = $service['ServiceCost'];
                $extras[] = [
                    'booking_id' => $flightBookId,
                    'service_id' => $service['ServiceId'],
                    'type' => $service['Type'],
                    'behavior' => $service['Behavior'],
                    'description' => $service['Description'],
                    'checkin_type' => $service['CheckInType'],
                    'currency' => $serviceCost['CurrencyCode'],
                    'service_amount' => $serviceCost['Amount'],
                    'created_at'=> date('Y-m-d H:i:s')
                ];
            }
            // print_r($passengers);
            FlightExtraServices::insert($extras);
        }
        return $travelItinerary['TicketStatus'];
    }

    public function updateDomesticFlightBookingData($tripDetailsResult, $tripDetailsResultInbound, $flightBookId){
        $travelItinerary = $tripDetailsResult['TravelItinerary'];
        $travelItineraryInbound = $tripDetailsResultInbound['TravelItinerary'];
        // echo '<pre>';
        // print_r($data);
        // print_r($travelItinerary);

        $ItineraryInfo = $travelItinerary['ItineraryInfo'];
        $ItineraryInfoInbound = $travelItineraryInbound['ItineraryInfo'];

        $CustomerInfos = $ItineraryInfo['CustomerInfos'];
        $ReservationItems = $ItineraryInfo['ReservationItems'];
        $extraServices = (isset($ItineraryInfo['ExtraServices'])) ? $ItineraryInfo['ExtraServices'] : [];

        $CustomerInfosInbound = $ItineraryInfoInbound['CustomerInfos'];
        $ReservationItemsInbound = $ItineraryInfoInbound['ReservationItems'];
        $extraServicesInbound = (isset($ItineraryInfoInbound['ExtraServices'])) ? $ItineraryInfoInbound['ExtraServices'] : [];
            
        $bookData = [
            'booking_status' => $travelItinerary['BookingStatus'], 
            'ticket_status' => $travelItinerary['TicketStatus'], 
        ];
       
        $flightBook = FlightBookings::where('id',$flightBookId)->update($bookData);
    
        $passengers = $itinerary = $extras=  [];
        if($CustomerInfos){
            FlightPassengers::where('booking_id',$flightBookId)->delete();
            foreach($CustomerInfos as $custInfo){
                $info = $custInfo['CustomerInfo'];
                $passengers[] = [
                    'booking_id' => $flightBookId,
                    'passenger_type' => $info['PassengerType'],
                    'passport_number' => $info['PassportNumber'],
                    'passenger_first_name' => $info['PassengerFirstName'],
                    'passenger_last_name' => $info['PassengerLastName'],
                    'passenger_title' => $info['PassengerTitle'],
                    'itemRPH' => $info['ItemRPH'],
                    'eticket_number' => $info['eTicketNumber'],
                    'date_of_birth' => $info['DateOfBirth'],
                    'gender' => $info['Gender'],
                    'passenger_nationality' => $info['PassengerNationality'],
                    'is_return' => 0,
                    'created_at'=> date('Y-m-d H:i:s')
                ];
            }
        }

        if($CustomerInfosInbound){
            foreach($CustomerInfosInbound as $custInfo){
                $info = $custInfo['CustomerInfo'];
                $passengers[] = [
                    'booking_id' => $flightBookId,
                    'passenger_type' => $info['PassengerType'],
                    'passport_number' => $info['PassportNumber'],
                    'passenger_first_name' => $info['PassengerFirstName'],
                    'passenger_last_name' => $info['PassengerLastName'],
                    'passenger_title' => $info['PassengerTitle'],
                    'itemRPH' => $info['ItemRPH'],
                    'eticket_number' => $info['eTicketNumber'],
                    'date_of_birth' => $info['DateOfBirth'],
                    'gender' => $info['Gender'],
                    'passenger_nationality' => $info['PassengerNationality'],
                    'is_return' => 1,
                    'created_at'=> date('Y-m-d H:i:s')
                ];
            }
        }

        if(!empty($passengers)){
            FlightPassengers::insert($passengers);
        }
       
        if($ReservationItems){
            FlightItineraryDetails::where('booking_id',$flightBookId)->delete();
            foreach($ReservationItems as $resItem){
                $resInfo = $resItem['ReservationItem'];
                $itinerary[] = [
                    'booking_id' => $flightBookId,
                    'airline_pnr' => $resInfo['AirlinePNR'],
                    'arrival_airport' => $resInfo['ArrivalAirportLocationCode'],
                    'arrival_date_time' => $resInfo['ArrivalDateTime'],
                    'arrival_terminal' => $resInfo['ArrivalTerminal'],
                    'baggage' => $resInfo['Baggage'],
                    'cabin_class' => $resInfo['CabinClassText'],
                    'departure_airport' => $resInfo['DepartureAirportLocationCode'],
                    'departure_date_time' => $resInfo['DepartureDateTime'],
                    'departure_terminal' => $resInfo['DepartureTerminal'],
                    'flight_number' => $resInfo['FlightNumber'],
                    'item_rph' => $resInfo['ItemRPH'],
                    'journey_duration' => $resInfo['JourneyDuration'],
                    'marketing_airline_code' => $resInfo['MarketingAirlineCode'],
                    'number_in_party' => $resInfo['NumberInParty'],
                    'operating_airline_code' => $resInfo['OperatingAirlineCode'],
                    'res_book_desig_code' => $resInfo['ResBookDesigCode'],
                    'stop_quantity' => $resInfo['StopQuantity'],
                    'is_return' => 0,
                    'created_at'=> date('Y-m-d H:i:s')
                ];
            }
        }

        if($ReservationItemsInbound){
            foreach($ReservationItemsInbound as $resItem){
                $resInfo = $resItem['ReservationItem'];
                $itinerary[] = [
                    'booking_id' => $flightBookId,
                    'airline_pnr' => $resInfo['AirlinePNR'],
                    'arrival_airport' => $resInfo['ArrivalAirportLocationCode'],
                    'arrival_date_time' => $resInfo['ArrivalDateTime'],
                    'arrival_terminal' => $resInfo['ArrivalTerminal'],
                    'baggage' => $resInfo['Baggage'],
                    'cabin_class' => $resInfo['CabinClassText'],
                    'departure_airport' => $resInfo['DepartureAirportLocationCode'],
                    'departure_date_time' => $resInfo['DepartureDateTime'],
                    'departure_terminal' => $resInfo['DepartureTerminal'],
                    'flight_number' => $resInfo['FlightNumber'],
                    'item_rph' => $resInfo['ItemRPH'],
                    'journey_duration' => $resInfo['JourneyDuration'],
                    'marketing_airline_code' => $resInfo['MarketingAirlineCode'],
                    'number_in_party' => $resInfo['NumberInParty'],
                    'operating_airline_code' => $resInfo['OperatingAirlineCode'],
                    'res_book_desig_code' => $resInfo['ResBookDesigCode'],
                    'stop_quantity' => $resInfo['StopQuantity'],
                    'is_return' => 1,
                    'created_at'=> date('Y-m-d H:i:s')
                ];
            }
        }
        if(!empty($itinerary)){
            FlightItineraryDetails::insert($itinerary);
        }

        if(isset($extraServices['Services'])){
            FlightExtraServices::where('booking_id',$flightBookId)->delete();
            foreach($extraServices['Services'] as $keye => $extra){
                $service = $extra['Service'];
                $serviceCost = $service['ServiceCost'];
                $extras[] = [
                    'booking_id' => $flightBookId,
                    'service_id' => $service['ServiceId'],
                    'type' => $service['Type'],
                    'behavior' => $service['Behavior'],
                    'description' => $service['Description'],
                    'checkin_type' => $service['CheckInType'],
                    'currency' => $serviceCost['CurrencyCode'],
                    'service_amount' => $serviceCost['Amount'],
                    'created_at'=> date('Y-m-d H:i:s')
                ];
            }
        }

        if(isset($extraServicesInbound['Services'])){
            FlightExtraServices::where('booking_id',$flightBookId)->delete();
            $serviceIn = $extraServicesInbound['Services'];
            foreach($serviceIn as $keye => $extra){
                $service = $extra['Service'];
                $serviceCost = $service['ServiceCost'];
                $extras[] = [
                    'booking_id' => $flightBookId,
                    'service_id' => $service['ServiceId'],
                    'type' => $service['Type'],
                    'behavior' => $service['Behavior'],
                    'description' => $service['Description'],
                    'checkin_type' => $service['CheckInType'],
                    'currency' => $serviceCost['CurrencyCode'],
                    'service_amount' => $serviceCost['Amount'],
                    'created_at'=> date('Y-m-d H:i:s')
                ];
            }
        }
        if(!empty($extras)){
            FlightExtraServices::insert($extras);
        }
        return $travelItinerary['TicketStatus'];
    }

    public function getTripDetails($bookingId){
        $response = Http::timeout(300)->withOptions($this->options)->post(env('API_BASE_URL').'trip_details', [
                        "user_id"=> env('API_USER_ID'),
                        "user_password"=> env('API_USER_PASSWORD'),
                        "access"=> env('API_ACCESS'),
                        "ip_address"=> env('API_IP_ADDRESS'),
                        "UniqueID"=> $bookingId
                    ]);

        $result = $response->getBody()->getContents();
        return $result;
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

    public function subAgents(){
        $type = "sub_agents";
        
        $query = User::leftJoin('user_details as ud','ud.user_id','=','users.id')
                            ->where('users.user_type','agent')
                            ->where('users.parent_id',Auth::user()->id)
                            ->where('users.is_deleted',0);
        $agents = $query->orderBy('users.id','DESC')->paginate(10);
        return  view('web.user.sub_agents',compact('agents','type'));
    }

    public function statusChange(Request $request){
        $status = ($request->status == 1) ? 0:1;
        $user = User::find($request->id);
        $user->update(['is_active' => $status]);
    }

    public function deleteSubAgent(Request $request){
        User::where('id',$request->id)->update(['is_deleted' => 1]);
    }

    public function updateSubAgent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'agent_code' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'company_name' => 'required',
            'email' => 'required|email|unique:users,email,'.$request->agent_id,
            'agent_margin' => 'required',
            'credit_balance' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $agentMargins = [];
        $currentUser = UserDetails::where('user_id', Auth::user()->id)->first();
        $currentUserCredit = $currentUser->credit_balance;

        $userData = User::find($request->agent_id);
        $oldCredit = $userData->user_details->credit_balance;
        if( $oldCredit != $request->credit_balance){
            
            if($oldCredit <  $request->credit_balance){
                $diffCredit = $request->credit_balance - $oldCredit;
                if($diffCredit > $currentUserCredit){
                    return back()->withError(['walletError'=>'Insufficient Wallet Balance. You can add upto <b> USD '.$currentUserCredit.'</b>'])->withInput();
                }
                $agentMargins[] = array(
                    'booking_id' => NULL,
                    'agent_id'   => $userData->id,
                    'from_agent_id' => Auth::user()->id,
                    'currency' => 'USD',
                    'usd_amount' => $diffCredit,
                    'transaction_type' => 'cr',
                    'credit_balance' => $request->credit_balance,
                    'created_at' => date('Y-m-d H:i:s')
                );
                
                $currentUser->credit_balance -= $diffCredit;
                $currentUser->save();
                
                $agentMargins[] = array(
                    'booking_id' => NULL,
                    'agent_id'   => Auth::user()->id,
                    'from_agent_id' => $userData->id,
                    'currency' => 'USD',
                    'usd_amount' => $diffCredit,
                    'transaction_type' => 'dr',
                    'credit_balance' => $currentUser->credit_balance,
                    'created_at' => date('Y-m-d H:i:s')
                );
            }else if($oldCredit >  $request->credit_balance){
                $diffCredit = $oldCredit - $request->credit_balance;
               
                $agentMargins[] = array(
                    'booking_id' => NULL,
                    'agent_id'   => $userData->id,
                    'from_agent_id' => Auth::user()->id,
                    'currency' => 'USD',
                    'usd_amount' => $diffCredit,
                    'transaction_type' => 'dr',
                    'credit_balance' => $request->credit_balance,
                    'created_at' => date('Y-m-d H:i:s')
                );
                
                $currentUser->credit_balance += $diffCredit;
                $currentUser->save();
                
                $agentMargins[] = array(
                    'booking_id' => NULL,
                    'agent_id'   => Auth::user()->id,
                    'from_agent_id' => $userData->id,
                    'currency' => 'USD',
                    'usd_amount' => $diffCredit,
                    'transaction_type' => 'cr',
                    'credit_balance' => $currentUser->credit_balance,
                    'created_at' => date('Y-m-d H:i:s')
                );
            } 
            if(!empty($agentMargins)){
                FlightMarginAmounts::insert($agentMargins); 
            }
            
        }

        
        
        $imageUrl = '';
        $presentImage = $request->image_url;
        if ($request->hasFile('logo')) {
            $uploadedFile = $request->file('logo');
            $filename =    strtolower(Str::random(2)).time().'.'. $uploadedFile->getClientOriginalName();
            $name = Storage::disk('public')->putFileAs(
                'users',
                $uploadedFile,
                $filename
            );
            $imageUrl = Storage::url($name);
            if($presentImage != '' && File::exists(public_path($presentImage))){
                unlink(public_path($presentImage));
            }
        }   

        
        $userData->parent_id = Auth::user()->id;
        $userData->name = $request->first_name.' '.$request->last_name;
        $userData->email = $request->email;
        if(isset($request->password)){
            $userData->password = Hash::make($request->password);
        }
        $userData->save();

        $data = [
                'code' => $request->agent_code, 
                'first_name' => $request->first_name, 
                'last_name' => $request->last_name,  
                'gender' => $request->gender, 
                'business_nature' => $request->business_nature, 
                'phone_number' => $request->phone_number,  
                'address' => $request->address,  
                'city' => $request->city,  
                'state' => $request->state,  
                'zip_code' => $request->zip_code,  
                'country' => $request->country,  
                'logo' =>  ($imageUrl !='') ? $imageUrl : $presentImage,
                'designation' => $request->designation,  
                'company_name' => $request->company_name, 
                'company_reg_no' => $request->company_reg_no, 
                'agent_margin' => $request->agent_margin,
                'credit_balance' => $request->credit_balance,
        ];

        UserDetails::where('user_id',$request->agent_id)->update($data);
        return back()->with('status', 'Sub agent Details Updated!');
    }

    public function editSubAgent($agent_id)
    {
        $type = "sub_agents";
        $agent = User::find($agent_id);
        $countries = Countries::get();
        return view('web.sub_agents.edit', compact('agent','type','countries'));
    }

    public function viewSubAgent($agent_id)
    {  
        $type = "sub_agents";
        $agent = User::select('users.*','ud.*','c.name as country_name')
                        ->leftJoin('user_details as ud','ud.user_id','=','users.id')
                        ->leftJoin('countries as c','c.id','=','ud.country')
                        ->where('users.id',$agent_id)
                        ->get();
                        // print_r($agent);
        return view('web.sub_agents.view', compact('type','agent'));
    }

    public function storeSubAgent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'agent_code' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'company_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'agent_margin' => 'required',
            'credit_balance' => 'required'
        ]);
        // echo '<pre>';
        // print_r($validator);die;
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $currentUser = UserDetails::where('user_id', Auth::user()->id)->get();
        $currentUserCredit = $currentUser[0]->credit_balance;
        if($request->credit_balance > $currentUserCredit){
            return back()->withError(['walletError'=>'Insufficient Wallet Balance. You can add upto <b> USD '.$currentUserCredit.'</b>'])->withInput();
        }
        

        $user = User::create([
            'user_type' => 'agent',
            'parent_id' => Auth::user()->id,
            'name' => $request->first_name.' '.$request->last_name,
            'email' => $request->email,
            'password' =>  Hash::make($request->password),
            'is_approved' => 0,
            'is_active' => 1,
        ]);

        if($user->id){
            $imageUrl = '';
            if ($request->hasFile('logo')) {
                $uploadedFile = $request->file('logo');
                $filename =    strtolower(Str::random(2)).time().'.'. $uploadedFile->getClientOriginalName();
                $name = Storage::disk('public')->putFileAs(
                    'users',
                    $uploadedFile,
                    $filename
                );
               $imageUrl = Storage::url($name);
            }   

            $user_details = UserDetails::create([
                'user_id' => $user->id, 
                'code' => $request->agent_code, 
                'first_name' => $request->first_name, 
                'last_name' => $request->last_name,  
                'gender' => $request->gender, 
                'business_nature' => $request->business_nature, 
                'phone_number' => $request->phone_number,  
                'address' => $request->address,  
                'city' => $request->city,  
                'state' => $request->state,  
                'zip_code' => $request->zip_code,  
                'country' => $request->country,  
                'logo' => $imageUrl, 
                'designation' => $request->designation,  
                'company_name' => $request->company_name, 
                'company_reg_no' => $request->company_reg_no,
                'agent_margin' => $request->agent_margin,
                'credit_balance' => $request->credit_balance,
            ]);

            $agentMargins[] = array(
                'booking_id' => NULL,
                'agent_id'   => $user->id,
                'from_agent_id' => Auth::user()->id,
                'currency' => 'USD',
                'usd_amount' => $request->credit_balance,
                'transaction_type' => 'cr',
                'credit_balance' => $request->credit_balance,
                'created_at' => date('Y-m-d H:i:s')
            );
            $mainAgent = UserDetails::where('user_id', Auth::user()->id)->first();
            $mainAgent->credit_balance -= $request->credit_balance;
            $mainAgent->save();

            $agentMargins[] = array(
                'booking_id' => NULL,
                'agent_id'   => Auth::user()->id,
                'from_agent_id' => $user->id,
                'currency' => 'USD',
                'usd_amount' => $request->credit_balance,
                'transaction_type' => 'dr',
                'credit_balance' => $mainAgent->credit_balance,
                'created_at' => date('Y-m-d H:i:s')
            );

            FlightMarginAmounts::insert($agentMargins); 
        }

        return redirect()->route('subagent.create')->with('status', 'Sub Agent created successfully!');
    }

    public function createSubAgent()
    {
        $type = "sub_agents";
        $countries = Countries::get();
        return view('web.sub_agents.create', compact('type','countries'));
    }

    public function viewAgentProfile(){
        $type = "profile";
        $countries = Countries::get();
        $agent = User::select('users.*','ud.*','c.name as country_name')
                        ->leftJoin('user_details as ud','ud.user_id','=','users.id')
                        ->leftJoin('countries as c','c.id','=','ud.country')
                        ->where('users.id',Auth::user()->id)
                        ->get();
                        // print_r($agent);
        return view('web.user.agent_profile', compact('type','agent','countries'));
    }

    public function updateAgentProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'agent_code' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'company_name' => 'required',
            'email' => 'required|email|unique:users,email,'.$request->agent_id,
            'agent_margin' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $imageUrl = '';
        $presentImage = $request->image_url;
        if ($request->hasFile('logo')) {
            $uploadedFile = $request->file('logo');
            $filename =    strtolower(Str::random(2)).time().'.'. $uploadedFile->getClientOriginalName();
            $name = Storage::disk('public')->putFileAs(
                'users',
                $uploadedFile,
                $filename
            );
            $imageUrl = Storage::url($name);
            if($presentImage != '' && File::exists(public_path($presentImage))){
                unlink(public_path($presentImage));
            }
        }   

        $userData = User::find($request->agent_id);
        // $userData->parent_id = Auth::user()->id;
        $userData->name = $request->first_name.' '.$request->last_name;
        $userData->email = $request->email;
        if(isset($request->password)){
            $userData->password = Hash::make($request->password);
        }
        $userData->save();

        $data = [
                'first_name' => $request->first_name, 
                'last_name' => $request->last_name,  
                'gender' => $request->gender, 
                'business_nature' => $request->business_nature, 
                'phone_number' => $request->phone_number,  
                'address' => $request->address,  
                'city' => $request->city,  
                'state' => $request->state,  
                'zip_code' => $request->zip_code,  
                'country' => $request->country,  
                'logo' =>  ($imageUrl !='') ? $imageUrl : $presentImage,
                'designation' => $request->designation,  
                'company_name' => $request->company_name, 
                'company_reg_no' => $request->company_reg_no, 
                'agent_margin' => $request->agent_margin
        ];

        UserDetails::where('user_id',$request->agent_id)->update($data);
        return back()->with('status', 'Agent Details Updated!');
    }
}
