@extends('web.layouts.app')
@section('content')


 <!-- Common Banner Area -->
 <section id="common_banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="common_bannner_text">
                        <h2>Update Sub-agent Details</h2>
                        
                    </div>
                </div>
            </div>
        </div>
</section>


    <!-- Dashboard Area -->
    <section id="dashboard_main_arae" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('web.common.dashboard_sidebar')
                </div>
                <div class="col-lg-9">
              
                    <div class="dashboard_common_table">
                        
                        <h3>Update Sub-agent Details</h3>
                        
                        <div class="profile_update_form">
                            @if(session()->has('status'))
                                <div class="alert alert-success">
                                    {{ session()->get('status') }}
                                </div>
                            @endif
                            @if(session()->has('error'))
                                <div class="alert alert-danger">
                                    {!! session('error')['walletError'] !!}
                                </div>
                            @endif
                            <form id="storeAgent" class="form_area" action="{{ route('subagent.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="agent_code">Agent Code<span class="required">*</span></label>
                                            <input type="text" class="form-control"  id="agent_code" name="agent_code" required="required" readonly value="{{ $agent->user_details->code }}">
                                            @error('agent_code')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="f-name">First name<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name',$agent->user_details->first_name) }}" placeholder="First Name" >
                                            @error('first_name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="l-name">Last name<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="{{ old('last_name',$agent->user_details->last_name) }}">
                                            @error('last_name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="mail-address">Email<span class="required">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email"  value="{{ old('email',$agent->email) }}">
                                            @error('email')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 ">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            
                                            <input type="password" id="password" name="password" placeholder="Password" autocomplete="new-password" value="{{ old('password') }}"  class="form-control">
                                            <!-- <span class="password-eye" onclick="hideshow()">
                                                <i id="slash" class="fa fa-eye-slash" style="display: block;"></i>
                                                <i id="eye" class="fa fa-eye" style="display: none;"></i>
                                            </span> -->
                                            @error('password')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="mobil-number">Phone Number</label>
                                            <input type="text" id="phone_number" name="phone_number" placeholder="Phone Number"  class="form-control"  value="{{ old('phone_number',$agent->user_details->phone_number) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="u-name">Gender</label>
                                            <div class="radio">
                                                <label class="radio-label"><input type="radio" class=" radio-size" name="gender" id="genderM" value="male" {{ ( old('gender',$agent->user_details->gender) =='male') ? "checked='checked'" : '' }} /> Male </label>
                                                <label class="radio-label"><input type="radio" class=" radio-size" name="gender" id="genderF" value="female" {{ ( old('gender',$agent->user_details->gender) =='female') ? "checked='checked'" : '' }}/> Female</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="u-name">Designation</label>
                                            <input type="text" id="designation" name="designation" placeholder="Designation" class="form-control"  value="{{ old('designation', $agent->user_details->designation) }}">
                                        </div>
                                    </div>
                                    
                                    <div class="change_password_input_boxed">
                                        <h3 style="font-size: 18px;">Company Details</h3>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Company Name<span class="required">*</span></label>
                                                    <input type="text" id="company_name" name="company_name" placeholder="Company Name" value="{{ old('company_name', $agent->user_details->company_name) }}" class="form-control">
                                                    @error('company_name')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Company Reg. No.</label>
                                                    <input type="text" id="company_reg_no" placeholder="Company Reg. No."  name="company_reg_no"  class="form-control"  value="{{ old('company_reg_no', $agent->user_details->company_reg_no) }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Nature Of Business</label>
                                                    <select name="business_nature" id="business_nature" class="form-control">
                                                        <option {{ ( ($agent->user_details->business_nature) == '0') ? 'selected' : '' }} value="0">--Select--</option>
                                                        <option {{ ( ($agent->user_details->business_nature) == '1') ? 'selected' : '' }} value="1">Corporate </option>
                                                        <option {{ ( ($agent->user_details->business_nature) == '2') ? 'selected' : '' }} value="2">Destination Management Company</option>
                                                        <option {{ ( ($agent->user_details->business_nature) == '3') ? 'selected' : '' }} value="3">Tour Operator</option>
                                                        <option {{ ( ($agent->user_details->business_nature) == '4') ? 'selected' : '' }} value="4">Travel Agent</option>
                                                        <option {{ ( ($agent->user_details->business_nature) == '5') ? 'selected' : '' }} value="5">Wholesale Travel Company</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Address</label>
                                                    <textarea id="address" name="address"  class="form-control"> {{ old('address', $agent->user_details->address) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">City</label>
                                                    <input type="text" id="city" name="city" placeholder="City" value="{{ old('city',$agent->user_details->city) }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">State</label>
                                                    <input type="text" id="state" name="state" placeholder="State" class="form-control" value="{{ old('state',$agent->user_details->state) }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Country</label>
                                                    <select name="country" id="country" class="form-control select2">
                                                        <option value="0">--Select--</option>
                                                        @foreach($countries as $country)
                                                        <option value="{{ $country->id }}" {{ (( $agent->user_details->country) == $country->id) ? 'selected' : '' }}>{{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Zipcode/Pincode</label>
                                                    <input type="text" id="zip_code" placeholder="Zipcode/Pincode" name="zip_code" class="form-control"  value="{{ old('zip_code',$agent->user_details->zip_code) }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Agent Margin (%)<span class="required">*</span></label>
                                                    <input type="number"  step='any' id="agent_margin" placeholder="Agent Margin (%)" name="agent_margin" class="form-control"  value="{{ old('agent_margin',$agent->user_details->agent_margin) }}">
                                                    @error('agent_margin')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Credit Balance (USD)<span class="required">*</span></label>
                                                    <input type="number"   step='any' id="credit_balance" placeholder="Credit Balance (USD)" name="credit_balance"  value="{{ old('credit_balance',$agent->user_details->credit_balance) }}" class="form-control">
                                                    @error('credit_balance')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Logo </label>
                                                    <input type="file" id="logo" name="logo" class="form-control" >
                                                    @if($agent->user_details->logo != '')
                                                        <br>
                                                        <img src="{{ asset($agent->user_details->logo) }}" class="wh-150" />
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <input type="hidden" name="agent_id" id="agent_id" value="{{ $agent->id }}">
                                                    <input type="hidden" name="image_url" id="image_url" value="{{ $agent->user_details->logo }}">
                                                    <button type="submit" class="btn btn-success w-150">Update</button>
                                                    <a href="{{ route('sub-agents') }}" class="btn btn-danger w-100px" type="button">Cancel</a>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
<!-- newsletter content -->
@include('web.includes.newsletter')
<!-- /newsletter content -->
@endsection
@push('header')
<link rel="stylesheet" href="{{ asset('assets/css/search_flights.css') }}" />
<style>
.alert {
    margin-top: 1rem;
    margin-bottom: 0;
}
</style>
@endpush
@push('footer')

@endpush