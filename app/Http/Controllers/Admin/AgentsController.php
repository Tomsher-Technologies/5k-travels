<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\Countries;
use App\Models\FlightMarginAmounts;
use Helper;
use Validator;
use Hash;
use Storage;
use Str;
use File;
use Mail;
use DB;

class AgentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort_search = $agent_search = null;
        if ($request->has('search')) {
            $sort_search = $request->search;
        }
        if ($request->has('agent')) {
            $agent_search = $request->agent;
        }
      
        $query = User::select('users.*','ud.*','pud.code as parent_code')->leftJoin('user_details as ud','ud.user_id','=','users.id')
                            ->leftJoin('users as pu', 'pu.id','=','users.parent_id')
                            ->leftJoin('user_details as pud', 'pud.user_id','=','pu.id')
                            ->where('users.user_type','agent')
                            ->where('users.is_deleted',0);
        if($sort_search){  
            if(trim(strtolower($sort_search)) == 'sub agent'){
                $query->whereNotNull('users.parent_id');
            }elseif(trim(strtolower($sort_search)) == 'agent'){
                $query->whereNull('users.parent_id');
            }else{
                $query->Where(function ($query) use ($sort_search) {
                        $query->orWhere('users.name', 'LIKE', "%$sort_search%")
                        ->orWhere('users.email', 'LIKE', "%$sort_search%")
                        ->orWhere('ud.code', 'LIKE', "%$sort_search%");   
                }); 
            }               
        }
        if($agent_search){
            $parent = User::with(['user_details'])->where('id', $agent_search)->first();
            $allChilds = $parent->children->pipe(function ($collection){
                $array = $collection->toArray();
                $ids = [];
                array_walk_recursive($array, function ($value, $key) use (&$ids) {
                    if ($key === 'id') {
                        $ids[] = $value;
                    };
                });
                return $ids;
            });
            $query->whereIn('users.id',$allChilds);
        }

        $agents = $query->orderBy('users.id','DESC')->paginate(10);
        $mainAgents = User::where('user_type','agent')->where('is_deleted',0)->where('is_approved',1)->get();
        return view('admin.agents.index', compact('agents', 'agent_search','sort_search','mainAgents'));
    }


    public function agentGraph(){
        $data = [];
        $agents = User::select('users.*')->leftJoin('user_details as ud','ud.user_id','=','users.id')
                            ->where('users.user_type','agent')
                            // ->where('is_approved',1)
                            ->where('users.is_deleted',0)
                            ->orderBy('parent_id','ASC')
                            ->get();
        $data[] = array(
            'id' => "0",
            'parent' => '',
            'name' => 'Admin'
        );
        if($agents){
            foreach($agents as $agt){
                $data[] = array(
                    'id' => "$agt->id",
                    'parent' => ( $agt->parent_id != '') ? "$agt->parent_id" : "0",
                    'name' => "$agt->name"
                );
            }
        }
        $graph = json_encode($data);

        return view('admin.agents.graph', compact('graph'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agents = User::where('user_type','agent')->where('is_approved',1)->where('is_active',1)->where('is_deleted',0)->get();
        $countries = Countries::get();
        return view('admin.agents.create', compact('agents', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'agent_type' => 'required',
            'agent_code' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'company_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'agent_margin' => 'required',
            'admin_margin' => 'required',
            'logo' => 'required',
            'credit_balance' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'user_type' => 'agent',
            'parent_id' => ((isset($request->main_agent) && $request->agent_type == 'sub') ? $request->main_agent : NULL),
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
                'admin_margin' => $request->admin_margin,
                'agent_margin' => $request->agent_margin,
                'credit_balance' => $request->credit_balance,
            ]);

            $agentMargins = FlightMarginAmounts::create([
                'booking_id' => NULL,
                'agent_id'   => $user->id,
                'currency' => 'USD',
                'usd_amount' => $request->credit_balance,
                'transaction_type' => 'cr',
                'credit_balance' => $request->credit_balance,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        return redirect()->route('agent.create')->with('status', 'Agent created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function view($agent_id)
    {  
        $agent = User::find($agent_id);
        return view('admin.agents.view', compact('agent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($agent_id)
    {
        $agent = User::find($agent_id);
        $agents = User::where('user_type','agent')->where('is_approved',1)->where('is_active',1)->where('is_deleted',0)->get();
        $countries = Countries::get();
        return view('admin.agents.edit', compact('agent','agents','countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'agent_type' => 'required',
            'agent_code' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'company_name' => 'required',
            'email' => 'required|email|unique:users,email,'.$request->agent_id,
            'agent_margin' => 'required',
            'admin_margin' => 'required',
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
        $userData->parent_id = ((isset($request->main_agent) && $request->agent_type == 'sub')  ? $request->main_agent : NULL);
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
                'admin_margin' => $request->admin_margin,
                'agent_margin' => $request->agent_margin,
                'credit_balance' => $request->credit_balance,
        ];

        $currentCredit = $userData->user_details->credit_balance;
        if($request->credit_balance != $currentCredit){
            if($request->credit_balance > $currentCredit){
                FlightMarginAmounts::create([
                        'booking_id' => NULL,
                        'agent_id'   => $userData->id,
                        'currency' => 'USD',
                        'usd_amount' => number_format(($request->credit_balance - $currentCredit), 2, '.', ''),
                        'transaction_type' => 'cr',
                        'credit_balance' => $request->credit_balance,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
            }else{
                FlightMarginAmounts::create([
                    'booking_id' => NULL,
                    'agent_id'   => $userData->id,
                    'currency' => 'USD',
                    'usd_amount' => number_format(($currentCredit - $request->credit_balance), 2, '.', ''),
                    'transaction_type' => 'dr',
                    'credit_balance' => $request->credit_balance,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        // $agentMargins = FlightMarginAmounts::create([
        //     'booking_id' => NULL,
        //     'agent_id'   => $user->id,
        //     'currency' => 'USD',
        //     'usd_amount' => $request->credit_balance,
        //     'transaction_type' => 'cr',
        //     'created_at' => date('Y-m-d H:i:s')
        // ]);

        UserDetails::where('user_id',$request->agent_id)->update($data);
        return back()->with('status', 'Agent Details Updated!');
    }

    public function approve(Request $request){
        $user = User::find($request->id);
        $user->update(['is_approved' => 1]);
        $site_url = env('APP_URL');
        $content = 'Welcome to '.env('APP_NAME').'. Your account has been approved by the Administrator. Click <a href="'.$site_url.'">Here to login</a> to the site.';

        $info = array(
            'name' => $user->name,
            'email' => $user->email,
            'body' => $content
        );
        Mail::send('admin.emails.mail', $info, function ($message) use($info)
        {
            $message->to($info['email'], env('APP_NAME'))
                ->subject('Account Approved');
            $message->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
        });
    }

    public function statusChange(Request $request){
        $status = ($request->status == 1) ? 0:1;
        $user = User::find($request->id);
        $user->update(['is_active' => $status]);
    }
    public function delete(Request $request){
        User::where('id',$request->id)->update(['is_deleted' => 1]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
       
    }
}
