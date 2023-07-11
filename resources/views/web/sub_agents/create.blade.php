@extends('web.layouts.app')
@section('content')


 <!-- Common Banner Area -->
 <section id="common_banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="common_bannner_text">
                        <h2>Create Sub-agents</h2>
                        
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
                        <div class="mt-n5 d-flex gap-3 flex-wrap align-items-end">
                            <div>
                                <h3>Create New Sub-agent</h3>
                            </div>
                               
                            <div class="ms-md-auto">
                                <a href="{{ route('sub-agents') }}" class="btn back-btn"><i class="fa fa-arrow-left"></i>&nbsp; Back</a>
                            </div>
                        </div>
                        
                        
                        <div class="profile_update_form">
                            @if(session()->has('status'))
                                <div class="alert alert-success">
                                    {{ session()->get('status') }}
                                </div>
                            @endif
                            <form id="storeAgent" class="form_area" action="{{ route('subagent.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="agent_code">Agent Code<span class="required">*</span></label>
                                            <input type="text" class="form-control"  id="agent_code" name="agent_code" required="required" readonly value="{{ old('agent_type',generateUniqueCode('sub_agent'))  }}">
                                            @error('agent_code')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="f-name">First name<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" >
                                            @error('first_name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="l-name">Last name<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name">
                                            @error('last_name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="mail-address">Email<span class="required">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Email">
                                            @error('email')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 ">
                                        <div class="form-group">
                                            <label for="password">Password<span class="required">*</span> </label>
                                            
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
                                            <input type="text" id="phone_number" name="phone_number" placeholder="Phone Number" class="form-control"  value="{{ old('phone_number') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="u-name">Gender</label>
                                            <div class="radio">
                                                <label class="radio-label"><input type="radio" class=" radio-size" name="gender" id="genderM" value="male" {{ (old('gender') =='male') ? "checked=''" : '' }} checked /> Male </label>
                                                <label class="radio-label"><input type="radio" class=" radio-size" name="gender" id="genderF" value="female" {{ (old('gender') =='female') ? "checked=''" : '' }}/> Female</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="u-name">Designation</label>
                                            <input type="text" id="designation" name="designation"  class="form-control" placeholder="Designation"  value="{{ old('designation') }}">
                                        </div>
                                    </div>
                                    
                                    <div class="change_password_input_boxed">
                                        <h3 style="font-size: 18px;">Company Details</h3>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Company Name<span class="required">*</span></label>
                                                    <input type="text" id="company_name" name="company_name" placeholder="Company Name" value="{{ old('company_name') }}" class="form-control">
                                                    @error('company_name')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Company Reg. No.</label>
                                                    <input type="text" id="company_reg_no" name="company_reg_no" placeholder="Company Reg. No." class="form-control"  value="{{ old('company_reg_no') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Nature Of Business</label>
                                                    <select name="business_nature" id="business_nature" class="form-control">
                                                        <option {{ (old('business_nature') == '0') ? 'selected' : '' }} value="0">--Select--</option>
                                                        <option {{ (old('business_nature') == '1') ? 'selected' : '' }} value="1">Corporate </option>
                                                        <option {{ (old('business_nature') == '2') ? 'selected' : '' }} value="2">Destination Management Company</option>
                                                        <option {{ (old('business_nature') == '3') ? 'selected' : '' }} value="3">Tour Operator</option>
                                                        <option {{ (old('business_nature') == '4') ? 'selected' : '' }} value="4">Travel Agent</option>
                                                        <option {{ (old('business_nature') == '5') ? 'selected' : '' }} value="5">Wholesale Travel Company</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Address</label>
                                                    <textarea id="address" name="address" placeholder="Address" class="form-control"> {{ old('address') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">City</label>
                                                    <input type="text" id="city" name="city" placeholder="City"  value="{{ old('city') }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">State</label>
                                                    <input type="text" id="state" name="state" placeholder="State"  class="form-control" value="{{ old('state') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Country</label>
                                                    <select name="country" id="country" class="form-control select2">
                                                        <option value="0">--Select--</option>
                                                        @foreach($countries as $country)
                                                        <option value="{{ $country->id }}" {{ (old('country') == $country->id) ? 'selected' : '' }}>{{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Zipcode/Pincode</label>
                                                    <input type="text" id="zip_code" name="zip_code" placeholder="Zipcode/Pincode" class="form-control"  value="{{ old('zip_code') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Agent Margin (%)<span class="required">*</span></label>
                                                    <input type="number" id="agent_margin" name="agent_margin" class="form-control" placeholder="Agent Margin (%)" value="{{ old('agent_margin') }}">
                                                    @error('agent_margin')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Credit Balance (USD)<span class="required">*</span></label>
                                                    <input type="number" id="credit_balance" name="credit_balance" placeholder="Credit Balance (USD)" value="{{ old('credit_balance') }}" class="form-control">
                                                    @error('credit_balance')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="u-name">Logo </label>
                                                    <input type="file" id="logo" name="logo" class="form-control" >
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-success w-150">Save</button>
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

<script type="text/javascript">

</script>
@endpush