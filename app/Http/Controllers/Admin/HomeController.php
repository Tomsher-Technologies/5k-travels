<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralSettings;
use App\Models\Pages;
use App\Models\FaqCategories;
use App\Models\FaqContents;
use App\Models\FlightBookings;
use App\Models\User;
use Auth;
use Validator;
use Str;
use Storage;
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

    public function getAllBookings(){
        $bookings = FlightBookings::select('flight_bookings.*','ud.code','ud.first_name','ud.last_name')
                                ->leftJoin('user_details as ud','flight_bookings.user_id','=','ud.user_id')
                                ->orderBy('flight_bookings.id','desc')->paginate(10);
        return  view('admin.bookings.bookings',compact('bookings'));
    }
    
}
