<?php
  
use Carbon\Carbon;
use App\Models\UserDetails;
use App\Models\GeneralSettings;
use App\Models\Airlines;
  

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
 
