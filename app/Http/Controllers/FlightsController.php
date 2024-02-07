<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Providers\FlyDubaiController;
use App\Http\Controllers\Providers\Yasin\YasinBookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Airports;
use App\Models\Airlines;
use App\Models\FlightBookings;
use App\Models\FlightPassengers;
use App\Models\FlightItineraryDetails;
use App\Models\FlightMarginAmounts;
use App\Models\FlightExtraServices;
use App\Models\FlightSearches;
use App\Models\UserDetails;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class FlightsController extends Controller
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
    public function index()
    {
        return  view('web.index');
    }

    public function dashboard()
    {
        return  view('web.index');
    }

    public function search(Request $request)
    {
        $data = $flightCodes = [];

        $cabin_type = 'Economy';

        if ($request->search_type == 'OneWay') {
            Session::put('current_search_type', 'OneWay');
            Session::put('flight_search_oneway', $request->all());
            $cabin_type = $request->oClass;
        } elseif ($request->search_type == 'Return') {
            Session::put('current_search_type', 'Return');
            Session::put('flight_search_return', $request->all());
        } elseif ($request->search_type == 'Circle') {
            Session::put('current_search_type', 'Circle');
            Session::put('flight_search_multi', $request->all());
        }

        $data['flightData'] = Airlines::get()->keyBy('AirLineCode')->toArray();
        $data['airports'] = Airports::get()->keyBy('AirportCode')->toArray();
        $data['search_type'] = $request->search_type;
        $data['margins'] = (Auth::check()) ? getAgentMarginData(Auth::user()->id) : getUserMarginData();
        $data['cabin_type'] = $cabin_type;

        $fly_dubai_con = new FlyDubaiController();
        $fly_dubai_res = $fly_dubai_con->search($request);

        // $yasin_con = new YasinBookingController();
        // $yasin_res = $yasin_con->search($request);

        // dd($yasin_res);

        $data['non_stop'] = $fly_dubai_res['non_stop'];
        $data['one_stop'] = $fly_dubai_res['one_stop'];
        $data['two_stop'] = $fly_dubai_res['two_stop'];
        $data['three_stop'] = $fly_dubai_res['three_stop'];
        $data['refund'] = $fly_dubai_res['refund'];
        $data['no_refund'] = $fly_dubai_res['no_refund'];
        $data['currency'] = $fly_dubai_res['currency'];
        $data['totalCount'] = count($fly_dubai_res['flights']);
        $data['flightDetails'] = $fly_dubai_res['flights'];
        $data['taxDetails'] = $fly_dubai_res['taxDetails'];
        $data['serviceDetails'] = $fly_dubai_res['serviceDetails'];
        $data['legDetails'] = $fly_dubai_res['legDetails'];
        $data['airlines'] = $fly_dubai_res['airlines'];
        $data['search_id'] = $fly_dubai_res['search_id'];
        $data['combinability'] = getCombinability($fly_dubai_res['combinability']);

        // dd($data['serviceDetails']);

        // dd($data['combinability']);

        // dd(Cache::get('fd_search_result_' . $data['search_id']));
        return  view('web.search_results', compact('data'));
    }

    public function booking(Request $request)
    {
        $fly_dubai_con = new FlyDubaiController();
        $fly_dubai_res = $fly_dubai_con->booking($request);
    }

    public function fightViewDetails(Request $request)
    {
        if ($request->api_provider == "flydubai" && Cache::has('fd_search_result_' . $request->session_id)) {
            $data = Cache::get('fd_search_result_' . $request->session_id);

            $cabin_type = $request->cabin_type;

            $matchingFlight = null;

            foreach ($data['flights'] as $flights) {
                if ($flights["LFID"] == $request->LFID) {
                    $matchingFlight = $flights;
                    break;
                }
            }

            $LFID = $request->LFID;

            $margin = Auth::check() ? getAgentMarginData(Auth::user()->id) : getUserMarginData();

            $viewdata = view('web.provides.flydubai.details', compact('matchingFlight', 'cabin_type', 'LFID', 'margin', 'data'))->render();
            $msg = array(
                'status' => true,
                'data' => $viewdata
            );

            echo json_encode($msg);
            exit;
        }

        $msg = array(
            'status' => false,
            'data' => []
        );
        echo json_encode($msg);
    }

    public function createBooking(Request $request)
    {
        $fly_dubai_con = new FlyDubaiController();
        $fly_dubai_res = $fly_dubai_con->submitPnr($request);
    }

    public function cancelTicket(Request $request)
    {
        $status = false;
        // $msg = array('status' => false, 'data' => array(), 'msg' => $request->bookid);
        // return  json_encode($msg);

        if ($request->provider == 'flydubai') {
            $fly_dubai_con = new FlyDubaiController();
            $status = $fly_dubai_con->cancelPNR($request);
        }

        if ($status) {
            $msg = ['status' => true, 'type' => 'cancel', 'msg' => 'Cancel request send successfully'];
        } else {
            $msg = array('status' => false, 'data' => array(), 'msg' => 'Something went wrong');
        }

        return  json_encode($msg);
    }

    public function sendBookingMail($bookings)
    {
        $name = $to_name = $bookings[0]->customer_name;
        $to_email = $bookings[0]->customer_email;
        $viewdata = view('web.booking_email', compact('name', 'bookings'))->render();
        $data = array('name' => $to_name, 'body' => $viewdata);
        Mail::send('web.email.booking_email', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('Flight Booked!');
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });
    }

    public function sendReissueBookingMail($bookings)
    {
        $name = $to_name = $bookings[0]->customer_name;
        $to_email = $bookings[0]->customer_email;
        $viewdata = view('web.booking_email', compact('name', 'bookings'))->render();
        $data = array('name' => $to_name, 'body' => $viewdata);
        Mail::send('web.email.booking_email', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('Flight Booking Reissued!');
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });
    }

    public function sendCancelMail($bookings)
    {
        $name = $to_name = $bookings[0]->customer_name;
        $to_email = $bookings[0]->customer_email;
        $viewdata = view('web.cancel_email', compact('name', 'bookings'))->render();
        $data = array('name' => $to_name, 'body' => $viewdata);
        Mail::send('web.email.booking_email', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('Flight Booking Cancelled!');
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });
    }

    public function ticketOrder($bookingId)
    {
        $response = Http::timeout(300)->withOptions($this->options)->post(env('API_BASE_URL') . 'ticket_order', [
            "user_id" => env('API_USER_ID'),
            "user_password" => env('API_USER_PASSWORD'),
            "access" => env('API_ACCESS'),
            "ip_address" => env('API_IP_ADDRESS'),
            "UniqueID" => $bookingId
        ]);

        $result = $response->getBody()->getContents();
        return $result;
    }

    public function getTripDetails($bookingId)
    {
        $response = Http::timeout(300)->withOptions($this->options)->post(env('API_BASE_URL') . 'trip_details', [
            "user_id" => env('API_USER_ID'),
            "user_password" => env('API_USER_PASSWORD'),
            "access" => env('API_ACCESS'),
            "ip_address" => env('API_IP_ADDRESS'),
            "UniqueID" => $bookingId
        ]);

        $result = $response->getBody()->getContents();
        return $result;
    }

    public function bookingFail()
    {
        return view('web.booking_fail');
    }
}
