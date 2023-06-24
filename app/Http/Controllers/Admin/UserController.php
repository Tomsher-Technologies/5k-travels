<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\Countries;
use Helper;
use Validator;
use Hash;
use Storage;
use Str;
use File;
use Mail;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort_search = null;
        if ($request->has('search')) {
            $sort_search = $request->search;
        }
      
        $query = User::leftJoin('user_details as ud','ud.user_id','=','users.id')
                            ->where('users.user_type','!=','agent')
                            ->where('users.is_deleted',0);
        if($sort_search){             
            $query->Where(function ($query) use ($sort_search) {
                    $query->orWhere('users.name', 'LIKE', "%$sort_search%")
                    ->orWhere('users.email', 'LIKE', "%$sort_search%")
                    ->orWhere('ud.code', 'LIKE', "%$sort_search%");   
            });        
        }

        $users = $query->orderBy('users.id','DESC')->paginate(10);
        return view('admin.users.index', compact('users', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Countries::get();
        return view('admin.users.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_type' => 'required',
            'user_code' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'user_type' => $request->user_type,
            'name' => $request->first_name.' '.$request->last_name,
            'email' => $request->email,
            'password' =>  Hash::make($request->password),
            'is_approved' => 0,
            'is_active' => 0,
        ]);

        if($user->id){
            $imageUrl = '';
            if ($request->hasFile('image')) {
                $uploadedFile = $request->file('image');
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
                'code' => $request->user_code, 
                'first_name' => $request->first_name, 
                'last_name' => $request->last_name,  
                'gender' => $request->gender, 
                'phone_number' => $request->phone_number,  
                'address' => $request->address,  
                'city' => $request->city,  
                'state' => $request->state,  
                'zip_code' => $request->zip_code,  
                'country' => $request->country,  
                'logo' => $imageUrl, 
            ]);
        }

        return redirect()->route('user.create')->with('status', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function view($id)
    {  
        $user = User::find($id);
        return view('admin.users.view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);
        $countries = Countries::get();
        return view('admin.users.edit', compact('user','countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_type' => 'required',
            'user_code' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,'.$request->user_id,
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $imageUrl = '';
        $presentImage = $request->image_url;
        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');
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

        $userData = User::find($request->user_id);
        $userData->name = $request->first_name.' '.$request->last_name;
        $userData->email = $request->email;
        if(isset($request->password)){
            $userData->password = Hash::make($request->password);
        }
        $userData->save();

        $data = [
                'code' => $request->user_code, 
                'first_name' => $request->first_name, 
                'last_name' => $request->last_name,  
                'gender' => $request->gender, 
                'phone_number' => $request->phone_number,  
                'address' => $request->address,  
                'city' => $request->city,  
                'state' => $request->state,  
                'zip_code' => $request->zip_code,  
                'country' => $request->country,  
                'logo' =>  ($imageUrl !='') ? $imageUrl : $presentImage,
        ];

        UserDetails::where('user_id',$request->user_id)->update($data);
        return back()->with('status', 'User Details Updated!');
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
