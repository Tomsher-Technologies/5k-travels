@extends('admin.layouts.app')
@section('title', 'Edit Agent')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <!-- <div class="title_left">
                    <h3>Edit Agent Details</h3>
                </div> -->
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Edit Agent Details <small></small></h2>
                            <a href="{{ route('agent.index') }}" class="btn back-btn" ><i class="fa fa-long-arrow-left"></i> Back</a>
                            <div class="clearfix"></div>
                           
                        </div>
                        <div class="x_content">
                            @if(session()->has('status'))
                                <div class="alert alert-success">
                                    {{ session()->get('status') }}
                                </div>
                            @endif
                            <br />
                            <form id="storeAgent" action="{{ route('agent.update') }}" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">
                                @csrf
                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="agent_type">Agent Type<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <select class="form-control" id="agent_type" name="agent_type" onchange="showAgents(this.value)">
                                            <option {{ ($agent->parent_id == '') ? 'selected' : '' }} value="main">Agent</option>
                                            <option {{ ($agent->parent_id != '') ? 'selected' : '' }} value="sub">Sub Agent</option>
                                        </select>
                                        @error('agent_type')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 {{ (old('agent_type') == 'sub' || $agent->parent_id != '') ? 'show' : 'hide' }}" id="agentsDiv">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="main_agent">Select Main Agent <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <select class="form-control select2" name="main_agent" id="main_agent">
                                            @foreach($agents as $age)
                                                <option {{ ($agent->parent_id == $age->id)  ? 'selected' : '' }} value="{{ $age->id }}">{{ $age->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="agent_code">Agent Code <span class="required">*</span> </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="agent_code" name="agent_code" required="required" readonly class="form-control" value="{{ $agent->user_details->code }}">
                                        @error('agent_code')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first_name">First Name <span class="required">*</span> </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name',$agent->user_details->first_name) }}"  class="form-control ">
                                        @error('first_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="last_name">Last Name <span class="required">*</span> </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name',$agent->user_details->last_name) }}" class="form-control">
                                        @error('last_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">Email <span class="required">*</span>  </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="email" id="email" name="email" value="{{ old('email',$agent->email) }}" class="form-control">
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="password">Password</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="password" id="password" name="password" autocomplete="new-password" value="{{ old('password') }}"  class="form-control">
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="phone_number">Phone Number </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="phone_number" name="phone_number" class="form-control"  value="{{ old('phone_number',$agent->user_details->phone_number) }}">
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="gender">Gender</label>
                                    <div class="col-md-6 col-sm-6 radio">
                                        <label class="radio-label"><input type="radio" class=" radio-size" name="gender" id="genderM" value="male" {{ ( old('gender',$agent->user_details->gender) =='male') ? "checked='checked'" : '' }}  /> Male </label>
                                        <label class="radio-label"><input type="radio" class=" radio-size" name="gender" id="genderF" value="female" {{ ( old('gender',$agent->user_details->gender) =='female') ? "checked='checked'" : '' }}/> Female</label>
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="designation">Designation </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="designation" name="designation"  class="form-control"  value="{{ old('designation', $agent->user_details->designation) }}">
                                    </div>
                                </div>
                                <div class="ln_solid col-md-12 col-sm-12 "></div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <h4 class="col-form-label col-md-3 col-sm-3 label-align"><b> Company Details</b> </h4>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="company_name">Company Name <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="company_name" name="company_name"  value="{{ old('company_name', $agent->user_details->company_name) }}" class="form-control">
                                        @error('company_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="company_reg_no">Company Reg. No.</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="company_reg_no" name="company_reg_no"  class="form-control"  value="{{ old('company_reg_no', $agent->user_details->company_reg_no) }}">
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="business_nature">Nature Of Business</label>
                                    <div class="col-md-6 col-sm-6 ">
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

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="address">Address</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <textarea id="address" name="address"  class="form-control"> {{ old('address', $agent->user_details->address) }}</textarea>
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="city">City</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="city" name="city" value="{{ old('city',$agent->user_details->city) }}" class="form-control">
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="state">State</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="state" name="state" class="form-control" value="{{ old('state',$agent->user_details->state) }}">
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="country">Country</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <select name="country" id="country" class="form-control select2">
                                            <option value="0">--Select--</option>
                                            @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ (( $agent->user_details->country) == $country->id) ? 'selected' : '' }}>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="zip_code">Zipcode/Pincode</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="zip_code" name="zip_code" class="form-control"  value="{{ old('zip_code',$agent->user_details->zip_code) }}">
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="agent_margin">Agent Margin (%) <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="number" id="agent_margin" name="agent_margin" class="form-control"  value="{{ old('agent_margin',$agent->user_details->agent_margin) }}">
                                        @error('agent_margin')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="admin_margin">Admin Margin (%) <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="number" id="admin_margin" name="admin_margin"  value="{{ old('admin_margin',$agent->user_details->admin_margin) }}" class="form-control">
                                        @error('admin_margin')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="admin_margin">Credit Balance (USD)<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="number" id="credit_balance" name="credit_balance"  value="{{ old('credit_balance',$agent->user_details->credit_balance) }}" class="form-control">
                                        @error('credit_balance')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="logo">Logo</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="file" id="logo" name="logo" class="form-control" >
                                        <br>
                                        <img src="{{ asset($agent->user_details->logo) }}" class="wh-150" />
                                        @error('logo')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="ln_solid col-md-12 col-sm-12 "></div>
                                <div class="item form-group col-md-12 col-sm-12 ">
                                    <div class="col-md-6 col-sm-6 offset-md-3">
                                        <input type="hidden" name="agent_id" id="agent_id" value="{{ $agent->id }}">
                                        <input type="hidden" name="image_url" id="image_url" value="{{ $agent->user_details->logo }}">
                                        <button type="submit" class="btn btn-success">Save</button>
                                        <a href="{{ route('agent.index') }}" class="btn btn-danger" type="button">Cancel</a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('header')
<link href="{{ asset('assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('footer')
<script src="{{ asset('assets/plugins/select2/dist/js/select2.full.min.js') }}"></script>  
<script>
    $(".select2").select2({
        placeholder: "Select",
        width:'100%',
        allowClear: false
    });

    function showAgents(type){
        var code = '';
        if(type == 'sub'){
            $('#agentsDiv').removeClass('hide');
            $('#agentsDiv').addClass('show');
            code = '{{ generateUniqueCode("sub_agent") }}';
            $('#agent_code').val(code);
        }else{
            $('#agentsDiv').removeClass('show');
            $('#agentsDiv').addClass('hide');
            code = '{{ generateUniqueCode("agent") }}';
            $('#agent_code').val(code);
        }
    }

</script>

@endsection
