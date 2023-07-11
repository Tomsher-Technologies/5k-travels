<?php
  
use Carbon\Carbon;
use App\Models\UserDetails;
use App\Models\GeneralSettings;
use App\Models\Airlines;
use App\Models\Airports;
use App\Models\User;

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('convertYmdToMdy')) {
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
if (! function_exists('convertMdyToYmd')) {
    function convertMdyToYmd($date)
    {
        return Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d');
    }
}

if (! function_exists('generateUniqueCode')) {
    function generateUniqueCode($type)
    {
        $characters = '0123456789';
        $charactersNumber = strlen($characters);
        $codeLength = 4;
        $code = '';
        while (strlen($code) < $codeLength) {
            $position = rand(0, $charactersNumber - 1);
            $character = $characters[$position];
            $code = $code.$character;
        }
        if($type == "agent"){
            $code = "AG".$code;
        }else if($type == "sub_agent"){
            $code = "SAG".$code;
        }else if($type == "admin"){
            $code = "AD".$code;
        }else{
            $code = "US".$code;
        }
        if (UserDetails::where('code', $code)->exists()) {
            $this->generateUniqueCode();
        }
        return $code;
    }
}

if (! function_exists('getGeneralSettings')) {
    function getGeneralSettings(){
        $result = array();
        $settings = GeneralSettings::get();
        if($settings){
            foreach($settings as$value){
                $result[$value['type']] = array('value' => $value['value'], 'content' => $value['content']);
            }
        }
        return $result;
    }
}

if (! function_exists('getTimeDiffInMInutes')) {
    function getTimeDiffInMInutes($datetime_1, $datetime_2){
        $start_datetime = new DateTime($datetime_1); 
        $diff = $start_datetime->diff(new DateTime($datetime_2)); 
        
        $total_minutes = ($diff->days * 24 * 60); 
        $total_minutes += ($diff->h * 60); 
        $total_minutes += $diff->i;
        return $total_minutes;
    }
}

if (! function_exists('convertToHoursMins')) {
    function convertToHoursMins($time) {
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return $hours.' hrs '.$minutes.' min';
    }
}
if (! function_exists('getAirlines')) {
    function getAirlines() {
        $airlines = Airlines::get()->keyBy('AirLineCode')->toArray();
        return $airlines;
    }
}
 
if (! function_exists('getAgentMarginData')) {
    function getAgentMarginData($userId) {
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
        foreach( $allParents  as $prts){
            $data['main_agents'][$prts->user_id] = $prts->agent_margin;
            $margins = $margins + $prts->agent_margin;
        }
        $data['totalmargin'] = $data['admin_margin'] + $data['agent_margin'] + $margins;
        return $data;
    }
}

if (! function_exists('getUserMarginData')) {
    function getUserMarginData() {
        $margin = GeneralSettings::where('type','admin_margin_users')->first();
        $data['admin_margin'] = $margin->value;
        $data['totalmargin'] = $margin->value;
        return $data;
    }
}

if (! function_exists('getAgentWalletBalance')) {
    function getAgentWalletBalance($userId) {
        $balance = User::with(['user_details'])->where('id', $userId)->first();
        return $balance->user_details->credit_balance;
    }
}

if (! function_exists('getUserDetails')) {
    function getUserDetails($userId) {
        $details = User::select('users.*','ud.*')
                        ->leftJoin('user_details as ud','ud.user_id','=','users.id')
                        ->where('users.id',$userId)
                        ->get();
        return $details;
    }
}

if (! function_exists('getAirlineData')) {
    function getAirlineData($code) {
        $details = Airlines::select('*')->where('AirLineCode',$code)
                        ->get()->toArray();
                        // echo '<pre>';
                        // print_r($details);die;
        return $details;
    }
}

if (! function_exists('getAirportData')) {
    function getAirportData($code) {
        $details = Airports::select('*')->where('AirportCode',$code)
                        ->get()->toArray();
                        // echo '<pre>';
                        // print_r($details);die;
        return $details;
    }
}

if (! function_exists('getCurrencyValue')) {
    function getCurrencyValue($currency) {
        $oneCurrency = 1;
        if(env('APP_ENV') != 'local'){
            $oneCurrency = Currency::convert()
                                    ->from($currency)
                                    ->to('USD')
                                    ->amount(1)
                                    ->get();
        }
        return $oneCurrency;
    }
}



