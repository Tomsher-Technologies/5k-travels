<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Hash;
use Auth;
use App;

class ApiController extends Controller
{
    protected  $options = [];

    public function __construct() {
        if (App::environment('local')) {
            $this->options = ['verify'=>false];
        }
    }

    public function checkAuthenticated($username, $password){
        $data = [
            'username' => $username,
            'password' => $password,
            'is_active' => 1
        ];
        if(auth('api')->attempt($data)){
            return auth('api')->user()->access ;
        }else{
            return 0;
        }
    }

    public function generatePassword(Request $request){
        echo Hash::make($request->password);
    }
    
    public function airportList(Request $request){
        $data = $request->all();
        $username = $data['username'];
        $password = $data['password'];

        $check = $this->checkAuthenticated($username, $password);
        if($check != 0){
            $check = strtoupper($check);

            $response = Http::withOptions($this->options)->post(env('5K_API_BASE_URL_'.$check).'airport_list', [
                            "user_id"=> env('5K_API_USER_ID_'.$check),
                            "user_password"=> env('5K_API_USER_PASSWORD_'.$check),
                            "access"=> env('5K_API_ACCESS_'.$check),
                            "ip_address"=> env('5K_API_IP_ADDRESS_'.$check)
                        ]);
            $result = $response->getBody()->getContents();
            $result = json_decode($result, true);
            return response()->json([ 'status' => true, 'message' => 'Data fetched', 'data' => $result]);
        }else{
            return response()->json([ 'status' => false, 'message' => 'Unauthenticated access', 'data' => []]);
        }
    }

    public function airlineList(Request $request){
        $data = $request->all();
        $username = $data['username'];
        $password = $data['password'];

        $check = $this->checkAuthenticated($username, $password);
        if($check != 0){
            $check = strtoupper($check);

            $response = Http::withOptions($this->options)->post(env('5K_API_BASE_URL_'.$check).'airline_list', [
                            "user_id"=> env('5K_API_USER_ID_'.$check),
                            "user_password"=> env('5K_API_USER_PASSWORD_'.$check),
                            "access"=> env('5K_API_ACCESS_'.$check),
                            "ip_address"=> env('5K_API_IP_ADDRESS_'.$check)
                        ]);
            $result = $response->getBody()->getContents();
            $result = json_decode($result, true);
            return response()->json([ 'status' => true, 'message' => 'Data fetched', 'data' => $result]);
        }else{
            return response()->json([ 'status' => false, 'message' => 'Unauthenticated access', 'data' => []]);
        }
    }

    public function availability(Request $request){
        $data = $request->all();
        $check = $this->checkAuthenticated($data['username'], $data['password']);
        
        if($check != 0){
            $check = strtoupper($check);

            $response = Http::timeout(300)->withOptions($this->options)->post(env('5K_API_BASE_URL_'.$check).'availability', [
                                "user_id"=> env('5K_API_USER_ID_'.$check),
                                "user_password"=> env('5K_API_USER_PASSWORD_'.$check),
                                "access"=> env('5K_API_ACCESS_'.$check),
                                "ip_address"=> env('5K_API_IP_ADDRESS_'.$check),
                                "requiredCurrency"=> $data['requiredCurrency'] ?? '',
                                "journeyType"=> $data['journeyType'] ?? '',
                                "OriginDestinationInfo"=> $data['OriginDestinationInfo'] ?? '',
                                "class"=> $data['class'] ?? '',
                                "airlineCode"=> isset($data['airlineCode']) ? $data['airlineCode'] : '',
                                "adults"=> isset($data['adults']) ? (int)$data['adults'] : 0,
                                "childs"=> isset($data['childs']) ? (int)$data['childs'] : 0,
                                "infants"=> isset($data['infants']) ? (int)$data['infants'] : 0,
                                "directFlight" => isset($data['directFlight']) ? (int)$data['directFlight'] : ''
            ]);
            $result = $response->getBody()->getContents();
            $result = json_decode($result, true);
            return response()->json([ 'status' => true, 'message' => 'Data fetched', 'data' => $result]);
        }else{
            return response()->json([ 'status' => false, 'message' => 'Unauthenticated access', 'data' => []]);
        }
    }

    public function revalidate(Request $request){
        $data = $request->all();
        $check = $this->checkAuthenticated($data['username'], $data['password']);
        
        if($check != 0){
            $check = strtoupper($check);

            $response = Http::timeout(300)->withOptions($this->options)->post(env('5K_API_BASE_URL_'.$check).'revalidate', [
                                "user_id"=> env('5K_API_USER_ID_'.$check),
                                "user_password"=> env('5K_API_USER_PASSWORD_'.$check),
                                "session_id"=> $data['session_id'] ?? '',
                                "fare_source_code"=> $data['fare_source_code'] ?? '',
                                "fare_source_code_inbound"=> $data['fare_source_code_inbound'] ?? ''
                        ]);
            $result = $response->getBody()->getContents();
            $result = json_decode($result, true);
            return response()->json([ 'status' => true, 'message' => 'Data fetched', 'data' => $result]);
        }else{
            return response()->json([ 'status' => false, 'message' => 'Unauthenticated access', 'data' => []]);
        }
    }

    public function fareRules(Request $request){
        $data = $request->all();
        $check = $this->checkAuthenticated($data['username'], $data['password']);
        
        if($check != 0){
            $check = strtoupper($check);

            $response = Http::timeout(300)->withOptions($this->options)->post(env('5K_API_BASE_URL_'.$check).'fare_rules', [
                                "user_id"=> env('5K_API_USER_ID_'.$check),
                                "user_password"=> env('5K_API_USER_PASSWORD_'.$check),
                                "session_id"=> $data['session_id'] ?? '',
                                "fare_source_code"=> $data['fare_source_code'] ?? '',
                                "fare_source_code_inbound"=> $data['fare_source_code_inbound'] ?? ''
                        ]);
            $result = $response->getBody()->getContents();
            $result = json_decode($result, true);
            return response()->json([ 'status' => true, 'message' => 'Data fetched', 'data' => $result]);
        }else{
            return response()->json([ 'status' => false, 'message' => 'Unauthenticated access', 'data' => []]);
        }
    }

    public function booking(Request $request){
        $data = $request->all();
        $check = $this->checkAuthenticated($data['username'], $data['password']);
        
        if($check != 0){
            $check = strtoupper($check);

            $response = Http::timeout(300)->withOptions($this->options)->post(env('5K_API_BASE_URL_'.$check).'booking', $data);
            $result = $response->getBody()->getContents();
            $result = json_decode($result, true);
            return response()->json([ 'status' => true, 'message' => 'Data fetched', 'data' => $result]);
        }else{
            return response()->json([ 'status' => false, 'message' => 'Unauthenticated access', 'data' => []]);
        }
    }

    public function ticketOrder(Request $request){
        $data = $request->all();
        $check = $this->checkAuthenticated($data['username'], $data['password']);
        
        if($check != 0){
            $check = strtoupper($check);

            $response = Http::timeout(300)->withOptions($this->options)->post(env('5K_API_BASE_URL_'.$check).'ticket_order', [
                                "user_id"=> env('5K_API_USER_ID_'.$check),
                                "user_password"=> env('5K_API_USER_PASSWORD_'.$check),
                                "access"=> env('5K_API_ACCESS_'.$check),
                                "ip_address"=> env('5K_API_IP_ADDRESS_'.$check),
                                "UniqueID"=> $data['UniqueID'] ?? ''
                        ]);
            $result = $response->getBody()->getContents();
            $result = json_decode($result, true);
            return response()->json([ 'status' => true, 'message' => 'Data fetched', 'data' => $result]);
        }else{
            return response()->json([ 'status' => false, 'message' => 'Unauthenticated access', 'data' => []]);
        }
    }

    public function tripDetails(Request $request){
        $data = $request->all();
        $check = $this->checkAuthenticated($data['username'], $data['password']);
        
        if($check != 0){
            $check = strtoupper($check);

            $response = Http::timeout(300)->withOptions($this->options)->post(env('5K_API_BASE_URL_'.$check).'trip_details', [
                                "user_id"=> env('5K_API_USER_ID_'.$check),
                                "user_password"=> env('5K_API_USER_PASSWORD_'.$check),
                                "access"=> env('5K_API_ACCESS_'.$check),
                                "ip_address"=> env('5K_API_IP_ADDRESS_'.$check),
                                "UniqueID"=> $data['UniqueID'] ?? ''
                        ]);
            $result = $response->getBody()->getContents();
            $result = json_decode($result, true);
            return response()->json([ 'status' => true, 'message' => 'Data fetched', 'data' => $result]);
        }else{
            return response()->json([ 'status' => false, 'message' => 'Unauthenticated access', 'data' => []]);
        }
    }

    public function cancel(Request $request){
        $data = $request->all();
        $check = $this->checkAuthenticated($data['username'], $data['password']);
        
        if($check != 0){
            $check = strtoupper($check);

            $response = Http::timeout(300)->withOptions($this->options)->post(env('5K_API_BASE_URL_'.$check).'cancel', [
                                "user_id"=> env('5K_API_USER_ID_'.$check),
                                "user_password"=> env('5K_API_USER_PASSWORD_'.$check),
                                "access"=> env('5K_API_ACCESS_'.$check),
                                "ip_address"=> env('5K_API_IP_ADDRESS_'.$check),
                                "UniqueID"=> $data['UniqueID'] ?? ''
                        ]);
            $result = $response->getBody()->getContents();
            $result = json_decode($result, true);
            return response()->json([ 'status' => true, 'message' => 'Data fetched', 'data' => $result]);
        }else{
            return response()->json([ 'status' => false, 'message' => 'Unauthenticated access', 'data' => []]);
        }
    }

    public function bookingNotes(Request $request){
        $data = $request->all();
        $check = $this->checkAuthenticated($data['username'], $data['password']);
        
        if($check != 0){
            $check = strtoupper($check);

            $response = Http::timeout(300)->withOptions($this->options)->post(env('5K_API_BASE_URL_'.$check).'booking_notes', [
                                "user_id"=> env('5K_API_USER_ID_'.$check),
                                "user_password"=> env('5K_API_USER_PASSWORD_'.$check),
                                "access"=> env('5K_API_ACCESS_'.$check),
                                "ip_address"=> env('5K_API_IP_ADDRESS_'.$check),
                                "UniqueID"=> $data['UniqueID'] ?? '',
                                "notes"=> $data['notes'] ?? ''
                        ]);
            $result = $response->getBody()->getContents();
            $result = json_decode($result, true);
            return response()->json([ 'status' => true, 'message' => 'Data fetched', 'data' => $result]);
        }else{
            return response()->json([ 'status' => false, 'message' => 'Unauthenticated access', 'data' => []]);
        }
    }

    public function voidTicketQuote(Request $request){
        $data = $request->all();
        $check = $this->checkAuthenticated($data['username'], $data['password']);
        
        if($check != 0){
            $check = strtoupper($check);

            $response = Http::timeout(300)->withOptions($this->options)->post(env('5K_API_BASE_URL_'.$check).'void_ticket_quote', [
                                "user_id"=> env('5K_API_USER_ID_'.$check),
                                "user_password"=> env('5K_API_USER_PASSWORD_'.$check),
                                "access"=> env('5K_API_ACCESS_'.$check),
                                "ip_address"=> env('5K_API_IP_ADDRESS_'.$check),
                                "UniqueID"=> $data['UniqueID'] ?? '',
                                "paxDetails"=> $data['paxDetails'] ?? ''
                        ]);
            $result = $response->getBody()->getContents();
            $result = json_decode($result, true);
            return response()->json([ 'status' => true, 'message' => 'Data fetched', 'data' => $result]);
        }else{
            return response()->json([ 'status' => false, 'message' => 'Unauthenticated access', 'data' => []]);
        }
    }

    public function searchPostTicketStatus(Request $request){
        $data = $request->all();
        $check = $this->checkAuthenticated($data['username'], $data['password']);
        
        if($check != 0){
            $check = strtoupper($check);

            $response = Http::timeout(300)->withOptions($this->options)->post(env('5K_API_BASE_URL_'.$check).'search_post_ticket_status', [
                                "user_id"=> env('5K_API_USER_ID_'.$check),
                                "user_password"=> env('5K_API_USER_PASSWORD_'.$check),
                                "access"=> env('5K_API_ACCESS_'.$check),
                                "ip_address"=> env('5K_API_IP_ADDRESS_'.$check),
                                "UniqueID"=> $data['UniqueID'] ?? '',
                                "ptrUniqueID"=> $data['ptrUniqueID'] ?? ''
                        ]);
            $result = $response->getBody()->getContents();
            $result = json_decode($result, true);
            return response()->json([ 'status' => true, 'message' => 'Data fetched', 'data' => $result]);
        }else{
            return response()->json([ 'status' => false, 'message' => 'Unauthenticated access', 'data' => []]);
        }
    }

    public function voidTicket(Request $request){
        $data = $request->all();
        $check = $this->checkAuthenticated($data['username'], $data['password']);
        
        if($check != 0){
            $check = strtoupper($check);

            $response = Http::timeout(300)->withOptions($this->options)->post(env('5K_API_BASE_URL_'.$check).'void_ticket', [
                                "user_id"=> env('5K_API_USER_ID_'.$check),
                                "user_password"=> env('5K_API_USER_PASSWORD_'.$check),
                                "access"=> env('5K_API_ACCESS_'.$check),
                                "ip_address"=> env('5K_API_IP_ADDRESS_'.$check),
                                "UniqueID"=> $data['UniqueID'] ?? '',
                                "remark"=> $data['remark'] ?? '',
                                "paxDetails"=> $data['paxDetails'] ?? ''
                        ]);
            $result = $response->getBody()->getContents();
            $result = json_decode($result, true);
            return response()->json([ 'status' => true, 'message' => 'Data fetched', 'data' => $result]);
        }else{
            return response()->json([ 'status' => false, 'message' => 'Unauthenticated access', 'data' => []]);
        }
    }

    public function refundQuote(Request $request){
        $data = $request->all();
        $check = $this->checkAuthenticated($data['username'], $data['password']);
        
        if($check != 0){
            $check = strtoupper($check);

            $response = Http::timeout(300)->withOptions($this->options)->post(env('5K_API_BASE_URL_'.$check).'refund_quote', [
                                "user_id"=> env('5K_API_USER_ID_'.$check),
                                "user_password"=> env('5K_API_USER_PASSWORD_'.$check),
                                "access"=> env('5K_API_ACCESS_'.$check),
                                "ip_address"=> env('5K_API_IP_ADDRESS_'.$check),
                                "UniqueID"=> $data['UniqueID'] ?? '',
                                "remark"=> $data['remark'] ?? '',
                                "paxDetails"=> $data['paxDetails'] ?? ''
                        ]);
            $result = $response->getBody()->getContents();
            $result = json_decode($result, true);
            return response()->json([ 'status' => true, 'message' => 'Data fetched', 'data' => $result]);
        }else{
            return response()->json([ 'status' => false, 'message' => 'Unauthenticated access', 'data' => []]);
        }
    }
    

    public function refund(Request $request){
        $data = $request->all();
        $check = $this->checkAuthenticated($data['username'], $data['password']);
        
        if($check != 0){
            $check = strtoupper($check);

            $response = Http::timeout(300)->withOptions($this->options)->post(env('5K_API_BASE_URL_'.$check).'refund', [
                                "user_id"=> env('5K_API_USER_ID_'.$check),
                                "user_password"=> env('5K_API_USER_PASSWORD_'.$check),
                                "access"=> env('5K_API_ACCESS_'.$check),
                                "ip_address"=> env('5K_API_IP_ADDRESS_'.$check),
                                "UniqueID"=> $data['UniqueID'] ?? '',
                                "remark"=> $data['remark'] ?? '',
                                "paxDetails"=> $data['paxDetails'] ?? ''
                        ]);
            $result = $response->getBody()->getContents();
            $result = json_decode($result, true);
            return response()->json([ 'status' => true, 'message' => 'Data fetched', 'data' => $result]);
        }else{
            return response()->json([ 'status' => false, 'message' => 'Unauthenticated access', 'data' => []]);
        }
    }

    public function reissueTicketQuote(Request $request){
        $data = $request->all();
        $check = $this->checkAuthenticated($data['username'], $data['password']);
        
        if($check != 0){
            $check = strtoupper($check);

            $response = Http::timeout(300)->withOptions($this->options)->post(env('5K_API_BASE_URL_'.$check).'reissue_ticket_quote', [
                                "user_id"=> env('5K_API_USER_ID_'.$check),
                                "user_password"=> env('5K_API_USER_PASSWORD_'.$check),
                                "access"=> env('5K_API_ACCESS_'.$check),
                                "ip_address"=> env('5K_API_IP_ADDRESS_'.$check),
                                "UniqueID"=> $data['UniqueID'] ?? '',
                                "paxDetails"=> $data['paxDetails'] ?? '',
                                "OriginDestinationInfo"=> $data['OriginDestinationInfo'] ?? ''
                        ]);
            $result = $response->getBody()->getContents();
            $result = json_decode($result, true);
            return response()->json([ 'status' => true, 'message' => 'Data fetched', 'data' => $result]);
        }else{
            return response()->json([ 'status' => false, 'message' => 'Unauthenticated access', 'data' => []]);
        }
    }

    public function reissueTicket(Request $request){
        $data = $request->all();
        $check = $this->checkAuthenticated($data['username'], $data['password']);
        
        if($check != 0){
            $check = strtoupper($check);

            $response = Http::timeout(300)->withOptions($this->options)->post(env('5K_API_BASE_URL_'.$check).'reissue_ticket', [
                                "user_id"=> env('5K_API_USER_ID_'.$check),
                                "user_password"=> env('5K_API_USER_PASSWORD_'.$check),
                                "access"=> env('5K_API_ACCESS_'.$check),
                                "ip_address"=> env('5K_API_IP_ADDRESS_'.$check),
                                "UniqueID"=> $data['UniqueID'] ?? '',
                                "ptrUniqueID"=> $data['ptrUniqueID'] ?? '',
                                "PreferenceOption"=> $data['PreferenceOption'] ?? '',
                                "remark"=> $data['remark'] ?? ''
                        ]);
            $result = $response->getBody()->getContents();
            $result = json_decode($result, true);
            return response()->json([ 'status' => true, 'message' => 'Data fetched', 'data' => $result]);
        }else{
            return response()->json([ 'status' => false, 'message' => 'Unauthenticated access', 'data' => []]);
        }
    }

    
}
