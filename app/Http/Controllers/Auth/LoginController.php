<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }

    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
      
        if ($validator->fails()){
            return response()->json([
                    "status" => false,
                    "errors" => $validator->errors()
                ]);
        } else {
            if (Auth::attempt($request->only(["email", "password"]))) {
                if(Auth::user()->user_type == "user" || Auth::user()->user_type == "admin" || (Auth::user()->user_type == "agent" && Auth::user()->is_approved == 1)){
                    return response()->json([
                        "status" => true, 
                        "redirect" => url("web-dashboard")
                    ]);
                }elseif(Auth::user()->user_type == "agent" && Auth::user()->is_approved == 0){
                    return response()->json([
                        "status" => false,
                        "errors" => ["Your account is waiting for our administrator approval. Please check back later."]
                    ]);
                }    
            } else {
                return response()->json([
                    "status" => false,
                    "errors" => ["These credentials do not match our records."]
                ]);
            }
        }
    }

    public function logoutWeb() {
        // Session::flush();
        Auth::logout();
    
        return redirect()->route('home');
    }

    // private function validator(Request $request)
    // {
    //     //validation rules.
    //     $rules = [
    //         'email'    => 'required|email|exists:users|min:5|max:191',
    //         'password' => 'required|string|min:4|max:255',
    //     ];

    //     //custom validation error messages.
    //     $messages = [
    //         'email.exists' => 'These credentials do not match our records.',
    //     ];

    //     //validate the request.
    //     $request->validate($rules,$messages);
    // }

    // private function loginFailed(){
    //     return redirect()
    //         ->back()
    //         ->withInput()
    //         ->with('error','Login failed, please try again!');
    // }

    // public function login(Request $request)
    // {
    //     $this->validator($request);
       
    //     if(Auth::attempt($request->only('email','password'),$request->filled('remember'))){
    //         //Authentication passed...
    //         return 1;
    //     }

    //     //Authentication failed...
    //     return 0;
    // }

    // public function logout(Request $request)
    // {
    //     auth()->guard()->logout();
       
    //     $request->session()->invalidate();

    //     $request->session()->regenerateToken();

    //     return redirect()
    //         ->route('admin.login')
    //         ->with('status','Admin has been logged out!');
    // }
}
