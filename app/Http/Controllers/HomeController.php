<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Airports;
use App\Models\Airlines;
use App\Models\FlightBookings;
use App\Models\FlightItineraryDetails;
use App\Models\FlightPassengers;
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
        $type = "my_bookings";
        $bookings = FlightBookings::where('user_id',Auth::user()->id)->orderBy('id','desc')->paginate(10);
        return  view('web.user.dashboard',compact('bookings','type'));
    }

    public function cancelled(){
        $type = "cancelled";
        $bookings = FlightBookings::where('user_id',Auth::user()->id)->where('is_cancelled',1)->orderBy('id','desc')->paginate(10);
        return  view('web.user.cancelled',compact('bookings','type'));
    }
    public function completed(){
        $type = "completed";
        // DB::enableQueryLog();
        $bookings = FlightBookings::select('flight_bookings.*')->where('user_id',Auth::user()->id)
                                    ->where('is_cancelled',0)
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
        if(isset($bookings[0])){
            $bookings[0]['flights'] = FlightItineraryDetails::where('booking_id',$request->id)->get();
            $bookings[0]['passengers'] = FlightPassengers::where('booking_id',$request->id)->get();
        }
       
        $type = $request->type;
        return  view('web.user.booking_details',compact('bookings','type'));
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
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
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
        $userData->parent_id = Auth::user()->id;
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
