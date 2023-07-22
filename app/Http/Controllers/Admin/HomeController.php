<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralSettings;
use App\Models\Pages;
use App\Models\FaqCategories;
use App\Models\FaqContents;
use App\Models\FlightBookings;
use App\Models\FlightItineraryDetails;
use App\Models\FlightExtraServices;
use App\Models\FlightPassengers;
use App\Models\FlightMarginAmounts;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Auth;
use Validator;
use Str;
use Storage;
use Session;
use File;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $agents = User::where('user_type','agent')->where('is_deleted',0)->where('is_approved',1)->get();
        return  view('admin.home',compact('agents'));
    }

    public function dashboardCounts(Request $request)
    {
        $startDate = $request->start;
        $endDate = $request->end;
        $data['bookings'] = FlightBookings::whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->count();
        $data['users'] = User::whereDate('created_at', '>=', $startDate)
                                ->whereDate('created_at', '<=', $endDate)
                                ->where('user_type','user')
                                ->count();
        $data['agents'] = User::whereDate('created_at', '>=', $startDate)
                                ->whereDate('created_at', '<=', $endDate)
                                ->where('user_type','agent')
                                ->count();
        return json_encode(array('status' => true, 'data' => $data));
    }

    public function allUsersCounts(Request $request){
        $users = User::select(DB::raw('COUNT(CASE user_type WHEN "agent" THEN 1 END) AS agent,COUNT(CASE user_type WHEN "user" THEN 2 END) AS user'))
                        ->where('is_deleted',0)
                        ->get();

        return json_encode(array('status' => true, 'data' => $users));
    }


    public function flightbookingCounts(Request $request)
    {
        $year = $request->year;
        $agent = $request->agentId;
        $monthlyArray =  ['January' => 0,
                            'February' => 0,
                            'March' => 0,
                            'April' => 0,
                            'May' => 0,
                            'June' => 0,
                            'July' => 0,
                            'August' => 0,
                            'September' => 0,
                            'October' => 0,
                            'November' => 0,
                            'December' => 0
                        ];

        $query = FlightBookings::select(DB::raw('count(id) as count'), DB::raw("MONTHNAME(created_at)  as month")) 
                                ->whereYear('created_at', $year);
        if(trim($agent) != ''){
            $query->where('user_id',$agent);
        }
        $dataTotal = $query->groupBy('month')
                    ->orderBy('month')// you don't really need this one 
                    ->get()
                    ->toArray();//fetch the results
                 
        foreach($dataTotal as $key => $array){//add the results to the default array
            $monthlyArray[$array['month']] = $array['count'];
        }
        $array_keys = array_keys($monthlyArray);
        $array_values = array_values($monthlyArray);
        return json_encode(array('status' => true, 'categories' => $array_keys, 'series' => $array_values));
    }

    public function generalSettings(){
        $general_settings = getGeneralSettings();
        return view('admin.settings.general',compact('general_settings'));
    }

    public function generalSettingsStore(Request $request){
        $validator = Validator::make($request->all(), [
            'admin_margin_users' => 'required',
            'site_mail' => 'required',
            'site_phone' => 'required'
        ],[
            'admin_margin_users.required' => 'Admin margin for users field is required',
            'site_mail.required' => 'Site email field is required',
            'site_phone.required' => 'Site phone number field is required'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = [
            'admin_margin_users' =>  $request->admin_margin_users,
            'site_mail' =>  $request->site_mail,
            'site_phone' =>  $request->site_phone,
            'facebook' =>  $request->facebook,
            'instagram' =>  $request->instagram,
            'twitter' =>  $request->twitter,
            'linkedin' =>  $request->linkedin
        ];
       
        $this->saveGeneralSettings($data);
        return back()->with('status', 'Settings Updated!');
    }

    public function saveGeneralSettings($datas){
        foreach($datas as $key=>$value){
            $page = GeneralSettings::updateOrCreate([
                'type'   => $key,
            ],[
                'value' => $value
            ]);
        }
    }

    public function pages(){
        $pages = Pages::orderBy('page_name','Asc')->paginate(10);
       
        return view('admin.settings.pages',compact('pages'));
    }

    public function updatePages(Pages $page){
        return view('admin.settings.page_edit',compact('page'));
    }

    public function savePages(Request $request){
        $validator = Validator::make($request->all(), [
            'page_title' => 'required',
            'seo_url' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $data = $request->all();
        $data['seo_url'] = $this->checkSEOUrlExist($request->seo_url, $request->page_type);
       
        $imageUrl = '';
        $presentImage = $request->image_url;
        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');
            $filename =    strtolower(Str::random(2)).time().'.'. $uploadedFile->getClientOriginalName();
            $name = Storage::disk('public')->putFileAs(
                'pages',
                $uploadedFile,
                $filename
            );
            $imageUrl = Storage::url($name);
            if($presentImage != '' && File::exists(public_path($presentImage))){
                unlink(public_path($presentImage));
            }
        }  
        $data['image'] = ($imageUrl != '') ? $imageUrl : $presentImage;
        $page = Pages::updateOrCreate([ 'id' => $request->page_id  ],$data);

        return back()->with('status', 'Page Details Updated!');
    }

    function checkSEOUrlExist($url, $type){
        $result = Pages::where('seo_url','LIKE',"$url")->where('page_type','!=',$type)->get();
        if(!empty($result[0])){
            return $url.'-'.strtolower(Str::random(2));
        }else{
            return $url;
        }
    }

    public function faq(){
        $faqs = FaqCategories::where('is_deleted',0)->orderBy('category_name','Asc')->paginate(10);
       
        return view('admin.settings.faqs',compact('faqs'));
    }

    public function faqCreate(){
        return view('admin.settings.faq_create');
    }

    public function faqStore(Request $request){
        $validator = Validator::make($request->all(), [
            'category_name' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $data = $request->all();
        $faq = new FaqCategories();
        $faq->category_name = $data['category_name'];
        $faq->save();
        
        $question = $data['question'];
        $answer = $request->answer;
        $insert_data = [];
        for($count = 0; $count < count($question); $count++)
        {
            if($question[$count] != ''){
                $dataHis = array(
                    'faq_category_id' => $faq->id,
                    'question' => $question[$count],
                    'answer'  => $answer[$count],
                    'created_at' => now()
                );
                $insert_data[] = $dataHis; 
            }
        }
        if($insert_data){
            FaqContents::insert($insert_data);
        }
        return redirect()->route('settings.faq')->with('status', 'Faq category details added successfully!');
    }

    public function faqEdit(FaqCategories $faq){
        
        $faq = $faq->where('id',$faq->id)->with(['question_answers' => function ($query) {
            $query->orderBy('id','ASC');
        }])->get();
       
        return view('admin.settings.faq_edit',compact('faq'));
    }

    public function faqUpdate(Request $request){
        $validator = Validator::make($request->all(), [
            'category_name' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $faq = FaqCategories::find($data['category_id']);
        $faq->category_name = $data['category_name'];
        $faq->save();
        
        $question = $data['question'];
        $answer = $request->answer;
        $insert_data = [];
        for($count = 0; $count < count($question); $count++)
        {
            if($question[$count] != ''){
                $dataHis = array(
                    'faq_category_id' => $faq->id,
                    'question' => $question[$count],
                    'answer'  => $answer[$count],
                    'created_at' => now()
                );
                $insert_data[] = $dataHis; 
            }
        }
        
        FaqContents::where('faq_category_id',$faq->id)->delete();
        if($insert_data){
            FaqContents::insert($insert_data);
        }
        return back()->with('status', 'Faq category details updated successfully!');
    }

    public function faqStatusChange(Request $request){
        $status = ($request->status == 1) ? 0:1;
        $faq = FaqCategories::find($request->id);
        $faq->update(['is_active' => $status]);
    }
    
    public function deleteFaq(Request $request){
        FaqCategories::where('id',$request->id)->update(['is_deleted' => 1]);
    }

    public function getAllBookings(Request $request){
        $data = $request->all();
        // echo '<pre>';
        // print_r($request->all());
        if(!empty($data)){
            Session::put('booking_filter', $data);
        }else{
            Session::forget('booking_filter');
        }

        $startDate = $endDate = '';
        if(isset($data['date_range'])){
            list($start,$end) = explode(" - ",$data['date_range']);
            $startDate = date('Y-m-d', strtotime("$start"));
            $endDate = date('Y-m-d', strtotime("$end"));
        }
        // die;

        $query = FlightBookings::select('flight_bookings.*','ud.code','ud.first_name','ud.last_name')
                                ->leftJoin('user_details as ud','flight_bookings.user_id','=','ud.user_id');
        if($startDate != '' && $endDate != ''){
            $query->whereDate('flight_bookings.created_at', '>=', $startDate)->whereDate('flight_bookings.created_at', '<=', $endDate);
        }
        if(isset($data['bookingID']) && $data['bookingID'] != ''){
            $query->where('unique_booking_id', $data['bookingID']);
        }

        if(isset($data['agent']) && $data['agent'] != ''){
            $query->where('flight_bookings.user_id', $data['agent']);
        }
        if(isset($data['status']) && $data['status'] != ''){
            if($data['status'] == 'cancelled'){
                $query->where('is_cancelled', 1);
            }elseif($data['status'] == 'cancel_request'){
                $query->where('is_cancelled', 0)->where('cancel_request', 1);
            }elseif($data['status'] == 'resheduled'){
                $query->where('is_reissued', 1);
            }elseif($data['status'] == 'reshedule_request'){
                $query->where('reissue_request', 1)->where('is_reissued', 0);
            }elseif($data['status'] == 'Ticketed'){
                $query->whereIn('ticket_status', ['Ticketed','OK']);
            }elseif($data['status'] == 'others'){
                $query->whereNotIn('ticket_status', ['Ticketed','OK','TktInProcess','BookingInProcess']);
            }else{
                $query->where('ticket_status', $data['status']);
            }
        }
        $bookings = $query->orderBy('flight_bookings.id','desc')->paginate(10);

        $agents = User::where('user_type','agent')->where('is_deleted',0)->where('is_approved',1)->get();
        return  view('admin.bookings.bookings',compact('bookings','agents','data'));
    }

    public function getBookingDetails(Request $request){
        $bookings = FlightBookings::select('flight_bookings.*','u.name as agent_name')
                                    ->leftJoin('users as u','u.id','flight_bookings.user_id')
                                    ->where('flight_bookings.id',$request->id)
                                    ->get();
        if(isset($bookings[0])){
            $bookings[0]['flights'] = FlightItineraryDetails::where('booking_id',$request->id)->get();
            $bookings[0]['passengers'] = FlightPassengers::where('booking_id',$request->id)->get();
            $bookings[0]['margins'] = FlightMarginAmounts::select('flight_margin_amounts.*','u.name')
                                                    ->leftJoin('users as u','u.id','flight_margin_amounts.agent_id')
                                                    ->where('booking_id',$request->id)
                                                    ->where('transaction_type','cr')
                                                    ->orderBy('id','desc')->get();
            $bookings[0]['extraServices'] = FlightExtraServices::where('booking_id',$request->id)->get();
        }
       
        return  view('admin.bookings.bookings_details',compact('bookings'));
    }
    public function ExportExcel($customer_data){
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->getStyle('1:1')->getFont()->setBold(true);
            $spreadSheet->getActiveSheet()->getStyle('1:1')->getFont()->setSize('13px');
            $spreadSheet->getActiveSheet()->fromArray($customer_data);
            $Excel_writer = new Xls($spreadSheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Flight_Bookings_'.date('d-m-Y').'.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }

    function exportData(){
        $data = [];
        if(Session::has('booking_filter')){
            $data = Session::get('booking_filter');
        }
        $startDate = $endDate = '';
        if(isset($data['date_range'])){
            list($start,$end) = explode(" - ",$data['date_range']);
            $startDate = date('Y-m-d', strtotime("$start"));
            $endDate = date('Y-m-d', strtotime("$end"));
        }
        // die;

        $query = FlightBookings::select('flight_bookings.*','ud.code','ud.first_name','ud.last_name')
                                ->leftJoin('user_details as ud','flight_bookings.user_id','=','ud.user_id');
        if($startDate != '' && $endDate != ''){
            $query->whereDate('flight_bookings.created_at', '>=', $startDate)->whereDate('flight_bookings.created_at', '<=', $endDate);
        }
        if(isset($data['bookingID']) && $data['bookingID'] != ''){
            $query->where('unique_booking_id', $data['bookingID']);
        }

        if(isset($data['agent']) && $data['agent'] != ''){
            $query->where('flight_bookings.user_id', $data['agent']);
        }
        if(isset($data['status']) && $data['status'] != ''){
            if($data['status'] == 'cancelled'){
                $query->where('is_cancelled', 1);
            }elseif($data['status'] == 'resheduled'){
                $query->where('is_reissued', 1);
            }elseif($data['status'] == 'Ticketed'){
                $query->whereIn('ticket_status', ['Ticketed','OK']);
            }elseif($data['status'] == 'others'){
                $query->whereNotIn('ticket_status', ['Ticketed','OK','TktInProcess','BookingInProcess']);
            }else{
                $query->where('ticket_status', $data['status']);
            }
        }
        $bookings = $query->orderBy('flight_bookings.id','desc')->get();


        $data_array [] = array("Booking ID","Agent Code","Agent Name","Origin","Destination","Direction","Passenger Count","Customer Name","Customer Email","Customer Phone","Amount","Booking Date","Booking Status","Admin Commission");
        foreach($bookings as $data_item)
        {

            if($data_item->is_cancelled == 1){
                $bookingStatus = 'Cancelled';
            }elseif($data_item->is_reissued == 1){
                $bookingStatus = 'Rescheduled';
            }elseif($data_item->cancel_request == 1){
                $bookingStatus = 'Cancellation Requested';
            }elseif($data_item->reissue_request == 1){
                $bookingStatus = 'Reschedule Requested';
            }else{
                if($data_item->ticket_status == "TktInProcess"){
                    $bookingStatus = 'Ticketing In Process';
                }elseif($data_item->ticket_status == "BookingInProcess"){
                    $bookingStatus = 'Booking In Process';
                }elseif($data_item->ticket_status == "Ticketed" || $data_item->ticket_status == "OK"){
                    $bookingStatus = 'Ticketed';
                }else{
                    if($data_item->ticket_status != ''){
                        $bookingStatus = ucfirst(strtolower($data_item->ticket_status));
                    }else{
                        $bookingStatus = 'Ticket Not Generated';
                    }
                }
            }

            $data_array[] = array(
                'Booking ID' => $data_item->unique_booking_id,
                'Agent Code' => $data_item->code,
                'Agent Name' => $data_item->first_name .' '. $data_item->last_name,
                'Origin' => $data_item->origin,
                'Destination' => $data_item->destination,
                'Direction' => $data_item->direction,
                'Passenger Count' => $data_item->adult_count + $data_item->child_count + $data_item->infant_count,
                'Customer Name' => $data_item->customer_name,
                'Customer Email' => $data_item->customer_email,
                'Customer Phone' => $data_item->phone_code .' '.$data_item->customer_phone,
                'Amount' => $data_item->currency .' '.$data_item->total_amount,
                'Booking Date' => date('d-m-Y' ,strtotime($data_item->created_at)),
                'Booking Status' => $bookingStatus,
                'Admin Commission' => 'USD '.$data_item->admin_amount,
            );
        }



        $this->ExportExcel($data_array);
    }
    
}
